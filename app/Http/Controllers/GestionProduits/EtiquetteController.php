<?php

namespace App\Http\Controllers\GestionProduits;
use App\Http\Controllers\Controller;
use App\Models\Etiquette;
use App\Models\Marque;
use Illuminate\Http\Request;

class EtiquetteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('etiquette.index')->with(
            [
                'Etiquettes' => Etiquette::all(),
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ];

        $request->validate($rules, ($request->all()));

        $etiquette = new Etiquette();

        $etiquette->name = $request->name;
        $etiquette->description = $request->description;

        ($etiquette->save()) ?
            connectify('success', 'Labels Manager', 'Label created with success') :
            notify()->warning('Creating Label encoutered error.', 'Labels Manager');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Etiquette $etiquette
     * @return void
     */
    public function show(Etiquette $etiquette)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Etiquette $etiquette
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('etiquette.index')->with([
            'LabelToEdit' => Etiquette::query()->find($id),
            'Etiquettes' => Etiquette::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Etiquette $etiquette
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Etiquette $etiquette)
    {
        try {
            //ddd($discount);
            $result = $etiquette->update($request->all());
            $result ?
                connectify('success', 'Labels Manager', 'Label updated with success') :
                notify()->warning('Updating Label encoutered error.', 'Labels Manager');

        } catch (\Exception $e) {
            //dd($e);
        }
        return view('etiquette.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Etiquette $etiquette
     * @return \Illuminate\Http\Response
     */
    public function destroy(Etiquette $etiquette)
    {
        try {
            //ddd($discount);
            $result = $etiquette->delete();
            $result ?
                connectify('success', 'Labels Manager', 'Label created with success') :
                notify()->warning('Deleting Label encoutered error.', 'Labels Manager');

        } catch (\Exception $e) {
            //dd($e);
        }

        return redirect()->route('etiquette.index');
    }
}
