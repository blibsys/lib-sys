

-- create and use database

CREATE DATABASE bovtslibsys;

USE bovtslibsys;
/* uncomment the below line to drop tables if they exist to avoid conflicts
Note: This will delete all data in the tables, so use with caution */
-- DROP TABLE IF EXISTS circulation, item_creators, items, users, creators, publishers, courses;

-- create tables with constraints and indexes
CREATE TABLE IF NOT EXISTS publishers (
    publisher_id INT AUTO_INCREMENT,
    publisher_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (publisher_id)
);

CREATE TABLE IF NOT EXISTS courses (
    course_id VARCHAR(20) NOT NULL,
    course_name VARCHAR(80) NOT NULL,
    PRIMARY KEY (course_id)
);
-- may need to change the email check to a more robust one, e.g. application level validation
-- course_id FK behaviour: if updated in Ptable update in Ctable, if deleted in Ptable set NULL in Ctable (removed due to import error:ON UPDATE CASCADE ON DELETE SET NULL)
CREATE TABLE IF NOT EXISTS users (
    user_id INT,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    user_start_date DATE,
    user_end_date DATE,
    user_type ENUM ('Admin', 'Guest', 'library', 'Staff', 'Student', 'Other') DEFAULT 'Student' NOT NULL,
    CHECK (user_type IN ('Admin', 'Guest', 'library', 'Staff', 'Student', 'Other')),
    CHECK (user_start_date IS NULL OR user_start_date <= CURRENT_DATE),
    CHECK (user_end_date IS NULL OR user_end_date >= CURRENT_DATE),
    email VARCHAR(320) UNIQUE NOT NULL,
    CHECK (email LIKE '%_@__%.__%'),
    course_id VARCHAR (20),
    number_of_items_on_loan INT DEFAULT 0 NOT NULL,
    CHECK (number_of_items_on_loan >= 0),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CHECK (user_end_date IS NULL OR user_end_date >= user_start_date),
    PRIMARY KEY (user_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    INDEX (first_name),
    INDEX (last_name),
    INDEX (email),
    INDEX (course_id)
) ;

CREATE TABLE IF NOT EXISTS contributors (
    contributor_id VARCHAR(20) NOT NULL, -- changed from INT to VARCHAR(20) to match the test import data, unsure on cataloging standard to be used
    contributor_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (contributor_id),
    INDEX (contributor_name)
);

CREATE TABLE contributor_roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL
);

-- publisher_id FK behaviour: if updated in Ptable update in Ctable, if deleted in Ptable set NULL in Ctable
CREATE TABLE IF NOT EXISTS items (
    item_id INT AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    item_edition TINYINT UNSIGNED,
    CHECK (item_edition IS NULL OR item_edition >= 1),
    isbn VARCHAR(20),
    item_type VARCHAR(20) NOT NULL,
    publication_year YEAR,
    item_copy TINYINT UNSIGNED DEFAULT 1 NOT NULL,
    CHECK (item_copy >= 1),
    publisher_id INT,
    category VARCHAR(80),   
    item_status ENUM ('available', 'on loan', 'missing') DEFAULT 'available' NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (item_id),
    FOREIGN KEY (publisher_id) REFERENCES publishers(publisher_id) ON UPDATE CASCADE ON DELETE SET NULL,
    INDEX (title)
);

-- item_id FK behaviour: if updated in Ptable update in Ctable, if deleted in Ptable delete row in Ctable
-- creator_id FK behaviour: if updated in Ptable update in Ctable, if deleted in Ptable delete row in Ctable
CREATE TABLE IF NOT EXISTS item_contributors (
    item_id INT NOT NULL,
    contributor_id VARCHAR(20) NOT NULL,
    PRIMARY KEY (item_id, contributor_id),
    FOREIGN KEY (item_id) REFERENCES items(item_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (contributor_id) REFERENCES contributors(contributor_id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- user_id FK behaviour: if updated in Ptable update in Ctable, if deleted in Ptable set NULL in Ctable
-- item_id FK behaviour: if updated in Ptable update in Ctable, if deleted in Ptable set NULL in Ctable

CREATE TABLE IF NOT EXISTS circulation (
    circulation_id INT AUTO_INCREMENT,
    user_id INT,
    item_id INT, 
    borrow_date DATE NOT NULL, 
    date_due_back DATE GENERATED ALWAYS AS (DATE_ADD(borrow_date, INTERVAL 30 DAY)) STORED,
    returned_date DATE DEFAULT NULL,
    next_reminder_date DATE GENERATED ALWAYS AS (DATE_ADD(borrow_date, INTERVAL 23 DAY)) STORED,
    item_circulation_status ENUM ('borrowed', 'returned', 'overdue') DEFAULT 'borrowed',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CHECK (date_due_back >= borrow_date),   
    CHECK (returned_date IS NULL OR returned_date >= borrow_date),
    CHECK (next_reminder_date IS NULL OR next_reminder_date >= borrow_date),
    PRIMARY KEY (circulation_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (item_id) REFERENCES items(item_id) ON UPDATE CASCADE ON DELETE SET NULL,
    INDEX (user_id)
);

CREATE TABLE auth (
  auth_id INT NOT NULL AUTO_INCREMENT,
  user_id INT,
  username VARCHAR(100),
  first_name VARCHAR(80),
  last_name VARCHAR(80),
  role VARCHAR(80),
  hashed_password VARCHAR(100),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (auth_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  INDEX (username)
);

-- table modifications
-- remaming creators to contributors

ALTER TABLE item_contributors
ADD COLUMN role_id INT NULL AFTER contributor_id;

ALTER TABLE item_contributors
ADD COLUMN role_id INT NULL AFTER contributor_id;

UPDATE item_contributors
SET role_id = 1
WHERE role_id IS NULL;

ALTER TABLE item_contributors
MODIFY COLUMN role_id INT NOT NULL;

ALTER TABLE item_contributors
ADD CONSTRAINT fk_role_id
    FOREIGN KEY (role_id) REFERENCES contributor_roles(role_id)
    ON UPDATE CASCADE ON DELETE RESTRICT;

-- modify circulation table
ALTER TABLE circulation
MODIFY COLUMN date_due_back DATE NULL;



-- ALTER TABLE users DROP COLOUMN course_id;

/*CREATE TABLE IF NOT EXISTS student_courses (
    user_id INT NOT NULL,
    course_id VARCHAR(20) NOT NULL,
    PRIMARY KEY (user_id, course_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON UPDATE CASCADE ON DELETE CASCADE
);*/



