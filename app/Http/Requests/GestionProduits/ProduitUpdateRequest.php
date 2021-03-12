<?php

namespace App\Http\Requests\GestionProduits;

use Illuminate\Foundation\Http\FormRequest;

class ProduitUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Libele' => 'required|string',
            'description' => 'required|string',
            'taille' => 'required|numeric|between:-999999.99,999999.99',
            'poids' => 'required|numeric|between:-999999.99,999999.99',
            'prix' => 'required|numeric',
            'code_gen' => 'required|string',
            'date_de_creation' => 'required|date',
            'categorie_id' => 'required|integer|exists:categories,id',
            'marque_id' => 'required|integer|exists:marques,id',
            'fournisseur_id' => 'required|integer|exists:fournisseurs,id',
            'photo_id' => 'required|integer|exists:photos,id',
        ];
    }
}
