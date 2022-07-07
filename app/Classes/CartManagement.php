<?php
namespace App\Classes;


use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Http\Request;

class CartManagement{


    public function show(){
        $user = auth()->user();
        return $user->cart;
    }



    public function addToCart($request){
        $user = auth()->user();
        $data = $user->cart->items;
        // $id = $data[$request['id']];
        
        $inventory = Inventory::where('id', $request['id'])->firstOrFail();

        // Checks the inventory if there is enough quantity

        if ($inventory->quantity < $request['quantity']){
            return response()->json([
                'error' => true,
                'message' => 'Not enough stock available'
            ]);
        }


        // checks if item is in cart

        if ($data[$request['id']]){
            $data[$request['id']]['quantity'] += $request['quantity'];
            $data[$request['id']]['amount'] = $inventory['price'] * $data[$request['id']]['quantity'];
        }

        else{
            $data[$request['id']] = [
                'name' => $inventory['name'],
                'quantity' => $request['quantity'],
                'amount' => $request['quantity'] * $inventory['price']
            ];
        }


        $inventory['quantity'] -= $request['quantity'];
        $inventory->save();

        $user->cart->items = $data;

        $total = 0;
        foreach ($user->cart->items as $item){
            $total += $item['amount'];

        }

        $user->cart->total = $total;

        $user->cart->save();

        return $user->cart;
    }




    public function removeFromCart(Request $request){
        $user = auth()->user();
        $data = $user->cart->items;
        
        $inventory = Inventory::where('id', $request['id'])->firstOrFail();

        $data[$request['id']]['quantity'] -= 1;
        $data[$request['id']]['amount'] = $inventory['price'] * $data[$request['id']]['quantity'];


        $inventory['quantity'] += 1;
        $inventory->save();

        $user->cart->items = $data;

        $total = 0;
        foreach ($data as $item){
            $total += $item['amount'];
        }

        $user->cart->total = $total;

        $user->cart->save();

        return $user->cart;
    }


    public function clearCart(){
        $user = auth()->user();
        $data = $user->cart->items;
        foreach (array_keys($data) as $item){
            $inventory = Inventory::where('id', $item)->firstOrFail();
            $inventory->quantity += $data[$item]['quantity'];
            $inventory->save();
        }
        $user->cart->items = [];
        $user->cart->total = 0;
        $user->cart->save();
        return $user->cart;

    }

}