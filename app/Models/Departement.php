<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $guarded = [];


    public function employee(){
        return $this->hasMany(Employee::class);
    }
    use HasFactory;
}
