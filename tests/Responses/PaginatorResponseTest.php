<?php

namespace Signifly\Responder\Tests\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Signifly\Responder\Responses\PaginatorResponse;
use Signifly\Responder\Tests\Models\Product;
use Signifly\Responder\Tests\Resources\ProductResource;
use Signifly\Responder\Tests\TestCase;

class PaginatorResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_json_response_if_a_resource_is_provided()
    {
        $products = Product::paginate(5);

        $response = (new PaginatorResponse($products, ProductResource::class))->toResponse(null);

        $this->assertInstanceOf(JsonResponse::class, $response);

        if (version_compare($this->app->version(), '5.8', '>')) {
            $this->assertInstanceOf(Collection::class, $response->original);
        }
    }

    /** @test */
    public function it_returns_a_json_response_if_no_resource_is_provided()
    {
        $products = Product::paginate(5);

        $response = (new PaginatorResponse($products))->toResponse(null);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertInstanceOf(LengthAwarePaginator::class, $response->original);
    }
}
