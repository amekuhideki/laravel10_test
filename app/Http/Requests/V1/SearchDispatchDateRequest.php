<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\Rules\IsWeekendRule;

class SearchDispatchDateRequest extends ApiRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'payment_date' => [
                'required',
                'date_format:"Y/m/d"',
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'payment_date.required' => '決済日を入力してください',
            'payment_date.date_format' => '決済日を正しく(Y/m/d形式)入力してください',
        ];
    }
}
