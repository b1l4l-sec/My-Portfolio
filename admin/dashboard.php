<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$db = getDB();

$stats = [
    'skills' => $db->fetchOne("SELECT COUNT(*) as count FROM skills")['count'],
    'certificates' => $db->fetchOne("SELECT COUNT(*) as count FROM certificates")['count'],
    'projects' => $db->fetchOne("SELECT COUNT(*) as count FROM projects")['count'],
    'messages' => $db->fetchOne("SELECT COUNT(*) as count FROM messages WHERE status = 'unread'")['count']
];

$recentMessages = $db->fetchAll("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");

$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
</head>
<body class="admin-body">
    <?php include 'includes/sidebar.php'; ?>

    <div class="admin-main">
        <?php include 'includes/header.php'; ?>

        <div class="admin-content">
            <?php if ($flash): ?>
            <div class="alert alert-<?php echo $flash['type']; ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
            <?php endif; ?>

            <div class="page-header">
                <h1>Dashboard</h1>
                <p>Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon skills-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['skills']; ?></h3>
                        <p>Total Skills</p>
                    </div>
                    <a href="<?php echo BASE_URL; ?>admin/skills" class="stat-link">Manage</a>
                </div>

                <div class="stat-card">
                    <div class="stat-icon certificates-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['certificates']; ?></h3>
                        <p>Certificates</p>
                    </div>
                    <a href="<?php echo BASE_URL; ?>admin/certificates" class="stat-link">Manage</a>
                </div>

                <div class="stat-card">
                    <div class="stat-icon projects-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['projects']; ?></h3>
                        <p>Projects</p>
                    </div>
                    <a href="<?php echo BASE_URL; ?>admin/projects" class="stat-link">Manage</a>
                </div>

                <div class="stat-card">
                    <div class="stat-icon messages-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['messages']; ?></h3>
                        <p>Unread Messages</p>
                    </div>
                    <a href="<?php echo BASE_URL; ?>admin/messages" class="stat-link">View</a>
                </div>
            </div>

            <div class="dashboard-section">
                <div class="section-header">
                    <h2>Recent Messages</h2>
                    <a href="<?php echo BASE_URL; ?>admin/messages" class="btn btn-secondary btn-sm">View All</a>
                </div>
                <div class="messages-list">
                    <?php if (empty($recentMessages)): ?>
                    <div class="empty-state">
                        <p>No messages yet</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($recentMessages as $message): ?>
                    <div class="message-item <?php echo $message['status'] === 'unread' ? 'unread' : ''; ?>">
                        <div class="message-header">
                            <div class="message-from">
                                <strong><?php echo sanitize($message['name']); ?></strong>
                                <span><?php echo sanitize($message['email']); ?></span>
                            </div>
                            <div class="message-meta">
                                <span class="message-status status-<?php echo $message['status']; ?>">
                                    <?php echo ucfirst($message['status']); ?>
                                </span>
                                <span class="message-time"><?php echo timeAgo($message['created_at']); ?></span>
                            </div>
                        </div>
                        <div class="message-subject">
                            <?php echo sanitize($message['subject']); ?>
                        </div>
                        <div class="message-preview">
                            <?php echo sanitize(substr($message['message'], 0, 100)) . '...'; ?>
                        </div>
                        <div class="message-footer">
                            <span class="message-source">via <?php echo sanitize($message['found_via']); ?></span>
                            <a href="<?php echo BASE_URL; ?>admin/messages?id=<?php echo $message['id']; ?>" class="btn btn-sm btn-link">Read More</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
</body>
</html>

