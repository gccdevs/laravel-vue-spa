# Central hub system

## Installation

1. Run 

    ```
    composer install
    ```
    and
    ```
    npm install
    ```

2. create `.env` file from `.env.example`

3. Set up **database** config in `.env`

4. Copy `form-builder` folder into `storage/app/local/` for sample demo purpose **(api: 'sample.form-builder' and 'sample.form-data')**.

5. Run `php artisan migrate`

## Run javascript script

6. Since all `public/js/*.js` are in **.gitignore** so please do compile all vue components to `.js` to `/public/js/*.js` first:
    ```
    npm run dev
    ```
    or watch on js changes
    ```
    npm run watch
    ```
    ,or auto update without refresh:
    ```
    npm run hot
    ```
7. Run the below command to migrate database
    ```
    php artisan migrate
    ```
7.1. Run the below command to seed dummy user
    ```
    php artisan db:seed
    ```
    Then you will be able to use `tg@tg.com` and password: `123123` to login

## Serve

8. Serve the website:
   - Use Valet
   Please install valet [here](https://laravel.com/docs/5.6/valet)

   - Use MAMP / MAMP Pro
   Install MAMP [here](https://www.mamp.info/en/downloads/)

   - Or simple serve please run:
   ```
   php artisan serve
   ```
9. If you're pushing to production, please set APP_ENV to **production** and run `npm run build`

## Installation troubleshooting

1. composer not found:

    So please install [composer](https://getcomposer.org/) first.

2. npm not found:

    Install npm and node.js [here](https://nodejs.org/en/)

3. Migrate failure: `Specified key was too long; max key length is 767 bytes `:

    The interim solution is to replace the mysql connection charset with the code below in `config/database.php`:
    
    ```
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
    ```
    
    Alternatively, modify `AppServiceProvider.php`:
    
    ```
    use Illuminate\Support\Facades\Schema;
    
    
    function boot()
    {
        Schema::defaultStringLength(191);
    }
    ```
 4. If you see error like below:
    ```
    dashboard:15 GET http://localhost:8080//css/app.css 0 ()
    dashboard:161 GET http://localhost:8080//js/manifest.js 0 ()
    dashboard:162 GET http://localhost:8080//js/vendor.js 0 ()
    dashboard:163 GET http://localhost:8080//js/app.js 0 ()
    ```   
    or: `The Mix manifest does not exist.`

    Please run `npm run hot`

Happy hacking!
# laravel-vue-spa
