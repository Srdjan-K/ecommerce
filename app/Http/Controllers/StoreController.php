<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Url;


class StoreController extends Controller
{
    function store_view(){

        $list_of_stores = Store::all();

        $data = [
            'LIST_OF_STORES' => $list_of_stores
        ];

        return view('admin.stores', compact('data'));

    }



    function get_specific_store($id){
                   
            $specific_store = Store::where( 'id', '=', $id )->first();
            
            $data = [
                'SPECIFIC_STORE' => $specific_store
            ];

            return view("admin.stores", compact('data'));

    }


    function add_new_store(Request $request){
        
        $action = "store_add";

        $request->validate([
            'name'=>'required',
            'code'=>'required|unique:stores',
            'base_url'=>'required|unique:stores',
            'description'=>'required'
        ]);


        $new_store = new Store;
        $new_store->name = $request->name;
        $new_store->code = $request->code;
        $new_store->base_url = $request->base_url;
        $new_store->description = $request->description;

        $query = $new_store->save();
        

        // if($query){
        //     return back()->with('success','USPESNO registrovana nova prodavnica ! ');
        // }else{
        //     return back()->with('fail','Nova prodavnica nije registrovana ... ');
        // }


        if($query){
            $ind = 1;
            $created_id = $new_store->id;
            $response = "USPESNO registrovana nova prodavnica ! ID prodavnice : " . $created_id;
        }else{
            $ind = -1;
            $response = "Nova prodavnica nije registrovana ... ";
        }

        $data_session = [
            'ind' => $ind,
            'response' => $response,
            'action' => $action
        ];

        return redirect()->to('stores')->with('data_session', $data_session);

    }


    function delete_specific_store($id){
        
        $action = "store_delete";
        $specific_store = Store::find( $id );
        $specific_store->delete();
        
        $list_of_stores = Store::all();

        
        unset($specific_store);
        $specific_store = Store::find( $id );


        if ($specific_store === null) {
            // user doesn't exist
            $ind = 1;
            $response = "Uspesno ste obrisali prodavnicu , ID : " . $id;

        }else{
            $ind = -1;
            $response = "Nazalost niste obrisali prodavnicu. Prodavnica je i dalje u bazi , ID : " . $id;
        }

        $data_session = [
            'ind' => $ind,
            'response' => $response,
            'action' => $action,
            'LIST_OF_STORES' => $list_of_stores
        ];

        return redirect()->to('stores')->with('data_session', $data_session);


    }





    function update_existing_store($id){
        
        $ind = 1;
        $response = "";
        $action = "store_update";

        $specific_store = Store::find($id);
        
        $data_session = [
            'ind' => $ind,
            'response' => $response,
            'action' => $action,
            'SPECIFIC_STORE' => $specific_store,
            'store_id' => $id
        ];

        return redirect()->to('stores')->with('data_session', $data_session);       // ovo je sesija pa obrati paznju kada uzimas podatke ...
        
    
    }


    function update_and_save_existing_store(Request $request){
        
        $action = "store_update_and_save";

        $request->validate([
            'id'=>'required'
        ]);

        $id = $request->get('id');
        $specific_store = Store::find($id);


        $specific_store->name = $request->get('name');
        $specific_store->code = $request->get('code');
        $specific_store->base_url = $request->get('base_url');
        $specific_store->description = $request->get('description');

        $specific_store->save();

        $ind = 1;
        $response = "Uspesna izmena radnje , ID : " . $id;


        $data_session = [
            'ind' => $ind,
            'response' => $response,
            'action' => $action,
            'store_id' => $id
        ];

        return redirect()->to('stores')->with('data_session', $data_session);       // ovo je sesija pa obrati paznju kada uzimas podatke ...

        

    }



}
