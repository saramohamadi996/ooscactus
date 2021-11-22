<?php

namespace Milano\User\Repositories\Interfaces;

interface VerifyCodeRepositoryInterface
{
    /**
     * Create or update new user.
     * @param $data
     * @return mixed
     */
    public function auth($data);

    /**
     * Get is_deleted and is_blocked match database
     * @param $data
     * @return mixed
     */
    public function status($data);
}
