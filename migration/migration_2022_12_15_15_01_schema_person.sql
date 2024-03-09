drop database if exists sim_webapp;

create database if not exists sim_webapp;

use sim_webapp;

drop table if exists Person;


CREATE TABLE Person (
  id   integer AUTO_INCREMENT  primary key,
  name    varchar(128),
  address varchar(128),
  city    varchar(64),
  postalcode varchar(32),  
  email   varchar(64)
);

/* index over name to accellerate select with field name */
create index person_name on Person(name);  
/* index over city to accellerate select with field name */
create index person_city on Person(city); 