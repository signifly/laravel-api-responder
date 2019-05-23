<?php

namespace Signifly\Responder\Tests;

use Signifly\Responder\Contracts\Responder;
use Signifly\Responder\Tests\Models\Product;
use Signifly\Responder\Responses\ModelResponse;
use Signifly\Responder\Responses\PaginatorResponse;
use Signifly\Responder\Responses\CollectionResponse;

class ResponderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->responder = app(Responder::class);
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
}
