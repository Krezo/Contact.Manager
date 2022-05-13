<?php

namespace App\Http\Controllers;

use App\Actions\Contact\AddFavoriteContactAction;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;

class AddContactToFavoriteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id, AddFavoriteContactAction $action)
    {
        return new ContactResource($action->handle($id));
    }
}
