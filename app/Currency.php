<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name', 'initials'
    ];

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
