<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OrderItemsIsValid implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $items = json_decode($value);
        if(empty($items)) {
            return  false;
        }

        foreach ($items as $item){
            if(empty($item->name) || empty($item->qty) || empty($item->unit_price)){
                return  false;
            }
        }

        return  true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid order items data structure';
    }
}
