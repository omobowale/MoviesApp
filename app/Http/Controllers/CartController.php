<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Session;
use App\Movie;
use App\Cart;

class CartController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function add($movie_id){

        $user_id = Auth::id();
        $cart = Cart::where('user_id', $user_id)->get();
        if(count($cart) == 0){
            Cart::create([
                'user_id' => $user_id,
                'movie_ids' => $movie_id
            ]);
        }
        else if(count($cart) == 1) {
            $mIds = explode("," , $cart[0]->movie_ids);
            if(!in_array($movie_id, $mIds)){
                $cart[0]->movie_ids .= "," . $movie_id;
                $cart[0]->save();
            }
        }

        return back(); 
        $user = User::find($user_id);

        

    }


    function showCart(){
        $cart = Cart::where('user_id', Auth::id())->get();
        $movie_cart = array();
        $total = 0;
        if(!empty($cart[0]) && (strlen($cart[0]->movie_ids) > 0)) {
            
            $i = 0;
            $cartItems = explode("," , $cart[0]->movie_ids);
            //echo ($cart);
            foreach($cartItems as $key => $myc){
                $movie = Movie::find($myc);
                if(!empty($movie)){
                    array_push($movie_cart, $movie);
                    $total += $movie_cart[$i]->price;
                    $i++;
                }
            }

            if(count($movie_cart) == 0){
                $movie_cart = Cart::where('user_id', Auth::id())->delete();
            }
        }
        
        return view('cart.show')->with(['cart'=> $movie_cart, 'total' => $total]);
    }


    function deleteCartItem($id){

        $cart = Cart::where('user_id', Auth::id())->get();
        if(!empty($cart) && count($cart) == 1) {
            $mIds = $cart[0]->movie_ids;
            $allitems = explode(',', $mIds);
            $filteredItems = array_diff($allitems, array($id));
            $cart[0]->movie_ids = implode(',', $filteredItems);
            $cart[0]->save();
            if($cart[0]->movie_ids < 1){
                $cart[0]->delete();
            }
            
        }

        else{
            $cart->delete();
        }
        
        return back();



    }

}
