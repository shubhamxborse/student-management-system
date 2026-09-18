# Student Management System

A web-based **Student Management System** built with **Core PHP, MySQL, PDO, HTML, CSS, Bootstrap, and JavaScript**.

The project was developed as a practical application to strengthen Core PHP fundamentals and understand how a server-side web application interacts with a relational database.

---

## Overview

The Student Management System provides a simple interface for managing student records.

The application currently supports:

* Student registration
* Viewing student records
* Viewing individual student details
* Updating student information
* Deleting student records
* Searching students
* Server-side form validation
* Session-based success messages
* Dashboard with total student count
* Responsive Bootstrap-based interface

The project follows a straightforward structure suitable for learning and gradually introducing better PHP application architecture.

---

## Features

### Student CRUD Operations

Complete CRUD functionality is implemented for student records.

**Create**

Add a student with:

* Name
* Email
* Phone
* Course
* Academic Year

**Read**

View all students in a structured table and view individual student details.

**Update**

Edit existing student information.

**Delete**

Delete student records after confirmation.

---

### Search

Students can be searched by:

* Name
* Email
* Course

The search functionality uses SQL `LIKE` queries with PDO prepared statements.

---

### Form Validation

The Add Student form includes server-side validation.

Validation currently checks:

* Required fields
* Name length
* Email format
* Email length
* Phone number format
* Course length
* Valid academic year
* Duplicate email addresses

Allowed academic years:

```text
First Year
Second Year
Third Year
Final Year
```

---

### Dashboard

The dashboard provides:

* Total number of students
* Quick access to student records
* Quick access to add a new student

The student count is retrieved dynamically from the MySQL database.

---

### Session Flash Messages

The application uses PHP sessions to display temporary success messages after operations such as:

```text
Student added successfully
Student updated successfully
Student deleted successfully
```

The project also follows the basic **Post/Redirect/Get (PRG)** pattern for these operations.

---

## Technology Stack

| Technology  | Usage                                         |
| ----------- | --------------------------------------------- |
| PHP 8.4     | Server-side application logic                 |
| MySQL 9     | Relational database                           |
| PDO         | Database connectivity and prepared statements |
| HTML5       | Application structure                         |
| CSS3        | Styling                                       |
| Bootstrap 5 | Responsive user interface                     |
| JavaScript  | Client-side interactions                      |
| Git         | Version control                               |
| GitHub      | Repository hosting                            |
| VS Code     | Development environment                       |

---

# Project Structure

```text
student-management/
│
├── config/
│   └── database.php
│
├── helpers/
│   └── helpers.php
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── functions/
│   └── student_functions.php
│
├── index.php
├── add_student.php
├── students.php
├── edit_student.php
├── view_student.php
├── delete_student.php
├── test.php
├── .gitignore
└── README.md
```

### Directory Description

| File / Directory     | Purpose                                             |
| -------------------- | --------------------------------------------------- |
| `config/`            | Database configuration                              |
| `helpers/`           | Reusable PHP helper functions                       |
| `includes/`          | Common header and footer                            |
| `functions/`         | Database-related reusable functions                 |
| `index.php`          | Dashboard                                           |
| `add_student.php`    | Add a new student                                   |
| `students.php`       | List and search students                            |
| `edit_student.php`   | Edit student information                            |
| `view_student.php`   | View individual student details                     |
| `delete_student.php` | Delete a student                                    |
| `test.php`           | Database connection testing                         |
| `.gitignore`         | Prevents sensitive/local files from being committed |

---

# Database

The application uses MySQL.

### Database Name

```text
student_management
```

### Table

```text
students
```

### Table Structure

| Column       | Type         | Constraints                 |
| ------------ | ------------ | --------------------------- |
| `id`         | INT          | Primary Key, Auto Increment |
| `name`       | VARCHAR(100) | NOT NULL                    |
| `email`      | VARCHAR(100) | NOT NULL, UNIQUE            |
| `phone`      | VARCHAR(15)  | Optional                    |
| `course`     | VARCHAR(100) | NOT NULL                    |
| `year`       | VARCHAR(20)  | Optional                    |
| `created_at` | TIMESTAMP    | Default Current Timestamp   |

---

# Installation

## Prerequisites

Before running the project, install:

* PHP 8.4 or compatible PHP 8.x version
* MySQL Server
* Git
* A web browser
* VS Code or another code editor

Make sure MySQL is running before starting the application.

---

