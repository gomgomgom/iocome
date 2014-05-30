CREATE TABLE tbl_category(
	id INT NOT NULL AUTO_INCREMENT,
	parent_id INT DEFAULT 0,
	name VARCHAR(255) NOT NULL,
	description TEXT,
	user_id INT NOT NULL,
	created_on DATETIME NOT NULL,
	created_by INT NOT NULL,
	last_modified_on DATETIME NOT NULL,
	last_modified_by INT NOT NULL,
	PRIMARY KEY (id)
);