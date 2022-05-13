<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Тест регистрация ползователя
     *
     * @return void
     */
    public function test_register_user()
    {
        $response = $this->postJson(route('register'), [
            'name' => 'test123',
            'email' => 'test@test.test1123',
            'password' => 'test123'
        ]);
        $response->assertCreated();
    }

    /**
     * Тест создание пользователя с одинаковым email
     * 
     * @return void
     */
    public function test_register_same_user()
    {
        $userData = [
            'name' => 'test123',
            'email' => 'test@test.test1123',
            'password' => 'test123'
        ];
        $this->postJson(route('register'), $userData);
        $response = $this->postJson(route('register'), $userData);
        $response->assertStatus(409);
    }

    /**
     * Тест некорректных данных пользователя при регистрации
     *
     * @return void
     */
    public function test_invalidated_register_params()
    {
        $validUser = [
            'name' => 'test123',
            'email' => 'test@test.test1123',
            'password' => 'test123'
        ];

        // Name
        $userWithEmptyName = array_merge($validUser, ['name' => '']);
        $response = $this->postJson(route('register'), $userWithEmptyName);
        $response->assertStatus(422);

        // Email
        $userWithEmptyEmail = array_merge($validUser, ['email' => '']);
        $response = $this->postJson(route('register'), $userWithEmptyEmail);
        $response->assertStatus(422);

        $userWithInvalidEmail = array_merge($validUser, ['email' => '123']);
        $response = $this->postJson(route('register'), $userWithInvalidEmail);
        $response->assertStatus(422);

        // Password
        $userWithEmptyPassword = array_merge($validUser, ['password' => '']);
        $response = $this->postJson(route('register'), $userWithEmptyPassword);
        $response->assertStatus(422);

        $userWithShortPassword = array_merge($validUser, ['password' => '1234']);
        $response = $this->postJson(route('register'), $userWithShortPassword);
        $response->assertStatus(422);
    }

    /**
     * Тест пользователь вводит верный данные
     *
     * @return void
     */
    public function test_user_can_login_with_corrent_credentional()
    {
        $user = User::factory()->create([
            'password' => Hash::make($password = '123456')
        ]);

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => $password
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Тест пользователь вводит неверный пароль
     *
     * @return void
     */
    public function test_user_login_with_wrong_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make($password = '123456')
        ]);

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => $password . 'test'
        ]);

        $response->assertStatus(401);
    }
}
