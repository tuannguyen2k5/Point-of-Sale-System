<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\FacebookCategory;
use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Tests\Feature\BaseTest;

class FacebookCategoryTest extends BaseTest
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
        $response = $this->get(route('admin.facebook-categories.index'));

        $response->assertStatus(200);
        $response->assertSee('<h1>Facebook Category Manage</h1>', false);
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

        $response = $this->get(route('admin.facebook-categories.create'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Facebook Category Add</h1>', false);
    }
    public function test_post_create_success()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.facebook-categories.create.store'), [
            'category_id' => $this->faker->numberBetween(1, 10),
            'category_name' => $this->faker->unique()->name(),
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.facebook-categories.index'));
        $response->withSession(['success' => 'Create Facebook Category successfully!']);
    }
    public function test_post_create_fail_if_empty_name()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->post(route('admin.facebook-categories.create.store'), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_show_edit()
    {
        $facebookCategory = FacebookCategory::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.facebook-categories.edit', $facebookCategory->id));

        $response->assertStatus(200);

        $response->assertSee('<h1>Edit Facebook Category</h1>', false);
    }
    public function test_show_edit_fail()
    {
        $id = rand(2, 10);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response = $this->get(route('admin.facebook-categories.edit', $id));
        $response->assertStatus(404);
    }
    public function test_put_edit_success()
    {
        $facebookCategory = FacebookCategory::factory()->create();

        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.facebook-categories.edit.update', $facebookCategory->id), [
            'category_id' => $this->faker->numberBetween(1, 10),
            'category_name' => $this->faker->unique()->name(),
        ]);
        $response->assertSessionHasNoErrors();

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.facebook-categories.index'));

        $response->withSession(['success' => 'Update Facebook Category successfully!']);
    }
    public function test_put_edit_fail_if_empty()
    {
        $facebookCategory = FacebookCategory::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->put(route('admin.facebook-categories.edit.update', $facebookCategory->id), []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors();
    }
    public function test_delete_success()
    {
        $facebookCategory = FacebookCategory::factory()->create();
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.facebook-categories.delete', $facebookCategory->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.facebook-categories.index'));
        $response->withSession(['success' => 'Delete Facebook Category successfully!']);
    }
    public function test_delete_fail()
    {
        $id = rand(2, 50);
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('3', false);
        $user->roles()->sync('1', false);

        $response =  $this->delete(route('admin.facebook-categories.delete', $id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.facebook-categories.index'));
        $response->withSession(['info' => 'Facebook Category not found!']);
    }
}
