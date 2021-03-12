<?php
/**
 * Created by IntelliJ IDEA.
 * User: PC
 * Date: 19/09/2020
 * Time: 17:07
 */

namespace App\Services;


use App\Models\Discount;
use App\Models\Paiement;
use Illuminate\Http\Request;

class SalesManagement
{
    public static function AllSales(){
        $Sales = Paiement::all();
        foreach ($Sales as $sale){
            $client = $sale->client()->get()->first();
            $mmoney = $sale->mmoney()->get()->first();
            $sale->client = $client->name;
            $sale->mmoney = $mmoney->fam;
        }
        return $Sales;
    }

    public static function StoreDiscount(Request $request){

        $discount = new Discount();
        $discount->name = $request->name;
        $discount->value = $request->value;
        $discount->saveOrFail();
    }

    public static function updateDiscount(Discount $discounts, Request $request){

        return $discounts->update($request->all());
    }

    public static function DeleteDiscount(Discount $discount){

        try {
            return $discount->delete();
        } catch (\Exception $e) {
            //dd($e);
        }
    }
}
