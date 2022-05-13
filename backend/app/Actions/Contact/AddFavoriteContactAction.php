<?php

namespace App\Actions\Contact;

use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class AddFavoriteContactAction
{
  /**
   * Action : Добавляет контак в список избранного пользователя
   *
   * @param  int $id Идентификатор добавлямого контакта
   * @throws ModelNotFoundException
   * @return Contact Модель контакта
   */
  public function handle(int $id): Contact
  {
    $findedContact = Contact::findOrFail($id);
    $userFavoriteContactsQuery = Auth::user()->favoriteContacts();
    // Если контак уже есть в списке избранного, то не добавляем его
    if (!$userFavoriteContactsQuery->find($id)) $userFavoriteContactsQuery->attach($findedContact->id);
    return $findedContact;
  }
}
