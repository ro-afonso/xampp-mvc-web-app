# Web App with XAMPP and MVC
Development of a small Web App using XAMPP (Cross-platform, Apache, MySQL, PHP, Perl) and an MVC (Model-View-Controller) framework.

The Web App allows CRUD operations for users and products, as demonstrated in the video below:

https://github.com/ro-afonso/xampp-mvc-web-app/assets/93609933/16b60cbe-9ad2-4f59-b63a-0570df7c896a

# How to run

Follow these steps to perform the operations demonstrated in the video:
1) Install [XAMPP](https://www.apachefriends.org/download.html)
2) (Optional) Install [VS Code](https://code.visualstudio.com/download) and add the "PHP intellisense", "Prettier – code formatter" and "PHP debug" extensions
3) Open Xampp and start MySQL
4) Open the console and run "mysql -u root -h localhost –p"
5) Set user and password by running "ALTER USER 'root'@'localhost' IDENTIFIED BY 'sim'"
6) Run the "migration.bat" script to migrate schemas and data
7) Run "php -S localhost:80" on the console to invoke all routes
8) The Web App is now available at "http://localhost/app.php?service=showLayout"
9) Perform the desired CRUD operations for users and products
