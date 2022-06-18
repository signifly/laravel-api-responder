<?php

namespace R4nkt\Responder\Tests\Support;

use R4nkt\Responder\Contracts\ModelResolver;
use R4nkt\Responder\Tests\Models\Product;
use R4nkt\Responder\Tests\TestCase;

class ModelResolverTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->resolver = app(ModelResolver::class);
    }

    /** @test */
    public function it_resolves_from_a_collection()
    {
        $products = Product::all();

        $modelClass = $this->resolver->resolve($products, 'collection');

        $this->assertEquals(Product::class, $modelClass);
    }

    /** @test */
    public function it_resolves_from_a_paginator()
    {
        $products = Product::paginate(5);

        $modelClass = $this->resolver->resolve($products, 'paginator');

        $this->assertEquals(Product::class, $modelClass);
    }

    /** @test */
    public function it_resolves_from_an_array()
    {
        $products = Product::get()->all();

        $modelClass = $this->resolver->resolve($products, 'array');

        $this->assertEquals(Product::class, $modelClass);
    }
}
