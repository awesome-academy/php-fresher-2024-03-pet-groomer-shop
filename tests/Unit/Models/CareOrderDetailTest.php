<?php

namespace Tests\Unit\Models;

use App\Models\CareOrderDetail;
use Tests\Unit\ModelTestCase;

class CareOrderDetailTest extends ModelTestCase
{
    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            CareOrderDetail::class,
            [],
            [],
            [],
            [],
            [],
            ['created_at', 'updated_at'],
            null,
            'care_order_detail',
            null,
        );
    }
}
