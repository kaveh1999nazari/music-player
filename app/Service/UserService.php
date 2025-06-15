<?php

namespace App\Service;

use App\Exceptions\DuplicateMediaException;
use App\Exceptions\InvalidUserToken;
use App\Exceptions\MediaNotEmpty;
use App\Exceptions\UploadNotSuccessfully;
use App\Exceptions\UserExistException;
use App\Exceptions\UserNotAdminException;
use App\Exceptions\UserNotFound;
use App\Exceptions\UserPasswordIncorrect;
use App\Models\User;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use App\Trait\SanitizesTitle;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService
{
    use SanitizesTitle;
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly MediaRepository $mediaRepository,
    )
    {}

    public function create(array $data, ?UploadedFile $photo = null): \App\Models\User
    {
//        if ( !$photo) {
//            throw new MediaNotEmpty();
//        }

        return DB::transaction(function () use ($data, $photo) {
            if ($this->userRepository->checkExistByEmailAndMobile($data['email'], $data['mobile']) === true) {
                throw new UserExistException();
            }

            $user = $this->userRepository->create($data);

            if ($photo instanceof UploadedFile) {
                $baseRelativePath = 'users/' . $user->id . '/' . $this->sanitizeTitle($data['full_name']);
                $fileName = Str::random(8);
                $extension = $photo->getClientOriginalExtension();

                if ($this->mediaRepository->existsDuplicateByName($baseRelativePath . '/' . $fileName . '.' . $extension)) {
                    throw new DuplicateMediaException();
                }

                $disk = config('filesystems.default');
                $baseStoragePath = 'users/' . $user->id . '/' . $this->sanitizeTitle($data['full_name']);
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
                    'model_id' => $user->id,
                    'model_type' => User::class,
                ]);
            }

            return $user;
        });
    }

    public function all(int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        if (auth()->user()->is_admin === true) {
            return $this->userRepository->all($perPage, $page);
        } else {
            throw new UserNotAdminException();
        }
    }

    public function getById(int $id)
    {
        if(auth()->user()->is_admin === true) {
            return $this->userRepository->getById($id);
        }else {
            throw new UserNotAdminException();
        }
    }

    public function login(array $data): \Illuminate\Http\JsonResponse
    {
        $user = $this->userRepository->getByEmail($data['email']);

        if (!$user) {
            throw new UserNotFound();
        }elseif (!Hash::check($data['password'], $user->password)) {
            throw new UserPasswordIncorrect();
        }else {
            $token = auth()->login($user);
        }

        $refreshToken = \Illuminate\Support\Str::random(60);

        $this->userRepository->update([
            'last_login' => now(),
            'access_token' => $token,
            'refresh_token' => $refreshToken,
        ], $user);

        return $this->respondWithToken($token, $refreshToken);
    }

    public function updatePassword(array $data)
    {
        $user = $this->userRepository->getByEmail($data['email']);

        if (! $user) {
            throw new UserNotFound();
        }

        return $this->userRepository->update([
            'password' => Hash::make($data['password'])
        ], $user);
    }

    public function requestOtp(array $data)
    {
        $user = $this->userRepository->getByEmail($data['email']);

        if (! $user) {
            $user = $this->userRepository->create([
                'email' => $data['email'],
                'password' => \Illuminate\Support\Str::random(8)
            ]);
        }

        return $this->userRepository->createOtp($user->id);
    }

    public function confirmOtp(array $data)
    {
        $user = $this->userRepository->getByEmail($data['email']);

        if (! $user) {
            throw new UserNotFound();
        }

        if (
            $user->otp_code === $data['otp_code']
            && $user->otp_expired > now()
        ) {
            $token = auth('api')->login($user);
            $refreshToken = \Illuminate\Support\Str::random(60);

            $this->userRepository->update([
                'last_login' => now(),
                'access_token' => $token,
                'refresh_token' => $refreshToken,
            ], $user);
        } else {
            throw new UserPasswordIncorrect();
        }

        return $this->respondWithToken($token, $refreshToken);
    }

    public function refreshToken(string $refreshToken): \Illuminate\Http\JsonResponse
    {
        $user = $this->userRepository->getByRefreshToken($refreshToken);

        if (! $user) {
            throw new InvalidUserToken();
        }

        $token = auth()->login($user);
        $newRefreshToken = \Illuminate\Support\Str::random(60);

        $this->userRepository->update([
            'access_token' => $token,
            'refresh_token' => $newRefreshToken,
        ], $user);

        return $this->respondWithToken($token, $newRefreshToken);
    }

    protected function respondWithToken($token, $refreshToken): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function streamPhoto(int $userId): string
    {
        $user = $this->userRepository->getById($userId);

        if (! $user) {
            throw new UserNotFound();
        }

        if ($user->id === auth()->id()) {

            $media = $this->mediaRepository->getByModelAndType($user->id, User::class, 'photo');

            if (!$media) {
                throw new \App\Exceptions\MediaNotFoundException();
            }

            $filePath = $media->file_path;
            $disk = config('filesystems.default');

            if (Str::startsWith($filePath, ['http://', 'https://'])) {
                return $filePath;
            }

            if ($disk === 's3') {
                if (!Storage::disk($disk)->exists($filePath)) {
                    return $filePath;
                }

                return Storage::disk($disk)->temporaryUrl(
                    $filePath,
                    now()->addMinutes(5)
                );
            }
            return Storage::disk($disk)->url($filePath);
        }else {
            throw new \Exception(message: 'not allowed', code: 406) ;
        }
    }
}
