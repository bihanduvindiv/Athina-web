# Athina - Premium Shoe Store

A modern e-commerce web application built with Laravel for selling premium shoes online.

## Project Overview

Athina is a full-featured shoe store application that provides:
- Product catalog with categories (Women's, Men's, Athletic shoes)
- Shopping cart functionality
- User authentication system
- Complete checkout process
- Order management
- Admin panel access

## Features

### Frontend
- Responsive design with Bootstrap 5
- Product browsing and search
- Shopping cart with real-time updates
- User-friendly checkout process
- Modal-based login system

### Backend
- Laravel 9.x framework
- MySQL database integration
- RESTful API endpoints
- User authentication and authorization
- Order and payment processing
- Admin role-based access control

### Database
- Users table with role-based access
- Products catalog
- Orders with customer information
- Payments tracking
- Database migrations and seeders

## Installation

1. Clone the repository
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env`
4. Configure database settings in `.env`
5. Generate application key: `php artisan key:generate`
6. Run migrations: `php artisan migrate`
7. Seed database: `php artisan db:seed`
8. Start server: `php artisan serve`

## Database Configuration

Configure your MySQL database in the `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=athina_db
DB_USERNAME=root
DB_PASSWORD=
```

## Usage

### Admin Access
- Email: admin@athina.com
- Password: admin123

### Customer Features
- Browse products by category
- Add items to shopping cart
- Complete checkout process
- View order history

## API Endpoints

- `POST /api/login` - User authentication
- `POST /api/logout` - User logout
- `GET /api/user` - Get user information
- `POST /api/checkout` - Process checkout
- `GET /api/orders` - Get all orders
- `GET /api/orders/{id}` - Get specific order

## Technologies Used

- **Backend**: Laravel 9.x, PHP 8.x
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Database**: MySQL
- **Authentication**: Laravel Auth
- **Icons**: Bootstrap Icons

## Project Structure

- `app/Http/Controllers/` - Application controllers
- `app/Models/` - Eloquent models
- `database/migrations/` - Database migrations
- `database/seeders/` - Database seeders
- `public/` - Frontend assets and entry point
- `routes/` - Application routes

## Development

This project was developed as part of academic coursework to demonstrate:
- Full-stack web development skills
- Laravel framework proficiency
- Database design and implementation
- Frontend-backend integration
- E-commerce functionality

## License

This project is developed for educational purposes.
