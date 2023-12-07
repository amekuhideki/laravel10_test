<?php

declare(strict_types=1);

namespace App\Http\Responders;

use Illuminate\Http\JsonResponse;
use \Throwable;

abstract class ApiResponder
{
    /** @var array */
    private array $response = [
        'data' => [],
        'errors' => [],
    ];

    /** @var array */
    protected array $params;

    /**
     * @param array $params
     * @return void
     */
    public function params(
        array $params
    ): void {
        $this->params = $params;
    }

    /**
     * @return JsonResponse
     */
    public function toResponse(): JsonResponse
    {
        if (!empty($this->throwable)) {
        }

        $this->response['data'] = $this->toArray();
        return new JsonResponse($this->response);
    }

    abstract protected function toArray(): array;
}