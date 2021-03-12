<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public $email;
    public $password;

    public function testRegister()
    {
        $user = User::factory()->make();

        $response = $this->post('/api/auth/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);

        $this->email = $user->email;
        $this->password = '123456';
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'fabricioprabelo@gmail.com',
            'password' => '776DY18i',
        ]);

        $response->assertStatus(200);

        // Cache::put('token', $response['access_token'], 600);
    }
}
