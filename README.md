Bangladesh Railway System
A Laravel-based web application for booking train tickets, managing passenger details, and tracking train routes in Bangladesh. Developed by Group A as an academic project to enhance railway travel with a user-friendly, technology-driven platform.
Table of Contents

Features
Technologies
Installation
Usage
Team
Contributing
License

Features

Ticket Booking: Book tickets with real-time seat availability and class selection.
Seat Selection: Interactive seat selection with coach and class options.
Payment Integration: Secure payments via SSLCommerz with OTP verification.
Train Tracking: Real-time train route tracking and status updates.
Admin Panel: Manage users, bookings, train schedules, and seats.
User Profile: Update personal details and view booking history.
Ticket Management: View and download tickets in PDF format.

Technologies

Backend: Laravel {{ Illuminate\Foundation\Application::VERSION }}, PHP {{ PHP_VERSION }}
Frontend: Blade, Bootstrap, Tailwind CSS, jQuery, Font Awesome, Phosphor Icons
Database: MySQL (configurable via .env)
Payment Gateway: SSLCommerz (EasyCheckout and Hosted)
Asset Compilation: Vite

Installation

Clone the Repository:
git clone https://github.com/your-username/bangladesh-railway-system.git
cd bangladesh-railway-system


Install Dependencies:
composer install
npm install


Set Up Environment:

Copy .env.example to .env:cp .env.example .env


Generate an application key:php artisan key:generate


Configure .env with your database and SSLCommerz credentials:DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=railway_system
DB_USERNAME=root
DB_PASSWORD=

SSL_COMMERZ_STORE_ID=your_store_id
SSL_COMMERZ_STORE_PASSWORD=your_store_password




Run Migrations:
php artisan migrate


Compile Assets:
npm run build


Start the Development Server:
php artisan serve



Usage

Access the Application: Open http://localhost:8000 in your browser.
Register/Login: Create an account or log in to book tickets.
Book a Ticket: Navigate to the booking page, select stations, date, class, and seats, then proceed to payment.
Track Trains: Use the tracking page to monitor train status in real-time.
Admin Panel: Admins can manage users, bookings, and train schedules.
Download Tickets: View and download tickets from the "My Booking" section.

Team

Raihan Sikder (Team Lead)
Hamed Hasan (Frontend Developer)
Soumen Biswas (Database Manager)
Sbuj Gupta (Tester)
Additional Member (Role TBD)

Contributing
Contributions are welcome! Please follow these steps:

Fork the repository.
Create a new branch (git checkout -b feature/your-feature).
Commit your changes (git commit -m "Add your feature").
Push to the branch (git push origin feature/your-feature).
Open a pull request.

License
This project is licensed under the MIT License.
