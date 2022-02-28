<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Tests\Feature\BaseTest;

class ProductControllerTest extends BaseTest
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

        $response = $this->get(route('admin.products.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Product</h1>', false);
    }
    public function test_index_fail()
    {
        $response = $this->get(route('admin.products.index'));

        $response->assertStatus(302);

        $response->assertRedirect(route('login'));
    }
    public function test_create()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.products.create'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Product Add</h1>', false);
    }
    public function test_post_create_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.products.create.store'), [
            'name' => $this->faker->text(50),
            'price' => $this->faker->randomNumber(6, true),
            'quantity' => $this->faker->numberBetween(1, 5),
            'brand_id' => $this->faker->numberBetween(1, 10),
            'expired_date' => '20/09/2020',
            'unit_id' => $this->faker->numberBetween(1, 10),
            'barcode' => $this->faker->randomNumber(9, true),
            'category_id' => $this->faker->numberBetween(1, 20),
            'created_by' => $this->faker->numberBetween(1, 3),
            'description' => $this->faker->text(300),
            'published' => $this->faker->boolean(),
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.products.index'));
    }
    public function test_post_create_fail()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.products.create.store'), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_edit()
    {
        $product = Product::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.products.edit', $product->id));

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

        $response = $this->get(route('admin.products.edit', $id));
        $response->assertStatus(404);
    }
    public function test_put_edit_success()
    {
        $product = Product::factory()->create();

        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.products.edit.update', $product->id), [
            'name' => $this->faker->text(50),
            'price' => $this->faker->randomNumber(6, true),
            'quantity' => $this->faker->numberBetween(1, 5),
            'brand_id' => $this->faker->numberBetween(1, 10),
            'expired_date' => '20/09/2020',
            'unit_id' => $this->faker->numberBetween(1, 10),
            'barcode' => $this->faker->randomNumber(9, true),
            'category_id' => $this->faker->numberBetween(1, 20),
            'created_by' => $this->faker->numberBetween(1, 3),
            'description' => $this->faker->text(300),
            'published' => $this->faker->boolean(),
        ]);
        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.products.index'));
    }
    public function test_put_edit_fail_if_empty()
    {
        $product = Product::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.products.edit.update', $product->id), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_delete_success()
    {
        $product = Product::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.products.delete', $product->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.products.index'));
        $response->withSession(['success' => 'Delete Product successfully!']);
    }
    public function test_delete_fail()
    {
        $id = rand(2, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.products.delete', $id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.products.index'));
        $response->withSession(['info' => 'Product not found!']);
    }
    public function test_view()
    {
        $product = Product::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.products.view', $product->id));
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

        $response = $this->get(route('admin.products.view', $id));
        $response->assertStatus(404);
    }
}
