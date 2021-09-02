<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'type',
        'invoice_number',
        'contact',
        'description',
        'due_date',
        'amount',
        'last_modified',
    ];
}
