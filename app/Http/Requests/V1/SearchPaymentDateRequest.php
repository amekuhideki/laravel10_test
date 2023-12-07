<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\Rules\IsWeekendRule;

class SearchPaymentDateRequest extends ApiRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'dispatch_date' => [
                'required',
                'bail',
                'date_format:"Y/m/d"',
                new IsWeekendRule
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'dispatch_date.required' => '発送日を入力してください',
            'dispatch_date.date_format' => '発送日を正しく(Y/m/d形式)入力してください',
        ];
    }
}
