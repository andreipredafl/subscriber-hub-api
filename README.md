# MailerLite Subscriber API

A simple RESTful API built with Laravel for managing subscribers and custom fields.

This project is part of a challenge and showcases backend skills including validation, database relationships, and API structuring.

There is also a Vue.js client app for consuming this API. Check it out [here](https://github.com/andreipredafl/mailerlite-subscriber-client).

## Requirements

-   PHP 8.2+
-   Composer
-   SQLite (or any other database)
-   Laravel Valet (optional)

## Installation

1.  **Clone the repository**

    ```bash
    git clone https://github.com/andreipredafl/mailerlite-subscriber-api.git
    cd mailerlite-subscriber-api
    ```

2.  **Install dependencies**

    ```bash
    composer install
    ```

3.  **Environment configuration**  
    The `.env` file is already included in the project, so no additional setup is required.

4.  **Generate application key**

    ```bash
    php artisan key:generate
    ```

5.  **Run migrations and seed the database**

    ```bash
    php artisan migrate --seed
    ```

6.  **Start the development server**

    -   **Using Artisan (default)**

        ```bash
        php artisan serve
        ```

        Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

    -   **Using Laravel Valet (if installed)**

        ```bash
        valet link
        ```

        Visit: [http://mailerlite-subscriber-api.test](http://mailerlite-subscriber-api.test)

    -   **If you want to use HTTPS, you can follow these steps:**

        ```bash
        valet secure
        ```

        Visit: [https://mailerlite-subscriber-api.test](https://mailerlite-subscriber-api.test)

        **If HTTPS is still not working, try the following:**

        ```bash
        valet unlink
        valet link
        valet secure
        ```

---

## Running Tests

To run automated tests, execute:

```bash
php artisan test
```
