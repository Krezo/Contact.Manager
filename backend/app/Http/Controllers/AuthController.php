<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:sanctum'])->except(['login', 'register']);
  }

  public function login(LoginRequest $request, LoginAction $action)
  {
    if ($action->handle($request)) {
      $request->session()->regenerate();
      return response('', 200);
    } else
      return response([
        'message' => 'Выввели неверный логин/пароль'
      ], 401);
  }

  public function user(Request $request)
  {
    return new UserResource($request->user());
  }

  public function register(RegisterRequest $request, RegisterAction $action)
  {
    try {
      return new UserResource($action->handle($request));
    } catch (Exception $e) {
      return response(['message' => $e->getMessage()], 409);
    }
  }
}
