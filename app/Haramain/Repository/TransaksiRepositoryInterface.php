<?php namespace App\Haramain\Repository;

interface TransaksiRepositoryInterface
{
    public static function kode(): ?string;
    public static function create(object $data, array $detail): ?string;
    public static function update(object $data, array $detail): ?string;
    public static function delete(int $id): ?string;
}
