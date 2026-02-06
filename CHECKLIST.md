# Deployment & Testing Checklist

## Pre-Deployment Checklist

### Files Verification
- [ ] All 24 files present in correct directories
- [ ] .htaccess files in root, uploads, and logs directories
- [ ] Config files are in config/ directory
- [ ] Admin files are in admin/ directory
- [ ] Assets (CSS/JS) are in assets/ directory
- [ ] Database.sql file is present

### Configuration
- [ ] Open config/config.php
- [ ] Update DB_HOST with your database host
- [ ] Update DB_NAME with your database name
- [ ] Update DB_USER with your database username
- [ ] Update DB_PASS with your database password
- [ ] Update SITE_URL with your website URL
- [ ] Save changes

### Database Setup
- [ ] Access phpMyAdmin
- [ ] Create new database
- [ ] Import database.sql file
- [ ] Verify all 6 tables created successfully
- [ ] Check sample data is present
- [ ] Verify admin user exists

### File Upload
- [ ] Upload all files to htdocs directory
- [ ] Maintain directory structure
- [ ] Verify .htaccess files are uploaded (check hidden files)
- [ ] Check uploads/ directory exists
- [ ] Check logs/ directory exists

### Permissions
- [ ] Set uploads/ directory to 755 or 777
- [ ] Verify web server can write to uploads/
- [ ] Check logs/ directory permissions if needed

## Post-Deployment Testing

### Homepage Tests
- [ ] Visit your website URL
- [ ] Hero section loads correctly
- [ ] Typing animation works
- [ ] Scroll animations trigger
- [ ] Navigation menu works
- [ ] Mobile menu toggles properly
- [ ] All sections scroll smoothly
- [ ] Skills display with progress bars
- [ ] Projects show correctly
- [ ] Certificates appear
- [ ] Footer displays properly

### Contact Form Tests
- [ ] Navigate to contact section
- [ ] Fill out all fields
- [ ] Select "How did you find me?" option
- [ ] Submit form
- [ ] Verify success message appears
- [ ] Check message appears in admin inbox

### Admin Login Tests
- [ ] Visit /admin/login
- [ ] Try wrong credentials (should fail)
- [ ] Login with: admin / admin123
- [ ] Verify redirect to dashboard
- [ ] Check welcome message shows
- [ ] Verify statistics display correctly

### Dashboard Tests
- [ ] Statistics show correct counts
- [ ] Recent messages appear
- [ ] Navigation sidebar works
- [ ] All menu items are clickable
- [ ] "View Site" link works
- [ ] User avatar displays

### Skills Management Tests
- [ ] Click "Skills" in sidebar
- [ ] Verify existing skills display
- [ ] Click "Add New Skill"
- [ ] Fill out form and submit
- [ ] Verify skill appears in list
- [ ] Click "Edit" on a skill
- [ ] Modify and save
- [ ] Verify changes saved
- [ ] Test delete functionality
- [ ] Check skill appears on homepage

### Certificates Management Tests
- [ ] Click "Certificates" in sidebar
- [ ] Verify existing certificates display
- [ ] Click "Add Certificate"
- [ ] Fill out all fields
- [ ] Submit form
- [ ] Verify certificate appears
- [ ] Test edit functionality
- [ ] Test delete with confirmation
- [ ] Check certificate shows on homepage

### Projects Management Tests
- [ ] Click "Projects" in sidebar
- [ ] Verify existing projects display
- [ ] Click "Add Project"
- [ ] Fill out project details
- [ ] Toggle "Featured" checkbox
- [ ] Submit form
- [ ] Verify project appears
- [ ] Test edit functionality
- [ ] Test delete functionality
- [ ] Check project displays on homepage

### Messages Management Tests
- [ ] Click "Messages" in sidebar
- [ ] Verify contact form submission appears
- [ ] Check message shows as "Unread"
- [ ] Click on message to read
- [ ] Verify status changes to "Read"
- [ ] Test filter buttons (All, Unread, Read, Archived)
- [ ] Test archive functionality
- [ ] Test delete functionality

### Mobile Responsiveness Tests
- [ ] Test on mobile device or use browser DevTools
- [ ] Verify hamburger menu works
- [ ] Check all sections are readable
- [ ] Test form submission on mobile
- [ ] Verify admin panel on mobile
- [ ] Check sidebar toggle works

### Security Tests
- [ ] Try accessing /config/config.php (should be blocked)
- [ ] Try accessing /includes/functions.php (should be blocked)
- [ ] Try accessing admin pages without login (should redirect)
- [ ] Logout and verify redirect to login
- [ ] Test CSRF protection (form submissions work)

