<?php

namespace Signifly\Responder\Tests\Responses;

use Illuminate\Http\JsonResponse;
use Signifly\Responder\Tests\TestCase;
use Signifly\Responder\Responses\DefaultResponse;

class DefaultResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_json_response()
    {
        $data = ['message' => 'Some message'];

        $response = (new DefaultResponse($data))->toResponse(null);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
