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
