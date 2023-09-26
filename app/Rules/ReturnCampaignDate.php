<?php

namespace App\Rules;

use B2BPanel\SharedModels\ReturnCampaign;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ReturnCampaignDate implements DataAwareRule, ValidationRule
{

    protected $data = [];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $return_campaigns = ReturnCampaign::whereDate('date_end', '>=', Carbon::today()->toDateString())->where('id', '!=', $this->data['data']['id'])->get();

        $date_start = Carbon::create($this->data['data']['date_start'])->addDay(-1);

        $date_end = Carbon::create($this->data['data']['date_end'])->addDay(1);

        $new_rc_period = CarbonPeriod::create($date_start, $date_end);

        foreach ($return_campaigns as $rc) {
            /* if ($rc->id === $this->data['data']['id']) {
                continue;
            } */
            $period = CarbonPeriod::create($rc->date_start, $rc->date_end);
            if ($period->overlaps($new_rc_period)) {
                $fail("Zakres wpisanych dat pokrywa się z akcją zwrotów o nazwie: $rc->name");
            }
        }

        /* dd($this->data['data']['date_start']); */
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
