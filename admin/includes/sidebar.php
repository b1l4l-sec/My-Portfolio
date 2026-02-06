<aside class="admin-sidebar">
    <div class="sidebar-header">
        <a href="<?php echo BASE_URL; ?>admin/dashboard" class="sidebar-logo">
            <span class="logo-icon">&#x276F;</span>
            <span class="logo-text">B1L4L</span>
        </a>
    </div>
    <nav class="sidebar-nav">
        <a href="<?php echo BASE_URL; ?>admin/dashboard" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <rect x="3" y="3" width="7" height="7"/>
                <rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/>
                <rect x="3" y="14" width="7" height="7"/>
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="<?php echo BASE_URL; ?>admin/skills" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'skills.php' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
            <span>Skills</span>
        </a>
        <a href="<?php echo BASE_URL; ?>admin/certificates" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'certificates.php' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
            <span>Certificates</span>
        </a>
        <a href="<?php echo BASE_URL; ?>admin/projects" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'projects.php' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
            </svg>
            <span>Projects</span>
        </a>
        <a href="<?php echo BASE_URL; ?>admin/messages" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'messages.php' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
            </svg>
            <span>Messages</span>
            <?php if (isset($stats) && $stats['messages'] > 0): ?>
            <span class="badge"><?php echo $stats['messages']; ?></span>
            <?php endif; ?>
        </a>
        <a href="<?php echo BASE_URL; ?>admin/resume" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'resume.php' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            <span>Resume</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="<?php echo BASE_URL; ?>admin/logout" class="nav-item logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            <span>Logout</span>
        </a>
    </div>
</aside>
