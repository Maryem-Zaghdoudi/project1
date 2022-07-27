<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\Readline\Hoa\Console;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $parentColumn = 'parent_id';


    protected $fillable = ['id','nom_categorie' , 'parent_id', 'position' ];
    protected $appends = [
        'getParentTree'
    ];

    public function services()
    {
        return $this->hasMany(Service::class , 'categorie_id' , 'id' );
    }

    public function parent()
    {
        return $this->belongsTo(static::class,$this->parentColumn);
    }

    public function children()
    {
        return $this->hasMany(static::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

   



    

}
