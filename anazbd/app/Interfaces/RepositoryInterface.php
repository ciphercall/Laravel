<?php namespace App\Interfaces;

interface RepositoryInterface
{
    public function all();

    public function getWithRelation(array $with = [],int $per_page);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show(array $with = [],$id);
}