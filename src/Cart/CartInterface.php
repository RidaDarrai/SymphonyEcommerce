<?php

namespace App\Cart;

interface CartInterface
{
    public function addItem(int $productId, int $quantity = 1): void;
    public function removeItem(int $productId): void;
    public function updateItemQuantity(int $productId, int $quantity): void;
    public function getItems(): array;
    public function getTotalItems(): int;
    public function getTotalPrice(): float;
    public function clear(): void;
    public function isEmpty(): bool;
}