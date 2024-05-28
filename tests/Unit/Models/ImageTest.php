<?php

namespace Tests\Unit\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Tests\Unit\ModelTestCase;

class ImageTest extends ModelTestCase
{
    protected $image;

    protected function setUp(): void
    {
        parent::setUp();
        $this->image = new Image();
        $this->image->image_path = 'images/test.jpg';
    }

    protected function tearDown(): void
    {
        unset($this->image);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            Image::class,
            ['image_path'],
            ['*'],
            [],
            [],
            ['id' => 'int'],
            ['created_at', 'updated_at'],
            null,
            'images',
            'id'
        );
    }

    public function testImageableRelationship()
    {
        $this->assertInstanceOf(MorphTo::class, $this->image->imageable());
    }
}
