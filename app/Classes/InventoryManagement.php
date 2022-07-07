<?php
namespace App\Classes;

use App\Http\Resources\InventoryResource;
use App\Http\Resources\InventoryResourceCollection;
use App\Repositories\InventoryRepository;
use App\Repositories\Interfaces\InventoryRepositoryInterface;
use Illuminate\Support\Facades\DB;


class InventoryManagement{

    private $inventoryRepository;

    public function __construct
    (
        InventoryRepositoryInterface $inventoryRepository
    ){
       $this->inventoryRepository = $inventoryRepository;
    }

    public function index(){
       $inventories = null;
       DB::transaction(function () use(&$inventories) {
            $inventories = $this->inventoryRepository->index();
            $inventories = new InventoryResourceCollection($inventories);

       });
       return $inventories;
    }

    public function show($id){
        $inventory = null;
        DB::transaction(function () use(&$inventory, $id) {
            $inventory = $this->inventoryRepository->getById($id);
            $inventory = new InventoryResource($inventory);
        });
        return $inventory;
    }

    public function create(array $data){
        $inventory = null;
        DB::transaction(function () use (&$inventory, $data) {
            $inventory = $this->inventoryRepository->create($data);
            $inventory = new InventoryResource($inventory);
        });
        return $inventory;
        
    }

    public function edit(array $data, $id){
        $inventory = null;
        DB::transaction(function () use (&$inventory, $data, $id) {
            $inventory = $this->inventoryRepository->edit($data, $id);
            $inventory = new InventoryResource($inventory);
        });
        return $inventory;
    }

    public function delete($id){
        DB::transaction(function () use (&$id) {
            $this->inventoryRepository->delete($id);
        });
        return $this->inventoryRepository->index();
    }
}
