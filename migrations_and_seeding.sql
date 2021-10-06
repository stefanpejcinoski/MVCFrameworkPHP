/*** Create and seed the database tables required for the code test project ***/
create database testdb;
use testdb;
create table frameworks(id int primary key not null auto_increment, name varchar(100), technology_id int);
create table technologies(id int primary key not null auto_increment, name varchar(100), type_id int);
create table types(id int primary key not null auto_increment, name varchar(255));
create table users(id int primary key not null auto_increment, email varchar(255), username varchar(255), password longtext, type_id int, technology_id int, framework_id int);

insert into frameworks(name, technology_id) values ("AngularJS", 1);
insert into frameworks(name, technology_id) values ("Angular 2", 1);
insert into frameworks(name, technology_id) values ("React native", 2);
insert into frameworks(name, technology_id) values ("Symfony", 4);
insert into frameworks(name, technology_id) values ("Laravel", 4);
insert into frameworks(name, technology_id) values ("Lumen", 4);
insert into frameworks(name, technology_id) values ("Express", 5);
insert into frameworks(name, technology_id) values ("NestJS", 5);
insert into technologies(name, type_id) values ("Angular", 1);
insert into technologies(name, type_id) values ("React", 1);
insert into technologies(name, type_id) values ("Vue", 1);
insert into technologies(name, type_id) values ("PHP", 2);
insert into technologies(name, type_id) values ("NodeJS", 2);
insert into types(name) values ("Front End Developer");
insert into types(name) values ("Back End Developer");