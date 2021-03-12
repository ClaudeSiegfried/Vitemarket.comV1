<?php

namespace App\Http\Requests\Utilisateurs;

use Illuminate\Foundation\Http\FormRequest;

class FournisseurUpdateRequest extends FormRequest
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
            'rccm' => 'required|string|unique:fournisseurs,rccm',
            'nif' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
