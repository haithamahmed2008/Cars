<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';
    protected $primaryKey = 'id';
    //protected $timestamps = true;

    protected $fillable = ['name','founded','description'];

    public function carmodel()
    {
        return $this->hasMany(CarModel::class);
    }
}
