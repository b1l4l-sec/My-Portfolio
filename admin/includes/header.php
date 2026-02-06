<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
<button class="admin-menu-toggle" id="adminMenuToggle" onclick="toggleSidebar()">
    <span></span>
    <span></span>
    <span></span>
</button>
<header class="admin-header">
    <div class="header-left">
        <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    <div class="header-right">
        <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-secondary btn-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
            </svg>
            <span>View Site</span>
        </a>
        <div class="user-menu">
            <span class="user-name"><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
            <div class="user-avatar">
                <?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?>
            </div>
        </div>
    </div>
</header>
