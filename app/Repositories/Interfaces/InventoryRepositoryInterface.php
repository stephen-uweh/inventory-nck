<?php
namespace App\Repositories\Interfaces;

use App\Models\BlogPost;
use App\Models\Inventory;
use App\Models\Review;
use Illuminate\Database\Eloquent\Model;

interface InventoryRepositoryInterface{

    public function index();

    public function create(array $data): Model;

    public function getById(string $id): Inventory;

    public function edit(array $data, string $id): Inventory;

    public function delete(string $id);

}
