CREATE DATABASE /*!32312 IF NOT EXISTS*/ `pipol` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `pipol`;

CREATE USER 'app'@'%' IDENTIFIED BY 'qwerty';
GRANT ALL PRIVILEGES ON pipol.* TO 'app'@'%' WITH GRANT OPTION;
