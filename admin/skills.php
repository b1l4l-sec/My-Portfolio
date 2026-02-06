<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$db = getDB();
$action = $_GET['action'] ?? 'list';
$skillId = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        flashMessage('Invalid security token', 'error');
        redirect(BASE_URL . 'admin/skills');
    }

    $name = sanitize($_POST['name'] ?? '');
    $category = sanitize($_POST['category'] ?? '');
    $proficiency = (int)($_POST['proficiency'] ?? 80);
    $iconClass = sanitize($_POST['icon_class'] ?? '');
    $orderPosition = (int)($_POST['order_position'] ?? 0);

    if ($action === 'add') {
        $sql = "INSERT INTO skills (name, category, proficiency, icon_class, order_position) VALUES (?, ?, ?, ?, ?)";
        $db->execute($sql, [$name, $category, $proficiency, $iconClass, $orderPosition]);
        flashMessage('Skill added successfully', 'success');
    } elseif ($action === 'edit' && $skillId) {
        $sql = "UPDATE skills SET name = ?, category = ?, proficiency = ?, icon_class = ?, order_position = ? WHERE id = ?";
        $db->execute($sql, [$name, $category, $proficiency, $iconClass, $orderPosition, $skillId]);
        flashMessage('Skill updated successfully', 'success');
    }
    redirect(BASE_URL . 'admin/skills');
}

if ($action === 'delete' && $skillId) {
    $db->execute("DELETE FROM skills WHERE id = ?", [$skillId]);
    flashMessage('Skill deleted successfully', 'success');
    redirect(BASE_URL . 'admin/skills');
}

$skills = $db->fetchAll("SELECT * FROM skills ORDER BY order_position ASC");
$editSkill = null;

if ($action === 'edit' && $skillId) {
    $editSkill = $db->fetchOne("SELECT * FROM skills WHERE id = ?", [$skillId]);
}

