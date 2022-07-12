<?php

namespace App\Http\Controllers;

use App\Classes\InventoryManagement;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    private $inventory;

    public function __construct(InventoryManagement $inventory){
        $this->inventory = $inventory;
    }

    public function index(){
        // return response()->fetch(
        //     "All Inventories",
        //     Inventory::orderBy('created_at','desc')->get(),// $this->inventory->index(),
        //     "data"
        // );
        return "API";
    }

    public function show($id){
        return response()->fetch(
            "Inventory",
            $this->inventory->show($id),
            "data"
        );
    }

    public function create(Request $request){

        if (auth()->user()->isAdmin != 1){
            return response()->json([
                "message" => "Unauthorized"
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "price" => "required",
            "quantity" => "required"
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ]);
        }
        return response()->created(
            "Inventory Created",
            $this->inventory->create($request->all()),
            "data"
        );
    }

    public function edit(Request $request, $id){
        if (auth()->user()->isAdmin != 1){
            return response()->json([
                "message" => "Unauthorized"
            ], 401);
        }

        return response()->updated(
            "Inventory Updated",
            $this->inventory->edit($request->all(), $id),
            "Inventory"
        );
    }

    public function delete($id){
        if (auth()->user()->isAdmin != 1){
            return response()->json([
                "message" => "Unauthorized"
            ], 401);
        }

        return response()->deleted(
            "Inventory Deleted",
            $this->inventory->delete($id)
        );
        
    }
}
