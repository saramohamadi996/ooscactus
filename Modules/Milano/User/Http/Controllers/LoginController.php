<?php

namespace Milano\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Milano\User\Http\Requests\LoginRequest;
use Milano\User\Repositories\Interfaces\LoginRepositoryInterface;
use Milano\User\Repositories\Interfaces\VerifyCodeRepositoryInterface;

class LoginController extends Controller
{
    /**
     * The Verify code history repository instance.
     * The user repository instance.
     * @var LoginRepositoryInterface
     */
    protected LoginRepositoryInterface $login_repository;
    protected VerifyCodeRepositoryInterface $verify_code_repository;

    /**
     * Instantiate a new verify code history instance.
     * Instantiate a new user instance.
     * @param LoginRepositoryInterface $login_repository
     * @param VerifyCodeRepositoryInterface $verify_code_repository
     */
    public function __construct(LoginRepositoryInterface      $login_repository,
                                VerifyCodeRepositoryInterface $verify_code_repository)
    {
        $this->login_repository = $login_repository;
        $this->verify_code_repository = $verify_code_repository;
    }

    /**
     * Show the create form.
     * @param LoginRequest $login_request
     */
    public function login(LoginRequest $login_request)
    {
        $status = $this->verify_code_repository->status($login_request);

        if ($status && $status->is_deleted == true) {
            return response()->json([
                'message' => 'این شماره از سیستم حذف شده و قابل استفاده نمی باشد.'
            ], 400);
        }
        if ($status && $status->is_blocked == true) {
            return response()->json([
                'message' => 'این شماره به دلیل عدم رعایت قوانین مسدود می باشد.'
            ], 400);
        }

        $login_request->only(['mobile']);
        $result = $this->login_repository->login($login_request);
        if ($result){
            return response()->json(['message' => 'کد فعال سازی با موفقیت ارسال شد'], 201);
        }
        return response()->json([
            'message' => 'خطایی در ارسال کد تایید رخ داده است. لطفا دقایقی بعد مجددا تلاش نمایید.'
        ], 400);
    }
}
