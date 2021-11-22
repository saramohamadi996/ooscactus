<?php

namespace Milano\User\Repositories;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Milano\User\Repositories\Interfaces\VerifyCodeRepositoryInterface;

class VerifyCodeRepository implements VerifyCodeRepositoryInterface
{
    /**
     * Create or update new user.
     * @param $data
     * @return mixed
     */
    public function auth($data)
    {
        $mobile = $data->input('mobile');
        $password = Hash::make('password', ['memory' => 1024, 'time' => 2, 'threads' => 2]);

        try {
            $user = User::firstOrCreate(['mobile' => $mobile], [
                'password' => $password,
                'email' => $mobile . '@ooscactus.com',
            ]);
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return $user;
    }

    /**
     * Get is_deleted and is_blocked match database.
     * @param $data
     * @return bool
     */
    public function status($data)
    {
        $user = User::whereIn('mobile', $data)->select('is_deleted', 'is_blocked')->first();
        try {
            return $user;
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
    }
}
