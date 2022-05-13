<?php

namespace App\Actions\Contact;

use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteFavoriteContactAction
{
  /**
   * Action: Удаляем контак из списка избранного пользователя
   *
   * @param  int $id
   * @throws ModelNotFoundException
   * @return void
   */
  public function handle(int $id)
  {
    $findedContact = Contact::findOrFail($id);
    Auth::user()->favoriteContacts()->detach($findedContact->id);
  }
}
