# Laravel Rental Cars

Laravel Rental Cars is a web application for managing car rentals. This project is built using the Laravel framework and provides a robust solution for car rental businesses to manage their vehicles, customers, and rental transactions.

## Features

- User authentication and authorization
- Car management (add, edit, delete, view)
- Customer management (add, edit, delete, view)
- Rental transaction management (create, update, delete, view)
- Search and filter functionality
- Responsive design

## Installation

1. **Clone the repository:**
    ```sh
    git clone https://github.com/Elkas-Hamza/laravel-rental-cars.git
    cd laravel-rental-cars
    ```

2. **Install dependencies:**
    ```sh
    composer install
    npm install
    ```

3. **Set up environment variables:**
    Copy the `.env.example` file to `.env` and update the environment variables as needed:
    ```sh
    cp .env.example .env
    ```

4. **Generate application key:**
    ```sh
    php artisan key:generate
    ```

5. **Run migrations and seed the database:**
    ```sh
    php artisan migrate --seed
    ```

6. **Build front-end assets:**
    ```sh
    npm run dev
    ```

7. **Start the development server:**
    ```sh
    php artisan serve
    ```

## Usage

1. Open your browser and navigate to `http://localhost:8000`.
2. Register a new user or log in with an existing account.
    `admine@exemple.com` password is `password`
    `test@exemple.com` password is `password`
    (you have to run the seeders before)
3. Start managing cars, customers, and rentals.

## Contributing

Contributions are welcome! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature-name`).
3. Commit your changes (`git commit -am 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature-name`).
5. Create a new Pull Request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Acknowledgements

- [Laravel](https://laravel.com/) - The PHP framework for web artisans.
- [Bootstrap](https://getbootstrap.com/) - The most popular HTML, CSS, and JavaScript framework for developing responsive, mobile-first projects on the web.

## Contact

For any inquiries or feedback, please contact [Elkas-Hamza](https://github.com/Elkas-Hamza) or [ikbaiss-abdelghafour](https://github.com/ikbaissabdelghafour)
