<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Milano\Cart\Models\Cart;

class DeleteCart extends Command
{
    protected $signature = 'command:deletecart';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $cart = Cart::where('expired_at' , '<' , Carbon::now())->delete();
        return 0;
    }
}
