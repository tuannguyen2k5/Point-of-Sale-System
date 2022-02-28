<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Tests\Feature\BaseTest;

class BrandControllerTest extends BaseTest
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

        $response = $this->get(route('admin.brands.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Brand</h1>', false);
    }
    public function test_index_fail()
    {
        $response = $this->get(route('admin.brands.index'));

        $response->assertStatus(302);

        $response->assertRedirect(route('login'));
    }
    public function test_create()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.brands.create'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Brand Add</h1>', false);
    }
    public function test_post_create_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.brands.create.store'), [
            'name' => $this->faker->text(15),
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.brands.index'));
    }
    public function test_post_create_fail_if_empty_name()
    {
        $this->be($this->user);

        $response =  $this->post(route('admin.brands.create.store'), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_edit()
    {
        $brand = Brand::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.brands.edit', $brand->id));

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

        $response = $this->get(route('admin.brands.edit', $id));
        $response->assertStatus(404);
    }
    public function test_put_edit_success()
    {
        $brand = Brand::factory()->create();

        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.brands.edit.update', $brand->id), [
            'name' => $this->faker->text(15),
        ]);
        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.brands.index'));
    }
    public function test_put_edit_fail_if_empty()
    {
        $brand = Brand::factory()->create();
        $this->be($this->user);
        $response =  $this->put(route('admin.brands.edit.update', $brand->id), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_delete_success()
    {
        $brand = Brand::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.brands.delete', $brand->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.brands.index'));
        $response->withSession(['success' => 'Delete brand successfully!']);
    }
    public function test_delete_fail()
    {
        $id = rand(2, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.brands.delete', $id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.brands.index'));
        $response->withSession(['info' => 'Brand not found!']);
    }
    public function test_view()
    {
        $brand = Brand::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.brands.view', $brand->id));
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

        $response = $this->get(route('admin.brands.view', $id));
        $response->assertStatus(404);
    }
}
