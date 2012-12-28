/*
  mysql -u root -p <this_file
*/
CREATE DATABASE calendar;
CREATE TABLE calendar.schedules (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date DATE UNIQUE,
  item TEXT
);
GRANT ALL ON calendar.* TO 'calendarman'@'localhost' IDENTIFIED BY 'calendarpass';
