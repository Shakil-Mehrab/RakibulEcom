<?php

namespace App\Cart;
use App\Models\User;
use App\Models\ShippingMethod;

class Cart
{
    protected $user;
    protected $changed=false;
    protected $shipping;

    public function __construct($user){
        $this->user=$user;
    }
    public function products(){
        return $this->user->cart;//product_variation
    }
    public function withShipping($shippingId){
        $this->shipping=ShippingMethod::find($shippingId);
        return $this;
    }
    public function add($products){
        $this->user->cart()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );
    }
    public function update($productId,$quantity){
        $this->user->cart()->updateExistingPivot($productId,[
            'quantity'=>$quantity
        ]);
    }
    public function sync(){
        $this->user->cart->each(function($product){//here $product=$variation
            // dd($product->pivot->quantity);
            $quantity=$product->minStock($product->pivot->quantity);//$product->pivot->quantity from cart_user

            // $quantity hocche cart_user pro_vari quantity and pro_vari_stock_view er moddhe j minimum
            // $this->changed=$quantity != $product->pivot->quantity;
            if($quantity != $product->pivot->quantity){
                $this->changed=true;
            }
            // dd($quantity != $product->pivot->quantity); false and trie dekahay
            $product->pivot->update([
                'quantity'=>$quantity,
            ]);
        });
    }
    public function hasChanged(){
        return $this->changed;
    }
    public function delete($productId){
        $this->user->cart()->detach($productId);
    }
    public function empty(){
        $this->user->cart()->detach();
    }
    public function isEmpty(){
      return $this->user->cart->sum('pivot.quantity')<=0;
    }
    public function subtotal(){
        $subtotal=$this->user->cart->sum(function($product){//here $product=$variation
            return $product->price->amount()*$product->pivot->quantity; //$product->price from pro_vari and $product->pivot->quantity from cart_user
        // amount() table er price amount dey.not converted currency

        });
        return new Money($subtotal);
    }
    public function total(){
        if($this->shipping){
          return $this->subtotal()->add($this->shipping->price);
        }
        return $this->subtotal();
    }
    protected function getStorePayload($products){//product variations $products from request
       return collect($products)->keyBy('id')->map(function($product){
            return[
                'quantity'=>$product['quantity'] + $this->getCurrentQuantity($product['id'])//pro_var id from request
            ];
        })
        ->toArray();
    }
    protected function getCurrentQuantity($productId){ //pro_var id
        dd( $this->user->cart());
        if($product = $this->user->cart->where('id',$productId)->first()){
            return $product->pivot->quantity;
        }
        return 0;
    }

}