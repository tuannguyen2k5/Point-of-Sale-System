<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Biller;
use App\Models\Store;
use App\Models\User;
use Database\Seeders\BillerSeeder;
use Database\Seeders\RoleTableSeeder;
use Tests\Feature\BaseTest;

class BillerControllerTest extends BaseTest
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

        $response = $this->get(route('admin.billers.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Biller Manage</h1>', false);
    }
    public function test_index_fail()
    {
        $response = $this->get(route('admin.billers.index'));

        $response->assertStatus(302);

        $response->assertRedirect(route('login'));
    }
    public function test_create()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);

        $response = $this->get(route('admin.billers.create'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Biller Add</h1>', false);
    }
    public function test_post_create_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);

        $response =  $this->post(route('admin.billers.create.store'), [
            'store_id' => $this->faker->numberBetween(1, 5),
            'name' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.billers.index'));
    }
    public function test_post_create_fail_if_empty_name()
    {
        $this->be($this->user);

        $response =  $this->post(route('admin.billers.create.store'), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_edit()
    {
        $biller = Biller::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);

        $response = $this->get(route('admin.billers.edit', $biller->id));

        $response->assertStatus(200);

        $response->assertSee('<h1>Edit Biller</h1>', false);
    }
    public function test_show_edit_fail()
    {
        $id = rand(2, 10);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.billers.edit', $id));
        $response->assertStatus(404);
    }
    public function test_put_edit_success()
    {
        $biller = Biller::factory()->create();

        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);

        $response =  $this->put(route('admin.billers.edit.update', $biller->id), [
            'store_id' => $this->faker->numberBetween(1, 5),
            'name' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ]);
        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.billers.index'));
    }
    public function test_put_edit_fail_if_empty()
    {
        $biller = Biller::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);

        $response =  $this->put(route('admin.billers.edit.update', $biller->id), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_delete_success()
    {
        $biller = Biller::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);

        $response =  $this->delete(route('admin.billers.delete', $biller->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.billers.index'));
        $response->withSession(['success' => 'Delete biller successfully!']);
    }
    public function test_delete_fail()
    {
        $id = rand(2, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);

        $response =  $this->delete(route('admin.billers.delete', $id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.billers.index'));
        $response->withSession(['info' => 'Biller not found!']);
    }
    public function test_view()
    {
        $store = Store::factory()->create();
        $biller = Biller::factory()->create(['store_id' => $store->id]);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);

        $response = $this->get(route('admin.billers.view', $biller->id));
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

        $response = $this->get(route('admin.billers.view', $id));
        $response->assertStatus(404);
    }
}
