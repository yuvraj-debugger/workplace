<?php

namespace App\Rules;

use App\Models\Leave;
use Illuminate\Contracts\Validation\Rule;

class LeaveDateRule implements Rule
{
    public $from;
    public $to;
    public $userid;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($from ,$to ,$userid)
    {
        $this->from = $from; 
        $this->to = $to;
        $this->userid = $userid;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $leave = Leave::where('from_date','>=',$this->from)
                            ->where('to_date','<=',$this->to)->where('name',$this->userid)->count();
        $leave === 0 ? true : false ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Already applied for this date.';
    }
}
