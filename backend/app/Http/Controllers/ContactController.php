<?php

namespace App\Http\Controllers;

use App\Actions\Contact\AddFavoriteContactAction;
use App\Actions\Contact\DeleteFavoriteContactAction;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class ContactController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Список всех контактов
     *
     * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ContactResource::collection(Contact::all());
    }

    /**
     * Добавление контака в список избранного пользователя
     *
     * @param  int $id
     * @param  AddFavoriteContactAction $action
     * @return ContactResource | \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function addToFavorite(int $id, AddFavoriteContactAction $action)
    {
        try {
            return new ContactResource($action->handle($id));
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Контакт не найден'], 404);
        }
    }

    /**
     * Удаление контакта из списка избранного пользователем
     *
     * @param  int $id
     * @param  DeleteFavoriteContactAction $action
     * @return void | \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function deleteFromFavorite(int $id, DeleteFavoriteContactAction $action)
    {
        try {
            $action->handle($id);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Контакт не найден'], 404);
        }
    }

    /**
     * Список всех избранных контактов пользователя
     *
     * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function favorite(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ContactResource::collection(Auth::user()->favoriteContacts);
    }
}
