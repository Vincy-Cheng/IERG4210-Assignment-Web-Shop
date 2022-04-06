IERG 4210 Assignment Phase 4
Name: Cheng Wing Lam
SID: 1155125313

*****************************************************************************************************************
Please access ip-address of 3.136.1.162 to view the website.
Or https://secure.s19.ierg4210.ie.cuhk.edu.hk/
My database id named cart.db. (in the zip file)

This phase is focus on shopping list.

*****************************************************************************************************************
Steps to run my code: (Step 1 - 5 is similar to phase 2)
1. Create Instance and get the elastic IP from AWS. Then connect your instance with the private key.

2. Install Apache,php and sqlite3 in the instance.
    "sudo amazon-linux-extras install -y lamp-mariadb10.2-php7.2 php7.2" (Install PHP)
    "sudo yum install -y httpd mariadb-server" (Install MySQL and Apache)
    "sudo systemctl start httpd" (Start Apache)

3. Finish the set up of the step 2.(Tutorial 2)
    "sudo usermod -a -G apache ec2-user" (Add your user to the Apache group)
    "sudo chown -R ec2-user:apache /var/www" (Set group ownership of the web folder to the Apache group)
    "sudo chmod 2775 /var/www && find /var/www -type d -exec sudo chmod 2775 {} \;" (Add group write permissions and set the group ID)
    "find /var/www -type f -exec sudo chmod 0664 {} \;" (Add group write permissions of the web folder and its subdirectories)

4. Create database in the /var/www folder (Tutorial 3)(upper folder of html)(Remember to open to php access of the database)
    "sudo sqlite3 /var/www/cart.db" (create a database named cart.db at /var/www/)
    "PRAGMA foreign_keys = ON;" (enable foreign-key support in the database)

5. Create table (schema and some SQL Statement example are included in the Statement.sql)(Tutorial 3)

6. Follow tutorial 7 to apply the SSL certificate. 
    - Generate private key 
    - Use the private key to apply the certificate
    - Validate the certificate on the instance
    - Download the zip file (the CRL file) from SSL
    - Put the private key and the 2 files (2 certificates) in the /var/www folder

7. Put the 2 folders,admin and css , 9 files: auth.php, auth_process.php, categories.php, index.php, product.php, login.php, get_prod.php and script.js inside the /var/www/html folder.
    (The zip file contains all of the above mentioned files.)
    And put the 3 files: ca-bundle-client.crt, secure.s19.ierg4210.ie.cuhk.edu.hk.key and secure_s19_ierg4210_ie_cuhk_edu_hk.crt and database(cart.db) inside the /var/www folder
    And put the redirect.conf inside the /etc/httpd/conf.d
    Become like that:
    - /var
        - /www
            - /cgi-bin
            - /html
                - /admin
                    - /lib
                        -/images
                    - admin-process.php
                    - admin.php
                    - main.php
                    - panel.js
                - /css
                    - style.css
                - auth.php
                - auth_process.php
                - categories.php
                - index.php
                - login.php
                - product.php
                - get_prod.php
                - script.js
            - cart.db
            - ca-bundle-client.crt
            - secure.s19.ierg4210.ie.cuhk.edu.hk.key
            - secure_s19_ierg4210_ie_cuhk_edu_hk.crt
        ...
    ...
    - /etc
        - /httpd
            - /conf.d
                ...
                - redirect.conf

8. Create account before login the page
    - run the gen_salthashpwd.php
    - get the salt and hashed password

9. The website is ok to be viewed. The admin panel button is on the home page(index.php)
    Admin can click the admin panel to manage the database.
    User can login with their account in login page

10. Can try to click the add to cart button to add product to the shopping list. And change the quantity of product or remove product througth the shopping list

*****************************************************************************************************************
Explansion of each file:
 
There are 2 folders,admin and css , 14 files: 
    - auth.php
    - auth_process.php
    - categories.php
    - index.php
    - login.php
    - product.php
    - get_prod.php
    - script.js
    - Statement.sql
    - ca-bundle-client.crt
    - secure.s19.ierg4210.ie.cuhk.edu.hk.key
    - secure_s19_ierg4210_ie_cuhk_edu_hk.crt
    - redirect.conf
    - gen_salthashpwd.php

/admin folder has /lib folder, admin-process.php, admin.php, main.php and panel.js
/lib folder contains /images folder and db.inc.php

/lib folder, admin-process.php, admin.php, main.php are provided by CUHK IERG 4210 tutor

/css folder contains the css file

The admin.php displays the admin panel that can manage the information of database.
Like the belows function:
- insert category(submit the name of category)
- insert product(submit the name, price, category, description, quantity and image of product)
- delete category by CATID
- delete product by CATID
- delete product by PID
- edit category by CATID (can only edit category's name)
- edit product by PID(need to submit the name, price, category, description, quantity and image of product)

After submit the form from admin.php, it will call the admin-process.php function. 
Then the admin-process.php will process the action and called the function that in the db.inc.php

The db.inc.php will connect with the database to manage the information of database, like INSERT INTO, DELETE, UPDATE and SELECT

The /images folder is used to store the product's image. It is named by lastInsertId() which is same as pid.

The index.php is the main page of my website.
The categories.php shows the products that in the same category.
The product.php shows the detail of product.
The get_prod.php is used to get specified product's name and price.
The script.js is for shopping list function
The auth.php is used to verify the session cookie and defense csrf attack
The auth_process.php is a similar file to admin_process.php. It is used to handle the login form request,logout function and change password function.
The login.php is the page of login and change password.
The Statement.sql is stored the SQL Statement that I used for the database and some account information.
The ca-bundle-client.crt, secure.s19.ierg4210.ie.cuhk.edu.hk.key and secure_s19_ierg4210_ie_cuhk_edu_hk.crt are used for the SSL certificate
The redirect.conf is used to redirect all http://s19.ierg4210.ie.cuhk.edu.hk into https://secure.s19.ierg4210.ie.cuhk.edu.hk/
The gen_salthashpwd.php is used to generate the salt and hashed password outside.

*****************************************************************************************************************
Citation:
1. The basic setup of admin panel is following the given sample code from CUHK IERG 4210 tutorial.

2. The method of HTML5 Drag-and-drop file selection in the admin panel is referring to dcode, which is a Youtube channel.
Link: https://www.youtube.com/watch?v=Wtrin7C4b7w
His source code: https://codepen.io/dcode-software/pen/xxwpLQo

3. Some css may be same as example from W3schools
Link: https://www.w3schools.com/css/

4. The AJAX method that used to grab the information of database is referring to W3schools
Link: https://www.w3schools.com/php/php_ajax_php.asp


*****************************************************************************************************************
P.S 

I have put the images that I have used for the website inside the /lib/images folder.