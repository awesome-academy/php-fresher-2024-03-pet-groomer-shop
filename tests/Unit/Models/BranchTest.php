<?php

namespace Tests\Unit\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\ModelTestCase;

class BranchTest extends ModelTestCase
{
    protected $branch;

    protected function setUp(): void
    {
        parent::setUp();
        $this->branch = Branch::factory()
            ->make([
                'branch_id' => 3,
                'branch_name' => 'test',
                'branch_address' => 'test',
                'branch_phone' => 'test',
            ]);
    }

    protected function tearDown(): void
    {
        unset($this->branch);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            Branch::class,
            [],
            [],
            [],
            [],
            ['branch_id' => 'int', 'deleted_at' => 'datetime'],
            ['created_at', 'updated_at'],
            null,
            'branches',
            'branch_id',
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(HasMany::class, $this->branch->users());
        $this->assertEquals('branch_id', $this->branch->users()->getForeignKeyName());
        $this->assertEquals('branch_id', $this->branch->users()->getLocalKeyName());

        $this->assertInstanceOf(BelongsTo::class, $this->branch->createdBy());
        $this->assertEquals('created_by', $this->branch->createdBy()->getForeignKeyName());
        $this->assertEquals('user_id', $this->branch->createdBy()->getOwnerKeyName());

        $this->assertInstanceOf(HasMany::class, $this->branch->careOrders());
        $this->assertEquals('branch_id', $this->branch->careOrders()->getForeignKeyName());
        $this->assertEquals('branch_id', $this->branch->careOrders()->getLocalKeyName());
    }
}
