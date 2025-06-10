<?php

namespace App\Service;

use App\Exceptions\MediaNotEmpty;
use App\Exceptions\MediaNotFoundException;
use App\Exceptions\PlaylistNotFoundException;
use App\Exceptions\UploadNotSuccessfully;
use App\Models\Playlist;
use App\Repository\MediaRepository;
use App\Repository\PlaylistRepository;
use App\Trait\SanitizesTitle;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PlaylistService
{
    use SanitizesTitle;
    public function __construct(
        private readonly PlaylistRepository $playlistRepository,
        private readonly MediaRepository $mediaRepository
    )
    {}

    public function create(array $data, ?UploadedFile $photo = null)
    {
        if (!$photo) {
            throw new MediaNotEmpty();
        }

        return DB::transaction(function () use ($data, $photo) {
            $playlist = $this->playlistRepository->create($data);

            $baseRelativePath = 'playlists/' . auth()->id() . '/' . $this->sanitizeTitle($data['title']);
            $fileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();
            $fileNameWithExt = $fileName . '.' . $extension;
            $relativeFilePath = $baseRelativePath . '/' . $fileNameWithExt;

            $disk = config('filesystems.default');

            if ($disk === 'local') {
                $directoryPath = storage_path('app/public/' . $baseRelativePath);
                File::ensureDirectoryExists($directoryPath, 0755, true);
                File::put($directoryPath . '/' . $fileNameWithExt, File::get($photo->getRealPath()));
            } elseif ($disk === 's3') {
                $tempPath = storage_path('app/public/' . uniqid() . '_' . $fileNameWithExt);
                File::ensureDirectoryExists(dirname($tempPath), 0755, true);
                File::put($tempPath, File::get($photo->getRealPath()));

                $upload = Storage::disk($disk)->put($relativeFilePath, File::get($tempPath));
                if (!$upload) {
                    throw new UploadNotSuccessfully();
                }

                File::delete($tempPath);
            }

            $this->mediaRepository->create([
                'file_path' => $relativeFilePath,
                'file_type' => 'photo',
                'mime_type' => $photo->getMimeType(),
                'model_id' => $playlist->id,
                'model_type' => Playlist::class,
            ]);

            return $playlist;
        });
    }

    public function all(int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->playlistRepository->all($perPage, $page);
    }

    public function get(string $shareToken)
    {
        $playList = $this->playlistRepository->get($shareToken);

        if(! $playList) {
            throw new PlaylistNotFoundException();
        }

        return $playList;
    }

    public function streamPhoto(string $shareToken): string
    {
        $playlist = $this->playlistRepository->get($shareToken);

        if (! $playlist) {
            throw new PlaylistNotFoundException();
        }

        $media = $this->mediaRepository->getByModelAndType(
            $playlist->id,
            Playlist::class,
            'photo'
        );

        if (! $media) {
            throw new MediaNotFoundException();
        }

        $disk = config('filesystems.default');

        if ($disk === 's3') {
            if (!Storage::disk($disk)->exists($media->file_path)) {
                throw new MediaNotFoundException();
            }

            return Storage::disk($disk)->temporaryUrl(
                $media->file_path,
                now()->addMinutes(5)
            );
        }

        return Storage::disk($disk)->url($media->file_path);
    }

    public function delete(string $shareToken)
    {
        $playList = $this->playlistRepository->get($shareToken);

        return $this->playlistRepository->delete($playList);
    }
}
