<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$db = getDB();
$messageId = $_GET['id'] ?? null;

if ($messageId) {
    $db->execute("UPDATE messages SET status = 'read' WHERE id = ?", [$messageId]);
}

$action = $_GET['action'] ?? 'list';

if ($action === 'delete' && $messageId) {
    $db->execute("DELETE FROM messages WHERE id = ?", [$messageId]);
    flashMessage('Message deleted successfully', 'success');
    redirect(BASE_URL . 'admin/messages');
}

if ($action === 'archive' && $messageId) {
    $db->execute("UPDATE messages SET status = 'archived' WHERE id = ?", [$messageId]);
    flashMessage('Message archived successfully', 'success');
    redirect(BASE_URL . 'admin/messages');
}

$filter = $_GET['filter'] ?? 'all';
$whereClause = $filter !== 'all' ? "WHERE status = '$filter'" : '';
$messages = $db->fetchAll("SELECT * FROM messages $whereClause ORDER BY created_at DESC");

$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Admin Panel</title>
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
                <h1>Messages</h1>
                <div class="filter-buttons">
                    <a href="<?php echo BASE_URL; ?>admin/messages.php?filter=all" class="btn btn-sm <?php echo $filter === 'all' ? 'btn-primary' : 'btn-secondary'; ?>">All</a>
                    <a href="<?php echo BASE_URL; ?>admin/messages.php?filter=unread" class="btn btn-sm <?php echo $filter === 'unread' ? 'btn-primary' : 'btn-secondary'; ?>">Unread</a>
                    <a href="<?php echo BASE_URL; ?>admin/messages.php?filter=read" class="btn btn-sm <?php echo $filter === 'read' ? 'btn-primary' : 'btn-secondary'; ?>">Read</a>
                    <a href="<?php echo BASE_URL; ?>admin/messages.php?filter=archived" class="btn btn-sm <?php echo $filter === 'archived' ? 'btn-primary' : 'btn-secondary'; ?>">Archived</a>
                </div>
            </div>

            <div class="messages-list-admin">
                <?php if (empty($messages)): ?>
                <div class="empty-state">
                    <svg viewBox="0 0 100 100" fill="none" stroke="currentColor">
                        <rect x="10" y="20" width="80" height="60" rx="5"/>
                        <path d="M10 30 L50 55 L90 30"/>
                    </svg>
                    <p>No messages found</p>
                </div>
                <?php else: ?>
                <?php foreach ($messages as $message): ?>
                <div class="message-card <?php echo $message['status'] === 'unread' ? 'unread' : ''; ?>">
                    <div class="message-card-header">
                        <div class="message-from">
                            <h3><?php echo sanitize($message['name']); ?></h3>
                            <a href="mailto:<?php echo sanitize($message['email']); ?>"><?php echo sanitize($message['email']); ?></a>
                        </div>
                        <span class="message-status status-<?php echo $message['status']; ?>">
                            <?php echo ucfirst($message['status']); ?>
                        </span>
                    </div>
                    <div class="message-card-subject">
                        <strong>Subject:</strong> <?php echo sanitize($message['subject']); ?>
                    </div>
                    <div class="message-card-body">
                        <?php echo nl2br(sanitize($message['message'])); ?>
                    </div>
                    <div class="message-card-footer">
                        <div class="message-meta">
                            <span>via <?php echo sanitize($message['found_via']); ?></span>
                            <span><?php echo timeAgo($message['created_at']); ?></span>
                            <span>IP: <?php echo sanitize($message['ip_address']); ?></span>
                        </div>
                        <div class="action-buttons">
                            <?php if ($message['status'] !== 'archived'): ?>
                            <a href="<?php echo BASE_URL; ?>admin/messages.php?action=archive&id=<?php echo $message['id']; ?>" class="btn btn-sm btn-secondary">Archive</a>
                            <?php endif; ?>
                            <a href="<?php echo BASE_URL; ?>admin/messages.php?action=delete&id=<?php echo $message['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
</body>
</html>

