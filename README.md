# Symfony E-Commerce Template Integration
Step 1 of the Symfony e-commerce exercise series: static HTML template integration into Symfony 7.4.

## Description
A prototype e-commerce site with 7 Bootstrap 5-powered static pages, no database/dynamic code yet (per Step 1 requirements).



## Features
- 7 integrated pages: Home, Products, Product Details, Cart, Login, Profile, Browse Categories
- Twig template inheritance (shared navbar/footer)
- Symfony Asset component for image paths
- Clean controller-template structure

## Prerequisites
PHP 8.1+, Composer, Git

## Screen shots
### 1.HOME 
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/82795519-1926-4469-901d-cfde839cb6b9" />

### 2.Products
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/2e10b0f2-8616-4b76-88f6-6cee3bc144f6" />

### 3.Product Details
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/d3035d25-3e87-432a-a389-e7cdd83c61ad" />

### 4.Cart
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/e008138e-c07a-4110-9e9a-c8800cc80257" />

### 5.LOGIN
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/53b7dae7-1e95-4ac2-b311-d76ee47a08c1" />

### 6.Profile
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/82cee196-be49-4c9a-aa86-d1dc40269231" />

### 7.Categories:
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/cb1d8312-eac2-4f0e-a4aa-e0c55c6e14e1" />



# STEP 2

Step 2 : Created Doctrine entities for Category and Product, but couldn't get sql-lite to work due to some driver error (rookie mistake) so i just used controller arrays to simulate dynamic pages. 
Pages now pull data from Symfony controllers (not hardcoded in Twig templates) :
BrowseCategoriesController passes a $categories array

## Step 3: Shopping Cart with SOLID Principles

Implemented a flexible shopping cart system following SOLID principles and Symfony dependency injection.

### Project Structure Updates
```
symfony-project/
├── src/
│   ├── Controller/
│   │   └── CartController.php          # Cart actions (add/remove/view)
│   ├── Cart/                           # NEW: Cart service layer
│   │   ├── CartInterface.php           # Contract for cart operations
│   │   ├── SessionCart.php             # Session-based storage
│   │   ├── CartHandler.php             # Business logic with DI
│   │   ├── ApiCart.php                 # Alternative storage strategy
│   │   └── ProductCatalogInterface.php # Abstraction for product data
│   ├── Entity/
│   │   ├── Category.php
│   │   └── Product.php
│   └── Repository/
│       ├── CategoryRepository.php
│       └── ProductRepository.php
├── templates/
│   └── cart/
│       └── index.html.twig             # Displays cart contents
└── ...
```

### Key Components

**CartInterface** (`src/Cart/CartInterface.php`)
```php
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
```

**SessionCart** (`src/Cart/SessionCart.php`)
```php
class SessionCart implements CartInterface
{
    private SessionInterface $session;
    private const CART_SESSION_KEY = 'cart';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        if (!$this->session->has(self::CART_SESSION_KEY)) {
            $this->session->set(self::CART_SESSION_KEY, []);
        }
    }

    public function addItem(int $productId, int $quantity = 1): void
    {
        $cart = $this->session->get(self::CART_SESSION_KEY, []);
        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
        $this->session->set(self::CART_SESSION_KEY, $cart);
    }

    public function getItems(): array
    {
        return $this->session->get(self::CART_SESSION_KEY, []);
    }

    public function getTotalPrice(): float
    {
        // Price calculation delegated to CartHandler (depends on ProductRepository)
        return 0.0;
    }
    // ... other methods ...
}
```

**CartHandler** (`src/Cart/CartHandler.php`)
```php
class CartHandler
{
    private CartInterface $cartStorage;
    private ProductRepository $productRepository;

    public function __construct(CartInterface $cartStorage, ProductRepository $productRepository)
    {
        $this->cartStorage = $cartStorage;
        $this->productRepository = $productRepository;
    }

    public function getTotalPrice(): float
    {
        $total = 0.0;
        foreach ($this->cartStorage->getItems() as $productId => $quantity) {
            $product = $this->productRepository->find($productId);
            if ($product) {
                $total += $product->getPrice() * $quantity;
            }
        }
        return $total;
    }
    // ... other methods delegate to $cartStorage ...
}
```

**Usage in Controller** (`src/Controller/CartController.php`)
```php
#[Route('/cart', name: 'app_cart')]
public function index(CartHandler $cartHandler): Response
{
    return $this->render('cart/index.html.twig', [
        'cartItems' => $cartHandler->getItems(),
        'totalItems' => $cartHandler->getTotalItems(),
        'totalPrice' => $cartHandler->getTotalPrice(),
    ]);
}

#[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
public function add(Request $request, int $id, CartHandler $cartHandler): Response
{
    $quantity = $request->request->get('quantity', 1);
    $cartHandler->addItem($id, $quantity);
    return $this->redirectToRoute('app_cart');
}
```

### SOLID Principles Applied
- **Single Responsibility**: Each class has one clear purpose (interface, storage, business logic)
- **Open/Closed**: New strategies (e.g., `ApiCart`) can be added without modifying existing code
- **Liskov Substitution**: Any `CartInterface` implementation works with `CartHandler`
- **Interface Segregation**: Focused interfaces (`CartInterface`, `ProductCatalogInterface`)
- **Dependency Inversion**: High-level modules depend on abstractions (`CartInterface`, not concrete implementations)

### Usage
The cart stores data in Symfony session (temporary per user). To change storage mechanism (e.g., to database or API), simply inject a different `CartInterface` implementation—no changes needed to `CartHandler` or controllers.
ProductsByCategoryController passes $category/$products arrays
ProductDetailsController passes a $product array Twig loops through these variables instead of static HTML. We used arrays as a workaround since SQLite driver is missing.
