<?php
namespace Milano\Product\Rules;
use Illuminate\Contracts\Validation\Rule;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Repositories\UserRepo;

class ValidSeller implements Rule
{

    public function passes($attribute, $value)
    {
        $user = resolve( UserRepo::class)->findById($value);
       return $user->hasPermissionTo(Permission::PERMISSION_SELL);
    }

    public function message()
    {
        return "کاربر انتخاب شده یک فروشنده معتبر نیست.";
    }
}
