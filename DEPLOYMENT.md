# Quick Deployment Guide

## InfinityFree Hosting Setup (5 Minutes)

### Step 1: Create Account
1. Visit https://infinityfree.net
2. Sign up for free hosting
3. Create a new website
4. Wait for account activation (usually instant)

### Step 2: Database Setup
1. Login to your InfinityFree control panel
2. Go to "MySQL Databases"
3. Create a new database
4. Note down:
   - Database Host (usually sql000.infinityfreeapp.com)
   - Database Name (e.g., if12345678_portfolio)
   - Database User (e.g., if12345678_user)
   - Database Password

### Step 3: Import Database
1. Click "phpMyAdmin" in your control panel
2. Select your database from the left sidebar
3. Click "Import" tab
4. Choose the `database.sql` file
5. Click "Go" to import

### Step 4: Configure Website
1. Open `config/config.php` in a text editor
2. Update the database credentials:

```php
define('DB_HOST', 'sql000.infinityfreeapp.com');  // Your DB host
define('DB_NAME', 'if12345678_portfolio');        // Your DB name
define('DB_USER', 'if12345678_user');             // Your DB user
define('DB_PASS', 'your_password_here');          // Your DB password
```

3. Update your site URL:
```php
define('SITE_URL', 'https://yoursite.infinityfreeapp.com');
```

### Step 5: Upload Files
1. Open "File Manager" or use FTP (FileZilla recommended)
2. Navigate to `htdocs` directory
3. Upload ALL project files maintaining the folder structure
4. Ensure all files are uploaded correctly

### Step 6: Set Permissions
1. Right-click the `uploads` folder
2. Select "Change Permissions" or "chmod"
3. Set to 755 or 777 if needed

### Step 7: Test Your Website
1. Visit your website URL (e.g., https://yoursite.infinityfreeapp.com)
2. Portfolio should load with animations
3. Test the contact form
4. Visit `/admin/login` to access admin panel

### Default Admin Login
```
Username: admin
Password: admin123
```

**IMPORTANT:** Change this immediately after first login!

## Changing Admin Password

### Method 1: Via phpMyAdmin
1. Open phpMyAdmin
2. Select your database
3. Click on `admin_users` table
4. Edit the admin row
5. In the password field, use this function:
   ```
   MD5: (no)
   Function: (none)
   Value: Copy the hash generated below
   ```

Generate hash in PHP:
```php
<?php echo password_hash('your_new_password', PASSWORD_DEFAULT); ?>
```

### Method 2: Via PHP Script
1. Create a file `change_password.php` in root:
```php
<?php
require_once 'config/config.php';
require_once 'config/database.php';

$new_password = 'your_new_password';
$hashed = password_hash($new_password, PASSWORD_DEFAULT);

$db = getDB();
$db->execute("UPDATE admin_users SET password = ? WHERE username = 'admin'", [$hashed]);

echo "Password updated! Delete this file now.";
?>
```

2. Visit the file in browser
3. DELETE the file immediately after

## SSL Certificate (Optional)
InfinityFree provides free SSL:
1. Go to "SSL Certificates" in control panel
2. Click "Install SSL Certificate"
3. Wait 5-10 minutes for activation
4. Update SITE_URL to use https://

## Troubleshooting

### White Screen / Errors
- Check if all files uploaded correctly
- Verify database credentials
- Check PHP error logs in control panel

### Database Connection Error
- Double-check credentials in config.php
- Ensure database was imported successfully
- Verify database user has all privileges

### Admin Login Not Working
- Clear browser cookies/cache
- Check if admin user exists in database
- Verify password hash is correct

### Contact Form Not Working
- Check uploads folder permissions
- Verify email settings if using mail()
- Check PHP error logs

### 404 Errors
- Verify .htaccess file is uploaded
- Check if mod_rewrite is enabled
- Contact InfinityFree support if needed

## Post-Deployment Checklist

- [ ] Database imported successfully
- [ ] Website loads without errors
- [ ] Contact form submits messages
- [ ] Admin login works
- [ ] Admin can add/edit/delete content
- [ ] Skills display correctly
- [ ] Projects show up
- [ ] Certificates visible
- [ ] Messages appear in admin inbox
- [ ] Changed default admin password
- [ ] SSL certificate installed (optional)
- [ ] Tested on mobile devices

## Custom Domain Setup

If you have a custom domain:

1. Update nameservers to InfinityFree's:
   - ns1.infinityfreeapp.com
   - ns2.infinityfreeapp.com

2. Add domain in InfinityFree control panel

3. Update SITE_URL in config.php

4. Wait 24-48 hours for DNS propagation

## Performance Tips

1. Enable browser caching (already in .htaccess)
2. Compress images before uploading
3. Use WebP format for images when possible
4. Minimize external resources
5. Enable Cloudflare (free plan available)

## Support

Need help?
- InfinityFree Forum: https://forum.infinityfree.net
- Documentation: See README.md
- Contact: contact@bilallbien.com

---

**Deployment Time:** Approximately 5-10 minutes

**Cost:** FREE with InfinityFree
