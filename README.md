
# spring Assignment

## Overview

It is a Back-End Developer assignment for Spring Financial based on Laravel. It requires creating an API for a Leaderboard application. The Leaderboard UI is as follows:


<pre>
\----------------------------------------
| X     [Emma]       +  -    25 points  |
| X     [Noah]       +  -    18 points  |
| X     [James]      +  -    17 points  |
| X     [William]    +  -    6 points   |
| X     [OLivia]     +  -    2 points   |
|                     + Add participant |
|                             WINNER    |
\----------------------------------------
</pre>

----

##### Assignment Requirements:

- Write an API that would power the leaderboard Screen above (REST/GraphQL or)
- All users start with 0 points.
- As you click +/-, the leaderboard updates, and users are re-ordered based on score
- You are able to add users (+) and delete users (x)
- When the name is clicked on, UI will show details of this user.
	- Name
	- Age
	- Points
	- Address
	- QR Image
- Create a model factory to fill the db with initial users with random values.
- Create a Laravel command to reset all scores.
- Create an endpoint that returns the users' info grouped by score and includes the

average age of the users in JSON format.

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
- Using queues/jobs generate a QR code that stores the user address after user creation. Store that QR image locally. You may use (https://goqr.me/api/) 
- Create a scheduled job that identifies the user with the highest points at a given moment and stores a new record in a winners' table. This table must maintain a relationship with the original participants' table and store the timestamp when the user was declared a winner and their corresponding points at that time. The job should run every 5 minutes. In cases where there's a tie for the highest points, no winner should be declared, and no record should be created in the winners' table.

##### Assignment Guideline

- Including a readme file with instructions on how to run the application.
- Using Laravel as the framework.
- Providing Unit tests for areas you see fit.
- Brief documentation on the endpoints
- Providing repository link, and link to the API (if you can host)

------

### Prerequisite

- PHP 8.1.2 (and its requirements). The required packages are as follows (for Debian-based OS):

```bash
sudo apt install php php-curl php-mbstring php-xml php-bcmath php-mysql php-zip
```
- composer 2.6.6

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

sudo mv composer.phar /usr/local/bin/composer #Installation Globally
```

- Laravel 10 (`composer create-project laravel/laravel <app_name>`)
- MySQL 8.0.35

### Installation

After successfully installing the Laravel project, we need to change the directory to the project folder.

To install all required dependencies, the below command has to be executed:

```bash
composer install
```
Before starting the development mode, we need to do some further actions. Check the below commands:

```bash
cp .env.example .env
php artisan key:generate # Generating the new project key

php artisan migrate # If the migration had not been done before
# If you need to redo the migration forcefully, you can use:
php artisan migrate:fresh # Warning: your previous data is removed with this command

php artisan storage:link # Linking the storage directory to the public in case to make it accessible for the users
```

If you want to generate dummy content and inject it into the database, you can use the following command, leveraging the provided participants' factory:

```bash
php artisan tinker

# Next, input the command below in the interactive terminal:
# Remember to adjust the value of NUM based on the number of records you intend to generate.
\App\Models\Participant::factory()->count(<NUM>)->create(); 
```

Here, we have a schedule for a specific job that needs to check the highest score and inject it into the "Winner" table of the database every five minutes. Therefore, we need to handle scheduling. **crontab** can be used to set up the required scheduling command to run every minute. As a result, follow the procedure below to configure the scheduling.

```bash
crontab -e

# Inside the editor provide the below command
* * * * * php /<Project_Directory>/artisan schedule:run >> /dev/null 2>&1
```

Now, we can start the development server with the below command:

```bash
php artisan serve
```

The application will be accessible at `http://localhost:8000` or `http://localhost:8000/leaderboard`.

Also, a command is create to reset all participants' scores to Zero:
```bash
php artisan scores:reset
```

#### Partial Project Layout and Directories:

Here, the directory structure of the project is presented. Only the parts that have been added or modified are illustrated:

```md
spring_assessment
├── app
│   ├── Console
│   │   ├── Commands
│   │   │   └── ResetScores.php
│   │   └── Kernel.php  -> To provide scheduling for the winner job
│   └── HTTP
│       ├── Controllers
│       │   ├── Controller.php
│       │   ├── LeaderboardController.php
│       │   └── WinnerController.php
│       ├── Jobs
│       │   ├── GenerateQrCode.php
│       │   └── IdentifyWinners.php
│       └── Models
│           ├── Participant.php
│           └── Winner.php
├── database
│   ├── factories
│   │   └── ParticipantFactory.php
│   ├── migrations
│   │   ├── 2023_12_24_070050_create_participants_table.php
│   │   ├── 2023_12_24_074923_create_jobs_table.php
│   │   ├── 2023_12_24_075626_create_failed_jobs_table.php
│   │   └── 2023_12_24_202843_create_winners_table.php
│   ├── seeders
│   │   └── ParticipantSeeder.php
├── public
│   ├── css
│   │   └── leaderboard.css
│   └── js
│       └── leaderboard.js
├── resources
│   └── views
│       └── leaderboard.blade.php
├── routes
│   ├── api.php
│   └── web.php
├── storage
│   └── app
│       └── public
│           └── qrImages -> All QR Code images are stored in this directory and linked to public
├── tests
│   └── Feature
│       └── LeaderboardTest.php
├── composer.json
├── docker-compose.yml
├── docker-cron
├── Dockerfile
└── README.md
```

#### Implementing Front End

A view of the project has been provided in `resources/view/leaderboard.blade.php` and the required static files including `.css` and `.js` are in the public directory.

#### Docker

`Dockerfile` and `YAML` files are available for building a Docker image for the project. Simply execute the two commands below to build the Docker images and run the containers.

```bash
# Build the Docker images
docker-compose build

# Run the Docker containers
docker-compose up -d
```

### REST API Endpoints

All endpoints for this project are listed below, utilizing four HTTP methods."

##### 1. HTTP GET

-	Retrieving the information related to all participants `/api/leaderboard/participants/`
```json
[
	{
		"id": 3,
		"name": "Melyssa Stroman",
		"age": 18,
		"points": 16,
		"address": "39703 Felipa Summit Suite 651\nLake Bennieport, NV 16008",
		"qr_code_filename": "melyssa-stroman_qr.png",
		"created_at": "2023-12-26T05:47:28.000000Z",
		"updated_at": "2023-12-26T18:51:11.000000Z"
	},
	{
		"id": 1,
		"name": "Daron Waelchi",
		"age": 57,
		"points": 14,
		"address": "31553 Orpha Gateway Suite 136\nLake Freemanborough, ND 66878-1485",
		"qr_code_filename": "daron-waelchi_qr.png",
		"created_at": "2023-12-26T05:47:28.000000Z",
		"updated_at": "2023-12-26T16:11:17.000000Z"
	},
	...
]
```

-	Retrieving information related to a specific participant can be done by inserting the participant's name or ID instead of `identifier` in `/api/leaderboard/participants/{identifier}`. For example, if we set `identifier` equal to `Melyssa Stroman`, it will return:

```json
[
	{
		"id": 3,
		"name": "Melyssa Stroman",
		"age": 18,
		"points": 16,
		"address": "39703 Felipa Summit Suite 651\nLake Bennieport, NV 16008",
		"qr_code_filename": "melyssa-stroman_qr.png",
		"created_at": "2023-12-26T05:47:28.000000Z",
		"updated_at": "2023-12-26T18:51:11.000000Z"
	},
]
```
- Extracting the data related to the participants' group based on the score. If `score` is left empty, it will return all the group. Otherwise, it only provides the information of a group that belongs to that specific core. The endpoint is `/api/leaderboard/groupbyscore/{score?}`. For instance, the output for `/api/leaderboard/groupbyscore/11` is as below:

```json
{
	"11": {
		"points": 11,
		"names": "Leo Beer,Otis Hessel",
		"average_age": "31.5000"
	}
}
```
- Based on the provided schedule for the winner job, the winner table is updated every five minutes if the score changes or no tie happens. To retrieve the related information, the endpoint of `/api/leaderboard/winner` can be used:
```json
{
	"winner": {
		"id": 181,
		"participant_id": 3,
		"points": 16,
		"won_at": "2023-12-26 14:15:01",
		"created_at": "2023-12-26T22:15:01.000000Z",
		"updated_at": "2023-12-26T22:15:01.000000Z"
	}
}
```

##### 2. HTTP PUT

The are two HTTP PUT methods available here, one for increment and the other for decrement of the point by one. The endpoints are `/api/leaderboard/participants/point/add/{identifier}` and `/api/leaderboard/participants/point/add/{identifier}`. It just requires replacing `identifier` with the participant's name or id.

##### 3. HTTP POST

To add the new participant's record, an HTTP POST method is required. The related endpoint is `/api/leaderboard/addparticipant`. It needs to provide the request alongside the method. For example, we can have something like this `/api/leaderboard/addparticipant?name=John Doe&age=28&address=Richards St, Vancouver, BC`. Then, the output is as follows:

```json
{
	"name": "John Doe",
	"age": 28,
	"address": "Richards St, Vancouver, BC",
	"updated_at": "2023-12-26T22:31:33.000000Z",
	"created_at": "2023-12-26T22:31:33.000000Z",
	"id": 12
}
```

Here, the full name has to be unique, if the name id is duplicated or the age is below 18, it will return an error like below:

```json
{
	"errors": {
		"name": [
			"The name has already been taken."
		]
	}
}

or 

{
"errors": {
		"age": [
			"The age field must be an integer.",
			"The age field must be at least 18."
		]
	}
}
```


##### 4. HTTP DELETE

To delete a record from `participants` table, it just needs to use the HTTP DELETE method. The related endpoint is `/api/leaderboard/deleteparticipant/{identifier}`. The `identifier` is required to be replaced by the participant's name or id. If the method result is:

```json
{
	"message": "Participant deleted"
}
```

### Tests

For this project, some feature tests have been provided. To test it, just run the below command:

```bash
php artisan test
```

### Deployment

Here, I'll explain the deployment process on DigitalOcean. After registering on the platform, create a Droplets service, selecting Ubuntu OS with minimal resources. Install project requirements, including PHP, MYSQL, and Composer. Additionally, install the `apache2` service using the command below:

```bash
sudo apt-get install apache2
sudo systemctl enable apache2
sudo systemctl start apache2
```
After that, we need to clone the project on the server and proceed with the `apache2` configuration to make it live."

```bash
git clone https://github.com/PooriaT/spring_assessment
```
##### Apache Configuration

Now, we need to provide `spring_assessment.conf` for the Apache configuration as follows:

```bash
sudo nano /etc/apache2/sites-available/spring_assessment.conf
```

and add the below configuration in the editor

```apacheconf
<VirtualHost *:80>
    ServerName <your-domain-or-ip>
    DocumentRoot /var/www/html/spring_assessment/public
    <Directory /var/www/html/spring_assessment>
        AllowOverride All
    </Directory>
</VirtualHost>
```

Then, the Apache module needs to be rewritten and the configuration is restarted.

```bash
sudo a2enmod rewrite
sudo a2ensite spring_assessment.conf
sudo systemctl restart apache2
```

The next step is to copy the `spring_assessment` project into `/var/www/html` directory and then provide the required permissions. 

```bash 
cp -r spring_assessment/ /var/www/html/spring_assessment
sudo chown -R www-data:www-data /var/www/html/spring_assessment
sudo chmod -R 775 /var/www/html/spring_assessment/storage
```
Now, the project is live and it is possible to check it on the browser via the Internet. 


