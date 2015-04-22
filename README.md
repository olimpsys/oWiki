# oWiki
Open Source Wiki / Team Collaboration / Knowledge Base software inspired by Atlassian Confluence written in Angular JS and PHP with MySQL.

# Features
- Create Categories with unlimited sub categories
- Create Pages inside categories, using rich text editor
- Search
- Manage users
- Works on both Desktop and Mobile

# How to use
1. clone repository or download zip file
2. create folder (e.g. "owiki") on web server with PHP support and move "index.html", "res/" and "api/" to this folder
3. configure database connection at api/class/sql/ConnectionProperty.class.php
4. run db/db.sql to create database structure (edit if desired)
5. insert first user to login: INSERT INTO `owiki`.`user` (`name`, `email`, `password`, `is_admin`) VALUES ('admin', 'your@email.com', 'e10adc3949ba59abbe56e057f20f883e', '1');
6. go to hosted folder on web browser, e.g. http://localhost/owiki/
7. login with created user: your@email.com, 123456
8. enjoy!
