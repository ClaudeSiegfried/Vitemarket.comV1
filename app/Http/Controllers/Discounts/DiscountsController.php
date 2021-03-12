<?php

namespace App\Http\Controllers\Discounts;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\User;
use App\Services\SalesManagement;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::all();
        return view('discounts.index')->with(
            [
                'discounts' =>$discounts
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SalesManagement::StoreDiscount($request);
        return redirect()->route('discounts.index');
    }

    public function applydiscountsuser(Request $request)
    {
        $Users = User::all();
        $Discounts = Discount::all();
        $UsersWithDiscounts = User::query()->where('discount_id','!=',null)->get();
        return view('discounts.applydiscountsuser')->with([
            'Users' => $Users,
            'Discounts' => $Discounts,
            'UsersWithDiscounts' => $UsersWithDiscounts,
        ]);
    }

    public function applydiscountsproduct(Request $request)
    {
        $Produits = Produit::all();
        $Discounts = Discount::all();
        $ProductsWithDiscounts = Stock::query()->where('discount_id','!=',null)->get();
        return view('discounts.applydiscountsproduct')->with([
            'Produits' => $Produits,
            'Discounts' => $Discounts,
            'ProductsWithDiscounts' => $ProductsWithDiscounts,
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */

    public function savediscountsuser(Request $request)
    {
        $User = User::query()->find($request->User_id);
        $Discount = Discount::query()->find($request->Discount_id);

        ($User->discount()->associate($Discount)) ?
            connectify('success', 'Discount Manager', 'Discount applied with success') :
            notify()->warning('Applying Discount to user encoutered error.', 'Discount Manager');
        $User->update();

        return redirect()->back();
    }

    public function deletediscountsuser($id)
    {
        $User = User::query()->find($id);
        $Discount = $User->discount()->first();

        ($User->discount()->dissociate($Discount)) ?
            connectify('success', 'Discount Manager', 'Discount deleted with success') :
            notify()->warning('Deleting Discount to user encoutered error.', 'Discount Manager');
        $User->update();
        return redirect()->back();
    }

    public function editdiscountsuser($id)
    {
        $User = User::query()->find($id);
        $Discount = $User->discount()->first();
        $Users = User::all();
        $Discounts = Discount::all();
        $UsersWithDiscounts = User::query()->where('discount_id','!=',null)->get();
        return view('discounts.applydiscountsuser')->with([
            'Users' => $Users,
            'Discounts' => $Discounts,
            'UsersWithDiscounts' => $UsersWithDiscounts,
            'UserToEdit' => $User,
            'DiscountToEdit' => $Discount,
        ]);
    }

    public function savediscountsproduct(Request $request)
    {
        $Produit = Produit::query()->find($request->Produit_id);
        $stock = $Produit->stock()->first();
        $Discount = Discount::query()->find($request->Discount_id);

        ($stock->discount()->associate($Discount)) ?
            connectify('success', 'Discount Manager', 'Discount applied with success') :
            notify()->warning('Applying Discount to product encoutered error.', 'Discount Manager');

        $stock->update();
        return redirect()->back();
    }

    public function deletediscountsproduct($id)
    {
        $Produit = Produit::query()->find($id);
        $stock = $Produit->stock()->first();
        $Discount = $stock->discount()->first();

        ($stock->discount()->dissociate($Discount)) ?
            connectify('success', 'Discount Manager', 'Discount deleted with success') :
            notify()->warning('Deleting Discount to user encoutered error.', 'Discount Manager');
        $stock->update();
        return redirect()->back();
    }

    public function editdiscountsproduct($id)
    {
        $Produit = Produit::query()->find($id);
        $stock = $Produit->stock()->first();
        $Discount = $stock->discount()->first();
        $Produits = Produit::all();
        $Discounts = Discount::all();
        $ProductsWithDiscounts = Stock::query()->where('discount_id','!=',null)->get();
        return view('discounts.applydiscountsproduct')->with([
            'Produits' => $Produits,
            'Discounts' => $Discounts,
            'ProductsWithDiscounts' => $ProductsWithDiscounts,
            'ProductToEdit' => $Produit,
            'DiscountToEdit' => $Discount,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Discount $discounts
     * @return void
     */
    public function show(Discount $discounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $discounts = Discount::all();
        return view('discounts.index')->with([
            'discountToEdit' => Discount::query()->find($id),
            'discounts' =>$discounts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Discount $discount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Discount $discount)
    {
        try {
            //ddd($discount);
            $result = SalesManagement::updateDiscount($discount , $request);
            $result ?
                connectify('success', 'Discount Manager', 'Discount updated with success') :
                notify()->warning('Processing Money Discount update encoutered error.', 'Discount Manager');

        } catch (\Exception $e) {
            //dd($e);
        }
        return redirect()->route('discounts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Discount $discount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Discount $discount)
    {
        try {
            //ddd($discount);
            $result = SalesManagement::DeleteDiscount($discount);
            $result ?
                connectify('success', 'Discount Manager', 'Discount deleted with success') :
                notify()->warning('Processing Money Discount deletetion encoutered error.', 'Discount Manager');

        } catch (\Exception $e) {
            //dd($e);
        }

        return redirect()->route('discounts.index');
    }
}
