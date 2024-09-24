# Laravel Project Setup

## Prerequisites
Make sure you have the following installed:
- PHP (>= 8.2)
- Composer
- Laravel (latest version)
- Database (e.g., MySQL, SQLite)

## Installation Steps

1. **Install Composer Dependencies**
   ```bash
   composer install

2. **Copy Environment File**
   ```bash
   cp .env.example .env

3. **Set Database Name Open the .env file and set your database name:**
   ```php
   DB_DATABASE=your_database_name

4. **Copy Environment File**
   ```bash
   cp .env.example .env.testing

5. **Set Database Name Open the .env.testing file and set your database name:**
   ```php
   DB_DATABASE=your_database_name_testing   

6. **Set Swagger Host Also in the .env file, set the L5 Swagger constant host:**
   ```php
   L5_SWAGGER_CONST_HOST=http://localhost:8000

7. **Run Migrations:**
   ```bash
   php artisan migrate

8. **Seed the Database:**
   ```bash
   php artisan db:seed

9. **Generate Swagger Documentation Run the following command to generate the Swagger documentation:**
   ```bash
   php artisan l5-swagger:generate

10. **Accessing Swagger Documentation:**
  After generating the Swagger documentation, you can access it at:

   ```bash
   http://localhost:8000/api/documentation

11. **Running the Application:**
  To start the Laravel development server, use:

   ```bash
   php artisan serve


12. **Open Swagger Documentation and Test APIs:**
   In your browser, navigate to the Swagger documentation by visiting the following URL:
   

13. **Test the `/api/profiles` Endpoint**  
Scroll down to find the **Profiles** section. Click on the `/api/profiles` endpoint, then click on the **Try it out** button to test it. 

14. **Test the `/api/login` Endpoint**  
Scroll to the **Auth** section and test the `/api/login` endpoint by providing valid email and password values. Submit the request and copy the token from the response.

15. **Authorize with Token**  
After logging in, go to the top-right section of the Swagger page and click the **Authorize** button. Paste the token in the `Bearer` token field and click **Authorize**.

16. **Test Other APIs**  
Now, you can test the other available APIs by clicking on each endpoint, selecting **Try it out**, and executing the request. Ensure you’re authenticated with the token for endpoints that require authorization.

17. **Run Unit Tests:**
To run the unit tests for the application, use the following command in your terminal.
    ```bash
   php artisan test


18. **Code Quality Tests**
To run PHPStan for static analysis, use the following command in your terminal:
    ```bash
    ./vendor/bin/phpstan analyse

To run PHP_CodeSniffer for checking coding standards, use the following command in your terminal:
    ```bash
    vendor/bin/phpcbf --standard=PSR12 app/





