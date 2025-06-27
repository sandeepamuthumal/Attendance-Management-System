# QR-Based Smart Attendance Management System

A modern, efficient attendance management system built with Laravel, featuring QR code scanning, real-time statistics, and comprehensive reporting capabilities for educational institutions.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 🚀 Features

### Core Features
- **QR Code Scanning**: Fast and accurate attendance marking using QR codes
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

## 📋 Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [Architecture](#architecture)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## 🔧 Requirements

- **PHP**: 8.1 or higher
- **Laravel**: 10.x
- **Database**: MySQL 8.0+ or PostgreSQL 13+
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Node.js**: 16+ (for asset compilation)
- **Composer**: 2.0+

### PHP Extensions
```
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension (for QR code generation)
```

## 📥 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/attendance-management-system.git
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

### 4. Configure Environment Variables
Edit `.env` file with your database and application settings:

```env
APP_NAME="Attendance Management System"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=attendance_system
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Cache Configuration
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Attendance System Configuration
ATTENDANCE_CACHE_TTL=300
AUTO_SCAN_COOLDOWN=3000
MAX_FUTURE_ATTENDANCE_DAYS=0
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

### 3. Seed Sample Data (Optional)
```bash
php artisan db:seed --class=AttendanceSeeder
```

### 4. Create Storage Link
```bash
php artisan storage:link
```

## 🚀 Usage

### Starting the Application
```bash
# Start development server
php artisan serve

# For production, configure your web server to point to the public directory
```

### Default Access
- **URL**: `http://localhost:8000`
- **Admin Dashboard**: `http://localhost:8000/dashboard`
- **Attendance Scanner**: `http://localhost:8000/attendance`
- **Reports**: `http://localhost:8000/attendance/report`

## 📱 Main Features Usage

### 1. Dashboard
- View real-time attendance statistics
- Monitor daily, weekly, and monthly trends
- Quick access to all system features
- Recent attendance activity

### 2. Attendance Scanner
```
1. Select a class from the dropdown
2. Choose the attendance date
3. Scan QR code or manually enter Student ID
4. Confirm student details in popup
5. Mark attendance with one click
```

### 3. Attendance Reports
```
1. Navigate to Reports section
2. Apply filters:
   - Select Class (optional)
   - Choose Student (optional)
   - Set Date Range
3. Click "Generate Report"
4. View results in data table
5. Export to CSV if needed
```

### 4. Student Management
- Add new students
- Manage class enrollments
- Update student information
- Track enrollment history

## 🔌 API Documentation

### Authentication
All API endpoints require authentication using Laravel Sanctum.

### Endpoints

#### Get Classes
```http
GET /api/attendance/classes
Authorization: Bearer {token}
```

#### Get Attendance Statistics
```http
GET /api/attendance/stats?class_id=1&date=2025-06-27
Authorization: Bearer {token}
```

#### Validate Student
```http
POST /api/attendance/validate-student
Authorization: Bearer {token}
Content-Type: application/json

{
    "student_id": "STU001",
    "class_id": 1,
    "date": "2025-06-27"
}
```

#### Mark Attendance
```http
POST /api/attendance/mark
Authorization: Bearer {token}
Content-Type: application/json

{
    "student_id": "STU001",
    "class_id": 1,
    "date": "2025-06-27"
}
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

### Example Test
```php
public function test_can_mark_attendance()
{
    $student = Student::factory()->create();
    $class = ClassModel::factory()->create();
    
    $response = $this->post('/api/attendance/mark', [
        'student_id' => $student->student_id,
        'class_id' => $class->id,
        'date' => Carbon::today()->format('Y-m-d')
    ]);
    
    $response->assertSuccessful();
    $this->assertDatabaseHas('attendances', [
        'students_id' => $student->id
    ]);
}
```

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

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. **Fork the repository**
2. **Create a feature branch**: `git checkout -b feature/amazing-feature`
3. **Commit changes**: `git commit -m 'Add amazing feature'`
4. **Push to branch**: `git push origin feature/amazing-feature`
5. **Open a Pull Request**

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Use meaningful commit messages

### Code Style
```bash
# Check code style
./vendor/bin/pint --test

# Fix code style
./vendor/bin/pint
```

## 📋 Changelog

### Version 1.0.0 (2025-06-27)
- Initial release
- QR code attendance scanning
- Dashboard with statistics
- Comprehensive reporting system
- Export functionality
- Mobile responsive design

## 🆘 Support

### Getting Help
- **Documentation**: Check this README and inline documentation
- **Issues**: [GitHub Issues](https://github.com/sandeepamuthumal/attendance-management-system/issues)
- **Discussions**: [GitHub Discussions](https://github.com/sandeepamuthumal/attendance-management-system/discussions)


## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

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
**LinkedIn**: [Sandeepa Muthumal](www.linkedin.com/in/sandeepa-muthumal-67a904295)

---

<div align="center">
  <p>Made with ❤️ for educational institutions</p>
  <p>© 2025 Bright Educational Center. All rights reserved.</p>
</div>
