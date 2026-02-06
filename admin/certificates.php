<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$db = getDB();
$action = $_GET['action'] ?? 'list';
$certId = $_GET['id'] ?? null;
$uploadDir = '../uploads/certificates/';

// Create certificates upload directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        flashMessage('Invalid security token', 'error');
        redirect(BASE_URL . 'admin/certificates');
    }

    $title = sanitize($_POST['title'] ?? '');
    $issuer = sanitize($_POST['issuer'] ?? '');
    $issueDate = sanitize($_POST['issue_date'] ?? '');
    $credentialId = sanitize($_POST['credential_id'] ?? '');
    $category = sanitize($_POST['category'] ?? '');
    $imagePath = null;

    // Handle image upload
    if (isset($_FILES['cert_image']) && $_FILES['cert_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['cert_image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (in_array($mimeType, $allowedTypes) && $file['size'] <= $maxSize) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'cert_' . time() . '_' . uniqid() . '.' . $ext;
            
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                $imagePath = 'certificates/' . $filename;
            }
        } else {
            flashMessage('Invalid image file. Allowed: JPG, PNG, GIF, WebP. Max 5MB.', 'error');
            redirect(BASE_URL . 'admin/certificates');
        }
    }

    if ($action === 'add') {
        $sql = "INSERT INTO certificates (title, issuer, issue_date, credential_id, category, image_path) VALUES (?, ?, ?, ?, ?, ?)";
        $db->execute($sql, [$title, $issuer, $issueDate, $credentialId, $category, $imagePath]);
        flashMessage('Certificate added successfully', 'success');
    } elseif ($action === 'edit' && $certId) {
        if ($imagePath) {
            // Delete old image if exists
            $oldCert = $db->fetchOne("SELECT image_path FROM certificates WHERE id = ?", [$certId]);
            if ($oldCert && $oldCert['image_path'] && file_exists('../uploads/' . $oldCert['image_path'])) {
                unlink('../uploads/' . $oldCert['image_path']);
            }
            $sql = "UPDATE certificates SET title = ?, issuer = ?, issue_date = ?, credential_id = ?, category = ?, image_path = ? WHERE id = ?";
            $db->execute($sql, [$title, $issuer, $issueDate, $credentialId, $category, $imagePath, $certId]);
        } else {
            $sql = "UPDATE certificates SET title = ?, issuer = ?, issue_date = ?, credential_id = ?, category = ? WHERE id = ?";
            $db->execute($sql, [$title, $issuer, $issueDate, $credentialId, $category, $certId]);
        }
        flashMessage('Certificate updated successfully', 'success');
    }
    redirect(BASE_URL . 'admin/certificates');
}

if ($action === 'delete' && $certId) {
    // Delete image file if exists
    $cert = $db->fetchOne("SELECT image_path FROM certificates WHERE id = ?", [$certId]);
    if ($cert && $cert['image_path'] && file_exists('../uploads/' . $cert['image_path'])) {
        unlink('../uploads/' . $cert['image_path']);
    }
    $db->execute("DELETE FROM certificates WHERE id = ?", [$certId]);
    flashMessage('Certificate deleted successfully', 'success');
    redirect(BASE_URL . 'admin/certificates');
}

$certificates = $db->fetchAll("SELECT * FROM certificates ORDER BY issue_date DESC");

