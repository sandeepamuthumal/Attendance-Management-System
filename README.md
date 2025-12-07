# QR-Based Smart Attendance Management System

A modern, efficient attendance management system built with Laravel, featuring QR code scanning, real-time statistics, and comprehensive reporting capabilities for educational institutions.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)

https://brighteducation.teamscits.com

## 🚀 Features

### Core Features
- **QR Code Scanning**: Fast and accurate attendance marking using QR codes
- **Role-based access** (Admin, Teacher, Student) using Spatie Permissions
- **Class scheduling** with FullCalendar.js
- **Real-time Dashboard**: Live statistics and attendance insights
- **Comprehensive Reporting**: Detailed attendance reports with filtering options
- **Student Management**: Complete student enrollment and class management
- **Mobile Responsive**: Works seamlessly on desktop, tablet, and mobile devices

### Advanced Features
- **Repository Pattern**: Clean, maintainable code architecture
- **Service Layer**: Centralized business logic
- **Exception Handling**: Robust error handling and user feedback
- **Export Functionality**: Download reports in CSV format
- **Caching**: Optimized performance with intelligent caching
- **Validation**: Comprehensive input validation and security

### 🛠 Engineering & Architecture
- Service–Repository Pattern
- Form Request Validations
- Query Scopes for clean Eloquent queries
- Centralized logging & error handling
- PHPUnit Unit + Feature Tests
- Secure authentication & authorization

## 🧩 Tech Stack

**Backend:** Laravel 10, MySQL  
**Frontend:** Blade, Livewire, Bootstrap  
**Real-time:** Laravel Echo, Pusher  
**Scheduling:** FullCalendar.js  
**Testing:** PHPUnit  
**Role Management:** Spatie Permissions 

## 🔧 Requirements

- **PHP**: 8.1 or higher
- **Laravel**: 10.x
- **Database**: MySQL 8.0+ or PostgreSQL 13+
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Node.js**: 16+ (for asset compilation)
- **Composer**: 2.0+


## 📥 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/sandeepamuthumal/Attendance-Management-System
cd attendance-management-system
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Build assets
npm run build
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

## 🗄️ Database Setup

### 1. Create Database
```sql
CREATE DATABASE attendance_system;
```

### 2. Run Migrations
```bash
php artisan migrate
```

## 🚀 Usage

### Starting the Application
```bash
# Start development server
php artisan serve

# For production, configure your web server to point to the public directory
```

## 🏗️ Architecture

### Repository Pattern
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Controllers   │───▶│    Services     │───▶│  Repositories   │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                                        │
                                              ┌─────────────────┐
                                              │     Models      │
                                              └─────────────────┘
```

### Key Components

#### Repositories
- `AttendanceRepository`: Handles attendance data operations
- `StudentRepository`: Manages student data
- `ClassRepository`: Handles class information
- `StudentHasClassRepository`: Manages enrollments

#### Services
- `AttendanceService`: Business logic for attendance operations
- `AttendanceReportService`: Report generation and statistics
- `ClassService`: Class management operations
- `DashboardService`: Dashboard statistics and data

#### Controllers
- `AttendanceReportController`: Handles report requests
- `DashboardController`: Dashboard data and views
- `Api\AttendanceController`: API endpoints

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test suite
php artisan test tests/Feature/AttendanceTest.php

# Run unit tests only
php artisan test tests/Unit/
```

### Test Categories
- **Feature Tests**: End-to-end functionality testing
- **Unit Tests**: Individual component testing
- **Integration Tests**: Database and service testing

## 📊 Performance Optimization

### Database Optimization
- **Indexes**: Strategic indexing on frequently queried columns
- **Query Optimization**: Efficient queries with proper joins
- **Eager Loading**: Reduced N+1 query problems

### Caching Strategy
- **Redis**: Session and cache storage
- **Query Caching**: Frequently accessed data
- **View Caching**: Static content caching

### Best Practices
- Repository pattern for clean architecture
- Service layer for business logic
- Proper error handling and logging
- Input validation and sanitization

## 🔒 Security Features

- **CSRF Protection**: All forms protected against CSRF attacks
- **SQL Injection Prevention**: Parameterized queries
- **XSS Protection**: Input sanitization and output encoding
- **Authentication**: Secure user authentication system
- **Authorization**: Role-based access control
- **Rate Limiting**: API endpoint protection

## 🐛 Troubleshooting

### Common Issues

#### QR Scanner Not Working
```bash
# Ensure camera permissions are granted
# Check if HTTPS is enabled (required for camera access)
# Verify QR code library is loaded
```

#### Database Connection Error
```bash
# Check database credentials in .env
# Ensure database server is running
# Verify database exists and user has permissions
```

#### Performance Issues
```bash
# Enable caching
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### Logs
```bash
# View application logs
tail -f storage/logs/laravel.log

# Clear logs
php artisan log:clear
```

## 📈 Monitoring and Maintenance

### Regular Maintenance Tasks
```bash
# Clear expired cache
php artisan cache:clear

# Optimize database
php artisan db:optimize

# Clean up old logs
php artisan log:clear --days=30

# Update dependencies
composer update
```

### Health Checks
- Database connectivity
- Cache system status
- Storage permissions
- QR scanner functionality

## 🙏 Acknowledgments

- **Laravel Framework**: For providing an excellent foundation
- **Bootstrap**: For responsive UI components
- **Chart.js**: For beautiful data visualization
- **Html5-QRCode**: For QR code scanning functionality
- **Font Awesome**: For beautiful icons

## 🎯 Roadmap

### Upcoming Features
- [ ] Multi-language support
- [ ] Advanced analytics dashboard
- [ ] Email notifications
- [ ] Mobile app (React Native)
- [ ] Biometric authentication
- [ ] API rate limiting
- [ ] Advanced reporting (PDF export)
- [ ] Integration with external systems

### Future Enhancements
- [ ] Real-time notifications
- [ ] Advanced user roles
- [ ] Attendance scheduling
- [ ] Parent portal
- [ ] SMS notifications
- [ ] Advanced security features

---

## 📞 Contact

**Project Maintainer**: Sandeepa Muthumal  
**Email**: sandeepamuthumal3@gmail.com 
**GitHub**: [@sandeepamuthumal](https://github.com/sandeepamuthumal)  
**LinkedIn**: [Sandeepa Muthumal](https://www.linkedin.com/in/sandeepa-muthumal)

---

<div align="center">
  <p>Made with ❤️ for educational institutions</p>
  <p>© 2025 Bright Educational Center. All rights reserved.</p>
</div>
