# ToucanTech | Task 05

## Setup Instructions

Clone the repository.
```bash
git clone https://github.com/pasanks/tech-task-05.git
```

Switch to the project folder

```bash
cd tech-task-05
```

Install composer dependencies.

```bash
composer install
```

Copy the example env file and make the required configuration changes in the .env file

```bash
cp .env.example .env
```

Generate a new application key
```bash
php artisan key:generate
```
Run the database migrations and seeds

**Set the database connection in .env before migrating

```bash
php artisan migrate --seed
```

Start the local development server

```bash
php artisan serve
```
The server will typically start on http://localhost:8000.

You can run the test suit by running

```bash
php artisan test
```

