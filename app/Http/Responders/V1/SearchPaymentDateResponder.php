<?php

declare(strict_types=1);

namespace App\Http\Responders\V1;

use App\Http\Responders\ApiResponder;

class SearchPaymentDateResponder extends ApiResponder
{
    /**
     * @return array
     */
    protected function toArray(): array
    {
        return $this->params;
    }
}