# Laravel E-Commerce Project

This is a Laravel-based e-commerce web application built as part of a final year project. It includes product listing, shopping cart, checkout, authentication, admin panel, sales, ratings, wishlist, and more.

## 🛠️ Features

- Product listing with categories
- Shopping cart and checkout
- Order management (admin + user)
- Authentication (Laravel UI)
- Role-based access control (admin/customer)
- Product reviews and ratings
- Sale price logic with automatic discounts
- Wishlist
- Admin dashboard (with middleware protection)
- Admin analytics panel 

---

## 📦 Installation

Follow the steps below to set up this project on your local machine.



```bash
### 1. Clone the repository


git clone https://github.com/YOUR_USERNAME/laravel-shop.git
cd laravel-shop

### 2. Install PHP Dependencies

composer install

### 3. Install Frontend Dependencies

npm install 

### 4. Set Up Environment File

MacOs: cp .env.example .env
Windows: copy .env.example .env

### Update the following in your .env:

APP_NAME=LaravelShop
APP_URL=http://127.0.0.1:8000

DB_DATABASE=shop
DB_USERNAME=root
DB_PASSWORD=your_password

### 5. Generate Application Key

php artisan key:generate

### 6. Set Up Database

php artisan migrate --seed
  ***remove comment in database seeder for admin seed

### 7. Link Storage

php artisan storage:link

### 8. Compile Frontend Assets

npm run dev


### 9. Run the Server 

php artisan serve
->  Visit: http://127.0.0.1:8000
 

 ### ROADMAP

| Feature                     | Status              |
| --------------------------- | -------------------  |
| Multi-vendor support        | ❌ Planned           |
| Payment integration         | ❌ Planned           |
| Inventory alerts            | ✅ Basic stock shown |      
| API versioning (for mobile) | ❌ Future work       |

🧑‍💻 Developer
Yessine Jouini
🎓 Final Year BTS Web development Student


