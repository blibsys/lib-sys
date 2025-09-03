# BOVTS Library Management System

A lightweight PHP-based library management system designed for a specialist, low-resource environment.
Core functions are catalogue search, circulation and role-based permissions.

## Setup Instructions

1. Clone the repository.
2. Create a `.env` file in the project root with the following:

DB_SERVER=localhost:3306 
DB_USER=yourUsername 
DB_PASS=yourPassword 
DB_NAME=yourDatabaseName

3. Import the SQL schema from `/database/` into your local MySQL instance.
4. Run the project via MAMP or your preferred local server.

## File Structure

- `/public/` — user-facing pages
- `/private/` — system logic (authentication, database functions, etc.)
- `/database/` — SQL schema and seed data
- `.env` — stores database credentials (excluded from version control via `.gitignore`)

## Notes for Maintainers

- Credentials are loaded securely via `parse_ini_file()` from `.env`.
- `.env` is excluded from Git history to protect sensitive data.


