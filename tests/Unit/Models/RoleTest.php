<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\ModelTestCase;

class RoleTest extends ModelTestCase
{
    protected $role;

    protected function setUp(): void
    {
        parent::setUp();
        $this->role = new Role();
        $this->role->role_name = 'Admin';
    }

    protected function tearDown(): void
    {
        unset($this->role);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            Role::class,
            ['role_name'],
            [0 => '*'],
            [],
            [],
            ['role_id' => 'int'],
            ['created_at', 'updated_at'],
            null,
            'roles',
            'role_id',
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->role->rolePermission());
        $this->assertEquals('role_id', $this->role->rolePermission()->getForeignPivotKeyName());
        $this->assertEquals('permission_id', $this->role->rolePermission()->getRelatedPivotKeyName());

        $this->assertInstanceOf(HasMany::class, $this->role->users());
        $this->assertEquals('role_id', $this->role->users()->getForeignKeyName());
        $this->assertEquals('role_id', $this->role->users()->getLocalKeyName());
    }
}
