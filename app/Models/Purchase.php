<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'orders';  // Set table name explicitly
    protected $fillable = ['customer_id', 'product_id', 'quantity', 'total', 'created_at']; // Define fillable fields

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Disable timestamps since we don't have updated_at in the table
    public $timestamps = false;
}
