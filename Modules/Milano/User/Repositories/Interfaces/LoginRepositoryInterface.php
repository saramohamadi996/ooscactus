<?php

namespace Milano\User\Repositories\Interfaces;

interface LoginRepositoryInterface
{
    /**
     * Create a new mobile and verify code or update an existing verify code.
     * @param $value
     * @return bool
     */
    public function login($value):bool;

    /**
     * Get mobile and verify code and match database.
     * @param $value
     * @return mixed
     */
    public function user($value);
}
