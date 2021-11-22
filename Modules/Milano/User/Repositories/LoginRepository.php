<?php

namespace Milano\User\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Milano\User\Models\VerifyCode;
use Milano\User\Repositories\Interfaces\LoginRepositoryInterface;

class LoginRepository implements LoginRepositoryInterface
{
    /**
     * Create a new mobile and verify code or update an existing verify code.
     * @param $value
     * @return bool
     */
    public function login($value):bool
    {
        $verify_code = rand(10000, 99999);
        $mobile = $value->input(['mobile']);
        try {
            VerifyCode::where('mobile', $mobile)->update([
                'verify_code' => $verify_code
            ], ['upsert' => true]);

            $kavenegar_gateway = new KavenegarGateway();
            $sms_dot_irGateway = new SmsDotIrGateway();
            if ($value->input(['call']) !== null && $value->input(['call']) == 'call') {
                $kavenegar_gateway->setGateway(new KavenegarRepository());
                $kavenegar_gateway->sendCallVerificationKaveNegar($mobile, $verify_code, 'call');
            }
            else {
                $sms_dot_irGateway->setGateway(new SmsDotIrRepository());
                $sms_dot_irGateway->sendVerificationCodeSmsDotIr($mobile, $verify_code);
            }

        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Get mobile and verify code and match database.
     * @param $value
     * @return bool
     */
    public function user($value)
    {
        $result = VerifyCode::where('mobile', $value['mobile'])->first();
        try {
            return $result;
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
    }
}
