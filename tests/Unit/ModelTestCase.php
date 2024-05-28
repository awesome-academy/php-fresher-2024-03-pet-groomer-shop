<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class ModelTestCase extends TestCase
{
    protected function runConfigurationsAssertions(
        $model,
        $fillable = [],
        $guarded = [],
        $visible = [],
        $hidden = [],
        $casts = [],
        $dates = ['created_at', 'updated_at'],
        $connection = null,
        $table = null,
        $primaryKey = 'id',
        $collectionClass = Collection::class
    ) {
        if (!($model instanceof Model)) {
            $model = new $model();
        }

        $this->assertEquals($fillable, $model->getFillable(), 'fillable');
        $this->assertEquals($guarded, $model->getGuarded(), 'guarded');
        $this->assertEquals($visible, $model->getVisible(), 'visible');
        $this->assertEquals($hidden, $model->getHidden(), 'hidden');
        $this->assertEquals($casts, $model->getCasts(), 'casts');
        $this->assertEquals($dates, $model->getDates(), 'dates');

        if ($connection !== null) {
            $this->assertEquals($connection, $model->getConnectionName(), 'connection');
        }

        if ($table !== null) {
            $this->assertEquals($table, $model->getTable(), 'table');
        }

        if ($primaryKey !== null) {
            $this->assertEquals($primaryKey, $model->getKeyName(), 'primaryKey');
        }

        $c = $model->newCollection();
        $this->assertEquals($collectionClass, get_class($c));
        $this->assertInstanceOf(Collection::class, $c);
    }

    protected function testBelongToRelationship($relationship, $foreignKey)
    {
        $this->assertInstanceOf(BelongsTo::class, $relationship);
        $this->assertEquals($foreignKey, $relationship->getForeignKeyName());
        $this->assertEquals($foreignKey, $relationship->getOwnerKeyName());
    }
}
