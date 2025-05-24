<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class CustomerController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user(); // from token
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function orders(Request $request)
    {
        $user = Auth::user();
        $purchases = Purchase::where('customer_id', $user->id)->get();

        return response()->json($purchases);
    }

    public function products()
    {
        $products = Product::select('id', 'name', 'price', 'description')->get();
        return response()->json($products);
    }
}
