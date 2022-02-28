<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => 'password'
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_show_index()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response = $this->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('<h1>Users Manage</h1>',false);
        $response->assertSee('table table-striped table-hover');
    }

    public function test_can_not_show_index()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('1',false);

        $response = $this->get(route('admin.users.index'));

        $response->assertStatus(401);
    }

    public function test_can_show_edit()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response = $this->get(route('admin.users.edit'));

        $response->assertStatus(200);
        $response->assertSee('<h1>Users Manage</h1>',false);
        $response->assertSee('row justify-content-center');
    }

    public function test_can_not_show_edit()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('1',false);

        $response = $this->get(route('admin.users.edit'));

        $response->assertStatus(401);
    }

    public function test_can_add_role()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response = $this->post(route('admin.users.edit.store'),[
            '_token' => csrf_token(),
            'role_id' => '2',
            'add' =>'add',
            'users'=>'1',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.users.edit'));
        $response->withSession(['success' => 'Add role successfully!']);
    }

    public function test_can_remove_role()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response = $this->post(route('admin.users.edit.store'),[
            '_token' => csrf_token(),
            'role_id' => '2',
            'remove' =>'remove',
            'users'=>'1',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.users.edit'));
        $response->withSession(['success' => 'Remove role successfully!']);
    }

    public function test_can_delete_user()
    {
        $userN = User::factory()->create();

        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response =  $this->delete(route('admin.users.delete', $userN->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.users.index'));
        $response->withSession(['success' => 'Delete user successfully!']);
    }

}
