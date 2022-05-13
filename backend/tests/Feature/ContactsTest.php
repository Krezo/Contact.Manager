<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Тест только зарегистированный пользователь может получить список контактов
     *
     * @return void
     */
    public function test_contacts_can_see_only_registered_users()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('contacts'));
        $response->assertStatus(200);
    }

    /**
     * Тест незарегистрированный пользователь пытается получить список контактов
     *
     * @return void
     */
    public function test_not_registered_user_training_to_get_contacts()
    {
        $response = $this->getJson(route('contacts'));
        $response->assertStatus(401);
    }

    /**
     * Тест зарегистрированный пользователь пытается получить список контактов
     *
     * @return void
     */
    public function test_registered_user_get_favorite_contacts()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('favorite_contacts'));
        $response->assertStatus(200);
    }

    /**
     * Тест незарегистрированный пользователь пытается получить список контактов
     *
     * @return void
     */
    public function test_not_registered_user_get_favorite_contacts()
    {
        $response = $this->getJson(route('favorite_contacts'));
        $response->assertStatus(401);
    }

    /**
     * Тест зарегистрированный пользователь добавляет контакт в избранное
     *
     * @return void
     */
    public function test_registered_user_add_contact_to_favorite()
    {
        $user = User::factory()->create();
        Contact::factory()->count(20)->create();
        $randomContact = Contact::inRandomOrder()->first();
        $response = $this->actingAs($user)->getJson(route('add_contact', $randomContact->id));
        $response->assertStatus(200);
    }

    /**
     * Тест зарегистрированный пользователь добавляет уже добавленный контакт в избранное
     *
     * @return void
     */
    public function test_registered_user_add_already_favorite_contact_to_favorite()
    {
        $user = User::factory()->create();
        Contact::factory()->count(20)->create();
        $randomContact = Contact::inRandomOrder()->first();
        $user->favoriteContacts()->attach($randomContact);
        $response = $this->actingAs($user)->getJson(route('add_contact', $randomContact->id));
        $response->assertStatus(200);
    }

    /**
     * Тест незарегистрированный пользователь добавляет контакт в избранное
     *
     * @return void
     */
    public function test_not_registered_user_add_contact_to_favorite()
    {
        Contact::factory()->count(20)->create();
        $randomContact = Contact::inRandomOrder()->first();
        $response = $this->getJson(route('add_contact', $randomContact->id));
        $response->assertStatus(401);
    }

    /**
     * Тест зарегистрированный пользователь удаляет контакт из избранного
     *
     * @return void
     */
    public function test_registered_user_delete_contact_from_favorite()
    {
        Contact::factory()->count(20)->create();
        $user = User::factory()->create();
        $randomContact = Contact::inRandomOrder()->first();
        $user->favoriteContacts()->attach($randomContact);
        $response = $this->actingAs($user)->getJson(route('delete_contact', $randomContact->id));
        $response->assertStatus(200);
    }


    /**
     * Тест зарегистрированный пользователь удаляет несуществующий контак из избранного
     *
     * @return void
     */
    public function test_registered_user_delete_non_exist_contact_from_favorite()
    {
        Contact::factory()->count(20)->create();
        $user = User::factory()->create();
        $randomContact = Contact::inRandomOrder()->first();
        $user->favoriteContacts()->attach($randomContact);
        $user->favoriteContacts()->detach($randomContact);
        $response = $this->actingAs($user)->getJson(route('delete_contact', $randomContact->id));
        $response->assertStatus(200);
    }

    /**
     * Тест зарегистрированный пользователь удаляет контакт из избранного
     *
     * @return void
     */
    public function test_not_registered_user_delete_contact_from_favorite()
    {
        Contact::factory()->count(20)->create();
        $randomContact = Contact::inRandomOrder()->first();
        $response = $this->getJson(route('delete_contact', $randomContact->id));
        $response->assertStatus(401);
    }
}
