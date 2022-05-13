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
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:sanctum'])->except(['login', 'register']);
  }

  /**
   * Вход пользователя
   *
   * @param  LoginRequest $request
   * @param  LoginAction $action
   * @return void | \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function login(LoginRequest $request, LoginAction $action)
  {
    if (!$action->handle($request)) return response([
      'message' => 'Вы ввели неверный логин/пароль'
    ], 401);
  }

  /**
   * Получение пользователя
   *
   * @param  Request $request
   * @return UserResource
   */
  public function user(Request $request): UserResource
  {
    return new UserResource($request->user());
  }

  /**
   * Регистрация пользователя
   *
   * @param  RegisterRequest $request
   * @param  RegisterAction $action
   * @return UserResource | \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function register(RegisterRequest $request, RegisterAction $action)
  {
    try {
      return new UserResource($action->handle($request));
    } catch (Exception $e) {
      return response(['message' => $e->getMessage()], 409);
    }
  }
}
