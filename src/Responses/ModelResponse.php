<?php

namespace Signifly\Responder\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelResponse extends Response
{
    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var string */
    protected $resourceClass;

    /** @var int */
    protected $statusCode;

    public function __construct(Model $model, ?string $resourceClass = null)
    {
        $this->model = $model;
        $this->resourceClass = $resourceClass;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function toResponse($request)
    {
        // Respond appropriately to a deleted model
        if ($this->deleted()) {
            return new JsonResponse(null, $this->statusCode ?? 204);
        }

        // Return the model directly if no resource is provided
        if (empty($this->resourceClass)) {
            return $this->model;
        }

        return (new $this->resourceClass($this->model))
            ->toResponse($request)
            ->setStatusCode($this->calculateStatus());
    }

    protected function calculateStatus(): int
    {
        if ($this->statusCode) {
            return $this->statusCode;
        }

        return $this->model->wasRecentlyCreated ? 201 : 200;
    }

    protected function deleted(): bool
    {
        if (! $this->model->exists) {
            return true;
        }

        $modelTraits = collect(class_uses_recursive($this->model));
        if ($modelTraits->contains(SoftDeletes::class) && $this->model->trashed()) {
            return true;
        }

        return false;
    }
}
