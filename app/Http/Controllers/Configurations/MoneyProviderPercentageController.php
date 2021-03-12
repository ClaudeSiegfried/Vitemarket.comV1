<?php

namespace App\Http\Controllers\Configurations;

use App\Models\Mmoney;
use App\Models\Money_provider_percentage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Stmt\Return_;


class MoneyProviderPercentageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mmoneys = Mmoney::all();
        return view('providerPercentage.index')->with(
            [
                'mmoneys' => $mmoneys,
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mmoney = Mmoney::query()->findOrFail($request->mmoney_id);
        $percentage = new Money_provider_percentage();
        $percentage->percentage = $request->percentage;

        if (!$mmoney->percentage()->exists()) {
            $mmoney->percentage()->save($percentage);
        } else {
            $mmoney->percentage()->update(['percentage' => $request->percentage]);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Money_provider_percentage $money_provider_percentage
     * @return void
     */
    public function show(Money_provider_percentage $money_provider_percentage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Money_provider_percentage $money_provider_percentage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $mmoneys = Mmoney::all();
        $money_provider_percentage = Mmoney::query()->find($id);

        return view('providerPercentage.index')->with(
            [
                'mmoneys' => $mmoneys,
                'percentageToEdit'=> $money_provider_percentage
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Money_provider_percentage $money_provider_percentage
     * @return void
     */
    public function update(Request $request, Money_provider_percentage $money_provider_percentage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Money_provider_percentage $money_provider_percentage
     * @return void
     */
    public function destroy(Money_provider_percentage $money_provider_percentage)
    {
        //
    }
}
