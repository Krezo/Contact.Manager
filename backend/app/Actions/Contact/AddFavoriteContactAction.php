<?php

namespace App\Actions\Contact;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddFavoriteContactAction
{
  /**
   * handle
   *
   * @param  mixed $id
   * @throws NotFoundHttpException
   * @return Contact
   */
  public function handle(int $id): Contact
  {
    $findedContact = Contact::findOrFail($id);
    Auth::user()->favoriteContacts()->attach($findedContact->id);
    return $findedContact;
  }
}
