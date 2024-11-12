<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Регистрация нового пользователя.
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        return $this->userRepository->createUser($data);
    }

    /**
     * Авторизация нового пользователя.
     *
     * @param array $credentials
     * @return string|null
     */
    public function login(array $credentials): ?string
    {
        $user = $this->userRepository->getUserByEmail($credentials['email']);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user->createToken('API Token')->plainTextToken;
        }

        return null;
    }

    /**
     * Разлогирование пользователя.
     *
     * @param User $user
     * @return void
     */
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}
