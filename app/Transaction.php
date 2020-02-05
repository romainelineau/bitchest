<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'date_purchase', 'quantity', 'price_currency', 'amount_investment', 'date_sale', 'amount_sale', 'sold', 'user_id', 'currency_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }
}
