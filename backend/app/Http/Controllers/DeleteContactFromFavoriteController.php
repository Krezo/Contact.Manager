<?php

namespace App\Http\Controllers;

use App\Actions\Contact\DeleteFavoriteContactAction;
use App\Http\Resources\ContactResource;

class DeleteContactFromFavoriteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, DeleteFavoriteContactAction $action)
    {
        return new ContactResource($action->handle($id));
    }
}
