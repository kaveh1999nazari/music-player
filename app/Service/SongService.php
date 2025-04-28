<?php

namespace App\Service;

use App\Exceptions\DuplicateMediaException;
use App\Exceptions\DuplicateTitleSongException;
use App\Exceptions\MediaNotEmpty;
use App\Exceptions\SongNotFoundException;
use App\Models\Song;
use App\Repository\MediaRepository;
use App\Repository\SongRepository;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class SongService
{
    public function __construct(
        private readonly SongRepository $songRepository,
        private readonly MediaRepository $mediaRepository
    ) {}

    public function create(array $data, ?UploadedFile $audio = null): Song
    {
        if (!$audio) {
            throw new MediaNotEmpty();
        }

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
    }

    public function all()
    {
        return $this->songRepository->all();
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
