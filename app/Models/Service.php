<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = ['nom', 'description' , 'image' ,'prix_initiale', 'prix_promo','categorie_id' , 'promotion'];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

     
    public function category()
    {
        return $this->belongsTo(Category::class ,'categorie_id' ,'id' );
    }
    
}