$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Certificates - Admin Panel</title>
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
                <h1>Manage Certificates</h1>
                <button class="btn btn-primary" onclick="openModal('addCertModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Add Certificate
                </button>
            </div>

            <div class="certificates-admin-grid">
                <?php foreach ($certificates as $cert): ?>
                <div class="cert-admin-card">
                    <div class="cert-admin-image">
                        <?php if ($cert['image_path']): ?>
                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo sanitize($cert['image_path']); ?>" alt="<?php echo sanitize($cert['title']); ?>">
                        <?php else: ?>
                            <div class="cert-placeholder">
                                <svg viewBox="0 0 100 100" fill="none">
                                    <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                                    <path d="M35 50 L45 60 L65 40" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.3"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="cert-admin-content">
                        <h3><?php echo sanitize($cert['title']); ?></h3>
                        <p class="cert-issuer"><?php echo sanitize($cert['issuer']); ?></p>
                        <div class="cert-meta">
                            <span><?php echo date('M d, Y', strtotime($cert['issue_date'])); ?></span>
                            <span class="badge"><?php echo sanitize($cert['category']); ?></span>
                        </div>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="editCert(<?php echo $cert['id']; ?>, '<?php echo addslashes(sanitize($cert['title'])); ?>', '<?php echo addslashes(sanitize($cert['issuer'])); ?>', '<?php echo $cert['issue_date']; ?>', '<?php echo addslashes(sanitize($cert['credential_id'])); ?>', '<?php echo addslashes(sanitize($cert['category'])); ?>', '<?php echo $cert['image_path'] ? BASE_URL . 'uploads/' . sanitize($cert['image_path']) : ''; ?>')">Edit</button>
                            <a href="<?php echo BASE_URL; ?>admin/certificates.php?action=delete&id=<?php echo $cert['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This will also delete the certificate image.')">Delete</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addCertModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Certificate</h2>
                <button class="modal-close" onclick="closeModal('addCertModal')">&times;</button>
            </div>
            <form method="POST" action="<?php echo BASE_URL; ?>admin/certificates.php?action=add" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                <div class="form-group">
                    <label for="add_title">Certificate Title</label>
                    <input type="text" id="add_title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="add_issuer">Issuer</label>
                    <input type="text" id="add_issuer" name="issuer" required>
                </div>

                <div class="form-group">
                    <label for="add_issue_date">Issue Date</label>
                    <input type="date" id="add_issue_date" name="issue_date" required>
                </div>

                <div class="form-group">
                    <label for="add_credential_id">Credential ID</label>
                    <input type="text" id="add_credential_id" name="credential_id">
                </div>

                <div class="form-group">
                    <label for="add_category">Category</label>
                    <select id="add_category" name="category" required>
                        <option value="Cybersecurity">Cybersecurity</option>
                        <option value="Development">Development</option>
                        <option value="Cloud">Cloud</option>
                        <option value="Networking">Networking</option>
                        <option value="Database">Database</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="add_cert_image">Certificate Image</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="add_cert_image" name="cert_image" accept="image/*">
                        <label for="add_cert_image" class="file-label">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <span>Choose image file</span>
                        </label>
                    </div>
                    <p class="upload-hint">Allowed: JPG, PNG, GIF, WebP. Max 5MB.</p>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addCertModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Certificate</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editCertModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Certificate</h2>
                <button class="modal-close" onclick="closeModal('editCertModal')">&times;</button>
            </div>
            <form id="editCertForm" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                <div class="form-group">
                    <label for="edit_title">Certificate Title</label>
                    <input type="text" id="edit_title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="edit_issuer">Issuer</label>
                    <input type="text" id="edit_issuer" name="issuer" required>
                </div>

                <div class="form-group">
                    <label for="edit_issue_date">Issue Date</label>
                    <input type="date" id="edit_issue_date" name="issue_date" required>
                </div>

                <div class="form-group">
                    <label for="edit_credential_id">Credential ID</label>
                    <input type="text" id="edit_credential_id" name="credential_id">
                </div>

                <div class="form-group">
                    <label for="edit_category">Category</label>
                    <select id="edit_category" name="category" required>
                        <option value="Cybersecurity">Cybersecurity</option>
                        <option value="Development">Development</option>
                        <option value="Cloud">Cloud</option>
                        <option value="Networking">Networking</option>
                        <option value="Database">Database</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Current Image</label>
                    <div id="currentCertImage" class="current-image-preview"></div>
                </div>

                <div class="form-group">
                    <label for="edit_cert_image">Replace Image (optional)</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="edit_cert_image" name="cert_image" accept="image/*">
                        <label for="edit_cert_image" class="file-label">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <span>Choose new image</span>
                        </label>
                    </div>
                    <p class="upload-hint">Leave empty to keep current image.</p>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editCertModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Certificate</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        
        function editCert(id, title, issuer, issueDate, credentialId, category, imagePath) {
            document.getElementById('editCertForm').action = '<?php echo BASE_URL; ?>admin/certificates.php?action=edit&id=' + id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_issuer').value = issuer;
            document.getElementById('edit_issue_date').value = issueDate;
            document.getElementById('edit_credential_id').value = credentialId;
            document.getElementById('edit_category').value = category;
            
            // Show current image preview
            const imagePreview = document.getElementById('currentCertImage');
            if (imagePath) {
                imagePreview.innerHTML = '<img src="' + imagePath + '" alt="Current certificate image">';
            } else {
                imagePreview.innerHTML = '<p class="no-image">No image uploaded</p>';
            }
            
            openModal('editCertModal');
        }
        
        // File input preview
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'Choose image file';
                this.nextElementSibling.querySelector('span').textContent = fileName;
            });
        });
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('addCertModal');
                closeModal('editCertModal');
            }
        });
        
        // Close modal when clicking outside
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
    <script src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
</body>
</html>

