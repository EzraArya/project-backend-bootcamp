<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display a listing of the cart items.
     */
    public function index()
    {
        // Retrieve the cart items for the logged-in user
        $cartItems = Cart::where('user_id', Auth::id())->with('item')->get();

        return View::make('cart.index')->with('cartItems', $cartItems);
    }

    /**
     * Add an item to the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
        ]);

        $user_id = $request->user_id;
        $item_id = $request->item_id;

        $item = Item::findOrFail($item_id);
        if ($item->stock <= 0) {
            return redirect()->route('home')->with('error', 'Item is out of stock');
        }

        $invoice_id = 'INV-' . strtoupper(Str::random(10)); 

        while (Cart::where('invoice_id', $invoice_id)->exists()) {
            $invoice_id = 'INV-' . strtoupper(Str::random(10));
        }
        
        $cartItem = Cart::where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->first();

        if($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user_id,
                'item_id' => $item_id,
                'invoice_id' => $invoice_id,
            ]);
        }
        $item->stock -= 1;
        $item->save();

        return redirect()->route('carts.index');
    }

    /**
     * Update the quantity of an item in the cart.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::find($id);

        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }

        return redirect()->route('carts.index');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy($id)
    {
        $cartItem = Cart::find($id);
        $item = Item::find($cartItem->item_id);
        $item->stock += $cartItem->quantity;
        $item->save();
        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $cartItem->delete();
        }

        return redirect()->route('carts.index');
    }

    public function generateInvoiceId()
    {
        return 'INV-' . Str::upper(Str::random(10));
    }
    public function checkout(Request $request)
    {
        $request->validate([
            'address' => 'required|string|min:10|max:100',
            'postal_code' => 'required|string|size:5|regex:/^\d{5}$/'
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        $items = $cartItems->map(function ($cartItem) {
            return [
                'item_id' => $cartItem->item_id,
                'name' => $cartItem->item->name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->item->price,
                'subtotal' => $cartItem->quantity * $cartItem->item->price
            ];
        });

        // Create Invoice
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'invoice_id' => $this->generateInvoiceId(),
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'total' => $items->sum('subtotal'),
            'items' => $items->toArray()
        ]);

        // Clear Cart
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

}
