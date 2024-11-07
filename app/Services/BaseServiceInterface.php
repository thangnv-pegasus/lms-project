<?php


namespace App\Services;

interface BaseServiceInterface
{
    public function getAll(array $conditions);

    public function show($id);

    public function create(array $attribute);

    public function update($id, $attribute);

    public function delete(array $ids);
}
