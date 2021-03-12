<?php

namespace App\Http\Requests\Utilisateurs;

use Illuminate\Foundation\Http\FormRequest;

class FournisseurStoreRequest extends FormRequest
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
            'etablissement' => 'required|string|unique:fournisseurs,etablissement',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
