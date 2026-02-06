<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$db = getDB();
$action = $_GET['action'] ?? 'list';
$projectId = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        flashMessage('Invalid security token', 'error');
        redirect(BASE_URL . 'admin/projects');
    }

    $title = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $technologies = sanitize($_POST['technologies'] ?? '');
    $githubUrl = sanitize($_POST['github_url'] ?? '');
    $demoUrl = sanitize($_POST['demo_url'] ?? '');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $orderPosition = (int)($_POST['order_position'] ?? 0);

    if ($action === 'add') {
        $sql = "INSERT INTO projects (title, description, technologies, github_url, demo_url, featured, order_position) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $db->execute($sql, [$title, $description, $technologies, $githubUrl, $demoUrl, $featured, $orderPosition]);
        flashMessage('Project added successfully', 'success');
    } elseif ($action === 'edit' && $projectId) {
        $sql = "UPDATE projects SET title = ?, description = ?, technologies = ?, github_url = ?, demo_url = ?, featured = ?, order_position = ? WHERE id = ?";
        $db->execute($sql, [$title, $description, $technologies, $githubUrl, $demoUrl, $featured, $orderPosition, $projectId]);
        flashMessage('Project updated successfully', 'success');
    }
    redirect(BASE_URL . 'admin/projects');
}

if ($action === 'delete' && $projectId) {
    $db->execute("DELETE FROM projects WHERE id = ?", [$projectId]);
    flashMessage('Project deleted successfully', 'success');
    redirect(BASE_URL . 'admin/projects');
}

$projects = $db->fetchAll("SELECT * FROM projects ORDER BY order_position ASC");

$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects - Admin Panel</title>
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
                <h1>Manage Projects</h1>
                <button class="btn btn-primary" onclick="openModal('addProjectModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Add Project
                </button>
            </div>

            <div class="projects-admin-grid">
                <?php foreach ($projects as $project): ?>
                <div class="project-admin-card">
                    <div class="project-admin-header">
                        <h3><?php echo sanitize($project['title']); ?></h3>
                        <?php if ($project['featured']): ?>
                        <span class="badge badge-featured">Featured</span>
                        <?php endif; ?>
                    </div>
                    <p><?php echo sanitize(substr($project['description'], 0, 100)) . '...'; ?></p>
                    <div class="project-meta">
                        <span class="tech-tag"><?php echo sanitize($project['technologies']); ?></span>
                    </div>
                    <div class="action-buttons">
                        <button type="button" class="btn btn-sm btn-secondary" onclick="editProject(<?php echo $project['id']; ?>, '<?php echo addslashes(sanitize($project['title'])); ?>', `<?php echo addslashes(sanitize($project['description'])); ?>`, '<?php echo addslashes(sanitize($project['technologies'])); ?>', '<?php echo addslashes(sanitize($project['github_url'])); ?>', '<?php echo addslashes(sanitize($project['demo_url'])); ?>', <?php echo $project['featured']; ?>, <?php echo $project['order_position']; ?>)">Edit</button>
                        <a href="<?php echo BASE_URL; ?>admin/projects.php?action=delete&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addProjectModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2>Add Project</h2>
                <button class="modal-close" onclick="closeModal('addProjectModal')">&times;</button>
            </div>
            <form method="POST" action="<?php echo BASE_URL; ?>admin/projects.php?action=add">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                <div class="form-group">
                    <label for="add_title">Project Title</label>
                    <input type="text" id="add_title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="add_description">Description</label>
                    <textarea id="add_description" name="description" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="add_technologies">Technologies (comma-separated)</label>
                    <input type="text" id="add_technologies" name="technologies" placeholder="React, Node.js, MongoDB">
                </div>

                <div class="form-group">
                    <label for="add_github_url">GitHub URL</label>
                    <input type="url" id="add_github_url" name="github_url">
                </div>

                <div class="form-group">
                    <label for="add_demo_url">Demo URL</label>
                    <input type="url" id="add_demo_url" name="demo_url">
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" id="add_featured" name="featured">
                        Featured Project
                    </label>
                </div>

                <div class="form-group">
                    <label for="add_order_position">Order Position</label>
                    <input type="number" id="add_order_position" name="order_position" min="0" value="0">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addProjectModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editProjectModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2>Edit Project</h2>
                <button class="modal-close" onclick="closeModal('editProjectModal')">&times;</button>
            </div>
            <form id="editProjectForm" method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                <div class="form-group">
                    <label for="edit_title">Project Title</label>
                    <input type="text" id="edit_title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="edit_technologies">Technologies (comma-separated)</label>
                    <input type="text" id="edit_technologies" name="technologies" placeholder="React, Node.js, MongoDB">
                </div>

                <div class="form-group">
                    <label for="edit_github_url">GitHub URL</label>
                    <input type="url" id="edit_github_url" name="github_url">
                </div>

                <div class="form-group">
                    <label for="edit_demo_url">Demo URL</label>
                    <input type="url" id="edit_demo_url" name="demo_url">
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" id="edit_featured" name="featured">
                        Featured Project
                    </label>
                </div>

                <div class="form-group">
                    <label for="edit_order_position">Order Position</label>
                    <input type="number" id="edit_order_position" name="order_position" min="0">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editProjectModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Project</button>
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
        
        function editProject(id, title, description, technologies, githubUrl, demoUrl, featured, orderPosition) {
            document.getElementById('editProjectForm').action = '<?php echo BASE_URL; ?>admin/projects.php?action=edit&id=' + id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_technologies').value = technologies;
            document.getElementById('edit_github_url').value = githubUrl;
            document.getElementById('edit_demo_url').value = demoUrl;
            document.getElementById('edit_featured').checked = featured == 1;
            document.getElementById('edit_order_position').value = orderPosition;
            openModal('editProjectModal');
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('addProjectModal');
                closeModal('editProjectModal');
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

