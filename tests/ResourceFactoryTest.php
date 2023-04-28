<?php

namespace Tests\ResourceFactoryTest;

use AchrafBardan\SimpleResources\ResourceFactory;
use AchrafBardan\SimpleResources\Tests\Support\Models\Test;
use AchrafBardan\SimpleResources\Tests\Support\Models\TestNoResource;
use AchrafBardan\SimpleResources\Tests\Support\Resources\TestResource;
use AchrafBardan\SimpleResources\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ResourceFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'simple-resources.model_namespace' => 'AchrafBardan\\SimpleResources\\Tests\\Support\\Models',
            'simple-resources.resource_namespace' => 'AchrafBardan\\SimpleResources\\Tests\\Support\\Resources',
        ]);
    }

    /** @test */
    public function it_gets_the_model_for_an_instance()
    {
        $item = new Test();

        $resourceFactory = new ResourceFactory();

        $this->assertEquals(Test::class, $resourceFactory->getModelClass($item));
    }

    /** @test */
    public function it_gets_the_model_for_a_collection()
    {
        $items = new Collection([new Test()]);

        $resourceFactory = new ResourceFactory();

        $this->assertEquals(Test::class, $resourceFactory->getModelClass($items, true));
    }

    /** @test */
    public function it_gets_the_model_for_a_paginated_collection()
    {
        $items = new LengthAwarePaginator([new Test()], 3, 2);

        $resourceFactory = new ResourceFactory();

        $this->assertEquals(Test::class, $resourceFactory->getModelClass($items, true));
    }

    /** @test */
    public function it_gets_resource_class_from_a_model()
    {
        $resourceFactory = new ResourceFactory();

        $this->assertEquals(TestResource::class, $resourceFactory->resolveResourceName(Test::class));
    }

    /** @test */
    public function it_gets_resource_class_from_a_model_with_a_resource_specified_in_the_model()
    {
        $resourceFactory = new ResourceFactory();

        $this->assertEquals(TestResource::class, $resourceFactory->resolveResourceName(TestNoResource::class));
    }
}
