<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = ['account_title', 'account_number', 'bank_name', 'barnch_name', 'routing_number', 'cheque_copy'];
}
