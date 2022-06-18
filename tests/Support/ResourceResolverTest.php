<?php

namespace R4nkt\Responder\Tests\Support;

use Illuminate\Http\Resources\Json\JsonResource;
use R4nkt\Responder\Contracts\ResourceResolver;
use R4nkt\Responder\Tests\Resources\Product;
use R4nkt\Responder\Tests\Resources\ProductResource;
use R4nkt\Responder\Tests\TestCase;

class ResourceResolverTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->resolver = app(ResourceResolver::class);
    }

    /** @test */
    public function it_resolves_from_a_model_class()
    {
        $resourceClass = $this->resolver->resolve(
            \R4nkt\Responder\Tests\Models\Product::class
        );

        $this->assertEquals(Product::class, $resourceClass);
    }

    /** @test */
    public function it_resolves_with_suffix_enabled()
    {
        config(['responder.use_type_suffix' => true]);

        $resourceClass = $this->resolver->resolve(
            \R4nkt\Responder\Tests\Models\Product::class
        );

        $this->assertEquals(ProductResource::class, $resourceClass);
    }

    /** @test */
    public function it_returns_the_default_resource_if_the_class_does_not_exist()
    {
        $resourceClass = $this->resolver->resolve('App\\Models\\Invalid');

        $this->assertEquals(JsonResource::class, $resourceClass);
    }
}
