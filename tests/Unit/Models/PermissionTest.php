<?php

namespace Tests\Unit\Models;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\Unit\ModelTestCase;

class PermissionTest extends ModelTestCase
{
    protected $permission;

    protected function setUp(): void
    {
        parent::setUp();
        $this->permission = new Permission();
        $this->permission->permission_name = 'manage_users';
        $this->permission->permission_description = 'Permission to manage users';
    }

    protected function tearDown(): void
    {
        unset($this->permission);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            Permission::class,
            [],
            ['*'],
            [],
            [],
            ['permission_id' => 'int'],
            ['created_at', 'updated_at'],
            null,
            'permissions',
            'permission_id',
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->permission->roles());
        $this->assertEquals('permission_id', $this->permission->roles()->getForeignPivotKeyName());
        $this->assertEquals('role_id', $this->permission->roles()->getRelatedPivotKeyName());
    }
}
