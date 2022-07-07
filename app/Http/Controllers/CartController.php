<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Classes\CartManagement;
use App\Models\Inventory;
use Illuminate\Http\Request;

class CartController extends Controller
{


    private $cartManagement;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CartManagement $cartManagement)
    {
        //
        $this->cartManagement = $cartManagement;
    }


    public function show(){
        $user = auth()->user();
        return response()->fetch(
            "My cart",
            $this->cartManagement->show(),
            "cart"
        );
    }

    public function addToCart(Request $request){
        return response()->updated(
            'Item added to cart',
            $this->cartManagement->addToCart($request),
            'cart'
        );
    }




    public function removeFromCart(Request $request){

        return response()->updated(
            'Item removed from cart',
            $this->cartManagement->removeFromCart($request),
            'cart'
        );
    }


    public function clearCart(){
        return response()->fetch(
            "Cart cleared",
            $this->cartManagement->clearCart(),
            "cart"
        );

    }
}
