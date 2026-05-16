<?php

namespace App\Cart;

interface ProductCatalogInterface
{
    public function getProduct(int $productId): ?array;
    public function getAllProducts(): array;
}