### Performance Tests
- [ ] Check page load time (should be < 3 seconds)
- [ ] Verify animations are smooth
- [ ] Test on slow connection
- [ ] Check image loading
- [ ] Verify no console errors in browser DevTools

## Post-Deployment Actions

### Immediate Actions
- [ ] Change default admin password
- [ ] Update admin email in config
- [ ] Test password reset if implemented
- [ ] Add your actual projects
- [ ] Upload your certificates
- [ ] Update bio text with your info

### Security Hardening
- [ ] Change admin username from "admin"
- [ ] Review .htaccess security rules
- [ ] Test file upload restrictions
- [ ] Verify database user permissions
- [ ] Check error logging is working

### Content Updates
- [ ] Delete sample skills or keep as desired
- [ ] Add your real projects
- [ ] Upload certificate images if available
- [ ] Update contact information
- [ ] Add social media links
- [ ] Customize color scheme if desired

### Optional Enhancements
- [ ] Set up custom domain
- [ ] Install SSL certificate
- [ ] Configure email for contact form
- [ ] Add Google Analytics
- [ ] Set up Cloudflare (optional)
- [ ] Optimize images before upload

## Troubleshooting Checklist

### If homepage doesn't load:
- [ ] Check database connection in config.php
- [ ] Verify database was imported
- [ ] Check PHP error logs
- [ ] Ensure .htaccess is uploaded
- [ ] Verify file permissions

### If admin login fails:
- [ ] Check database connection
- [ ] Verify admin_users table exists
- [ ] Check username/password
- [ ] Clear browser cookies
- [ ] Check session configuration

### If forms don't submit:
- [ ] Check database connection
- [ ] Verify CSRF token is generated
- [ ] Check PHP error logs
- [ ] Verify table exists
- [ ] Check file permissions

### If images don't upload:
- [ ] Check uploads/ directory permissions (755 or 777)
- [ ] Verify upload_max_filesize in PHP settings
- [ ] Check available disk space
- [ ] Verify file types are allowed

### If styling looks broken:
- [ ] Verify CSS files uploaded correctly
- [ ] Check browser console for errors
- [ ] Clear browser cache
- [ ] Check file paths in HTML
- [ ] Verify assets/ directory structure

## Browser Testing Matrix

### Desktop Browsers
- [ ] Chrome (latest version)
- [ ] Firefox (latest version)
- [ ] Safari (latest version)
- [ ] Edge (latest version)

### Mobile Browsers
- [ ] iOS Safari
- [ ] Chrome Mobile (Android)
- [ ] Samsung Internet
- [ ] Firefox Mobile

### Screen Sizes
- [ ] 1920x1080 (Desktop)
- [ ] 1366x768 (Laptop)
- [ ] 768x1024 (Tablet)
- [ ] 375x667 (iPhone)
- [ ] 360x640 (Android)

## Performance Checklist

### Speed Optimization
- [ ] Enable Gzip compression (via .htaccess)
- [ ] Enable browser caching (via .htaccess)
- [ ] Optimize images before upload
- [ ] Minimize external resources
- [ ] Use WebP format for images

### Loading Times
- [ ] Homepage loads in < 2 seconds
- [ ] Admin panel loads in < 2 seconds
- [ ] Forms submit in < 1 second
- [ ] Images load progressively
- [ ] Animations are smooth (60fps)

## SEO Checklist (Optional)

- [ ] Update meta description
- [ ] Add relevant keywords
- [ ] Ensure proper heading hierarchy
- [ ] Add alt text to images
- [ ] Create sitemap.xml
- [ ] Add robots.txt
- [ ] Submit to Google Search Console

## Backup Checklist

### Regular Backups
- [ ] Backup database weekly
- [ ] Backup uploaded files
- [ ] Keep local copy of config.php
- [ ] Export admin credentials safely
- [ ] Document any custom changes

## Maintenance Schedule

### Weekly
- [ ] Check for new messages
- [ ] Review error logs
- [ ] Test contact form
- [ ] Check site is accessible

### Monthly
- [ ] Backup database
- [ ] Update content as needed
- [ ] Review analytics (if installed)
- [ ] Test all functionality

### Quarterly
- [ ] Change admin password
- [ ] Review security settings
- [ ] Update PHP if needed
- [ ] Check for broken links

## Final Verification

- [ ] All checklist items completed
- [ ] Website is fully functional
- [ ] Admin panel works correctly
- [ ] Content is personalized
- [ ] Security measures active
- [ ] Performance is optimized
- [ ] Mobile experience verified
- [ ] Documentation reviewed

---

**Congratulations! Your portfolio is ready to go live!**

After completing this checklist, your website should be:
- Fully functional
- Secure
- Fast
- Mobile-friendly
- Professional
- Easy to maintain

**Last Updated:** Use this checklist every time you deploy or make major changes.
