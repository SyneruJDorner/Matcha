# Matcha

A dating web site that matches users together based on thier interests, romantic preferences and their location.

## Requirements
- XAMPP: https://www.apachefriends.org/index.html

## Installation
### How to download the project
- Navigate to: https://github.com/justindd1994/Matcha
- Click "Code/Download Zip" or simply clone it with Git.
- Once you have downloaded the source code navigate to the fold

### How to set up and configure XAMPP
- Download XAMPP from the provided website
- Install XAMPP on you PC
- Place the downloaded Matcha folder into the installed path "C:\xampp\htdocs\"
- Ensure less secure apps enabled on gmail (as I used gmail for sending email)

- Next navigate to "C:\xampp\php\php.ini"
- Look for the heading "[mail function]"
- Set SMTP=smtp.gmail.com
- smtp_port=587
- sendmail_from = ENTER YOUR EMAIL HERE
- sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
- Save and close php.ini

- Next navigate to "C:\xampp\sendmail\sendmail.ini"
- Look for the heading "[sendmail]"
- Set smtp_server=smtp.gmail.com
- Set smtp_port=587
- Set auth_username = ENTER YOUR EMAIL HERE
- Set auth_password = ENTER YOUR GMAIL PASSWORD
- Save and close sendmail.ini

### How to run the program
- Open XAMPP
- Click on the start button for "Apache"
- Click on the start button for "MySQL"
- Open a web browser of your choosing
- Type the following in your search bar "http://localhost/matcha/"
- Hit submit, and the website Matcha should appear.

## Code Breakdown
- Back end technologies
    - PHP
    - SQL
    - JavaScript

- Front-end technologies
    - HTML
    - CSS

- Database management systems
    - MySQL
    - phpMyAdmin

## Project Expectations
https://github.com/justindd1994/Matcha/blob/master/matcha.markingsheet.pdf

## Ensure
1. PHP
2. Config/database.php
3. Config/setup.php
4. PDO’s

## Steps
1. Navigate to localhost/Matcha/
2. Successfully register an account. Make sure information is valid.
3. Check your inbox for a verification email and verify your account.
4. Log in to your account.
5. Update first time login information.
6. Update account information.
7. Ensure we find people based on our preferences.
8. Block a user and reported.
9. Like and unlike a user.
10. Have two users like each other.
11. Message each other.
12. Click logout.

## Outcomes
1. The webpage should load.
2. The account should appear in the database.
3. You should receive an email with a link to validate your account.
4. Your username should appear in the top-left corner.
5. Should apply your preferences to the database.
6. You should be able to edit everything.
7. People of the right sexual preferences and likes should appear.
8. The user should be blocked and reported.
9. Should be likable and unlickable.
10. Chat may only appear once both have liked each other.
11. Chat should be live.
12. Should take us to the registration page.
