# E-commerce Backend

This project is an e-commerce backend developed during my internship at Robusta Studio. It provides a comprehensive solution for managing users, products, orders, and payments, all powered by Laravel, PHP, and MySQL. The project implements both RESTful and GraphQL APIs to offer flexible integration options for front-end applications.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Running the Application](#running-the-application)
- [APIs](#apis)
  - [RESTful APIs](#restful-apis)
  - [GraphQL APIs](#graphql-apis)
  - [Email Functionalities](#email-functionalities)

## Features

- User registration, authentication, and email verification
- Product management with category support
- Shopping cart functionality
- Order processing with stock management and payment method integration
- Order history tracking and admin order management
- Daily order report generation and email notifications

## Technologies Used

- **Backend:** Laravel, PHP
- **Database:** MySQL
- **APIs:** RESTful, GraphQL
- **Queue Management:** Laravel Queues
- **Mailing:** Laravel Mail
- **File Handling:** Maatwebsite Excel
- **Design Patterns:** Abstract Factory, Observer, Bridge

## Getting Started

### Prerequisites

- PHP >= 8.0
- Composer
- MySQL
- Node.js and npm (for frontend integration, if needed)

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/ecommerce-backend.git
   
2. Navigate to the project directory:

   ```bash
   cd ecommerce-backend

3. Install dependencies:

   ```bash
   composer install

### Running the Application

1. Run migrations to set up the database:

   ```bash
   php artisan migrate
   
2. Start the development server:

   ```bash
   php artisan serve

## APIs

### RESTful APIs

- **User Management:** Register, login, and manage user profiles.
- **Product Management:** CRUD operations for products and categories.
- **Order Management:** Create and manage orders and order items.

### GraphQL APIs

- **User Queries:** Fetch user details and order history.
- **Product Queries:** List products with filtering and sorting options.
- **Mutations:** Register users, manage shopping cart, and checkout orders.

## Email Functionalities

- **Daily Orders Report:** Automatically generates and emails a daily report of orders as an Excel spreadsheet.
- **User Notifications:** Send order confirmations and account-related notifications.



