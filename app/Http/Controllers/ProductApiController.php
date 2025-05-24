<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductApiController extends Controller
{
    public function list()
    {
        $products = Product::all();
        return response()->json([
            'status' => 'success',
            'products' => $products
        ]);
    }

    public function view($id)
    {
        $product = Product::findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'product' => [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'model' => $product->model,
                'description' => $product->description,
                'price' => $product->price,
                'photo' => $product->photo,
                'in_stock' => $product->quantity,
                'quantity' => $product->quantity,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at
            ]
        ]);
    }

    public function buy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        // Check if user has enough credit
        if ($user->credit < $product->price) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient credit balance'
            ], 400);
        }

        // Check if product is in stock
        if ($product->quantity <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product is out of stock'
            ], 400);
        }

        // Create purchase record
        $purchase = Purchase::create([
            'customer_id' => $user->id,
            'product_id' => $product->id,
            'price' => $product->price
        ]);

        // Update user's credit
        $user->credit -= $product->price;
        $user->save();

        // Update product stock
        $product->quantity -= 1;
        $product->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Product purchased successfully',
            'purchase' => [
                'id' => $purchase->id,
                'product_name' => $product->name,
                'price' => $purchase->price,
                'created_at' => $purchase->created_at
            ],
            'remaining_credit' => $user->credit
        ]);
    }
} 