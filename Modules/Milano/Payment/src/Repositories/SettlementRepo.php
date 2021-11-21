<?php
namespace Milano\Payment\Repositories;
use Milano\Payment\Models\Settlement;

class SettlementRepo
{
    private $query;

    public function __construct()
    {
        $this->query = Settlement::query();
    }

    public function store(array $request)
    {
        return Settlement::query()->create([
            "user_id" => auth()->id(),
            "to" => [
                "cart" => $request["cart"],
                "name" => $request["name"]
            ],
            "amount" => $request["amount"]
        ]);
    }

    public function update(int $id,array $request)
    {
        return Settlement::query()->where("id", $id)->update([
            "from" => [
                "name" => $request["from"]["name"],
                "cart" => $request["from"]["cart"]
            ],
            "to" => [
                "name" => $request["to"]["name"],
                "cart" => $request["to"]["cart"]
            ],
            "status" => $request["status"]
        ]);
    }

    public function paginate()
    {
        return $this->query->paginate();
    }

    public function Settled()
    {
        $this->query->where("status", Settlement::STATUS_SETTLED);

        return $this;
    }

    public function find($settlement)
    {
        return $this->query->findOrFail($settlement);
    }
}

