CREATE TABLE tbl_transaction_data(
	id INT NOT NULL AUTO_INCREMENT,
	date DATETIME NOT NULL,
	description TEXT NULL,
	user_id INT NOT NULL,
	created_on DATETIME NOT NULL,
	created_by INT NOT NULL,
	last_modified_on DATETIME NOT NULL,
	last_modified_by INT NOT NULL,
	PRIMARY KEY (id)
);