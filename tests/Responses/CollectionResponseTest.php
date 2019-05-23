<?php

namespace Signifly\Responder\Tests\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Signifly\Responder\Tests\TestCase;
use Signifly\Responder\Tests\Models\Product;
use Signifly\Responder\Responses\CollectionResponse;
use Signifly\Responder\Tests\Resources\ProductResource;

class CollectionResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_json_response_if_a_resource_is_provided()
    {
        $products = Product::all();

        $response = (new CollectionResponse($products, ProductResource::class))->toResponse(null);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /** @test */
    public function it_returns_the_collection_if_no_resource_is_provided()
    {
        $products = Product::all();

        $response = (new CollectionResponse($products))->toResponse(null);

        $this->assertInstanceOf(Collection::class, $response);
    }
}
