<?php

namespace App\Repositories\HotelService;

use App\Repositories\BaseRepository;

class HotelServiceRepository extends BaseRepository implements HotelServiceRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\HotelService::class;
    }
}
