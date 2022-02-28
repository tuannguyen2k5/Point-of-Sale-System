<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\GoogleCategory;
use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Tests\Feature\BaseTest;

class GoogleCategoryTest extends BaseTest
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
    public function test_can_show_index()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);
        $response = $this->get(route('admin.google-categories.index'));

        $response->assertStatus(200);
        $response->assertSee('<h1>Google Category Manage</h1>', false);
    }
    public function test_index_fail()
    {
        $response = $this->get(route('admin.facebook-categories.index'));

        $response->assertStatus(302);

        $response->assertRedirect(route('login'));
    }
    public function test_create()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.google-categories.create'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Google Category Add</h1>', false);
    }
    public function test_post_create_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.google-categories.create.store'), [
            'category_id' => $this->faker->numberBetween(1, 10),
            'category_name' => $this->faker->unique()->name(),
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.google-categories.index'));
        $response->withSession(['success' => 'Create Google Category successfully!']);
    }
    public function test_post_create_fail_if_empty_name()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.google-categories.create.store'), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_show_edit()
    {
        $googleCategory = GoogleCategory::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.google-categories.edit', $googleCategory->id));

        $response->assertStatus(200);

        $response->assertSee('<h1>Edit Google Category</h1>', false);
    }
    public function test_show_edit_fail()
    {
        $id = rand(2, 10);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.google-categories.edit', $id));
        $response->assertStatus(404);
    }
    public function test_put_edit_success()
    {
        $googleCategory = GoogleCategory::factory()->create();

        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.google-categories.edit.update', $googleCategory->id), [
            'category_id' => $this->faker->numberBetween(1, 10),
            'category_name' => $this->faker->unique()->name(),
        ]);
        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.google-categories.index'));

        $response->withSession(['success' => 'Update Google Category successfully!']);
    }
    public function test_put_edit_fail_if_empty()
    {
        $googleCategory = GoogleCategory::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.google-categories.edit.update', $googleCategory->id), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_delete_success()
    {
        $googleCategory = GoogleCategory::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.google-categories.delete', $googleCategory->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.google-categories.index'));
        $response->withSession(['success' => 'Delete Google Category successfully!']);
    }
    public function test_delete_fail()
    {
        $id = rand(2, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.google-categories.delete', $id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.google-categories.index'));
        $response->withSession(['info' => 'Google Category not found!']);
    }
}
