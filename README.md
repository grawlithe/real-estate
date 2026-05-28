## Real Estate Project

Has 2 login pages: Admin Panel and Tenant/Owner Portal.

## How to setup:
- clone this project
- run `composer install`
- run `npm install`
- copy the .env.example to .env
- run `php artisan key:generate`
- run `php artisan migrate --seed`
- run `php artisan filament:optimize`
- run `php artisan serve`
- run `npm run dev` (on a separate terminal)

## Login Accounts
- Admin Panel:
    - url: http://localhost:8000/admin
    - email: admin@realestate.test
    - password: password
- Portal Tenant:
    - url: http://localhost:8000/portal
    - email: tenant1@realestate.test
    - password: password
- Portal Owner:
    - url: http://localhost:8000/portal
    - email: owner1@realestate.test
    - password: password
