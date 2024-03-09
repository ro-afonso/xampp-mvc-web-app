use sim_webapp;
drop table if exists Product;


CREATE TABLE Product (
  id   integer AUTO_INCREMENT  primary key,
  name    varchar(128),
  price varchar(64),  
  description   varchar(64),
  existingstock varchar(64),
  totalsalesyear varchar(128)
);

/* index over name to accellerate select with field name */
create index product_name on Product(name);  
/* index over city to accellerate select with field name */
create index product_price on Product(price);

create index product_existing_stock on Product(existingstock);

create index product_total_sales_year on Product(totalsalesyear);