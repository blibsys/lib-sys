USE bovtslibsys;

-- Insert test data into courses table
INSERT INTO courses (course_id, course_name) VALUES ('COURSE001', 'WRITING');
INSERT INTO courses (course_id, course_name) VALUES ('COURSE002', 'ACTING');
INSERT INTO courses (course_id, course_name) VALUES ('COURSE003', 'DIRECTING');

INSERT INTO contributor_roles (role_name) VALUES
('Actor'),
('Author'),
('Choreographer'),
('Compiler'),
('Co-author'),
('Composer'),
('Costume Designer'),
('Director'),
('Editor'),
('Illustrator'),
('Lighting Designer'),
('Narrator'),
('Photographer'),
('Playwright'),
('Producer'),
('Set Designer'),
('Sound Designer'),
('Stage Manager'),
('Translator');
