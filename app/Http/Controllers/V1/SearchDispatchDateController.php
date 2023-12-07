<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SearchDispatchDateRequest;
use App\Http\Responders\V1\SearchDispatchDateResponder;
use Carbon\CarbonImmutable as Carbon;
use Illuminate\Http\JsonResponse;

class SearchDispatchDateController extends Controller
{
    /** @var SearchDispatchDateRequest */
    private SearchDispatchDateRequest $request;

    /** @var SearchDispatchDateResponder*/
    private SearchDispatchDateResponder $responder;

    /**
     * @param SearchDispatchDateRequest $request
     * @param SearchDispatchDateResponder responder
     * @return JsonResponse
     */
    public function __invoke(
        SearchDispatchDateRequest $request,
        SearchDispatchDateResponder $responder
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
        $paymentDate = Carbon::parse($params['payment_date']);

        $firstDispatchDate = $this->getFirstDispatchDate($paymentDate);

        $this->responder->params([
            'first_payment_date' => $firstDispatchDate->format('Y/m/d'),
            // 2回目以降[初回発送から2週間目の平日 & 4週間目の平日]
            'second_payment_date' => $this->getRandomWeekdayString(
                $firstDispatchDate->addWeeks(2)
            ),
            'third_payment_date' => $this->getRandomWeekdayString(
                $firstDispatchDate->addWeeks(4)
            ),
        ]);
    }

    /**
     * 初回発送日は決済日の翌日（発送日が土日の場合は月曜日発送）
     * 
     * @param Carbon $paymentDate
     * @return Carbon
     */
    private function getFirstDispatchDate(
        Carbon $paymentDate
    ): Carbon {
        return $paymentDate->addDay()->isWeekday()
            ? $paymentDate->addDay()
            : $paymentDate->next(Carbon::MONDAY);
    }

    /**
     * $targetDateの週の平日の日付をランダムに取得
     * 
     * @param Carbon $targetDate
     * @return string
     */
    private function getRandomWeekdayString(
        Carbon $targetDate
    ): string {
        $mnonday = $targetDate->startOfWeek();
        $friday = $targetDate->next(Carbon::FRIDAY);

        // 月曜から金曜日までの日数を計算しランダムな日数を生成
        $randomDays = random_int(0, $friday->diffInDays($mnonday));

        // 開始日にランダムな日数を加えてランダムな日付を計算
        return $mnonday->addDays($randomDays)->format('Y/m/d');
    }
}
