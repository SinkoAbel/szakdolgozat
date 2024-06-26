# Szakdolgozat

## Szerző: Sinkó Ábel

## Architektúra felépítése:
### Frontend:
- React.js
- Redux Store
- React Router 
- Chakra UI komponens könyvtár
- TailwindCSS
- React Big Calendar

### Backend
- Laravel Sanctum API 
- PHPUnit
- Spatie
- Laravel Service Generator
- knuckleswtf/scribe

### API dokumentáció
1. Projekt klónozása és dependenciák telepítése
2. php artisan scribe:generate
3. {{baseURL}}/docs

### Adatbázis
- MySQL

## Eszközök verziószáma:
- PHP: 8.3.3
- Laravel: 10.10
- Composer: 2.7.2
- Spatie: 2.0
- Node: 21.7.0
- NPM: 10.5.0
- React: 18.2.0
- Redux: 8.1.2
- React Router: 6.14.2
- Redux Persist: 6.0.0
- React Big Calendar: 1.8.1
- Axios 1.4.0

## Projekt futtatása:
- git clone <project>
### Kliens
- cd client
- npm install
- npm run start
### Szerver
- cd server
- composer install
- npm install (opcionális)
- set .env file
- php artisan migrate
- php artisan serve

## Ajánlott műveletek szerver oldalon:
- php artisan db:seed --class=RoleSeeder
- php artisan db:seed --class=UserSeeder
