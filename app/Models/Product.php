<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug', 'price', 'image', 'description'];
    
    public function scopeFilter($query, array $filters){   
        if($filters['search'] ?? false){
            $query->where('id', 'like', '%' . request('search') . '%')
                  ->orWhere('name', 'like', '%' . request('search') . '%')
                  ->orWhere('price', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%')
                  ->orWhere('created_at', 'like', '%' . request('search') . '%');
        }
    }
}
