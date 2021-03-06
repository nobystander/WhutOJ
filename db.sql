CREATE DATABASE oj;
USE oj;
CREATE TABLE oj_user( username VARCHAR(20) NOT NULL, password VARCHAR(256) NOT NULL, email VARCHAR(64) NOT NULL, school VARCHAR(64) NOT NULL, hashstr VARCHAR(64) NOT NULL, role INT NOT NULL DEFAULT 0 );
ALTER TABLE oj_user ADD user_id INT NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY (user_id);
CREATE TABLE oj_problem( title VARCHAR(64) NOT NULL, source VARCHAR(64) NOT NULL, add_time DATE NOT NULL, time_limit INT NOT NULL, memory_limit INT NOT NULL ,special_judge INT NOT NULL DEFAULT 0);
ALTER TABLE oj_problem ADD problem_id INT NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY (problem_id);
ALTER TABLE oj_problem AUTO_INCREMENT = 1000;

CREATE TABLE oj_submit( user_id INT NOT NULL, problem_id INT NOT NULL, result INT NOT NULL DEFAULT 0, language INT NOT NULL, time INT, memory INT, length INT, submit_time INT, file_name VARCHAR(128) NOT NULL );
ALTER TABLE oj_submit ADD run_id INT NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY (run_id);


CREATE TABLE oj_language( language VARCHAR(20) NOT NULL );
ALTER TABLE oj_language ADD language_id INT NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY (language_id);
ALTER TABLE oj_language AUTO_INCREMENT = 0;
INSERT INTO oj_language(language) VALUES('Java'); 

CREATE TABLE oj_result( result VARCHAR(20) NOT NULL );
ALTER TABLE oj_result ADD result_id INT NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY (result_id);
ALTER TABLE oj_result AUTO_INCREMENT = 0;
INSERT INTO oj_result(result) VALUES('Submitted');

