CREATE TABLE tbl_transaction_detail(
	id INT NOT NULL AUTO_INCREMENT,
	transaction_data_id INT NOT NULL,
	category_id INT NOT NULL,
	type VARCHAR(10) NOT NULL, /* Income or Outcome */
	nominal INT NOT NULL,
	description TEXT NULL,
	created_on DATETIME NOT NULL,
	created_by INT NOT NULL,
	last_modified_on DATETIME NOT NULL,
	last_modified_by INT NOT NULL,
	PRIMARY KEY (id)
);