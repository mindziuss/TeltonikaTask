## TELTONIKA TASK

## About service requirements
- Atleast PHP 8.3.0.
- Docker with Ubuntu distribution. (If using windows WSL with Ubuntu distribution)
- NPM 22^.
- Make.

## Used technologies
- Laravel 12.
- Filament 4.
- Docker.
- Ubuntu.
- Git.
- Make.
- Livewire.
- Tailwind.
- Mailpit.
- Vite.

## Setup guide
- Clone repository to local machine with docker installed.
- Run **docker-compose up --build** inside cloned repository.
- Copy .env.example to .env, if you changed settings on docker-schema please update .env file.
- After build inside directory run **make prepare** which will generate app key and set permissions. Might have to adjust permissions or use **sudo make prepare**
- Download composer packages
- After that, run **make migrate** which will run migrations and seeders. Might have to adjust permissions or use **sudo make prepare**

## Usage guide
- Application uses two guards User and Company. If you want to login as Admin user use: **http://localhost:80/admin/login**, if you want to login as company user use: **http://localhost:80/company/login**.
- To access Mailpit services use: **http://localhost:8025/**
- All company users share same password: **password123**, admin user password is: **password**. **ATTENTION:** only use these passwords to test application, if you decide to pull it as product, change them **IMMEDIATELY**, or delete test users.
- To login as company user, use company email and password. You can access them by logging into database or use first email created: **company0@example.com**
- To login as admin user, use **test@example.com** and password mentioned above.
- Application provides possibility to add employees to companies, edit, delete and associate or dissasociate them, actions like association, dissasociation, update or creation will send email to employee. Admin can see all companies, by pressing on any company you will be redirected to edit window with company information edit window and table of associated employees, you can also perform any action mentioned above, plus create companies or delete them.
