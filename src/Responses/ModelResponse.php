<?php

namespace Signifly\Responder\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelResponse extends Response
{
    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var int|null */
    protected $statusCode;

    public function __construct(Model $model, ?int $statusCode = null)
    {
        $this->model = $model;
        $this->statusCode = $statusCode;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function toResponse($request)
    {
        // Model has recently been deleted, so we want to
        // respond accordingly.
        if (! $this->model->exists || $this->deleted()) {
            return new JsonResponse(null, $this->statusCode ?? 204);
        }

        // Otherwise return with the associated http resource
        $resourceClass = $this->getResourceClassFor(get_class($this->model));

        return (new $resourceClass($this->model))
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
