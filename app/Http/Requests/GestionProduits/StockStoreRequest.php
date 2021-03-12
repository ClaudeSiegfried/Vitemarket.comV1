<?php

namespace App\Http\Requests\GestionProduits;

use Illuminate\Foundation\Http\FormRequest;

class StockStoreRequest extends FormRequest
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
            'produit_id' => 'required|integer|exists:produits,id',
            'quantite_physique' => 'required|integer',
            'quantite_predebite' => 'required|integer',
            'quantite_facture' => 'required|integer',
            'expiration_id' => 'required|integer|exists:expirations,id',
        ];
    }
}
