USE bovtslibsys;

-- count of users with condition
SELECT COUNT(*) AS 	user_count
FROM users
WHERE first_name LIKE '%a%' AND last_name LIKE '%b%';

-- number of books on loan per user
SELECT 
	c.user_id,
	u.email,
	COUNT(*)  AS books_on_loan
FROM circulation c
JOIN users u ON c.user_id=u.user_id
WHERE item_circulation_status = 'borrowed'	
GROUP BY user_id;

-- number of users grouped by course
SELECT 
	c.course_id,
	c.course_name,
	COUNT(*) AS user_count
FROM users u
JOIN courses c ON u.course_id=c.course_id
GROUP BY course_id;

-- join tables to list item name and creators
SELECT 
    i.item_id,
    i.title,
    c.creator_name
FROM items i
JOIN item_creators ic ON i.item_id = ic.item_id
JOIN creators c ON ic.creator_id = c.creator_id;

-- show multiple creators on same row
SELECT 
i.item_id
,i.title
,GROUP_CONCAT(c.creator_name ORDER BY c.creator_name SEPARATOR ', ') AS creators
FROM items i
JOIN item_creators ic ON ic.item_id=i.item_id
JOIN creators c ON c.creator_id=ic.creator_id
WHERE i.item_id = '70'
GROUP BY i.item_id, i.title;


