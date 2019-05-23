<?php

namespace Signifly\Responder\Tests\Responses;

use Illuminate\Http\JsonResponse;
use Signifly\Responder\Tests\TestCase;
use Signifly\Responder\Tests\Models\Product;
use Signifly\Responder\Responses\ModelResponse;
use Signifly\Responder\Tests\Resources\ProductResource;

class ModelResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_json_response_if_a_resource_is_provided()
    {
        $product = Product::first();

        $response = (new ModelResponse($product, ProductResource::class))->toResponse(null);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /** @test */
    public function it_returns_a_model_if_no_resource_is_provided()
    {
        $product = Product::first();

        $response = (new ModelResponse($product))->toResponse(null);

        $this->assertInstanceOf(Product::class, $response);
    }

    /** @test */
    public function it_can_set_the_status_code()
    {
        $product = Product::first();

        $response = (new ModelResponse($product, ProductResource::class))
            ->setStatusCode(201)
            ->toResponse(null);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }
}
