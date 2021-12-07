<?php

namespace Milano\Comment\Repositories\Interfaces;

interface CommentRepositoryInterface
{
    public function paginate(int $per_page = 20);

    public function paginateParents($status = null);

    public function findApproved($id);

    public function findOrFail($id);

    public function searchBody($body);

    public function searchStatus($status);

    public function searchEmail($email);

    public function searchName($name);

    public function store($data);

    public function updateStatus($id, string $status);
}
