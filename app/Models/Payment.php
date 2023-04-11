<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters) {
       
        if($filters['search'] ?? false) {
            $query->where('name', 'like', '%'. request('search'). '%')
            
            ->orwhere('email', 'like', '%'. request('search'). '%')
            ->orwhere('phone_number', 'like', '%'. request('search'). '%');
        }
    }

}
