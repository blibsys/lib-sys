-- Load Faker CSV to populate users table
LOAD DATA LOCAL INFILE '/Users/abbiebowers/Documents/test_users.csv'
INTO TABLE table_name
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'-- could be '\n' or '\r\n' depending on your file format
IGNORE 1 ROWS;
-- use the below 2lines of code to ensure correct handling of NULL values. In this example it is the 'returned_date' in circulation table.
/* (circulation_id, user_id, item_id, borrow_date, date_due_back, @returned_date, next_reminder_date, item_circulation_status, created_at, updated_at)
SET returned_date = NULLIF(@returned_date, ''); */



-- to remove all data from table run: TRUNCATE TABLE users;
-- to see the data in the table run: SELECT * FROM users;
-- to count the number of rows in the table run: SELECT COUNT(*) FROM users;

-- Disable foreign key checks
-- SET FOREIGN_KEY_CHECKS = 0;

-- Re-enable foreign key checks
-- SET FOREIGN_KEY_CHECKS = 1;
