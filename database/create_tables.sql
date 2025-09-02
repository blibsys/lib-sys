

-- Library System Database Schema
-- Updated to reflect current database structure as of August 2025

-- Create and use database
CREATE DATABASE IF NOT EXISTS bovtslibsys;
USE bovtslibsys;

-- Drop tables if they exist (uncomment to reset database - WARNING: This deletes all data)
-- DROP TABLE IF EXISTS circulation, item_contributors, items, users, contributors, publishers, courses, auth, contributor_roles;

-- Create publishers table
CREATE TABLE IF NOT EXISTS publishers (
    publisher_id INT AUTO_INCREMENT,
    publisher_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (publisher_id)
);

-- Create courses table
CREATE TABLE IF NOT EXISTS courses (
    course_id VARCHAR(20) NOT NULL,
    course_name VARCHAR(80) NOT NULL,
    PRIMARY KEY (course_id)
);

-- Create users table (updated structure)
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    user_start_date DATE,
    user_end_date DATE,
    role ENUM('Student', 'Staff', 'Admin', 'Guest') DEFAULT NULL,
    email VARCHAR(320) UNIQUE NOT NULL,
    course_id VARCHAR(20),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON UPDATE CASCADE ON DELETE SET NULL,
    INDEX (first_name),
    INDEX (last_name),
    INDEX (email),
    INDEX (course_id),
    CONSTRAINT users_chk_1 CHECK (email LIKE '%_@__%.__%'),
    CONSTRAINT users_chk_3 CHECK (user_end_date IS NULL OR user_end_date >= user_start_date)
);

-- Create contributors table
CREATE TABLE IF NOT EXISTS contributors (
    contributor_id VARCHAR(20) NOT NULL,
    contributor_name VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (contributor_id),
    INDEX creator_name (contributor_name)
);

-- Create contributor roles table
CREATE TABLE IF NOT EXISTS contributor_roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL
);

-- Create items table (updated structure)
CREATE TABLE IF NOT EXISTS items (
    item_id INT AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    item_edition TINYINT UNSIGNED,
    isbn VARCHAR(17),
    item_type VARCHAR(20) NOT NULL,
    publication_year YEAR,
    item_copy TINYINT UNSIGNED NOT NULL DEFAULT 1,
    publisher_id INT,
    category VARCHAR(80),   
    item_status ENUM('On-loan', 'Available', 'Missing') NOT NULL DEFAULT 'Available',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (item_id),
    FOREIGN KEY (publisher_id) REFERENCES publishers(publisher_id) ON UPDATE CASCADE ON DELETE SET NULL,
    INDEX (title),
    CONSTRAINT items_chk_1 CHECK (item_edition IS NULL OR item_edition >= 1),
    CONSTRAINT items_chk_2 CHECK (item_copy >= 1)
);

-- Create item_contributors table (updated with role_id)
CREATE TABLE IF NOT EXISTS item_contributors (
    item_id INT NOT NULL,
    contributor_id VARCHAR(20) NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (item_id, contributor_id),
    KEY creator_id (contributor_id),
    KEY fk_role_id (role_id),
    FOREIGN KEY (item_id) REFERENCES items(item_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (contributor_id) REFERENCES contributors(contributor_id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_role_id FOREIGN KEY (role_id) REFERENCES contributor_roles(role_id) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Create circulation table (updated structure)
CREATE TABLE IF NOT EXISTS circulation (
    circulation_id INT AUTO_INCREMENT,
    user_id INT,
    item_id INT, 
    borrow_date DATE NOT NULL, 
    date_due_back DATE DEFAULT NULL,
    returned_date DATE DEFAULT NULL,
    next_reminder_date DATE DEFAULT NULL,
    item_circulation_status ENUM ('On-loan', 'Returned', 'Overdue', 'Return confirmation pending') DEFAULT 'On-loan',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (circulation_id),
    KEY item_id (item_id),
    KEY user_id (user_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (item_id) REFERENCES items(item_id) ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT circulation_chk_1 CHECK (date_due_back >= borrow_date),   
    CONSTRAINT circulation_chk_2 CHECK (returned_date IS NULL OR returned_date >= borrow_date),
    CONSTRAINT circulation_chk_3 CHECK (next_reminder_date IS NULL OR next_reminder_date >= borrow_date)
);

-- Create auth table (updated structure)
CREATE TABLE IF NOT EXISTS auth (
    auth_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    username VARCHAR(100) NOT NULL,
    hashed_password VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (auth_id),
    UNIQUE KEY username (username),
    KEY user_id (user_id),
    KEY username_2 (username),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);





