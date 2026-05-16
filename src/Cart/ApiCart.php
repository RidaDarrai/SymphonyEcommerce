<?php

namespace App\Cart;

use Symfony\Component\HttpClient\HttpClient;

class ApiCart implements CartInterface
{
    private string $apiUrl;
    private \Symfony\Component\HttpClient\HttpClientInterface $httpClient;

    public function __construct(string $apiUrl = 'http://localhost:8000/api/cart')
    {
        $this->apiUrl = $apiUrl;
        $this->httpClient = HttpClient::create();
    }

    public function addItem(int $productId, int $quantity = 1): void
    {
        $this->httpClient->request('POST', $this->apiUrl . '/add', [
            'json' => [
                'productId' => $productId,
                'quantity' => $quantity
            ]
        ]);
    }

    public function removeItem(int $productId): void
    {
        $this->httpClient->request('DELETE', $this->apiUrl . '/remove/' . $productId);
    }

    public function updateItemQuantity(int $productId, int $quantity): void
    {
        $this->httpClient->request('PUT', $this->apiUrl . '/update', [
            'json' => [
                'productId' => $productId,
                'quantity' => $quantity
            ]
        ]);
    }

    public function getItems(): array
    {
        $response = $this->httpClient->request('GET', $this->apiUrl . '/items');
        return $response->toArray();
    }

    public function getTotalItems(): int
    {
        $response = $this->httpClient->request('GET', $this->apiUrl . '/count');
        return $response->toArray()['count'];
    }

    public function getTotalPrice(): float
    {
        $response = $this->httpClient->request('GET', $this->apiUrl . '/total');
        return $response->toArray()['total'];
    }

    public function clear(): void
    {
        $this->httpClient->request('DELETE', $this->apiUrl . '/clear');
    }

    public function isEmpty(): bool
    {
        $response = $this->httpClient->request('GET', $this->apiUrl . '/empty');
        return $response->toArray()['empty'];
    }
}