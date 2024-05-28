<?php

namespace Tests\Unit\Models;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Scopes\ActiveUserScope;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Hash;
use Tests\Unit\ModelTestCase;

class UserTest extends ModelTestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make([
            'user_id' => 1,
            'user_password' => Hash::make('password'),
            'role_id' => RoleEnum::ADMIN,
            'is_active' => 1,
            'user_first_name' => 'Hoàng',
            'user_last_name' => 'Văn',
            'username' => 'hoang van',
            'user_email' => 'nguyenhoangthai@gmail.com',
            'user_gender' => 0,
        ]);
    }

    protected function tearDown(): void
    {
        unset($this->user);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            User::class,
            [],
            ['is_admin'],
            [],
            [
                'user_password',
                'remember_token',
            ],
            [
                'email_verified_at' => 'datetime',
                'is_admin' => 'boolean',
                'user_id' => 'int',
            ],
            ['created_at', 'updated_at'],
            null,
            'users',
            'user_id',
        );
    }

    public function testGetAuthPassword()
    {
        $this->assertEquals($this->user->user_password, $this->user->getAuthPassword());
    }

    public function testGlobalScopes()
    {
        $this->assertInstanceOf(ActiveUserScope::class, User::getGlobalScope(ActiveUserScope::class));
    }

    public function testScopeAdmin()
    {
        $this->assertEquals(
            'select * from `users` where `is_admin` = ? and `is_active` = ?',
            $this->user->admin()->toSql()
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(HasMany::class, $this->user->coupons());
        $this->assertEquals('created_by', $this->user->coupons()->getForeignKeyName());
        $this->assertEquals('user_id', $this->user->coupons()->getLocalKeyName());

        $this->assertInstanceOf(HasMany::class, $this->user->pets());
        $this->assertEquals('user_id', $this->user->pets()->getForeignKeyName());
        $this->assertEquals('user_id', $this->user->pets()->getLocalKeyName());

        $this->testBelongToRelationship($this->user->branch(), 'branch_id');
        $this->testBelongToRelationship($this->user->role(), 'role_id');

        $this->assertInstanceOf(HasMany::class, $this->user->careOrders());
        $this->assertEquals('user_id', $this->user->careOrders()->getForeignKeyName());
        $this->assertEquals('user_id', $this->user->careOrders()->getLocalKeyName());

        $this->assertInstanceOf(BelongsToMany::class, $this->user->assignTask());
        $this->assertEquals('user_id', $this->user->assignTask()->getForeignPivotKeyName());
        $this->assertEquals('order_id', $this->user->assignTask()->getRelatedPivotKeyName());
        $this->assertEquals(['from_time', 'to_time'], $this->user->assignTask()->getPivotColumns());

        $this->assertInstanceOf(HasMany::class, $this->user->petServices());
        $this->assertEquals('created_by', $this->user->petServices()->getForeignKeyName());
        $this->assertEquals('user_id', $this->user->petServices()->getLocalKeyName());

        $this->assertInstanceOf(HasMany::class, $this->user->petServicesPrices());
        $this->assertEquals('created_by', $this->user->petServicesPrices()->getForeignKeyName());
        $this->assertEquals('user_id', $this->user->petServicesPrices()->getLocalKeyName());

        $this->assertInstanceOf(HasMany::class, $this->user->breeds());
        $this->assertEquals('created_by', $this->user->breeds()->getForeignKeyName());
        $this->assertEquals('user_id', $this->user->breeds()->getLocalKeyName());

        $this->assertInstanceOf(MorphOne::class, $this->user->image());
        $this->assertEquals('imageable_type', $this->user->image()->getMorphType());
    }

    public function testFullNameAttribute()
    {
        $this->assertEquals($this->user->user_first_name . ' ' . $this->user->user_last_name, $this->user->full_name);
    }

    public function testGenderNameAttribute()
    {
        $this->assertEquals('Male', $this->user->gender_name);
    }

    public function testSetUsernameAttribute()
    {
        $this->user->setUsernameAttribute('hoang van');

        $this->assertEquals('hoang-van', $this->user->username);
    }

    public function testIsActiveName()
    {
        $this->assertEquals('Active', $this->user->is_active_name);
    }
}
