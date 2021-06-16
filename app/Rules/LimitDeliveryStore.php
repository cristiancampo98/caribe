<?php

namespace App\Rules;

use App\Traits\OrderDetail\Query\QueryOrderDetailTrait;
use App\Traits\Remission\Query\QueryRemissionTrait;
use Illuminate\Contracts\Validation\Rule;

class LimitDeliveryStore implements Rule
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
    public function __construct($detail_id)
    {
        $this->detail = self::getOrderDetailWithRelationships($detail_id);

        $this->limit_production = $this->detail->product->limit_day - self::getRemissionByProductTrait($this->detail->product_id);

        $this->limit_delivery = $this->detail->quantity - self::getTotalDeliveredByDetail($detail_id);

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
        if ($this->limit) {
            return 'El valor de la remisión es '.$this->value.' y no puede ser mayor a '.$this->limit;    
        }
        return 'No es posible crear la remisión porque el limíte de la producción diaría es '.$this->limit;

        
    }
}
