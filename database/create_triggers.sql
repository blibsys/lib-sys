-- BEFORE INSERT - new circulation record

DELIMITER //
CREATE TRIGGER circulation_before_insert
BEFORE INSERT ON circulation
FOR EACH ROW
BEGIN
    -- Set borrow_date to today if not provided
    IF NEW.borrow_date IS NULL THEN
        SET NEW.borrow_date = CURRENT_DATE;
    END IF;

    -- Set date_due_back to borrow_date + 30 days if not provided
    IF NEW.date_due_back IS NULL THEN
        SET NEW.date_due_back = DATE_ADD(NEW.borrow_date, INTERVAL 30 DAY);
    END IF;

    -- Set next_reminder_date to 7 days before due date
    SET NEW.next_reminder_date = DATE_ADD(NEW.date_due_back, INTERVAL -7 DAY);

    -- Set circulation status to On-loan
    SET NEW.item_circulation_status = 'On-loan';
END//
DELIMITER ;


-- AFTER INSERT update status in items table when a new circulation record is created
DELIMITER //
CREATE TRIGGER update_item_status_on_borrow
AFTER INSERT ON circulation
FOR EACH ROW
BEGIN
    UPDATE items
    SET item_status = 'On-loan'
    WHERE item_id = NEW.item_id;
END//
DELIMITER ;

-- BEFORE UPDATE - returns, overdue and manual changes
DELIMITER //
CREATE TRIGGER circulation_before_update
BEFORE UPDATE ON circulation
FOR EACH ROW
BEGIN
    -- Returned item
    IF NEW.returned_date IS NOT NULL THEN
        SET NEW.item_circulation_status = 'Returned';
        SET NEW.next_reminder_date = NULL;
    END IF;

    -- Overdue
    IF NEW.returned_date IS NULL AND NEW.date_due_back < NOW() THEN
        SET NEW.item_circulation_status = 'Overdue';
    END IF;

    -- Recalculate due date if borrow_date changed and due date not manually overridden
    IF OLD.borrow_date <> NEW.borrow_date AND OLD.date_due_back = NEW.date_due_back THEN
        SET NEW.date_due_back = DATE_ADD(NEW.borrow_date, INTERVAL 30 DAY);
    END IF;

    -- Update next_reminder_date when date_due_back is changed (unless returned)
    IF NEW.returned_date IS NULL AND (OLD.date_due_back <> NEW.date_due_back OR OLD.borrow_date <> NEW.borrow_date) THEN
        SET NEW.next_reminder_date = DATE_ADD(NEW.date_due_back, INTERVAL -7 DAY);
    END IF;
END//
DELIMITER ;

-- AFTER UPDATE - update item status based on circulation changes

DELIMITER //
CREATE TRIGGER update_item_status_on_update
AFTER UPDATE ON circulation
FOR EACH ROW
BEGIN
    IF NEW.returned_date IS NOT NULL THEN
        UPDATE items
        SET item_status = 'Available'
        WHERE item_id = NEW.item_id;
    ELSEIF NEW.item_circulation_status = 'On-loan' THEN
        UPDATE items
        SET item_status = 'On-loan'
        WHERE item_id = NEW.item_id;
    END IF;
END//
DELIMITER ;
