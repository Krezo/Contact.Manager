<?php

namespace App\Http\Controllers;

use App\Actions\Contact\AddFavoriteContactAction;
use App\Actions\Contact\DeleteFavoriteContactAction;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ContactResource::collection(Contact::all());
    }

    public function addToFavorite(int $id, AddFavoriteContactAction $action): ContactResource
    {
        return new ContactResource($action->handle($id));
    }

    public function deleteFromFavorite(int $id, DeleteFavoriteContactAction $action)
    {
        $action->handle($id);
    }

    public function favorite(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ContactResource::collection(Auth::user()->favoriteContacts);
    }
}
