<?php

namespace App\Cart;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionCart implements CartInterface
{
    private SessionInterface $session;
    private const CART_SESSION_KEY = 'cart';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        // Initialize cart if not exists
        if (!$this->session->has(self::CART_SESSION_KEY)) {
            $this->session->set(self::CART_SESSION_KEY, []);
        }
    }

    public function addItem(int $productId, int $quantity = 1): void
    {
        $cart = $this->session->get(self::CART_SESSION_KEY, []);
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        $this->session->set(self::CART_SESSION_KEY, $cart);
    }

    public function removeItem(int $productId): void
    {
        $cart = $this->session->get(self::CART_SESSION_KEY, []);
        unset($cart[$productId]);
        $this->session->set(self::CART_SESSION_KEY, $cart);
    }

    public function updateItemQuantity(int $productId, int $quantity): void
    {
        $cart = $this->session->get(self::CART_SESSION_KEY, []);
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }
        $this->session->set(self::CART_SESSION_KEY, $cart);
    }

    public function getItems(): array
    {
        return $this->session->get(self::CART_SESSION_KEY, []);
    }

    public function getTotalItems(): int
    {
        $cart = $this->session->get(self::CART_SESSION_KEY, []);
        return array_sum($cart);
    }

    public function getTotalPrice(): float
    {
        // We need product prices; we'll delegate to CartHandler or have cart depend on ProductCatalog
        // For simplicity, we'll return 0 and let CartHandler calculate with catalog
        return 0.0;
    }

    public function clear(): void
    {
        $this->session->remove(self::CART_SESSION_KEY);
    }

    public function isEmpty(): bool
    {
        return empty($this->session->get(self::CART_SESSION_KEY, []));
    }
}