<?php

namespace Milano\User\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Milano\User\Http\Requests\LoginRequest;
use Milano\User\Http\Requests\VerifyCodeRequest;
use Milano\User\Repositories\Interfaces\LoginRepositoryInterface;
use Milano\User\Repositories\Interfaces\VerifyCodeRepositoryInterface;

class VerifyCodeController extends Controller
{
    /**
     * The user repository instance.
     * The verify code history repository instance.
     * @var VerifyCodeRepositoryInterface
     * @var LoginRepositoryInterface
     */
    protected VerifyCodeRepositoryInterface $verify_code_repository;
    protected LoginRepositoryInterface $login_repository;

    /**
     * Instantiate a new user instance.
     * Instantiate a new verify code history instance.
     * @param VerifyCodeRepositoryInterface $user_repository
     * @param LoginRepositoryInterface $login_repository
     */
    public function __construct(VerifyCodeRepositoryInterface $user_repository,
                                LoginRepositoryInterface $login_repository)
    {
        $this->verify_code_repository = $user_repository;
        $this->login_repository = $login_repository;
    }

    /**
     *  Get a JWT token via given credentials.
     * @param loginRequest $login_request
     * @param VerifyCodeRequest $verify_code_request
     * @return JsonResponse
     */
    public function auth(loginRequest $login_request, VerifyCodeRequest $verify_code_request): JsonResponse
    {
        $login = $verify_code_request->only(['mobile', 'verify_code']);
        $getRow = $this->login_repository->user($verify_code_request);
        if ($getRow && $login['verify_code'] == $getRow->verify_code) {

            $login_request->only(['mobile']);
            $user = $this->verify_code_repository->auth($login_request);
            if ($user) {
                $token = auth()->login($user);
                return $this->respondWithToken($token, $user);
            }
            return response()->json(['massage' => 'با موفقیت انجام شد.'], 201);
        }
        return response()->json(['message' => 'کد وارد شده اشتباه است.'], 400);
    }

    /** Get the token array structure.
     * @param string $token
     * @param $user
     * @return JsonResponse
     */
    protected function respondWithToken(string $token, $user): JsonResponse
    {
        try {
            return response()->json([
                'name' => $user->first_name . ' ' . $user->last_name,
                'mobile' => $user->mobile,
                'profile_pic_url' => $user->profile_pic_url,
                'is_new' => !((isset($user->first_name) && !empty($user->first_name))),
                'is_karchi' => !($user->role == 'employer'),
                'token' => $token,
            ], 201);
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' =>
                'شناسه ارتباطی شما در سیستم ما موجود نمی باشد. لطفا مجددا مراحل ثبت نام را از ابتدا طی نمایید.'
            ], 401);
        }
    }
}
