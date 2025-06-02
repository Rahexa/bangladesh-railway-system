# Bangladesh Railway System

A Laravel-based web application for booking train tickets, managing passenger details, and tracking train routes in Bangladesh. Developed by Group A as an academic project to enhance railway travel with a user-friendly, technology-driven platform.

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technologies](#technologies)
- [Installation](#installation)
- [Usage](#usage)
- [Team](#team)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

The Bangladesh Railway System is a comprehensive web application designed to streamline train ticket booking, passenger management, and train tracking for railway travel in Bangladesh. Built as an academic project by Group A, it aims to provide a seamless, technology-driven experience for both passengers and administrators.

---

## Features

- **Ticket Booking:** Book tickets with real-time seat availability and class selection.
- **Seat Selection:** Interactive interface for choosing seats with coach and class options.
- **Payment Integration:** Secure payments via SSLCommerz with OTP verification.
- **Train Tracking:** Real-time updates on train routes and statuses.
- **Admin Panel:** Comprehensive management of users, bookings, train schedules, and seats.
- **User Profile:** Manage personal details and view booking history.
- **Ticket Management:** View and download tickets in PDF format.

---

## Technologies

- **Backend:** Laravel `{{ Illuminate\Foundation\Application::VERSION }}`, PHP `{{ PHP_VERSION }}`
- **Frontend:** Blade, Bootstrap, Tailwind CSS, jQuery, Font Awesome, Phosphor Icons
- **Database:** MySQL (configurable via `.env`)
- **Payment Gateway:** SSLCommerz (EasyCheckout and Hosted)
- **Asset Compilation:** Vite

---

## Installation

Follow these steps to set up the Bangladesh Railway System locally:

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/your-username/bangladesh-railway-system.git
    cd bangladesh-railway-system
    ```

2. **Install Dependencies:**

    ```bash
    composer install
    npm install
    ```

3. **Set Up Environment:**

    - Copy the `.env.example` file to `.env`:

      ```bash
      cp .env.example .env
      ```

    - Generate an application key:

      ```bash
      php artisan key:generate
      ```

    - Configure the `.env` file with your database and SSLCommerz credentials:

      ```
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=railway_system
      DB_USERNAME=root
      DB_PASSWORD=

      SSL_COMMERZ_STORE_ID=your_store_id
      SSL_COMMERZ_STORE_PASSWORD=your_store_password
      ```

4. **Run Migrations:**

    ```bash
    php artisan migrate
    ```

5. **Compile Assets:**

    ```bash
    npm run build
    ```

6. **Start the Development Server:**

    ```bash
    php artisan serve
    ```

---

## Usage

- **Access the Application:** Navigate to `http://localhost:8000` in your browser.
- **Register/Login:** Create an account or log in to access booking features.
- **Book a Ticket:** Select stations, date, class, and seats, then proceed to payment.
- **Track Trains:** Monitor real-time train status on the tracking page.
- **Admin Panel:** Admins can manage users, bookings, and schedules via the admin dashboard.
- **Download Tickets:** View and download tickets in PDF format from the "My Booking" section.

---

