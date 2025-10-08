# IESMI Student Information System

A comprehensive web-based Student Information Management System (SIMS) built with PHP and MySQL, designed to manage student data, grades, and academic records for educational institutions.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [Database Schema](#database-schema)
- [Default Credentials](#default-credentials)
- [Development](#development)
- [Contributing](#contributing)
- [License](#license)

## 🌟 Overview

IESMI (likely "Student Information Management System") is a full-featured educational management platform that allows administrators, teachers, and students to manage academic records, grades, and user accounts through a role-based access control system.

The system provides:
- **Multi-role authentication** (Admin, Teacher, Student)
- **Grade management** with subject-wise organization
- **User profile management**
- **CSV export functionality**
- **Responsive web interface** using DaisyUI components

## ✨ Features

### 🔐 User Management
- **Three-tier role system**: Admin, Teacher, Student
- **Secure authentication** with session management
- **Profile management** with picture upload support
- **Password management** for all users

### 📚 Academic Management
- **Subject management**: Add, view, and organize course subjects
- **Grade management**: Teachers can add, edit, and track student grades
- **Grade viewing**: Students can view their grades by subject
- **Grade constraints**: Grades range from 1-10 with validation

### 👨‍💼 Administrative Features
- **User administration**: Add, edit, delete users with role assignment
- **System oversight**: Admin dashboard for system management
- **Data export**: CSV export for grades and user data

### 🚀 Additional Features
- **Export functionality**: Download grades as CSV files
- **Notification system** (planned for future implementation)
- **Profile pictures** (planned for future implementation)
- **Responsive design** with modern UI components

## 🛠 Technology Stack

- **Backend**: PHP 7.4+ (Vanilla PHP with custom MVC architecture)
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **UI Framework**: DaisyUI (Tailwind CSS component library)
- **Web Server**: Apache/Nginx (configured via .htaccess)
- **Architecture**: Custom MVC pattern with Router, Database, and View utilities

## 📋 Prerequisites

Before installing IESMI, ensure you have the following:

- **PHP 7.4 or higher** with PDO extension enabled
- **MySQL 5.7 or higher**
- **Web server** (Apache or Nginx)
- **Composer** (optional, for dependency management)

## 🚀 Installation

### 1. Clone or Download the Project

```bash
# Clone the repository
git clone <repository-url>
cd iesmi-_stud-

# Or download and extract the ZIP file
```

### 2. Set Up the Database

1. Create a new MySQL database:
```sql
CREATE DATABASE schooldb;
```

2. The application will automatically create the required tables on first run

### 3. Configure Environment Variables

1. Copy the environment configuration file:
```bash
cp .env.example .env
```

2. Edit the `.env` file with your database credentials:
```env
DB_HOST=localhost
DB_NAME=schooldb
DB_USER=your_db_username
DB_PASS=your_db_password
```

### 4. Set Up Web Server

#### For Apache:
- Ensure `mod_rewrite` is enabled
- Point your document root to the project directory
- The `.htaccess` file is already included for URL rewriting

#### For Nginx:
Add this configuration block:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/iesmi-_stud-;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 5. Set File Permissions

Ensure the web server has write permissions for:
- Profile picture uploads (if implemented)
- Log files (if logging is enabled)

```bash
chmod 755 . # Project root
chmod 777 uploads/ # If uploads directory exists
```

## ⚙️ Configuration

### Database Configuration
All database settings are managed through the `.env` file:

- `DB_HOST`: Database server hostname (default: localhost)
- `DB_NAME`: Database name (default: schooldb)
- `DB_USER`: Database username
- `DB_PASS`: Database password

### Application Settings
Additional configuration can be found in `utils/config.php`:
- Debug mode settings
- Application constants
- Security configurations

## 🎯 Usage

### Starting the Application

1. Navigate to your project URL in a web browser
2. You'll be redirected to the login page if not authenticated
3. Use the default credentials below to log in

### Default Credentials

The system comes with pre-configured demo accounts:

#### Administrator
- **Username**: `admin@admin.admin`
- **Password**: `admin@admin.admin`
- **Role**: Full system access

#### Teacher
- **Username**: `teacher@teacher.teacher`
- **Password**: `teacher@teacher.teacher`
- **Role**: Can manage grades and subjects

#### Student
- **Username**: `student@student.student`
- **Password**: `student@student.student`
- **Role**: Can view grades and profile

### User Roles and Permissions

#### 🛡️ Admin
- Full system access
- Manage all users (add, edit, delete)
- Access admin dashboard
- Export system data
- Manage subjects

#### 👨‍🏫 Teacher
- View and manage student grades
- Add/edit grades for students
- Access teacher dashboard
- Manage subjects (add new ones)

#### 🎓 Student
- View personal grades
- Access grade history by subject
- Manage personal profile
- Export personal grade data

## 📁 Project Structure

```
iesmi-_stud-/
├── backend/                    # Backend logic and handlers
│   ├── core/                   # Core controllers
│   │   ├── gradeController.php
│   │   ├── subjectController.php
│   │   └── userController.php
│   └── handlers/               # Request handlers
│       ├── addGrade.php
│       ├── addSubject.php
│       ├── addUser.php
│       └── [5 more handlers...]
├── frontend/                   # Frontend views and components
│   ├── components/             # Reusable UI components
│   │   ├── Footer.php
│   │   ├── Head.php
│   │   └── Navbar.php
│   ├── layouts/                # Page layouts
│   │   ├── admin.php
│   │   ├── student.php
│   │   └── teacher.php
│   └── views/                  # Page views
│       ├── admin/
│       ├── generic/
│       └── student/
├── utils/                      # Utility classes
│   ├── Database.php            # Database connection and operations
│   ├── Router.php              # URL routing system
│   ├── SMW.php                 # Simple Middleware
│   ├── View.php                # View rendering
│   └── config.php              # Configuration settings
├── .env.example                # Environment variables template
├── .htaccess                   # Apache URL rewriting
├── index.php                   # Main entry point
└── README.md                   # This file
```

## 🔗 API Endpoints

The application uses a custom routing system. Key endpoints include:

### Authentication
- `POST /backend/login` - User login
- `GET /backend/logout` - User logout

### User Management
- `POST /backend/addUser` - Add new user (Admin only)
- `POST /backend/editUser` - Edit user details
- `POST /backend/editUserPassword` - Change user password

### Grade Management
- `POST /backend/addGrade` - Add new grade (Teacher/Admin)
- `POST /backend/editGrade` - Edit existing grade
- `GET /grade` - View specific grade
- `GET /grades` - View all grades for user

### Subject Management
- `POST /backend/addSubject` - Add new subject (Teacher/Admin)
- `GET /subject` - View grades for specific subject

### Data Export
- `GET /export` - Export user grades as CSV
- `GET /export-grade` - Export lesson grades as CSV

### Admin Routes
- `GET /admin` - Admin dashboard
- `GET /add-user` - Add new user form
- `GET /edit-user` - Edit user form

## 🗄️ Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    role ENUM('admin', 'teacher', 'student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Subjects Table
```sql
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Grades Table
```sql
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    teacher_id INT NOT NULL,
    subject_id INT NOT NULL,
    grade INT NOT NULL CHECK (grade >= 1 AND grade <= 10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notified INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (teacher_id) REFERENCES users(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);
```

## 🔧 Development

### Running Locally

1. Set up a local development environment:
```bash
# Using XAMPP/WAMP/LAMP
# Place project in htdocs/www directory

# Or use built-in PHP server
php -S localhost:8000 -t .
```

2. Enable PHP error reporting in `utils/config.php` for development

### Code Structure

The application follows a custom MVC pattern:

- **Models**: Database operations in `utils/Database.php`
- **Views**: PHP templates in `frontend/views/`
- **Controllers**: Business logic in `backend/core/` and handlers in `backend/handlers/`
- **Routes**: Defined in `index.php` using custom Router class

### Adding New Features

1. **New Route**: Add to `index.php` using `$router->addRoute()`
2. **Handler**: Create handler file in `backend/handlers/`
3. **View**: Create view file in `frontend/views/`
4. **Controller Logic**: Add business logic if needed in `backend/core/`

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

