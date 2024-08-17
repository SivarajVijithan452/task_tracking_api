
## About application

This Laravel API system provides a RESTful API to manage products. The system includes functionalities such as creating, reading, updating, and deleting (CRUD) products. Additionally, system that integrates a frontend using Vite, Tailwind CSS, and DaisyUI. The system provides an API for managing products, with real-time updates using Laravel Echo and broadcasting events.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Features

Backend: Laravel (PHP framework)
Frontend: Vite (build tool), Tailwind CSS (CSS framework), DaisyUI (component library)
Real-time Communication: Laravel Echo, Pusher
Authentication: Laravel Breeze

## Setup Instructions

Ensure the following are installed on your machine:

- **PHP 8.0+**
- **Composer**
- **MySQL** 

## Installation Steps

Clone the Repository

Open your terminal and run the following command to clone the repository:

git clone https://github.com/SivarajVijithan452/task_tracking_api.git
cd task_tracking_api

## Install Backend Dependencies

composer install

## Install Frontend Dependencies

npm install

Open the .env file in a text editor and configure the following settings:

Database Connection: Update DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD to match your database setup.
Broadcasting: Configure the BROADCAST_DRIVER, PUSHER_APP_ID, PUSHER_APP_KEY, PUSHER_APP_SECRET, and PUSHER_APP_CLUSTER if you're using Pusher for real-time events.


## Run the following command to start the backend server:

php artisan serve

This will start the Laravel server at http://localhost:8000.

## Start the Frontend Development Server

Open another terminal window and start the frontend server:

npm run dev

This will start the Vite development server

## Access the Application

Backend API: You can interact with the API at http://localhost:8000/api.
Frontend Interface: Open your browser and navigate to http://localhost:3000 to view the frontend interface.
Troubleshooting
Database Issues: Ensure that your database credentials in the .env file are correct and that the database server is running.

Missing Dependencies: If you encounter issues with missing packages, run composer install and npm install again.
