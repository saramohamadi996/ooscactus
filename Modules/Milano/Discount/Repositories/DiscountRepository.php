<?php

namespace Milano\Discount\Repositories;

use Milano\Discount\Models\Discount;
use Milano\Discount\Repositories\Interfaces\DiscountRepositoryInterface;
use Morilog\Jalali\Jalalian;

class DiscountRepository implements DiscountRepositoryInterface
{
    public function find($id)
    {
        return Discount::query()->find($id);
    }

    public function store($data)
    {
        $discount = Discount::query()->create([
            "user_id" => auth()->id(),
            "code" => $data["code"],
            "percent" => $data["percent"],
            "usage_limitation" => $data["usage_limitation"],
            "expire_at" => $data["expire_at"] ? Jalalian::fromFormat("Y/m/d H:i", $data["expire_at"])
                ->toCarbon() : null,
            "link" => $data["link"],
            "type" => $data["type"],
            "description" => $data["description"],
            "uses" => 0
        ]);
        if ($discount->type == Discount::TYPE_SPECIAL) {
            $discount->products()->sync($data["products"]);
        }
    }

    public function paginateAll()
    {
        return Discount::query()->latest()->paginate();
    }

    public function update($id, array $data)
    {
        Discount::query()->where("id", $id)->update([
            "code" => $data["code"],
            "percent" => $data["percent"],
            "usage_limitation" => $data["usage_limitation"],
            "expire_at" => $data["expire_at"] ? Jalalian::fromFormat("Y/m/d H:i", $data["expire_at"])
                ->toCarbon() : null,
            "link" => $data["link"],
            "type" => $data["type"],
            "description" => $data["description"],
        ]);
        $discount = $this->find($id);
        if ($discount->type == Discount::TYPE_SPECIAL) {
            $discount->products()->sync($data["products"]);
        } else {
            $discount->products()->sync([]);
        }
    }

    public function getValidDiscountsQuery($type = "all", $id = null)
    {
        $query = Discount::query()
            ->where("expire_at", ">", now())
            ->where("type", $type)
            ->whereNull("code");
        if ($id) {
            $query->whereHas("products", function ($query) use ($id) {
                $query->where("id", $id);
            });
        }

        $query->where(function ($query) {
            $query->where("usage_limitation", ">", "0")->orWhereNull("usage_limitation");
        })->orderBy("percent", "desc");
        return $query;
    }

    public function getGlobalBiggerDiscount()
    {
        return $this->getValidDiscountsQuery()->first();
    }

    public function getProductBiggerDiscount($id)
    {
        return $this->getValidDiscountsQuery(Discount::TYPE_SPECIAL, $id)->first();
    }

    public function getValidDiscountByCode($code, $id)
    {
        return Discount::query()
            ->where("code", $code)
            ->where(function ($query) use ($id) {
                return $query->whereHas("products", function ($query) use ($id) {
                    return $query->where("id", $id);
                })->orWhereDoesntHave("products");
            })
            ->first();
    }

}
