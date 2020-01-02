<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\ExpertRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct()
    {
        $this->model = New User();
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model::find([$id]);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function where($column, $operator, $value)
    {
        return $this->model::where($column, $operator, $value);
    }

    public function whereHas($relation, $callback)
    {
        return $this->model::whereHas($relation, $callback);
    }

    // Eager load database relationships
    public function paginate($items)
    {
        return $this->model::orderBy('id', 'DESC')->paginate($items);
    }
}