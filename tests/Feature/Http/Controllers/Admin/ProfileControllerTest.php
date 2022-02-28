<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Tests\Feature\BaseTest;

class ProfileControllerTest extends BaseTest
{
    protected static $migrationRun = false;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => 'password'
        ]);
        if (!static::$migrationRun) {
            $this->artisan('migrate:refresh');
            $this->seed(RoleTableSeeder::class);
            static::$migrationRun = true;
        }
        $this->setUpFaker();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_show_profile()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('1',false);

        $response = $this->get(route('admin.users.profile'));

        $response->assertStatus(200);
        $response->assertSee('container emp-profile');
    }

    public function test_can_show_edit_profile()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('1',false);

        $response = $this->get(route('admin.users.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('py-2');
    }

    public function test_can_edit_profile()
    {
        $this->be($this->user);
        $user = User::find($this->user->id);
        $user->roles()->sync('1',false);

        $response = $this->put(route('admin.users.profile.update', $this->user->id), [
            'name' => $this->faker->name(10),
            'username' => $this->faker->unique()->username(10),
            'email' => $this->faker->unique()->safeEmail(),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.users.profile'));
        $response->withSession(['success' => 'account updated']);
    }
}
