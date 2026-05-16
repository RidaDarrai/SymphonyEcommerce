<?php

namespace App\Cart;

use App\Entity\Product;
use App\Repository\ProductRepository;

class CartHandler
{
    private CartInterface $cartStorage;
    private ProductRepository $productRepository;

    public function __construct(CartInterface $cartStorage, ProductRepository $productRepository)
    {
        $this->cartStorage = $cartStorage;
        $this->productRepository = $productRepository;
    }

    public function addItem(int $productId, int $quantity = 1): void
    {
        $this->cartStorage->addItem($productId, $quantity);
    }

    public function removeItem(int $productId): void
    {
        $this->cartStorage->removeItem($productId);
    }

    public function updateItemQuantity(int $productId, int $quantity): void
    {
        $this->cartStorage->updateItemQuantity($productId, $quantity);
    }

    public function getItems(): array
    {
        return $this->cartStorage->getItems();
    }

    public function getTotalItems(): int
    {
        return $this->cartStorage->getTotalItems();
    }

    public function getTotalPrice(): float
    {
        $total = 0.0;
        $items = $this->cartStorage->getItems();
        
        foreach ($items as $productId => $quantity) {
            /** @var Product|null $product */
            $product = $this->productRepository->find($productId);
            if ($product) {
                $total += floatval($product->getPrice()) * $quantity;
            }
        }
        
        return $total;
    }

    public function clear(): void
    {
        $this->cartStorage->clear();
    }

    public function isEmpty(): bool
    {
        return $this->cartStorage->isEmpty();
    }
}