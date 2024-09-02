<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_id',
        'address',
        'postal_code',
        'total',
        'items'
    ];

    protected $casts = [
        'items' => 'array', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
