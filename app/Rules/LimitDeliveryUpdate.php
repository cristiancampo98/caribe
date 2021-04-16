<?php

namespace App\Rules;

use App\Traits\OrderDetail\Query\QueryOrderDetailTrait;
use App\Traits\Remission\Query\QueryRemissionTrait;
use Illuminate\Contracts\Validation\Rule;

class LimitDeliveryUpdate implements Rule
{
    use QueryOrderDetailTrait;
    use QueryRemissionTrait;

    private $detail;
    private $limit_production;
    private $limit_delivery;
    private $limit;
    private $value;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($remission_id)
    {
        $remission = self::getRemissionById($remission_id);

        $this->detail = self::getOrderDetailWithRelationships($remission->order_details_id);

        $this->limit_production = $this->detail->product->limit_day 
                                - self::getRemissionByProductTrait($this->detail->product_id) 
                                + $remission->delivered;

        $this->limit_delivery = $this->detail->quantity 
                                - self::getTotalDeliveredByDetail($remission->order_details_id) 
                                + $remission->delivered;

        $this->limit = $this->limit_delivery <= $this->limit_production 
                        ? $this->limit_delivery 
                        : $this->limit_production;
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
        $this->value = $value;
        if ($value > 0 && $value <= $this->limit ) {
           return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El valor de entrega es '.$this->value.' y debe ser menor o igual a '.$this->limit;
    }
}
