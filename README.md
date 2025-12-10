# ImpactGuru CRM

A professional, full-featured Customer Relationship Management (CRM) system built with **Laravel 12** and **Tailwind CSS**. Designed to streamline customer and order management with an intuitive interface, real-time analytics, and advanced features.

## 🎯 Features

### Core Modules
- **Customer Management** - Create, read, update, delete customer records with profile images
- **Order Management** - Full CRUD operations for orders with status tracking (Pending, Completed, Cancelled)
- **Dynamic Dashboard** - Real-time statistics, revenue tracking, and recent customer list
- **Order Status Filtering** - Filter orders by status for better organization

### Advanced Features
- **Authentication & Authorization**
  - Breeze authentication system (Login/Register/Password Reset)
  - Role-Based Access Control (RBAC) - Admin & Staff roles
  - Admin-only delete functionality with middleware protection

- **Email Notifications**
  - Admin notifications for new orders via Mail
  - Graceful error handling for mail transport failures

- **Data Export**
  - Export customers to Excel format
  - Export orders to Excel format
  - Uses Maatwebsite/Excel package

- **Soft Deletes**
  - Non-destructive data deletion
  - Ability to restore deleted records

- **Professional UI**
  - Modern, responsive landing page with hero section
  - Glass-morphism design elements
  - Mobile-friendly interface
  - Tailwind CSS styling
  - Interactive animations

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- MySQL 5.7+
- Node.js & NPM (for frontend assets)
- Git

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/VaradPDamle/Mini-CRM.git
cd Mini-CRM
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies
```bash
npm install
```

### 4. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure Database
Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=impactguru_crm
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run Migrations
```bash
php artisan migrate
```

### 7. Seed Database (Optional)
```bash
php artisan db:seed
```

### 8. Build Frontend Assets
```bash
npm run dev
```

### 9. Start Development Server
```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser.

## 🔐 Authentication

### Default Test Users
Create test users during seeding or via registration:
- **Admin User** - Full access to all features
- **Staff User** - Limited access (cannot delete customers/orders)

### Role Permissions
| Action | Admin | Staff |
|--------|-------|-------|
| Create Customer | ✅ | ✅ |
| Edit Customer | ✅ | ✅ |
| Delete Customer | ✅ | ❌ |
| Create Order | ✅ | ✅ |
| Edit Order | ✅ | ✅ |
| Delete Order | ✅ | ❌ |
| View Analytics | ✅ | ✅ |
| Export Data | ✅ | ✅ |

## 📁 Project Structure

```
impactguru_crm/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CustomerController.php
│   │   │   ├── OrderController.php
│   │   │   ├── DashboardController.php
│   │   ├── Middleware/
│   │   │   ├── IsAdmin.php
│   │   ├── Requests/
│   │   │   ├── CustomerStoreRequest.php
│   │   │   ├── OrderStoreRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Customer.php
│   │   ├── Order.php
│   ├── Notifications/
│   │   ├── NewOrderNotification.php
│   ├── Exports/
│   │   ├── CustomersExport.php
│   │   ├── OrdersExport.php
├── database/
│   ├── migrations/
│   ├── seeders/
├── resources/
│   ├── views/
│   │   ├── landing.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── customers/
│   │   ├── orders/
│   │   ├── layouts/
│   ├── css/app.css
│   ├── js/app.js
├── routes/
│   ├── web.php
│   ├── auth.php
└── config/
```

## 🎨 Key Technologies

- **Framework**: Laravel 12
- **Frontend**: Tailwind CSS, Blade Templates
- **Database**: MySQL with Eloquent ORM
- **Authentication**: Laravel Breeze
- **Export**: Maatwebsite/Excel (PHPOffice)
- **Build Tool**: Vite
- **CSS Framework**: Tailwind CSS

## 📊 Database Schema

### Users Table
- id, name, email, password, role (admin/staff), timestamps

### Customers Table
- id, name, email, phone, address, profile_image, timestamps, soft_deletes

### Orders Table
- id, customer_id (FK), order_number, amount, status, order_date, timestamps, soft_deletes

## 🔧 Configuration

### Mail Setup (for notifications)
Update `.env`:
```env
MAIL_MAILER=log  # For development (logs to storage/logs/laravel.log)
# Or use real SMTP:
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
```

### File Upload
Profile images are stored in `storage/app/public`. Create symbolic link:
```bash
php artisan storage:link
```

## 📈 Usage Examples

### Create a Customer
```php
POST /customers
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "9876543210",
  "address": "123 Main St"
}
```

### Create an Order
```php
POST /orders
{
  "customer_id": 1,
  "order_number": "ORD-001",
  "amount": "5000",
  "status": "Pending",
  "order_date": "2025-12-10"
}
```

### Export Customers
```php
GET /customers/export
```

### Export Orders
```php
GET /orders/export
```

## 🐛 Troubleshooting

### Mail notifications failing
- Use `MAIL_MAILER=log` in development
- Check mail configuration in `config/mail.php`
- View error logs: `storage/logs/laravel.log`

### File uploads not working
- Ensure `storage/app/public` directory exists
- Run `php artisan storage:link`
- Check file permissions

### Database connection errors
- Verify MySQL is running
- Check `.env` database credentials
- Run `php artisan migrate --fresh` to reset

## 📝 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/` | Landing page |
| GET | `/dashboard` | Main dashboard |
| GET | `/customers` | List customers |
| POST | `/customers` | Create customer |
| GET | `/customers/{id}/edit` | Edit customer form |
| PATCH | `/customers/{id}` | Update customer |
| DELETE | `/customers/{id}` | Delete customer (Admin only) |
| GET | `/orders` | List orders |
| POST | `/orders` | Create order |
| GET | `/orders/{id}/edit` | Edit order form |
| PATCH | `/orders/{id}` | Update order |
| DELETE | `/orders/{id}` | Delete order (Admin only) |
| GET | `/customers/export` | Export customers to Excel |
| GET | `/orders/export` | Export orders to Excel |

## 📄 License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👤 Author

**VaradPDamle**  
GitHub: [@VaradPDamle](https://github.com/VaradPDamle)

## 🤝 Contributing

Contributions are welcome! Please fork the repository and create a pull request with your changes.

## 📞 Support

For issues, bugs, or feature requests, please create an issue on the [GitHub repository](https://github.com/VaradPDamle/Mini-CRM/issues).

---

**Built with ❤️ using Laravel & Tailwind CSS**
