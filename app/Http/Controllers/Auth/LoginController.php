<?php

namespace Fitest\Http\Controllers\Auth;

use Fitest\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Fitest\Http\Requests\UserLoginRequest;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * It is used to rewrite the same name functin in AuthenticatesUsers class.
     * In the AuthenticatesUsers class, the username function's return is fixed, it always returns email.
     * In my way, it can be returned email or username.
     *
     * @return string
     */
    protected function username()
    {
        return filter_var(request()->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * Rewrite login function in AuthenticatesUsers class for username or password login.
     *
     * @param  Fitest\Http\Requests\UserLoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(UserLoginRequest $request)
    {
        $request->validated();

        //merge input type email or username into request for the check login.
        $request->merge([ $this->username() => $request->input('username') ]);

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
}
