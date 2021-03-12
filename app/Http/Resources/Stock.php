<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Stock extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        Carbon::setLocale('fr');
        return [
            'id' => $this->id,
            'libele' => $this->ProduitName,
            'dispo' => $this->quantite_physique,
            'facturee' => $this->quantite_facture,
            'reserve' => $this->quantite_predebite,
            'code' => $this->ProduitCode,
            'prix' => $this->ProduitPrix,
            'poids' => $this->ProduitPoids,
            'taille' => $this->ProduitTaille,
            'categorie' => $this->ProduitCategorie,
            'marque' => $this->ProduitMarque,
            'fournisseur' => $this->ProduitFournisseur,
            'discount' => $this->ProduitDiscount,
            'expirele' => Carbon::parse($this->ProduitExpiration)->diffForHumans(),
            'creele' => Carbon::parse($this->ProduitCreation)->diffForHumans(),
            'photo' => $this->ProduitPhoto != "" ? url(route('photo.display',$this->ProduitPhoto)): null,
            'description' => $this->ProduitDescription,
        ];
    }
}
