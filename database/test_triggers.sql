-- Test script to check if triggers are working
-- Run this after creating/updating your triggers

-- First, let's see what triggers currently exist
SHOW TRIGGERS LIKE 'circulation%';

-- Test the INSERT trigger
INSERT INTO circulation (user_id, item_id, borrow_date, date_due_back) 
VALUES (1, 1, '2025-08-13', '2025-09-13');

-- Check what was inserted
SELECT circulation_id, borrow_date, date_due_back, next_reminder_date, item_circulation_status 
FROM circulation 
ORDER BY circulation_id DESC LIMIT 1;

-- Test the UPDATE trigger - change due date
UPDATE circulation 
SET date_due_back = '2025-09-20' 
WHERE circulation_id = (SELECT MAX(circulation_id) FROM (SELECT * FROM circulation) AS temp);

-- Check if reminder date updated
SELECT circulation_id, borrow_date, date_due_back, next_reminder_date, item_circulation_status 
FROM circulation 
ORDER BY circulation_id DESC LIMIT 1;

-- Clean up test record
DELETE FROM circulation WHERE circulation_id = (SELECT MAX(circulation_id) FROM (SELECT * FROM circulation) AS temp);
