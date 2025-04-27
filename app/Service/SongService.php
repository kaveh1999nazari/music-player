<?php

namespace App\Service;

use App\Exceptions\DuplicateMediaException;
use App\Exceptions\MediaNotEmpty;
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

        $fileName = $audio->getClientOriginalName();
        $relativePath = 'songs/' . auth()->id() . '/' . $fileName;

        if ($this->mediaRepository->existsDuplicateByName($relativePath)) {
            throw new DuplicateMediaException();
        }

        $song = $this->songRepository->create($data);

        $directoryPath = storage_path('app/public/songs/' . auth()->id());
        File::ensureDirectoryExists($directoryPath, 0755, true);

        $this->compressAudio($audio, $directoryPath . '/' . $fileName);

        $this->mediaRepository->create([
            'file_path' => $relativePath,
            'file_type' => 'audio',
            'mime_type' => $audio->getMimeType(),
            'model_id' => $song->id,
            'model_type' => Song::class,
        ]);

        return $song;
    }

    private function compressAudio(UploadedFile $audio, string $outputPath): void
    {
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),
            'ffprobe.binaries' => env('FFPROBE_PATH', '/usr/bin/ffprobe'),
            'timeout' => 3600
        ]);

        $audioFile = $ffmpeg->open($audio->getRealPath());

        $format = new Mp3();
        $format->setAudioKiloBitrate(128);
        $format->setAudioChannels(2);

        $audioFile->save($format, $outputPath);
    }
}
