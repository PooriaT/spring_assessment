# spring_assessment

## Overview

It is a Back End Developer Assignment for Spring Financial based on Laravel.

Creating and API for Leaderboard application.

----
#### Requirements:

- Write an API that would power the leaderboard Screen above (REST/GraphQL or)
- All users start with 0 points.
- As you click +/-, the leaderboard updates and users are re-ordered based on score.
- You are able to add users (+) and delete users (x)
- When the name is clicked on, UI would show details of this user.
    - Name
    - Age
    - Points
    - Address
- Create a model factory to fill the db with initial users with random values.
- Create a laravel command to reset all scores.
- Create an endpoint that returns the users info grouped by score and include the
average age of the users in json format.
```json
{
    “25”: {
        “names”: [’Emma’],
        “average_age”: 18
    },
        “18”: {
        “names”: [’Noah’],
        “average_age”: 17
    },
    ...
}
```

- Using queues/jobs generate a QR code that stores the user address after user
creation. Store that QR image locally. You may use (https://goqr.me/api/)

- Create a scheduled job that identifies the user with the highest points at a given
moment and stores a new record in a winners table. This table must maintain a
relationship with the original users table and store the timestamp when the user was
declared a winner and their corresponding points at that time. The job should run
every 5 minutes.

In cases where there's a tie for the highest points, no winner should be declared, and
no record should be created in the winners table.

#### Guideline
- Please include a readme file with instructions on how to run the application.
- Use Laravel as framework.
- Unit test for areas you see fit.
- Brief documentation on the endpoints
- Provide us with link to repository, and link to the API (if you are able to host)

------

### Prerequisite

- PHP 8.1.2-1 (and its requirements)

`sudo apt install php php-curl php-mbstring php-xml php-bcmath php-mysql php-zip`

- composer 2.6.6
- Laravel 10

### Installation

After successfully installed laravel project, we need to change the direcotry to the project folder. 

To install all required dependencies, the below command has to be executed:

`composer install`

Then we can start the development server with below command:

`php artisan serve`

The application wil be accessible at `http://localhost:8000`.

#### Setting up the Database

- Open the .env file and configure your database connection settings.
- Run migrations to create necessary tables:

`php artisan migrate`

#### Creating Routes and Controllers:

- Define routes in routes/web.php for handling HTTP requests.
- Create controllers using the command:

`php artisan make:controller <ContorllerName>`

#### Implementing Front End

All HTML, CSS, and JavaScript files for the view located in `resources` directory. 

#### Docker


#### API 

### Usage

