<?php

namespace Milano\Discount\Repositories\Interfaces;

interface DiscountRepositoryInterface
{
    public function find($id);

    public function store($data);

    public function paginateAll();

    public function update($id, array $data);

    public function getValidDiscountsQuery($type = "all", $id = null);

    public function getGlobalBiggerDiscount();

    public function getProductBiggerDiscount($id);

    public function getValidDiscountByCode($code, $id);
}
