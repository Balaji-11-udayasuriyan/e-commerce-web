## e-commerce-web
# task3


## Requirements
- PHP >= 8.0
- Composer
- MySQL or compatible DB
- Node.js & npm

## Installation

Follow these steps to install and run the Laravel project locally:

1. Clone the repository and navigate into it:
   git clone https://github.com/balaji-11-udayasuriyan/e-commerce-web
   cd e-commerce-web

2. Install PHP dependencies using Composer:
   composer install

3. Setup environment configuration:
   cp .env.example .env
   Then open the .env file and update your database credentials and other settings as needed.

4. Generate application key:
   php artisan key:generate

5. Run database migrations:
   php artisan migrate

6. Start the development server:
   php artisan serve

7. Access the app:
   Open your browser and visit http://localhost:8000