$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Skills - Admin Panel</title>
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
                <h1>Manage Skills</h1>
                <button class="btn btn-primary" onclick="openModal('addSkillModal')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Add New Skill
                </button>
            </div>

            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Proficiency</th>
                            <th>Icon</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($skills as $skill): ?>
                        <tr>
                            <td><?php echo sanitize($skill['name']); ?></td>
                            <td><span class="badge"><?php echo sanitize($skill['category']); ?></span></td>
                            <td>
                                <div class="progress-mini">
                                    <div class="progress-fill" style="width: <?php echo $skill['proficiency']; ?>%"></div>
                                </div>
                                <?php echo $skill['proficiency']; ?>%
                            </td>
                            <td><?php echo sanitize($skill['icon_class']); ?></td>
                            <td><?php echo $skill['order_position']; ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="editSkill(<?php echo $skill['id']; ?>, '<?php echo addslashes(sanitize($skill['name'])); ?>', '<?php echo addslashes(sanitize($skill['category'])); ?>', <?php echo $skill['proficiency']; ?>, '<?php echo addslashes(sanitize($skill['icon_class'])); ?>', <?php echo $skill['order_position']; ?>)">Edit</button>
                                    <a href="<?php echo BASE_URL; ?>admin/skills.php?action=delete&id=<?php echo $skill['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addSkillModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Skill</h2>
                <button class="modal-close" onclick="closeModal('addSkillModal')">&times;</button>
            </div>
            <form method="POST" action="<?php echo BASE_URL; ?>admin/skills.php?action=add">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                <div class="form-group">
                    <label for="add_name">Skill Name</label>
                    <input type="text" id="add_name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="add_category">Category</label>
                    <select id="add_category" name="category" required>
                        <option value="Cybersecurity">Cybersecurity</option>
                        <option value="Frontend">Frontend</option>
                        <option value="Backend">Backend</option>
                        <option value="IoT">IoT</option>
                        <option value="3D Modeling">3D Modeling</option>
                        <option value="Database">Database</option>
                        <option value="DevOps">DevOps</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="add_proficiency">Proficiency (%)</label>
                    <input type="number" id="add_proficiency" name="proficiency" min="0" max="100" value="80" required>
                </div>

                <div class="form-group">
                    <label for="add_icon_class">Icon</label>
                    <div class="icon-select-wrapper">
                        <select id="add_icon_class" name="icon_class" onchange="previewIcon(this, 'add_icon_preview')">
                            <option value="">-- Select Icon --</option>
                            <option value="code">Code</option>
                            <option value="shield">Shield</option>
                            <option value="lock">Lock/Security</option>
                            <option value="database">Database</option>
                            <option value="server">Server</option>
                            <option value="cloud">Cloud</option>
                            <option value="terminal">Terminal</option>
                            <option value="globe">Globe/Web</option>
                            <option value="smartphone">Mobile</option>
                            <option value="cpu">CPU/Hardware</option>
                            <option value="wifi">WiFi/IoT</option>
                            <option value="box">Box/3D</option>
                            <option value="git-branch">Git</option>
                            <option value="layers">Layers</option>
                            <option value="tool">Tool</option>
                            <option value="zap">Zap/Speed</option>
                            <option value="bar-chart">Chart</option>
                            <option value="key">Key</option>
                            <option value="eye">Eye/Monitor</option>
                            <option value="settings">Settings</option>
                            <option value="hash">Hash/Crypto</option>
                            <option value="file-code">File Code</option>
                        </select>
                        <div id="add_icon_preview" class="icon-preview"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="add_order_position">Order Position</label>
                    <input type="number" id="add_order_position" name="order_position" min="0" value="0">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addSkillModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Skill</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editSkillModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Skill</h2>
                <button class="modal-close" onclick="closeModal('editSkillModal')">&times;</button>
            </div>
            <form id="editSkillForm" method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                <div class="form-group">
                    <label for="edit_name">Skill Name</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="edit_category">Category</label>
                    <select id="edit_category" name="category" required>
                        <option value="Cybersecurity">Cybersecurity</option>
                        <option value="Frontend">Frontend</option>
                        <option value="Backend">Backend</option>
                        <option value="IoT">IoT</option>
                        <option value="3D Modeling">3D Modeling</option>
                        <option value="Database">Database</option>
                        <option value="DevOps">DevOps</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_proficiency">Proficiency (%)</label>
                    <input type="number" id="edit_proficiency" name="proficiency" min="0" max="100" required>
                </div>

                <div class="form-group">
                    <label for="edit_icon_class">Icon</label>
                    <div class="icon-select-wrapper">
                        <select id="edit_icon_class" name="icon_class" onchange="previewIcon(this, 'edit_icon_preview')">
                            <option value="">-- Select Icon --</option>
                            <option value="code">Code</option>
                            <option value="shield">Shield</option>
                            <option value="lock">Lock/Security</option>
                            <option value="database">Database</option>
                            <option value="server">Server</option>
                            <option value="cloud">Cloud</option>
                            <option value="terminal">Terminal</option>
                            <option value="globe">Globe/Web</option>
                            <option value="smartphone">Mobile</option>
                            <option value="cpu">CPU/Hardware</option>
                            <option value="wifi">WiFi/IoT</option>
                            <option value="box">Box/3D</option>
                            <option value="git-branch">Git</option>
                            <option value="layers">Layers</option>
                            <option value="tool">Tool</option>
                            <option value="zap">Zap/Speed</option>
                            <option value="bar-chart">Chart</option>
                            <option value="key">Key</option>
                            <option value="eye">Eye/Monitor</option>
                            <option value="settings">Settings</option>
                            <option value="hash">Hash/Crypto</option>
                            <option value="file-code">File Code</option>
                        </select>
                        <div id="edit_icon_preview" class="icon-preview"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_order_position">Order Position</label>
                    <input type="number" id="edit_order_position" name="order_position" min="0">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editSkillModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Skill</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // SVG Icons mapping
        const iconsSVG = {
            'code': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>',
            'shield': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
            'lock': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',
            'database': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>',
            'server': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>',
            'cloud': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path></svg>',
            'terminal': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>',
            'globe': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>',
            'smartphone': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>',
            'cpu': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>',
            'wifi': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>',
            'box': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>',
            'git-branch': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="3" x2="6" y2="15"></line><circle cx="18" cy="6" r="3"></circle><circle cx="6" cy="18" r="3"></circle><path d="M18 9a9 9 0 0 1-9 9"></path></svg>',
            'layers': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>',
            'tool': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>',
            'zap': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
            'bar-chart': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>',
            'key': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>',
            'eye': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
            'settings': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>',
            'hash': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>',
            'file-code': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><path d="M10 13l-2 2 2 2"></path><path d="M14 17l2-2-2-2"></path></svg>'
        };

        function previewIcon(selectElement, previewId) {
            const iconName = selectElement.value;
            const previewDiv = document.getElementById(previewId);
            if (iconName && iconsSVG[iconName]) {
                previewDiv.innerHTML = iconsSVG[iconName];
                previewDiv.style.display = 'flex';
            } else {
                previewDiv.innerHTML = '';
                previewDiv.style.display = 'none';
            }
        }

        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
            // Reset URL when closing edit modal
            if (id === 'editSkillModal') {
                window.history.replaceState({}, '', '<?php echo BASE_URL; ?>admin/skills.php');
            }
        }
        
        function editSkill(id, name, category, proficiency, iconClass, orderPosition) {
            document.getElementById('editSkillForm').action = '<?php echo BASE_URL; ?>admin/skills.php?action=edit&id=' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_proficiency').value = proficiency;
            document.getElementById('edit_icon_class').value = iconClass;
            document.getElementById('edit_order_position').value = orderPosition;
            // Update icon preview
            previewIcon(document.getElementById('edit_icon_class'), 'edit_icon_preview');
            openModal('editSkillModal');
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('addSkillModal');
                closeModal('editSkillModal');
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

