<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Url;


class ProductController extends Controller
{
    function product_view(){

        $list_of_products = Product::all();

        $data = [
            'LIST_OF_PRODUCTS' => $list_of_products
        ];

        return view('admin.products', compact('data'));

    }



    function get_specific_product($id){
                   
            $specific_product = Product::where( 'id', '=', $id )->first();
            
            $data = [
                'SPECIFIC_PRODUCT' => $specific_product
            ];

            return view("admin.products", compact('data'));

    }


    function add_new_product(Request $request){
        
        $action = "product_add";

        $request->validate([
            'name'=>'required',
            'sku'=>'required|unique:products',
            'description'=>'min:2',
            'price'=>'required'
        ]);


        $new_product = new Product();
        $new_product->name = $request->name;
        $new_product->sku = $request->sku;
        $new_product->description = $request->description;
        $new_product->price = $request->price;

        $query = $new_product->save();
        

        if($query){
            $ind = 1;
            $created_id = $new_product->id;
            $response = "USPESNO registrovan novi proizvod ! ID proizvoda : " . $created_id;
        }else{
            $ind = -1;
            $response = "Novi proizvod nije registrovan ... ";
        }

        $data_session = [
            'ind' => $ind,
            'response' => $response,
            'action' => $action
        ];

        return redirect()->to('products')->with('data_session', $data_session);

    }


    function delete_specific_product($id){
        
        $action = "product_delete";
        $specific_product = Product::find( $id );
        $specific_product->delete();
        
        $list_of_products = Product::all();

        
        unset($specific_product);
        $specific_product = Product::find( $id );


        if ($specific_product === null) {
            // user doesn't exist
            $ind = 1;
            $response = "Uspesno ste obrisali proizvod , ID : " . $id;

        }else{
            $ind = -1;
            $response = "Nazalost, niste obrisali proizvod. Proizvod je i dalje u bazi , ID : " . $id;
        }

        $data_session = [
            'ind' => $ind,
            'response' => $response,
            'action' => $action,
            'LIST_OF_PRODUCTS' => $list_of_products
        ];

        return redirect()->to('products')->with('data_session', $data_session);


    }





    function update_existing_product($id){
        
        $ind = 1;
        $response = "";
        $action = "product_update";

        $specific_product = Product::find($id);
        
        $data_session = [
            'ind' => $ind,
            'response' => $response,
            'action' => $action,
            'SPECIFIC_PRODUCT' => $specific_product,
            'product_id' => $id
        ];

        return redirect()->to('products')->with('data_session', $data_session);       // ovo je sesija pa obrati paznju kada uzimas podatke ...
        
    
    }


    function update_and_save_existing_product(Request $request){
        
        $action = "product_update_and_save";

        $request->validate([
            'id'=>'required'
        ]);

        $id = $request->get('id');
        $specific_product = Product::find($id);


        $specific_product->name = $request->get('name');
        $specific_product->sku = $request->get('sku');
        $specific_product->description = $request->get('description');
        $specific_product->price = $request->get('price');

        $specific_product->save();

        $ind = 1;
        $response = "Uspesna izmena proizvoda , ID : " . $id;


        $data_session = [
            'ind' => $ind,
            'response' => $response,
            'action' => $action,
            'product_id' => $id
        ];

        return redirect()->to('products')->with('data_session', $data_session);       // ovo je sesija pa obrati paznju kada uzimas podatke ...

        

    }

}
