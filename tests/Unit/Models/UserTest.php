<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class UserTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->user = new User();
    }

    public function test_user_belongs_to_many_roles()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('user_role', $this->user->roles()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsToMany::class, $this->user->roles());
    }

    public function test_user_has_role_fail()
    {
        $this->assertNull($this->user->roles()->where('name', $role)->first());
    }

    public function test_user_has_role_success()
    {
        $this->assertNull(!$this->user->roles()->where('name', $role)->first());
    }
}
