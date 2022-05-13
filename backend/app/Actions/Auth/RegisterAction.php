<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
  public function handle(RegisterRequest $request): User
  {
    if (User::where('email', $request['email'])->first()) {
      throw new Exception('Пользователь с таким email уже существует', 1);
    }
    return User::create([
      'name' => $request->get('name'),
      'email' => $request->get('email'),
      'password' => Hash::make($request->get('password'))
    ]);
  }
}
