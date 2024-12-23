<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReport extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'reason'];


    public function reporter()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function product()
{
    return $this->belongsTo(Product::class);
}

public function seller()
{
    return $this->product->user; // Mengambil user yang memiliki post (bukan user yang melaporkan)
}

}


