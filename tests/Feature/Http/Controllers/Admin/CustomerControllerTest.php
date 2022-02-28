<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Tests\Feature\BaseTest;

class CustomerControllerTest extends BaseTest
{
    protected static $migrationRun = false;
    public function setUp(): void
    {
        parent::setUp();
        if(!static::$migrationRun){
            $this->artisan('migrate:fresh');
            $this->seed(RoleTableSeeder::class);
            static::$migrationRun = true;
        }
        $this->user = User::factory()->create([
            'password' => 'password'
        ]);
        //$this->seed(RoleTableSeeder::class);
    }
    public function test_index_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response = $this->get(route('admin.customers.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Customer Manage</h1>', false);
    }
    public function test_index_fail()
    {
        $response = $this->get(route('admin.customers.index'));

        $response->assertStatus(302);

        $response->assertRedirect(route('login'));
    }
    public function test_create()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response = $this->get(route('admin.customers.create'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Customer Add</h1>', false);
    }
    public function test_post_create_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response =  $this->post(route('admin.customers.create.store'), [
            'name' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.customers.index'));
    }
    public function test_post_create_fail_if_empty_name()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response =  $this->post(route('admin.customers.create.store'), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_edit()
    {
        $customer = Customer::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response = $this->get(route('admin.customers.edit', $customer->id));

        $response->assertStatus(200);

        $response->assertSee('<h1>Edit Customer</h1>', false);
    }
    public function test_put_edit_success()
    {
        $customer = Customer::factory()->create();

        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);

        $response =  $this->put(route('admin.customers.edit.update', $customer->id), [
            'name' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ]);
        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.customers.index'));
    }
    public function test_put_edit_fail_if_empty()
    {
        $customer = Customer::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);
        $response =  $this->put(route('admin.customers.edit.update', $customer->id), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_delete_success()
    {
        $customer = Customer::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);
        $response =  $this->delete(route('admin.customers.delete', $customer->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.customers.index'));
        $response->withSession(['success' => 'Delete customer successfully!']);
    }
    public function test_delete_fail()
    {
        $id = rand(2, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);
        $response =  $this->delete(route('admin.customers.delete', $id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.customers.index'));
        $response->withSession(['info' => 'Customer not found!']);
    }
    public function test_view()
    {
        $customer = Customer::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3',false);
        $response = $this->get(route('admin.customers.view', $customer->id));
        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Information</h3>', false);
    }
}
