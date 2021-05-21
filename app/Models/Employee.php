<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $guarded = [];
    protected $hidden = [
        'departement_id'
    ];

    public function departement(){
        return $this->BelongsTo(Departement::class);
    }

    public function payment(){
        return $this->hasMany(Payment::class);
    }
    use HasFactory;
}
