<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Region extends Model
{
    use SoftDeletes;
 
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'sede',
        'coordinador'
    ];
    public function delegaciones()
    {
        return $this->hasMany(Delegacion::class);
    }
}
