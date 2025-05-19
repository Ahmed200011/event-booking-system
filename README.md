<!-- <p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

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

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). -->

                                     🎟️ Event Booking System API (Laravel)

This is a full-featured event booking system built with Laravel 11. It allows users to browse and book events, while admins can manage events via an API. Role-based access is implemented using Laratrust.

🚀 Features
-User registration & login (Laravel Sanctum)

-Role-based access (Admin, User) via Laratrust

-Browse events and view event details

-Book events (1 ticket per user per event)

-Admin can Create, Update, Delete events

-Upload event images

-Public API structure

-API secured via Sanctum token

                                       🧱 Project Structure

project/  
├── app/  
│ ├── Models/  
│ │ ├── User.php  
│ │ ├── Event.php  
│ │ └── Booking.php  
│ ├── Http/  
│ │ ├── Controllers/  
│ │ │ └── API/  
│ │ │ ├── AuthController.php  
│ │ │ ├── EventController.php  
│ │ │ ├── BookingController.php  
│ │ │ └── AdminController.php  
│ ├── Middleware/  
│ │ └── isAdmin.php (if needed)  
├── routes/  
│ └── api.php  
├── database/  
│ ├── migrations/  
│ └── seeders/  
├── storage/  
│ └── app/public/  
├── public/  
│ └── storage → (linked via `php artisan storage:link`)

                                       🧑‍💻 Tech Stack

-Laravel 11

-Laravel Sanctum (API Auth)

-Laratrust (Roles & Permissions)

-MySQL

-Postman (for API testing)

-File upload via Laravel Storage (local)

                                      🗃️ Database Tables

-users

-events

-bookings

-roles (Laratrust)

-permissions (Laratrust - optional)

-role_user (Pivot)

-permission_role (Pivot)

                                     🔗 API Endpoints (routes/api.php)

📦 Auth

Method         Endpoint             Description
POST           /auth/register       Register a new user                                              
POST           /auth/login          Login & get token                                                
GET            /profile             Get current user profile                                          
POST           /logout              Logout user                                                  

🎫 Events

Method         Endpoint             Description                                               
GET            /events              List all events                                                 
GET            /events/{id}         Get event details                                             



🛠️ Admin (requires role: administrator|superadministrator)                                         

Method	       Endpoint	                 Description                                              
POST	       /admin/store/event	     Create new event                                            
PUT	           /admin/update/{id}/event  Update event                                             
DELETE	       /admin/delete/{id}/event  Delete event                                          
GET	           /admin/all/events	     List all events (admin)                                  
GET	           /admin/all/bookings	     List all events (admin)                                  


👤 user                                                                                   

Method	       Endpoint	                 Description                                        
POST	       /user/events	             Show all user event                                  
POST	       /user/bookEvent           booking an event                                      
DELETE	       /user/delete/{id}/event   Delete event                                            



                                     ⚙️ Setup Instructions                                        
Clone repository                                                                  

git clone https://github.com/Ahmed200011/api-event-booking-system                           
cd api-event-booking-system                                                         

                                     [⚠️ Suspicious Content] Install dependencies                  

 
composer install                                                                


                                     Create .env and setup database                             


cp .env.example .env                                                     
php artisan key:generate                                    


                                    Configure your DB credentials in .env:



DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=



                                   Run migrations & seeders


php artisan migrate
php artisan db:seed
                                   
                                   Install Laratrust & publish config


composer require santigarcor/laratrust
php artisan laratrust:setup
php artisan migrate



<!-- Create storage symlink


php artisan storage:link -->


                                    Run the app


php artisan serve
                                   👤 Default Roles

In your seeder or tinker you can add roles:

use App\Models\User;
use App\Models\Role;

Role::create(['name' => 'admin']);
Role::create(['name' => 'user']);

$user = User::find(1);
$user->attachRole('admin');
                                
Now the first user is an admin.

                                    🧪 Testing API
Use Postman or Thunder Client to test routes:

Add Authorization header: Bearer {token}

Upload images using multipart/form-data for event creation

