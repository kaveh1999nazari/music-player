<?php

namespace App\Service;

use App\Exceptions\AlbumNotExistException;
use App\Exceptions\ArtistNotExistException;
use App\Exceptions\CategoryExistException;
use App\Exceptions\CategoryNotExistException;
use App\Exceptions\DuplicateMediaException;
use App\Exceptions\DuplicateTitleSongException;
use App\Exceptions\MediaNotEmpty;
use App\Exceptions\SongNotFoundException;
use App\Models\Song;
use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use App\Repository\SongAlbumRepository;
use App\Repository\SongArtistRepository;
use App\Repository\SongCategoryRepository;
use App\Repository\SongRepository;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SongService
{
    public function __construct(
        private readonly SongRepository $songRepository,
        private readonly MediaRepository        $mediaRepository,
        private readonly SongCategoryRepository $songCategoryRepository,
        private readonly SongAlbumRepository    $songAlbumRepository,
        private readonly SongArtistRepository   $songArtistRepository,
        private readonly CategoryRepository     $categoryRepository,
        private readonly AlbumRepository        $albumRepository,
        private readonly ArtistRepository       $artistRepository
    ) {}

    public function create(array $data, ?UploadedFile $audio = null): Song
    {
        if (!$audio) {
            throw new MediaNotEmpty();
        }

        return DB::transaction(function () use ($data, $audio) {
            $title = $data['title'];

            $baseRelativePath = 'songs/' . auth()->id() . '/' . $this->sanitizeTitle($title);
            $fileName = pathinfo($audio->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $audio->getClientOriginalExtension();

            if ($this->mediaRepository->existsDuplicateByName($baseRelativePath . '/' . $fileName . '_320.' . $extension)) {
                throw new DuplicateMediaException();
            }

            if ($this->songRepository->existsByTitleForUser($data['title'], auth()->id())) {
                throw new DuplicateTitleSongException();
            }

            $song = $this->songRepository->create($data);

            if (isset($data['category_id'])) {
                if ($this->categoryRepository->checkExistById($data['category_id'])) {
                    $this->songCategoryRepository->create([
                        'category_id' => $data['category_id'],
                        'song_id' => $song->id
                    ]);
                } else {
                    throw new CategoryNotExistException();
                }
            }

            if (isset($data['category_name'])) {
                if ($this->categoryRepository->checkExistByName($data['category_name']) === false) {
                    $category = $this->categoryRepository->create(['name' => $data['category_name']]);
                    $this->songCategoryRepository->create([
                        'category_id' => $category->id,
                        'song_id' => $song->id
                    ]);
                } else {
                    throw new CategoryExistException();
                }

            }

            if (isset($data['artist_id'])) {
                if ($this->artistRepository->checkExist($data['artist_id'])) {
                    $this->songArtistRepository->create([
                        'song_id' => $song->id,
                        'artist_id' => $data['artist_id']
                    ]);
                } else {
                    throw new ArtistNotExistException();
                }
            }

            if (isset($data['artist_name'])) {
                $artist = $this->artistRepository->create(['name' => $data['artist_name']]);
                $this->songArtistRepository->create([
                    'song_id' => $song->id,
                    'artist_id' => $artist->id
                ]);
            }

            if (isset($data['album_id'])) {
                if ($this->albumRepository->checkExist($data['album_id'])) {
                    $this->songAlbumRepository->create([
                        'song_id' => $song->id,
                        'album_id' => $data['album_id']
                    ]);
                } else {
                    throw new AlbumNotExistException();
                }
            }

            if (isset($data['album_name'])) {
                $album = $this->albumRepository->create([
                    'name' => $data['album_name'],
                    'artist_id' => $data['artist_id'] ?? $artist->id ?? null,
                    'release_year' => $data['release_year']
                ]);

                $this->songAlbumRepository->create([
                    'song_id' => $song->id,
                    'album_id' => $album->id
                ]);
            }

            $directoryPath = storage_path('app/public/' . $baseRelativePath);
            File::ensureDirectoryExists($directoryPath, 0755, true);

            foreach ([320, 196, 128, 96] as $kbps) {
                $outputPath = $directoryPath . '/' . $fileName . "_{$kbps}." . $extension;
                $relativeFilePath = $baseRelativePath . '/' . $fileName . "_{$kbps}." . $extension;

                $this->compressAudio($audio, $outputPath, $kbps);

                $this->mediaRepository->create([
                    'file_path' => $relativeFilePath,
                    'file_type' => 'audio',
                    'mime_type' => $audio->getMimeType(),
                    'model_id' => $song->id,
                    'model_type' => Song::class,
                    'quality' => $kbps,
                ]);
            }

            return $song;
        });
    }

    public function all(int $perPage, int $page)
    {
        return $this->songRepository->all($perPage, $page);
    }

    public function get(string $shareToken)
    {
        $song = $this->songRepository->get($shareToken);

        if (!$song) {
            throw new SongNotFoundException();
        }

        return $song;
    }

    public function deleteByShareToken(string $shareToken): void
    {
        $song = $this->songRepository->get($shareToken);

        if (!$song) {
            throw new SongNotFoundException();
        }

        $this->songRepository->delete($song);
    }

    private function compressAudio(UploadedFile $audio, string $outputPath, int $bitrate): void
    {
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),
            'ffprobe.binaries' => env('FFPROBE_PATH', '/usr/bin/ffprobe'),
            'timeout' => 3600
        ]);

        $audioFile = $ffmpeg->open($audio->getRealPath());

        $format = new Mp3();
        $format->setAudioKiloBitrate($bitrate);
        $format->setAudioChannels(2);

        $audioFile->save($format, $outputPath);
    }

    private function sanitizeTitle(string $title): string
    {
        $title = preg_replace('/[^\p{Arabic}a-zA-Z0-9_-]+/u', '_', $title);
        return trim($title, '_');
    }
}
