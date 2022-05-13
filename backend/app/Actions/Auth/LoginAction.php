<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
  /**
   * Аутентификация пользователя
   *
   * @param  LoginRequest $request
   * @return bool
   */
  public function handle(LoginRequest $request): bool
  {
    $isAuth =  Auth::attempt($request->only([
      'email',
      'password'
    ]));
    $request->session()->regenerate();
    return $isAuth;
  }
}
