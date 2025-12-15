# 🛒 TokoSaya - E-Commerce Web Application

**TokoSaya** is a simple yet functional E-Commerce web application built with the **Laravel** framework. This project serves as a platform for managing products, categories, and displaying them to customers.

It is designed to be easily deployed on shared hosting environments (like InfinityFree, cPanel) without requiring complex server configurations (SSH access/symlinks).

## Akses Online
Aplikasi telah di-deploy di InfinityFree:
👉 [Akses Website TokoSaya](https://tokosaya.rf.gd/)

## 🚀 Features

### 👤 Admin Panel
- **Dashboard**: Overview of product stats.
- **Product Management (CRUD)**:
  - Add, Edit, and Delete products.
  - **Image Upload System**: Optimized for shared hosting (images stored directly in `public/storage/products`), eliminating the need for `php artisan storage:link`.
- **Category Management**: Organize products into dynamic categories.
- **Authentication**: Secure login system for administrators.

### 🛍️ Public Frontend (Customer)
- **Product Catalog**: Browse available products with images and details.
- **Responsive Design**: Compatible with desktop and mobile views.

## 🛠️ Tech Stack

- **Framework**: [Laravel](https://laravel.com/) (PHP)
- **Database**: MySQL
- **Frontend**: Blade Templates, Bootstrap / Tailwind CSS (Adjust based on your usage)
- **Server**: Apache / Nginx

## ⚙️ Installation (Local Development)

Follow these steps to run the project on your local machine:

1.  **Clone the repository**
    ```bash
    git clone [https://github.com/Lesmana24/Ecommerce-TokoSaya.git](https://github.com/Lesmana24/Ecommerce-TokoSaya.git)
    cd Ecommerce-TokoSaya
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Environment Setup**
    - Copy the `.env.example` file to `.env`.
    - Configure your database credentials (DB_DATABASE, DB_USERNAME, etc.).
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Migration**
    ```bash
    php artisan migrate --seed
    ```

5.  **Run the Server**
    ```bash
    php artisan serve
    ```
    Access the app at `http://127.0.0.1:8000`.

## ☁️ Deployment Notes (Shared Hosting)

This project has been optimized for shared hosting where SSH access is limited:

1.  **Database**: Export your local SQL and import it to your hosting's phpMyAdmin.
2.  **Files**: Upload all files to the server.
3.  **Images**:
    - The `AdminProductController` uses a custom logic to store images in `public/storage/products`.
    - **No Symlink Required**: You do not need to run `php artisan storage:link`. Images will appear automatically.
4.  **Configuration**: Update the `.env` file with your production database credentials.

## 📸 Screenshots

| Admin Dashboard | Product List |
| :---: | :---: |
| ![Admin Dashboard](path/to/image.png) | ![Product List](path/to/image.png) |

## 👨‍💻 Author

**Lesmana24**
- GitHub: [Lesmana24](https://github.com/Lesmana24)
- Role: Informatics Engineering Student

---
*Made with ❤️ and Laravel.*
