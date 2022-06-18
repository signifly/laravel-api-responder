<?php

namespace R4nkt\Responder\Tests;

use R4nkt\Responder\Contracts\Responder as ResponderContract;
use R4nkt\Responder\Facades\Responder;
use R4nkt\Responder\Responses\CollectionResponse;
use R4nkt\Responder\Responses\ModelResponse;
use R4nkt\Responder\Responses\PaginatorResponse;
use R4nkt\Responder\Tests\Models\Product;

class ResponderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->responder = app(ResponderContract::class);
    }

    /** @test */
    public function it_responds_to_a_collection()
    {
        $products = Product::all();

        // Act
        $response = $this->responder->respond($products);

        // Assert
        $this->assertInstanceOf(CollectionResponse::class, $response);
    }

    /** @test */
    public function it_responds_to_a_paginator()
    {
        $products = Product::paginate(5);

        // Act
        $response = $this->responder->respond($products);

        // Assert
        $this->assertInstanceOf(PaginatorResponse::class, $response);
    }

    /** @test */
    public function it_responds_to_a_model()
    {
        $product = Product::first();

        // Act
        $response = $this->responder->respond($product);

        // Assert
        $this->assertInstanceOf(ModelResponse::class, $response);
    }

    /** @test */
    public function it_can_use_the_facade()
    {
        $product = Product::first();

        // Act
        $response = Responder::respond($product);

        // Assert
        $this->assertInstanceOf(ModelResponse::class, $response);
    }
}
