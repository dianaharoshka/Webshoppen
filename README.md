# Forest Brew

A small tea webshop developed as part of a web development course with a focus on e-commerce systems.

## Features

- Home page with 10 popular products  
- Product detail page  
- Category listing  
- Global search  
- Sorting by title and price (ascending/descending)  
- Admin page (work in progress)

## Technologies

- PHP  
- MySQL  
- HTML/CSS (no CSS frameworks)  
- JavaScript  
- Composer for autoloading  
- Environment configuration with `.env`

## Setup

1. Clone the repository  
2. Run `composer install` to enable autoloading  
3. Create a `.env` file in the root directory with the following keys:
   HOST=localhost DB=your_database_name USER=your_db_username PASSWORD=your_db_password PORT=3306
4. On first run, the database tables and demo data will be created automatically.  

Make sure your MySQL server is running and accessible.

