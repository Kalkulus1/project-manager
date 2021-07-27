# project-manager
A simple project manager with laravel and livewire


## Install and run the project

### Clone the project
```bash
git clone git@github.com:Kalkulus1/project-manager.git
```

### Navigate to the project
```bash
cd project_manager
```
### Composer install
```bash
composer install
```

### Copy the .env file
```bash
cp .env.example .env
```

### Create a database and update the database credentials
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_manager
DB_USERNAME=root
DB_PASSWORD=
```

### Run the migrations
```bash
php artisan migrate
```


### Run the seeder for the default user and todo items
```bash
php artisan db:seed
```

This creates a new user with the credentials below:

```copy
Email: kalkulus@ktechhub.com
Password: ktechhub
```

### Generate an app key

```bash
php artisan key:generate
```

### Start the server

```bash
php artisan serve
```

The server is located at [http://127.0.0.1:8000](http://127.0.0.1:8000)

You can login with the credentials shown...
