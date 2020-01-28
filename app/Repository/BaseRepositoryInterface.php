<?php


namespace App\Repository;


interface BaseRepositoryInterface
{
    public function index();

    public function show($id);

    public function store(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function exists($column, $value);

    public function findWith($column, $value);

    public function find($id);
}
