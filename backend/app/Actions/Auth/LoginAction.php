<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
  public function handle(LoginRequest $request): bool
  {
    return Auth::attempt($request->only([
      'email',
      'password'
    ]));
  }
}
