
DROP DATABASE IF EXISTS ClaremontTalk;
/* Now, create a new database named ClaremontTalk */
CREATE DATABASE ClaremontTalk;



USE ClaremontTalk;

/* A table to hold each user */
CREATE TABLE User(
    userId INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(256) NOT NULL,
    password VARCHAR(256) NOT NULL,
    school VARCHAR(256) NOT NULL,
    admin INT UNSIGNED NOT NULL
    );

 /* A table to hold each Message */
CREATE TABLE Messages(
  userId INT UNSIGNED NOT NULL,
  messageContents TEXT NOT NULL,
  messageId INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  type VARCHAR(256) NOT NULL,
  approved INT UNSIGNED NOT NULL,
  
  title VARCHAR(256) NOT NULL,
  name VARCHAR(256) NOT NULL,  
  /*photo BLOB,*/
  dt DATETIME NOT NULL,
  emailed INT UNSIGNED NOT NULL,
  FOREIGN KEY(userID) REFERENCES USER(userID)

); 


