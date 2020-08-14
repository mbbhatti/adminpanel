<?php

namespace App\Repositories;

use App\UserPlace;

class UserPlaceRepository implements UserPlaceRepositoryInterface
{
    /**
     * Get user locations
     *
     * @return array
     */
    public function getAll(): array
    {
        return UserPlace::select('name', 'latitude', 'longitude')->get()->toArray();
    }

    /**
     * Create | Update user place information.
     *
     * @param int $userId
     * @return int|null
     */
    public function saveUserPlace(int $userId): ?int
    {
        $request = getUserLatLng();
        if ($request !== null) {
            $userPlace = UserPlace::firstOrNew(['user_id' => $userId]);
            $userPlace->user_id = $userId;
            $userPlace->latitude = $request['latitude'];
            $userPlace->longitude = $request['longitude'];
            $userPlace->name = $request['country_name'];
            $userPlace->save();

            return $userPlace->id;;
        }

        return $request;
    }
}

