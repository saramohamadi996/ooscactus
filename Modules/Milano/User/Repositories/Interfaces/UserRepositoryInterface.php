<?php

namespace Milano\User\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function findByEmail($email);

    public function getSellers();

    public function findById($id);

    public function paginate();

    public function update($userId, $values);

    public function updateProfile($request);

    public function FindByIdFullInfo($id);
}
