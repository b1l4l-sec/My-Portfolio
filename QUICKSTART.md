# Quick Start Guide - 5 Minutes to Live

This guide will get your portfolio website live in just 5 minutes.

## Step 1: Get Free Hosting (2 minutes)

1. Go to https://infinityfree.net
2. Click "Sign Up"
3. Create account (email verification required)
4. Click "Create Account" in your control panel
5. Choose a subdomain (e.g., bilallbien.infinityfreeapp.com)
6. Wait for account activation (usually instant)

## Step 2: Create Database (1 minute)

1. In InfinityFree control panel, find "MySQL Databases"
2. Click "Create Database"
3. Save these credentials:
   ```
   Database Host: sql000.infinityfreeapp.com
   Database Name: if12345678_portfolio
   Database User: if12345678_user
   Database Password: [generated password]
   ```

## Step 3: Import Database (1 minute)

1. Click "phpMyAdmin" in control panel
2. Select your database from left sidebar
3. Click "Import" tab at top
4. Click "Choose File" and select `database.sql`
5. Click "Go" button at bottom
6. Wait for "Import has been successfully finished"

## Step 4: Configure Website (30 seconds)

1. Open `config/config.php` in text editor
2. Update these 4 lines with your database credentials:
   ```php
   define('DB_HOST', 'sql000.infinityfreeapp.com');
   define('DB_NAME', 'if12345678_portfolio');
   define('DB_USER', 'if12345678_user');
   define('DB_PASS', 'your_password_here');
   ```
3. Update site URL:
   ```php
   define('SITE_URL', 'https://bilallbien.infinityfreeapp.com');
   ```
4. Save file

## Step 5: Upload Files (1 minute)

### Using File Manager (Easiest):
1. Click "Online File Manager" in control panel
2. Navigate to `htdocs` folder
3. Click "Upload" button
4. Select ALL project files
5. Wait for upload to complete

### Using FTP (Alternative):
1. Download FileZilla (free FTP client)
2. Get FTP credentials from InfinityFree
3. Connect to your server
4. Upload all files to `htdocs` folder

## Step 6: Set Permissions (30 seconds)

1. In File Manager, right-click `uploads` folder
2. Select "Change Permissions"
3. Set to 755 (or 777 if 755 doesn't work)
4. Click "OK"

## Done! Test Your Website

1. Visit your website URL: https://yoursite.infinityfreeapp.com
2. You should see the portfolio homepage with animations
3. Test the contact form by sending a message
4. Visit `/admin/login` to access admin panel

### Default Admin Login:
```
Username: admin
Password: #in infinity free 'bilal0606411104' and local 'admin123'
```

**IMPORTANT:** Change this password immediately!

## Quick Test Checklist

Visit your website and verify:
- [ ] Homepage loads with animations
- [ ] Skills section displays
- [ ] Projects section shows
- [ ] Certificates appear
- [ ] Contact form works
- [ ] Admin login works at /admin/login
- [ ] Can add/edit content in admin panel

## What's Next?

### Immediate (5 minutes):
1. Login to admin panel
2. Change admin password (in phpMyAdmin or via code)
3. Add your real projects
4. Update skills as needed
5. Check messages inbox

### Soon (30 minutes):
1. Customize colors if desired
2. Add your own bio text
3. Upload certificate images
4. Add more projects
5. Test on mobile device

### Optional (1 hour):
1. Set up custom domain
2. Enable SSL certificate
3. Add social media links
4. Configure email for forms
5. Add Google Analytics

## Need Help?

### Common Issues:

**Can't connect to database?**
- Double-check credentials in config.php
- Ensure database was imported successfully

**404 errors on pages?**
- Make sure .htaccess was uploaded
- Check file permissions

**Admin login not working?**
- Clear browser cookies
- Verify admin user exists in database

**Styling looks wrong?**
- Clear browser cache
- Verify CSS files uploaded to assets/css/

## Files You Must Upload

Essential files (24 total):
```
✓ index.php
✓ contact.php
✓ .htaccess
✓ config/ (2 files)
✓ includes/ (1 file)
✓ admin/ (8 files)
✓ assets/ (3 files: 2 CSS, 1 JS)
✓ uploads/ (.htaccess)
✓ logs/ (.htaccess)
```

Do NOT upload:
- node_modules/
- package.json
- package-lock.json
- Documentation files (.md files) - optional

## Quick Reference

### Important URLs:
- Homepage: https://yoursite.infinityfreeapp.com
- Admin Login: https://yoursite.infinityfreeapp.com/admin/login
- phpMyAdmin: Via InfinityFree control panel
- Control Panel: https://members.infinityfree.net

### Important Files:
- Config: config/config.php
- Database: database.sql
- Admin: admin/login.php
- Styles: assets/css/style.css

### Support Resources:
- README.md - Complete documentation
- DEPLOYMENT.md - Detailed deployment guide
- FEATURES.md - Full features list
- CHECKLIST.md - Testing checklist

## Success!

If you can see your portfolio and login to admin, you're done!

Your website is now:
- ✓ Live on the internet
- ✓ Fully functional
- ✓ Mobile responsive
- ✓ Secure and fast
- ✓ Easy to manage

## Pro Tips

1. **Backup Regularly**: Export database weekly
2. **Change Password**: Update admin credentials now
3. **Personalize**: Add your real content ASAP
4. **Test Mobile**: Check on your phone
5. **Share**: Send the link to friends for feedback

## Upgrade Path

### Free Forever:
- InfinityFree hosting (current)
- No credit card needed
- Perfect for portfolio

### Want More Later?
- Custom domain ($10-15/year)
- Premium hosting ($3-10/month)
- Email hosting (optional)

But start free and upgrade only if needed!

---

**Total Time:** 5 minutes
**Cost:** FREE
**Difficulty:** Easy
**Result:** Professional portfolio website

You're now live! Go ahead and share your new portfolio with the world!