## 1. Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/student-management-system.git
```

Navigate into the project:

```bash
cd student-management-system
```

---

## 2. Create the Database

Open MySQL and run:

```sql
CREATE DATABASE student_management;
```

Select the database:

```sql
USE student_management;
```

Create the `students` table:

```sql
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    course VARCHAR(100) NOT NULL,
    year VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

# Database Configuration

## Important: `config/database.php`

The actual database configuration file is intentionally **not included in the GitHub repository**.

The reason is that database configuration can contain local credentials such as:

```text
Database username
Database password
Database host
```

The file is excluded using `.gitignore`:

```gitignore
config/database.php
```

Therefore, after cloning the repository, you must create the file manually.

Create:

```text
config/database.php
```

Use the following structure:

```php
<?php

$host = "127.0.0.1";
$dbname = "student_management";
$username = "root";
$password = "";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Database connection failed: " . $e->getMessage());

}
```

### Configure Your Credentials

The values may be different depending on your local MySQL installation.

For example:

```php
$username = "root";
$password = "your_mysql_password";
```

Do **not** commit your actual credentials to GitHub.

---

## Why is `database.php` missing from GitHub?

This is intentional.

The repository contains the application source code, while the local database credentials remain on the developer's machine.

This prevents accidentally exposing sensitive database configuration through source control.

For a future version of the project, the database configuration can be improved further by using environment variables and an `.env` file.

---

# 3. Start the PHP Development Server

From the project directory:

```bash
php -S localhost:8000
```

The PHP development server will start on port `8000`.

---

# 4. Open the Application

Open your browser:

```text
http://localhost:8000/
```

The application dashboard should be displayed.

---

# Security Practices

The project currently follows several basic security practices.

### PDO Prepared Statements

Database queries that use user input are implemented using prepared statements.

This helps protect against SQL injection.

### Server-Side Validation

User-submitted form data is validated on the server before database operations are performed.

### Output Escaping

User-provided data is escaped using `htmlspecialchars()` before being displayed in HTML.

This helps reduce the risk of Cross-Site Scripting (XSS).

### Database Credentials

The local database configuration file is excluded from Git using `.gitignore`.

---

# Current Architecture

The current application uses a simple PHP structure:

```text
Browser
   ↓
PHP Page
   ↓
Validation / Application Logic
   ↓
PDO
   ↓
MySQL
```

Reusable components are also used for:

```text
Header
Footer
Helper Functions
Database Functions
```

The project is intentionally kept simpler than a full MVC framework because it is being used to build a strong foundation in Core PHP.

---

# Learning Objectives

This project was developed to gain practical experience with:

* Core PHP
* PHP syntax and control flow
* Forms
* GET and POST requests
* CRUD operations
* MySQL
* SQL queries
* PDO
* Prepared statements
* Input validation
* Sessions
* Flash messages
* PHP functions
* Basic application structure
* Git and GitHub
* Bootstrap

---

# Current Limitations

This is an ongoing learning project.

The following features have not been implemented yet:

* User authentication
* Login and logout
* Password hashing
* Protected pages
* Admin and user roles
* Pagination
* Advanced filtering
* Foreign key relationships
* Advanced SQL relationships
* CSRF protection
* Complete MVC architecture
* Laravel implementation

---

# Future Improvements

Planned improvements include:

1. Improve validation consistency across Add and Edit forms
2. Learn Object-Oriented PHP
3. Implement user authentication
4. Add password hashing
5. Add protected pages
6. Add admin and user roles
7. Improve database relationships
8. Add JOIN-based queries
9. Add stronger security protections
10. Add dashboard statistics
11. Add advanced filtering
12. Add pagination
13. Improve application architecture
14. Introduce MVC concepts
15. Rebuild or migrate the application using Laravel

---

# Development Status

**Status: In Progress**

Current development stage:

```text
Core PHP Fundamentals
        ↓
MySQL Database
        ↓
PDO
        ↓
CRUD
        ↓
Search
        ↓
Validation
        ↓
Sessions & Flash Messages
        ↓
Reusable PHP Functions
        ↓
Basic Project Structure
        ↓
Next: Object-Oriented PHP / Application Structure
```

Some database-function refactoring was started in `functions/student_functions.php` but is intentionally incomplete at the current stage.

Pagination has also been intentionally deferred to a later phase.

---

# Author

**Shubham Dilip Borse**

---

# License

This project is currently intended for **educational and portfolio purposes**.
