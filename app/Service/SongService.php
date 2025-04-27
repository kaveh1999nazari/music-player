<?php

namespace App\Service;

use App\Exceptions\DuplicateMediaException;
use App\Exceptions\MediaNotEmpty;
use App\Models\Song;
use App\Repository\MediaRepository;
use App\Repository\SongRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;



class SongService
{
    public function __construct(
        private readonly SongRepository $songRepository,
        private readonly MediaRepository $mediaRepository
    )
    {}

    public function create(array $data, ?UploadedFile $audio = null): Song
    {
        if (! $audio) {
            throw new MediaNotEmpty();
        }

        $fileName = $audio->getClientOriginalName();
        $relativePath = 'songs/' . $fileName;

        if ($this->mediaRepository->existsDuplicateByName($relativePath)) {
            throw new DuplicateMediaException();
        }

        $song = $this->songRepository->create($data);

        $directoryPath = storage_path('app/public/songs');

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        $fileName =  $audio->getClientOriginalName();
        $path = $audio->storeAs('songs', $fileName, 'public');
        $this->mediaRepository->create([
            'file_path' => $path,
            'file_type' => 'audio',
            'mime_type' => $audio->getMimeType(),
            'model_id' => $song->id,
            'model_type' => Song::class,
        ]);
        return $song;
    }
}
