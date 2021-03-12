<?php

namespace App\Http\Controllers\Configurations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configurations\MmoneyStoreRequest;
use App\Http\Requests\Configurations\MmoneyUpdateRequest;
use App\Models\Mmoney;
use App\Services\StockManagement;
use Illuminate\Http\Request;

class MmoneyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mmoneys = Mmoney::all();

        return view('mmoney.index', compact('mmoneys'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $mmoneys = Mmoney::all();

        return view('mmoney.create', compact('mmoneys'));
    }

    /**
     * @param \App\Http\Requests\Configurations\MmoneyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MmoneyStoreRequest $request)
    {
        $mmoney = Mmoney::create($request->all());

        $mmoney ?
            connectify('success', 'Money paiement gate provider', 'Storing provider done with success') :
            notify()->warning('Processing Money paiement gate provider encoutered error.', 'Money paiement gate provider');
        return redirect()->route('mmoney.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Mmoney $mmoney
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Mmoney $mmoney)
    {
        return view('mmoney.show', compact('mmoney'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Mmoney $mmoney
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $mmoneyToEdit = Mmoney::find($id);
        $mmoneys = Mmoney::all();

        return view('mmoney.index')->with(
            [
                'mmoneyToEdit' => $mmoneyToEdit,
                'mmoneys' => $mmoneys
            ]);
    }

    /**
     * @param \App\Http\Requests\Configurations\MmoneyUpdateRequest $request
     * @param \App\Models\Mmoney $mmoney
     * @return \Illuminate\Http\Response
     */
    public function update(MmoneyUpdateRequest $request, Mmoney $mmoney)
    {
        $result = $mmoney->update($request->all());

        $result ?
            connectify('success', 'Money paiement gate provider', 'Update done with success') :
            notify()->warning('Processing Money paiement gate provider encoutered error.', 'Money paiement gate provider');
        return redirect()->route('mmoney.index');
    }

    public function destroy(Request $request, Mmoney $mmoney)
    {
        try {
            $result = StockManagement::deleteMmoney($mmoney);
            $result ?
                connectify('success', 'Money paiement gate provider', 'Provider deleted with success') :
                notify()->warning('Processing Money paiement gate provider encoutered error.', 'Money paiement gate provider');
        } catch (\Exception $e) {
        }

        $request->session()->flash('marque', $mmoney);

        return redirect()->route('mmoney.index');
    }
}
