## Documentation for Book Management System,
## Laravel Backend
Overview
The backend system is built using Laravel and provides authentication and book management functionalities.
The authentication is done using Laravel Sanctum, and the application structure is based on the MVC pattern.

## 1. Authentication
## 1.1. AuthController.php

Register Function: Handles user registration by validating the input data (name, email, password).
If successful, a new user is created and a token is generated for them.

Login Function: Validates the email and password provided by users. If valid, a token is returned,
which should be used for subsequent API calls that require authentication.

Logout Function: Revokes the currently authenticated user's token.

## 1.2. Models/User.php

This model represents a user in the system.
It uses the HasApiTokens trait from Laravel Sanctum to handle token generation.

## 1.3. config/auth.php

set up to use Sanctum for the API guard.

## 2. Book Management
## 2.1. BookController.php

Index Function: Returns a paginated list of books.
Store Function: Creates a new book after validating input data.
Show Function: Returns details of a specified book.
Update Function: Updates the details of a specific book after validating the data.
Destroy Function: Deletes a specified book from storage.

## 2.2. Models/Book.php

This model represents a book in the system.

## 2.3. database/migrations/2023_08_13_211638_create_books_table.php

Migration for creating the books table.
Columns include id, title, author, publication_date, description, created_at, and updated_at.

## 2.4. routes/api.php

Authentication endpoints: /login and /register.
Book-related routes: These are protected by the auth:sanctum middleware to ensure that only authenticated users can access them.
These routes are defined using the apiResource method which sets up standard CRUD routes for books.

Frontend Documentation

## 1. Components Overview
## 1.1. Book.vue

Handles the main functionality including adding, editing, deleting, and listing books.

## 1.2. BookValidation.vue

Handles the form validation for the book inputs and emits the validation result to its parent.

## 1.3. Login.vue

Manages the user login functionality.

## 1.4. Toast.vue

Displays a temporary notification to the user.

## 2. Book.vue Component
Methods:

logout(): Logs out the user by removing the authentication token and reloading the page.
Properties:

books: Contains an array of all books fetched from the server.
newBook: Contains the properties of a new book to be added.
errors: Contains the validation errors.
editMode: A boolean indicating if the edit mode is active.
editingBook: Contains the properties of the book currently being edited.
pagination: Handles pagination data.
Major Methods in setup():

fetchBooks(): Fetches the books for the current page from the server.
createBook(): Sends a request to the server to add a new book.
showEditForm(book): Prepares the editingBook object for editing.
updateBook(): Sends a request to update an existing book.
deleteBook(book): Sends a request to delete a book.

## 3. BookValidation.vue Component
Properties:

book: Accepts a book object for validation.
errors: Contains the validation errors.
Methods:

validate(): Validates the book's properties.
clearErrors(): Clears the validation errors.

## 4. Login.vue Component
Properties:

credentials: Contains the user's email and password for login.
errorMessage: Contains the error message if login fails.
Methods:

login(): Sends a request to the server to log in the user.

## 5. Toast.vue Component
Displays a notification based on the given message and type.

Properties:

message: Contains the message to be shown in the toast.
type: Indicates the type of toast (success or error).
duration: The duration for which the toast will be displayed.
Methods:

show(): Displays the toast.
hide(): Hides the toast.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
