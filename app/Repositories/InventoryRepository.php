<?php
namespace App\Repositories;

use App\Exceptions\UnprocessableEntityException;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Model;
use Dotenv\Exception\ValidationException;
use App\Repositories\Interfaces\InventoryRepositoryInterface;

class InventoryRepository extends BaseRepository implements InventoryRepositoryInterface{
    public function __construct(Inventory $model)
    {
        parent::__construct($model);
    }

    public function index(){
        return $this->model->all();
    }

    public function getById(string $id): Inventory
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function edit(array $data, string $id): Inventory
    {
        $inventory = $this->model->findOrFail($id);
        $inventory->fill($data);
        if ($inventory->isClean()) {
            throw new UnprocessableEntityException("Product cannot be updated as details is the same");
        }
        $inventory->update($data);
        return $inventory;
    }

    public function delete(string $id){
        $this->model->where('id', $id)->delete();
    }

}
