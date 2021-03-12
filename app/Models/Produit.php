<?php

namespace App\Models;

use App\Services\StockManagement;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Libele',
        'description',
        'taille',
        'poids',
        'prix',
        'code_gen',
        'date_de_creation',
        'categorie_id',
        'marque_id',
        'fournisseur_id',
        'photo_id',
    ];

    protected $primaryKey = 'id';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'taille' => 'float',
        'poids' => 'decimal:2',
        'prix' => 'decimal:2',
        'categorie_id' => 'integer',
        'marque_id' => 'integer',
        'fournisseur_id' => 'integer',
        'photo_id' => 'integer',
    ];

    /**
     * Produit constructor.
     */

    public function getLibeleAttribute()
    {
        return $this->attributes['Libele'];
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description'];
    }

    public function getCategoryAttribute()
    {
        $produit = $this->categorie()->first();
        return $produit->libele;
    }

    public function getMarkAttribute()
    {
        $produit = $this->marque()->first();
        return $produit->libele;
    }

    public function getSupplierAttribute()
    {
        $produit = $this->fournisseur()->first();
        return $produit->etablissement;
    }

    public function getLabelAttribute()
    {
        return  $this->etiquette()->get();
    }

    public function getPhotoAttribute()
    {
        if ($this->photo()->exists()){
            $photo =  $this->photo()->first();
            return $photo->path;
        }
        return '';

    }


    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function etiquette()
    {
        return $this->belongsToMany(Etiquette::class, 'etiquette_produit');
    }

    public function panier()
    {
        return $this->belongsToMany(Panier::class, 'panier_produit', 'produit_id', 'panier_id')->withPivot('quantite');
    }

    public function scopeGetPanierId($query, $id){
        return $query->from('panier_produit')->where('panier_id','=',$id);
    }

    public function scopeGetProduits($query, $id){
        return $query->from('panier_produit')->where('panier_id','=',$id);
    }

    public function scopeVerifyStock($Q, $produit){
        $sto = $produit->stock()->get();
        $Qte_P = ($sto->Getproduit($produit));
        $Qte_B = ($sto->get('quantite_predebite')->first());
        //$Qte_P > $Q && $Qte_B < $Qte_P && $Q < $Qte_B;
        return ($sto);
    }

}
