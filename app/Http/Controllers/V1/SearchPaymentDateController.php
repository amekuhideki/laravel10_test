<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SearchPaymentDateRequest;
use App\Http\Responders\V1\SearchPaymentDateResponder;
use Carbon\CarbonImmutable as Carbon;
use Illuminate\Http\JsonResponse;

class SearchPaymentDateController extends Controller
{
    /** @var SearchPaymentDateRequest */
    private SearchPaymentDateRequest $request;

    /** @var SearchPaymentDateResponder */
    private SearchPaymentDateResponder $responder;

    /**
     * @param SearchPaymentDateRequest $request
     * @param SearchPaymentDateResponder responder
     * @return JsonResponse
     */
    public function __invoke(
        SearchPaymentDateRequest $request,
        SearchPaymentDateResponder $responder
    ): JsonResponse {
        $this->request = $request;
        $this->responder = $responder;

        $this->run();
        return $this->responder->toResponse();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $params = $this->request->validated();
        $dispatchDate = Carbon::parse($params['dispatch_date']);

        // 2回目の発送日からの決済日を求める
        $paymentDate = $dispatchDate->addWeek()->startOfWeek();

        // 発送日の前週月曜日が決済日
        $paymentDate = $dispatchDate->startOfWeek()->subWeek();
        $this->responder->params([
            'payment_date' => $paymentDate->format('Y/m/d')
        ]);
    }
}
