<?php

namespace Milano\User\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function findByEmail($email);

    public function getSellers();

//    public function getSeller();

    public function getUsers();

    public function findById($id);

    public function searchName($name);

    public function searchEmail($email);

    public function searchMobile($mobile);

    public function paginate();

    public function update($userId, $values);

    public function updateProfile($request);

    public function updateImage($request);
}
