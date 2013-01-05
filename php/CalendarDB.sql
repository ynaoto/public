/*
  mysql -u root -p <this_file
*/
CREATE DATABASE calendar DEFAULT CHARACTER SET utf8;
CREATE TABLE calendar.schedules (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date DATE UNIQUE,
  item TEXT
) DEFAULT CHARACTER SET utf8;
GRANT ALL ON calendar.* TO 'calendarman'@'localhost' IDENTIFIED BY 'calendarpass';
