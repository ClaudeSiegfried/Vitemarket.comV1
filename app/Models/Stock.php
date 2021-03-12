<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'produit_id',
        'quantite_physique',
        'quantite_predebite',
        'quantite_facture',
        'expiration_id',
        'discount_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'produit_id' => 'integer',
        'expiration_id' => 'integer',
        'quantite_physique' => 'integer',
        'quantite_predebite' => 'integer',
        'quantite_facture' => 'integer',
    ];

    protected $primaryKey = 'id';

    public function getProduitNameAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->libele;
    }

    public function getProduitDescriptionAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->description;
    }

    public function getProduitCodeAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->code_gen;
    }

    public function getProduitPrixAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->prix;
    }

    public function getProduitPoidsAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->poids;
    }

    public function getProduitTailleAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->taille;
    }

    public function getProduitPhotoAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->photo;
    }

    public function getProduitCategorieAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->category;
    }

    public function getProduitMarqueAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->mark;
    }

    public function getProduitFournisseurAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->Supplier;
    }

    public function getProduitCreationAttribute()
    {
        $produit = $this->produit()->first();
        return $produit->date_de_creation;
    }

    public function getProduitExpirationAttribute()
    {
        $produit = $this->expiration()->first();
        return $produit->date_de_peremption;
    }
    public function getProduitDiscountAttribute()
    {
        $produit = $this->discount()->first();
        return $produit ?$produit->value: 0;
    }

    public function getQuantitePhysiqueAttribute()
    {
        return $this->attributes['quantite_physique'];
    }

    public function getQuantitePredebiteAttribute()
    {
        return $this->attributes['quantite_predebite'];

    }

    public function getQuantiteFactureAttribute()
    {
        return $this->attributes['quantite_facture'];
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function scopeGetproduit($query, $id)
    {
        return $query->where('produit_id', $id);
    }

    public function expiration()
    {
        return $this->belongsTo(Expiration::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }


}
