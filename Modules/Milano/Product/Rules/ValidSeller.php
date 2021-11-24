<?php
namespace Milano\Product\Rules;
use Illuminate\Contracts\Validation\Rule;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Repositories\UserRepo;

class ValidSeller implements Rule
{
    /**
     * Check the status of the selected seller.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = resolve( UserRepo::class)->findById($value);
       return $user->hasPermissionTo(Permission::PERMISSION_SELL);
    }

    /**
     * Error message.
     * @return array|string
     */
    public function message()
    {
        return "کاربر انتخاب شده یک فروشنده معتبر نیست.";
    }
}
