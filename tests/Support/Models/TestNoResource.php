<?php

namespace AchrafBardan\SimpleResources\Tests\Support\Models;

use AchrafBardan\SimpleResources\Contracts\HasResource;
use AchrafBardan\SimpleResources\Tests\Support\Resources\TestResource;
use Illuminate\Database\Eloquent\Model;

class TestNoResource extends Model implements HasResource
{
    public function getResource(): string
    {
        return TestResource::class;
    }
}
