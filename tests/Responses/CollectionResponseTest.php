<?php

namespace Signifly\Responder\Tests\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Signifly\Responder\Responses\CollectionResponse;
use Signifly\Responder\Tests\Models\Product;
use Signifly\Responder\Tests\Resources\ProductResource;
use Signifly\Responder\Tests\TestCase;

class CollectionResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_json_response_if_a_resource_is_provided()
    {
        $products = Product::all();

        $response = (new CollectionResponse($products, ProductResource::class))->toResponse(null);

        $this->assertInstanceOf(JsonResponse::class, $response);

        if (version_compare($this->app->version(), '5.8', '>')) {
            $this->assertContainsOnlyInstancesOf(ProductResource::class, $response->original);
        }
    }

    /** @test */
    public function it_returns_a_json_response_if_no_resource_is_provided()
    {
        $products = Product::all();

        $response = (new CollectionResponse($products))->toResponse(null);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertInstanceOf(Collection::class, $response->original);
        $this->assertContainsOnlyInstancesOf(Product::class, $response->original);
    }

    /** @test */
    public function it_can_set_the_status_code()
    {
        $products = Product::all();

        $response = (new CollectionResponse($products))
            ->setStatusCode(204)
            ->toResponse(null);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->status());
    }
}
