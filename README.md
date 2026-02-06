# Bilal Lbien - Portfolio Website

A production-ready, futuristic cybersecurity-themed portfolio website with complete admin panel for managing content.

## Features

### Public Portfolio
- Futuristic hero section with glitch effects and typing animation
- Interactive skills showcase with proficiency bars
- Featured projects gallery
- Professional certificates display
- Contact form with multi-step validation
- Fully responsive design with glassmorphism effects
- Modern animations and transitions

### Admin Dashboard
- Secure login with session management
- Complete CRUD operations for:
  - Skills management
  - Certificates management
  - Projects management
  - Message inbox
- Real-time statistics
- Responsive admin interface

## Technology Stack

- PHP 7.4+
- MySQL Database
- Vanilla JavaScript (ES6+)
- Modern CSS with custom properties
- Orbitron & Inter fonts

## Installation Instructions

### 1. InfinityFree Hosting Setup

1. Create an account at InfinityFree
2. Create a new website
3. Note your database credentials from the control panel

### 2. Upload Files

Upload all files to your InfinityFree `htdocs` directory:
```
htdocs/
├── index.php
├── .htaccess
├── config/
├── includes/
├── admin/
├── assets/
└── uploads/
```

### 3. Database Configuration

1. Access phpMyAdmin from your InfinityFree control panel
2. Create a new database
3. Import the `database.sql` file
4. Update `config/config.php` with your database credentials:

```php
define('DB_HOST', 'your_host');
define('DB_NAME', 'your_database');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### 4. Update Site URL

In `config/config.php`, update:
```php
define('SITE_URL', 'https://your-domain.infinityfreeapp.com');
```

### 5. Set Permissions

Ensure the `uploads/` directory has write permissions (755 or 777)

## Default Admin Credentials

```
Username: admin
Password: admin123
```

**IMPORTANT:** Change the admin password immediately after first login!

To change the password:
1. Generate a new hash:
```php
echo password_hash('your_new_password', PASSWORD_DEFAULT);
```

2. Update in phpMyAdmin `admin_users` table

## File Structure

```
portfolio/
├── index.php                  # Main portfolio page
├── contact.php                # Contact form handler
├── .htaccess                  # URL rewriting & security
├── database.sql               # Database schema
│
├── config/
│   ├── config.php             # Site configuration
│   └── database.php           # Database connection
│
├── includes/
│   └── functions.php          # Helper functions
│
├── admin/
│   ├── login.php              # Admin login
│   ├── logout.php             # Logout handler
│   ├── dashboard.php          # Main dashboard
│   ├── skills.php             # Skills management
│   ├── certificates.php       # Certificates management
│   ├── projects.php           # Projects management
│   ├── messages.php           # Message inbox
│   └── includes/
│       ├── sidebar.php        # Admin sidebar
│       └── header.php         # Admin header
│
├── assets/
│   ├── css/
│   │   ├── style.css          # Main stylesheet
│   │   └── admin.css          # Admin styles
│   └── js/
│       └── main.js            # JavaScript functionality
│
└── uploads/                   # File uploads directory
```

## Security Features

- CSRF token protection
- SQL injection prevention with prepared statements
- XSS protection with output escaping
- Secure password hashing with bcrypt
- Session management with timeouts
- Input sanitization
- File upload validation

## Customization

### Update Personal Information

Edit the bio in `index.php` hero section:
```php
<p class="hero-description">
    Your custom bio here...
</p>
```

### Modify Colors

Update CSS variables in `assets/css/style.css`:
```css
:root {
    --color-primary: #7fff00;
    --color-primary-dark: #39ff14;
    /* Modify as needed */
}
```

### Add/Remove Skills

Use the admin panel at `/admin/skills` to manage skills dynamically.

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Optimization

- Minified CSS and JavaScript
- Optimized images
- Browser caching enabled
- Gzip compression
- Lazy loading for images

## Troubleshooting

### Issue: Database connection failed
- Check database credentials in `config/config.php`
- Verify database exists in phpMyAdmin
- Ensure database user has proper permissions

### Issue: 404 errors on pages
- Verify `.htaccess` is uploaded
- Check if mod_rewrite is enabled (usually is on InfinityFree)

### Issue: File uploads not working
- Check `uploads/` directory permissions (755 or 777)
- Verify `upload_max_filesize` in PHP settings

### Issue: Admin login not working
- Clear browser cookies
- Check session configuration in `config/config.php`
- Verify admin user exists in database

## Support & Contact

For issues or questions:
- Email: contact@bilallbien.com
- GitHub: github.com/b1l4l

## License

All rights reserved. Created for Bilal Lbien (b1l4l).

## Credits

- Font: Orbitron by Matt McInerney
- Font: Inter by Rasmus Andersson
- Icons: Custom SVG designs

---

**Note:** This portfolio is optimized for InfinityFree hosting but can be deployed on any shared hosting platform with PHP 7.4+ and MySQL support.
