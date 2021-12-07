<?php

namespace Milano\Comment\Repositories;

use Milano\Comment\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{

    public function paginate()
    {
        // TODO: Implement paginate() method.
    }

    public function store($data)
    {
        // TODO: Implement store() method.
    }

    public function findApproved($id)
    {
        // TODO: Implement findApproved() method.
    }

    public function findOrFail($id)
    {
        // TODO: Implement findOrFail() method.
    }

    public function paginateParents($status = null)
    {
        // TODO: Implement paginateParents() method.
    }

    public function updateStatus($id, string $status)
    {
        // TODO: Implement updateStatus() method.
    }

    public function searchBody($body)
    {
        // TODO: Implement searchBody() method.
    }

    public function searchStatus($status)
    {
        // TODO: Implement searchStatus() method.
    }

    public function searchEmail($email)
    {
        // TODO: Implement searchEmail() method.
    }

    public function searchName($name)
    {
        // TODO: Implement searchName() method.
    }
}
