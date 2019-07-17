<?php

namespace App\Traits;

use App\Model\Stock;
use App\Model\UnitConversion;

trait QuantityFromConversionTrait
{
    public function getQuantity(array $sale, $stock=null)
    {
        if(!$stock)
            $stock = Stock::findOrFail($sale['stock_id']);

        $conversionRate = false;
        $saleUnitId = (int) $sale['item_unit_id']; //if comes from axios, can be in string form. So cast to int
        if($stock->item_unit_id != $saleUnitId)
        {
            $conversion = UnitConversion::where('unit_id_from', $stock->item_unit_id)->where('unit_id_to', $sale['item_unit_id'])->first();
            if(!$conversion)
                return false;

            $conversionRate = $conversion->conversion_rate;
        }

        $quantity = $conversionRate ? $sale['quantity']/$conversionRate : $sale['quantity'];

        return $quantity;
    }
}
