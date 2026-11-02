<?php

namespace App\services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        return User::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email','=', $search);
            })
            ->latest()
            ->paginate($perPage);
    }


    public function createUser(array $data): User
    {
        return User::create($data);

    }

    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return $user->fresh();
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
