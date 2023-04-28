<?php

namespace Tests\ResourceFactoryTest;

use function AchrafBardan\SimpleResources\resource;
use AchrafBardan\SimpleResources\Tests\Support\Models\Test;
use AchrafBardan\SimpleResources\Tests\Support\Resources\TestResource;
use AchrafBardan\SimpleResources\Tests\TestCase;

class FunctionsTest extends TestCase
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
    public function it_gets_resource_class_from_a_model()
    {
        $this->assertInstanceOf(TestResource::class, resource(new Test));
    }
}
