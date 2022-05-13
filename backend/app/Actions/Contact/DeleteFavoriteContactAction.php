<?php

namespace App\Actions\Contact;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteFavoriteContactAction
{
  public function handle(int $id)
  {
    $findedContact = Contact::find($id);
    Auth::user()->favoriteContacts()->detach($findedContact->id);
  }
}
