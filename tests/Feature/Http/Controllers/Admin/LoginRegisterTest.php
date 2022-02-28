<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginRegisterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);
        
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanViewLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login')->assertSee('Sign in');
    }
    
    public function testUserCanViewRegister()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register')->assertSee('Register');
    }

    public function testCanRegister()
    {
        $this->be($this->user);

        $response = $this->post(route('register.create'), [

        ]);

        $response->assertStatus(302)->assertRedirect('/login');
        $this->assertAuthenticated();
    }

    public function testCanLogin()
    {
        $this->assertGuest();
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $this->post(route('login.authenticate'), [
            'email' => $this->user->email,
            'password' => 'password',
        ])
        ->assertStatus(302)
        ->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->user);

    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $response = $this->from(route('login'))
        ->post(route('login.authenticate'), [
            'email' => $this->user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();

    }

    public function tearDown():void
    {
        parent::tearDown();
    }

}
