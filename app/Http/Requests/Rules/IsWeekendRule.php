<?php

declare(strict_types=1);

namespace App\Http\Requests\Rules;

use Carbon\CarbonImmutable as Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsWeekendRule implements ValidationRule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {
        $dispatchDate = Carbon::parse($value);
 
        // 土曜日または日曜日の場合はエラーメッセージを返す
        if ($dispatchDate->isWeekend()) {
            $fail('土曜日または日曜日は指定できません');
        }
    }
}