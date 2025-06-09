<?php

namespace App\Service;

use App\Exceptions\ArtistNotExistException;
use App\Exceptions\DuplicateArtistException;
use App\Exceptions\DuplicateMediaException;
use App\Exceptions\MediaNotEmpty;
use App\Exceptions\MediaNotFoundException;
use App\Exceptions\UploadNotSuccessfully;
use App\Exceptions\UserNotAdminException;
use App\Models\Artist;
use App\Repository\ArtistRepository;
use App\Repository\MediaRepository;
use App\Trait\SanitizesTitle;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ArtistService
{
    use SanitizesTitle;
    public function __construct(
        private readonly ArtistRepository $artistRepository,
        private readonly MediaRepository $mediaRepository,
    )
    {}

    public function getByToken(string $shareToken)
    {
        $artist = $this->artistRepository->getByToken($shareToken);
        if(! $artist) {
            throw new ArtistNotExistException();
        }

        return $artist;
    }

    public function getById(int $id)
    {
        $artist = $this->artistRepository->getById($id);
        if(! $artist) {
            throw new ArtistNotExistException();
        }

        return $artist;
    }

    public function create(array $data, ?UploadedFile $photo = null)
    {
        if (auth()->user()->is_admin === false) {
            throw new UserNotAdminException();
        }

        if ( !$photo) {
            throw new MediaNotEmpty();
        }
        return DB::transaction(function () use ($data, $photo) {
            $baseRelativePath = 'artists/' . auth()->id() . '/' . $this->sanitizeTitle($data['name']);
            $fileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();

            if ($this->mediaRepository->existsDuplicateByName($baseRelativePath . '/' . $fileName . '.' . $extension)) {
                throw new DuplicateMediaException();
            }

            if ($this->artistRepository->checkExistByName($data['name']) === true) {
                throw new DuplicateArtistException();
            }

            $artist = $this->artistRepository->create($data);
            $disk = config('filesystems.default');
            $baseStoragePath = 'artists/' . auth()->id() . '/' . $this->sanitizeTitle($data['name']);
            $fileNameWithBitrate = $fileName . '.' . $extension;
            $relativeFilePath = $baseStoragePath . '/' . $fileNameWithBitrate;

            if ($disk === 'local') {
                $directoryPath = storage_path('app/public/' . $baseStoragePath);
                File::ensureDirectoryExists($directoryPath, 0755, true);
                $outputPath = $directoryPath . '/' . $fileNameWithBitrate;
                File::put($outputPath, File::get($photo->getRealPath()));
            } elseif ($disk === 's3') {
                $tempPath = storage_path('app/public/' . uniqid() . '_' . $fileNameWithBitrate);
                File::ensureDirectoryExists(dirname($tempPath), 0755, true);
                File::put($tempPath, File::get($photo->getRealPath()));

                $upload = Storage::disk($disk)->put($relativeFilePath, File::get($tempPath));
                if ($upload === false) {
                    throw new UploadNotSuccessfully();
                }

                File::delete($tempPath);
            }

            $this->mediaRepository->create([
                'file_path' => $relativeFilePath,
                'file_type' => 'photo',
                'mime_type' => $photo->getMimeType(),
                'model_id' => $artist->id,
                'model_type' => Artist::class,
            ]);
            return $artist;
        });
    }

    public function streamPhoto(string $shareToken): string
    {
        $artist = $this->artistRepository->getByToken($shareToken);

        if (! $artist) {
            throw new ArtistNotExistException();
        }

        $media = $this->mediaRepository->getByModelAndType($artist->id, Artist::class, 'photo');

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
}
