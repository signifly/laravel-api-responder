<?php

namespace Signifly\Responder\Tests;

use Signifly\Responder\Contracts\Responder as ResponderContract;
use Signifly\Responder\Facades\Responder;
use Signifly\Responder\Responses\CollectionResponse;
use Signifly\Responder\Responses\ModelResponse;
use Signifly\Responder\Responses\PaginatorResponse;
use Signifly\Responder\Tests\Models\Product;

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
