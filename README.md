# Subscriber API

A simple RESTful API built with Laravel for managing subscribers and custom fields as part of a technical challenge.

This project showcases backend skills such as validation, database relationships, and API structuring.

I aimed to keep the code as simple as possible while following best practices for structuring the project.

Of course, there’s room for improvement, such as better error handling, enhanced validation, and more robust testing. Additionally, the fields in the store and update **subscriber methods could be moved to dedicated services**, but I opted to keep it simple.

There is also a Vue.js client app for consuming this API. Check it out [here](https://github.com/andreipredafl/subscriber-hub-client).

If the video has expired, feel free to contact me at andrei.preda.dev@gmail.com

## Requirements

-   PHP 8.2+
-   Composer
-   SQLite (or any other database)
-   Laravel Valet (optional)

## Installation

1.  **Clone the repository**

    ```bash
    git clone git@github.com:andreipredafl/subscriber-api.git
    cd subscriber-api
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

        Visit: [http://subscriber-api.test](http://subscriber-api.test)

    -   **If you want to use HTTPS, you can follow these steps:**

        ```bash
        valet secure
        ```

        Visit: [https://subscriber-api.test](https://subscriber-api.test)

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
