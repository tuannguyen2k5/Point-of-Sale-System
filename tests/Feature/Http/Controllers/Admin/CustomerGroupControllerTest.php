<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\CustomerGroup;
use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Tests\Feature\BaseTest;

class CustomerGroupControllerTest extends BaseTest
{
    protected static $migrationRun = false;
    public function setUp(): void
    {
        parent::setUp();
        if (!static::$migrationRun) {
            $this->artisan('migrate:refresh');
            $this->seed(RoleTableSeeder::class);
            static::$migrationRun = true;
        }
        $this->user = User::factory()->create([
            'password' => 'password'
        ]);
    }
    public function test_index_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.customergroups.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Customer Group</h1>', false);
    }
    public function test_index_fail()
    {
        $response = $this->get(route('admin.customergroups.index'));

        $response->assertStatus(302);

        $response->assertRedirect(route('login'));
    }
    public function test_create()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.customergroups.create'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Customer Group Add</h1>', false);
    }
    public function test_post_create_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.customergroups.create.store'), [
            'group_name' => $this->faker->text(10),
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.customergroups.index'));
    }

    public function test_post_create_fail_if_empty_groupname()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.customergroups.create.store'), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_edit()
    {
        $customergroup = CustomerGroup::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.customergroups.edit', $customergroup->id));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Edit</h3>', false);
    }
    public function test_show_edit_fail()
    {
        $id = rand(2, 10);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.customergroups.edit', $id));
        $response->assertStatus(404);
    }
    public function test_put_edit_success()
    {
        $customergroup = CustomerGroup::factory()->create();

        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.customergroups.edit.update', $customergroup->id), [
            'group_name' => $this->faker->text(10),
        ]);
        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.customergroups.index'));
    }
    public function test_put_edit_fail_if_empty_groupname()
    {
        $customergroup = CustomerGroup::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.customergroups.edit.update', $customergroup->id), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_delete_success()
    {
        $customergroup = CustomerGroup::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.customergroups.delete', $customergroup->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.customergroups.index'));
        $response->withSession(['success' => 'Delete customergroup successfully!']);
    }
    public function test_delete_fail()
    {
        $id = rand(2, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.customergroups.delete', $id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.customergroups.index'));
        $response->withSession(['info' => 'Customer group not found!']);
    }
    public function test_view()
    {
        $customergroup = CustomerGroup::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.customergroups.view', $customergroup->id));
        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Information</h3>', false);
    }
    public function test_show_view_fail()
    {
        $id = rand(2, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.customergroups.view', $id));
        $response->assertStatus(404);
    }
}
