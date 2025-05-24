<?php

namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Purchase;

use DB;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller
{

	use ValidatesRequests;

	public function __construct()
	{
		$this->middleware('auth:web')->except('list');
	}

	public function list(Request $request)
	{

		$query = Product::select("products.*");

		$query->when(
			$request->keywords,
			fn($q) => $q->where("name", "like", "%$request->keywords%")
		);

		$query->when(
			$request->min_price,
			fn($q) => $q->where("price", ">=", $request->min_price)
		);

		$query->when($request->max_price, fn($q) =>
		$q->where("price", "<=", $request->max_price));

		$query->when(
			$request->order_by,
			fn($q) => $q->orderBy($request->order_by, $request->order_direction ?? "ASC")
		);

		$products = $query->get();

		return view('products.list', compact('products'));
	}
	public function buy(Product $product)
{
    if (!auth()->user()) return redirect('/');

    $user = auth()->user();

    // Check if the user has sufficient credit
    if ($user->credit < $product->price) {
        return back()->withErrors(['error' => 'Insufficient credit to buy this product.']);
    }

    // Check if there's enough quantity in stock
    if ($product->quantity <= 0) {
        return back()->withErrors(['error' => 'This product is out of stock.']);
    }

    // Deduct the price from user's credit
    $user->credit -= $product->price;
    $user->save();

    // Create the order entry in the orders table
    \App\Models\Purchase::create([
        'customer_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,                // Quantity purchased (adjust as needed)
        'total' => $product->price,     // Total price (adjust as needed)
        'created_at' => now(),
    ]);

    // Reduce the quantity of the product by 1
    $product->quantity -= 1;
    $product->save();

    // Optionally log the purchase or send a notification

    return back()->with('success', 'Product purchased successfully!');
}


public function viewOrders()
{
    $user = auth()->user();

    $orders = Purchase::with('product')
                ->where('customer_id', $user->id)
                ->latest()
                ->get();

    return view('users.orders', compact('orders'));
}



	public function edit(Request $request, Product $product = null)
	{

		if (!auth()->user()) return redirect('/');

		$product = $product ?? new Product();

		return view('products.edit', compact('product'));
	}

	public function save(Request $request, Product $product = null)
	{

		$this->validate($request, [
			'code' => ['required', 'string', 'max:32'],
			'name' => ['required', 'string', 'max:128'],
			'model' => ['required', 'string', 'max:256'],
			'description' => ['required', 'string', 'max:1024'],
			'price' => ['required', 'numeric'],
		]);

		$product = $product ?? new Product();
		$product->fill($request->all());
		$product->save();

		return redirect()->route('products_list');
	}

	public function delete(Request $request, Product $product)
	{

		if (!auth()->user()->hasPermissionTo('delete_products')) abort(401);

		$product->delete();

		return redirect()->route('products_list');
	}
}
