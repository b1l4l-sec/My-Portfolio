<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$uploadDir = '../uploads/';
$resumePath = $uploadDir . 'resume.pdf';
$maxFileSize = 5 * 1024 * 1024; // 5MB

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        flashMessage('Invalid security token', 'error');
        redirect(BASE_URL . 'admin/resume');
    }

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['resume'];
        
        // Validate file type
        $allowedTypes = ['application/pdf'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            flashMessage('Only PDF files are allowed', 'error');
            redirect(BASE_URL . 'admin/resume');
        }

        // Validate file size
        if ($file['size'] > $maxFileSize) {
            flashMessage('File size must be less than 5MB', 'error');
            redirect(BASE_URL . 'admin/resume');
        }

        // Create uploads directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Delete old resume if exists
        if (file_exists($resumePath)) {
            unlink($resumePath);
        }

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $resumePath)) {
            flashMessage('Resume uploaded successfully!', 'success');
        } else {
            flashMessage('Failed to upload resume', 'error');
        }
    } else {
        flashMessage('Please select a file to upload', 'error');
    }
    
    redirect(BASE_URL . 'admin/resume');
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    if (file_exists($resumePath)) {
        unlink($resumePath);
        flashMessage('Resume deleted successfully', 'success');
    }
    redirect(BASE_URL . 'admin/resume');
}

$resumeExists = file_exists($resumePath);
$resumeInfo = $resumeExists ? [
    'size' => filesize($resumePath),
    'modified' => filemtime($resumePath)
] : null;

$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resume - Admin Panel</title>
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
                <h1>Manage Resume</h1>
            </div>

            <div class="resume-manager">
                <div class="resume-card">
                    <?php if ($resumeExists): ?>
                    <div class="resume-preview">
                        <div class="resume-icon">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </div>
                        <h3>resume.pdf</h3>
                        <div class="resume-meta">
                            <span>Size: <?php echo number_format($resumeInfo['size'] / 1024, 1); ?> KB</span>
                            <span>Updated: <?php echo date('M d, Y H:i', $resumeInfo['modified']); ?></span>
                        </div>
                        <div class="resume-actions">
                            <a href="<?php echo BASE_URL; ?>uploads/resume.pdf" class="btn btn-primary" target="_blank">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                View
                            </a>
                            <a href="<?php echo BASE_URL; ?>uploads/resume.pdf" class="btn btn-secondary" download>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                                Download
                            </a>
                            <a href="<?php echo BASE_URL; ?>admin/resume.php?action=delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the resume?')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                </svg>
                                Delete
                            </a>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="no-resume">
                        <div class="resume-icon muted">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.3">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <h3>No Resume Uploaded</h3>
                        <p>Upload your resume so visitors can download it from your portfolio.</p>
                    </div>
                    <?php endif; ?>

                    <div class="upload-section">
                        <h4><?php echo $resumeExists ? 'Replace Resume' : 'Upload Resume'; ?></h4>
                        <form method="POST" enctype="multipart/form-data" class="upload-form">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                            <div class="file-input-wrapper">
                                <input type="file" id="resume" name="resume" accept=".pdf" required>
                                <label for="resume" class="file-label">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                                        <polyline points="17 8 12 3 7 8"/>
                                        <line x1="12" y1="3" x2="12" y2="15"/>
                                    </svg>
                                    <span>Choose PDF file</span>
                                </label>
                            </div>
                            <p class="upload-hint">Maximum file size: 5MB. Only PDF files are allowed.</p>
                            <button type="submit" class="btn btn-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                Upload Resume
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
    <script>
        // File input preview
        document.getElementById('resume').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Choose PDF file';
            this.nextElementSibling.querySelector('span').textContent = fileName;
        });
    </script>
</body>
</html>

