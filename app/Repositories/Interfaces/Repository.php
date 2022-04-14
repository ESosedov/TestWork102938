<?php
namespace App\Repositories\Interfaces;



interface Repository
{
    public function create(array $data);
    public function detail(int $entity_id);
    public function addAttribute(int $entity_id, int $attribute_id, string $pivot);
    public function deleteAttribute(int $entity_id, int $attribute_id);
    public function get(array $data);
    public function delete(int $id);
}
