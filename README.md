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

When implementing this demo app,

Based on the requirements "Each member can be associated with 1 or more schools, and the demo should display all members for a selected school," this is indicative of a many-to-many relationship.
- Each member can be associated with multiple schools.
- Each school can be associated with multiple members.

- I created feature tests for the two main controllers and didn't spend much time on unit tests.
- Created a GitHub action workflow to run CodeSniffer to identify any code styling issues.
- In terms of the user interface (UI), I opted for a basic Bootstrap/Jquery design. It is responsive up to some extent but has issues with bar chart in the mobile view. Given the time constraints, I focused more on the backend logic and functionality to ensure that the core requirements were effectively met.
