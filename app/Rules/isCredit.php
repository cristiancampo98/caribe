<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class isCredit implements Rule
{
    private $type_pay;
    private $consignment_number;
    private $contract;
    private $purchaseOrder;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type_pay, $consignment_number)
    {

        $this->type_pay = $type_pay;
        $this->consignment_number = $consignment_number;
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
        if ($this->type_pay && !isset($this->consignment_number)) {

            if (request()->hasFile('contract') && request()->hasFile('purchaseOrder')) {
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Los documentos son requeridos porque el tipo de pago es a crédito y porque no se esta ingresando una consignación.';
    }
}
