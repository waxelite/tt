<?php

namespace App\Services\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): User;

    public function login(array $credentials): ?string;

    public function logout(User $user): void;
}
