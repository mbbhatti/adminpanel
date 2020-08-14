<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get's all users.
     *
     * @param int|null $userId
     * @return array
     */
    public function getAll(int $userId = null): array
    {
        $users = User::select(
            'users.id',
            'users.name AS Name',
            'users.email AS Email',
            'users.created_at AS Created At',
            'users.avatar AS Avatar'
        )
            ->selectRaw('GROUP_CONCAT(roles.display_name) AS Role')
            ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->groupBy(
                'users.id',
                'users.name',
                'users.email',
                'users.created_at',
                'users.avatar'
            )
            ->orderBy('users.created_at', 'ASC')
            ->offset(0)
            ->limit(10);

        if ($userId !== null) {
            $users->where('users.id', $userId);
        }

        return $users->get()->toArray();
    }

    /**
     * Get a user by Id
     *
     * @param int $userId
     * @return object
     */
    public function getUserById(int $userId): object
    {
        $users = User::select('id', 'name', 'email', 'avatar')
            ->where('id', $userId)
            ->first();

        return $users;
    }

    /**
     * Get user avatar
     *
     * @param int $userId
     * @return object
     */
    public function getUserAvatarById(int $userId): object
    {
        return User::select('avatar')->where('id', $userId)->first();
    }

    /**
     * Create | Update User.
     *
     * @param  object  $request
     * @param  string  $filePath
     * @return int     last record id
     */
    public function saveUser(object $request, string $filePath): int
    {
        $user = User::firstOrNew(['id' => request('id')]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = $request->input('password');
        if (isset($password)) {
            $user->password = Hash::make($password);
        }
        if (!empty($filePath)) {
            $user->avatar = $filePath;
        }
        $user->save();

        return $user->id;
    }

    /**
     * Delete user.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool
    {
        return User::where('id', $userId)->delete();
    }

    /**
     * Delete all users expect logged In.
     *
     * @param array $users
     * @return bool
     */
    public function deleteAllUser(array $users): bool
    {
        return User::whereIn('id', $users)->delete();
    }

    /**
     * Get latest users.
     *
     * @return array
     */
    public function getLatestUsers(): array
    {
        return User::select(
            'id',
            'name',
            'created_at AS date',
            'avatar'
        )
            ->orderBy('created_at', 'DESC')
            ->offset(0)
            ->limit(6)
            ->get()
            ->toArray();
    }
}

