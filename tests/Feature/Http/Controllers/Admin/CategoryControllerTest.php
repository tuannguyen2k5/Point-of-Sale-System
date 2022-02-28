<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\TaxRate;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\RoleTableSeeder;
use Tests\Feature\BaseTest;

class CategoryControllerTest extends BaseTest
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

        $response = $this->get(route('admin.categories.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Categories</h1>', false);
    }
    public function test_index_fail()
    {
        $response = $this->get(route('admin.categories.index'));

        $response->assertStatus(302);

        $response->assertRedirect(route('login'));
    }
    public function test_create()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.categories.create'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Category Add</h1>', false);
    }
    public function test_post_create_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.categories.create.store'), [
            'name' => $this->faker->text(30),
            'parent_id' => $this->faker->numberBetween(1, 10),
            'tax_id' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->text(100),
            'google_category_id' => $this->faker->numberBetween(1000, 1010),
            'facebook_category_id' => $this->faker->numberBetween(1, 10),
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.categories.index'));
        $response->withSession(['success' => 'Create Category successfully!']);
    }
    public function test_post_create_fail()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.categories.create.store'), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_edit()
    {
        $category = Category::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.categories.edit', $category->id));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Edit</h3>', false);
    }
    public function test_edit_fail()
    {
        $id = rand(40, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.categories.edit', $id));
        $response->assertNotFound();
    }
    public function test_put_edit_success()
    {
        $category = Category::factory()->create();

        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.categories.edit.update', $category->id), [
            'name' => $this->faker->text(30),
            'parent_id' => $this->faker->numberBetween(1, 10),
            'tax_id' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->text(100),
            'google_category_id' => $this->faker->numberBetween(1000, 1010),
            'facebook_category_id' => $this->faker->numberBetween(1, 10),
        ]);
        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.categories.index'));
        $response->withSession(['success' => 'Update Category successfully!']);
    }
    public function test_put_edit_fail_if_empty()
    {
        $category = Category::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.categories.edit.update', $category->id), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_delete_success()
    {
        $category = Category::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.categories.delete', $category->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.categories.index'));
        $response->withSession(['success' => 'Delete Category successfully!']);
    }
    public function test_delete_fail()
    {
        $id = rand(2, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.categories.delete', $id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.categories.index'));
        $response->withSession(['info' => 'Category not found!']);
    }
    public function test_view()
    {
        $category = Category::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.categories.view', $category->id));
        $response->assertStatus(200);
        $response->assertSee('<h3 class="card-title">Information</h3>', false);
    }
    public function test_view_fail()
    {
        $id = rand(1, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.categories.view', $id));
        $response->assertStatus(404);
    }
}
