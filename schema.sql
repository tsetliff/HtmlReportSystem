DROP DATABASE IF EXISTS reports;
CREATE DATABASE reports;
USE reports;
CREATE TABLE users (
  id INTEGER  NOT NULL auto_increment PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(32) NULL,
  password_salt VARCHAR(32) NULL
);
INSERT INTO users (username, password, password_salt) VALUES('admin', '72a5822e152e384a3d55737d9c3e4c3f', 'saltz');
GRANT ALL ON reports.* to 'reports'@'localhost' identified by 'reportsPassword';