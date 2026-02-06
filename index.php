<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'includes/functions.php';

$db = getDB();

// Get counts for statistics
$skillsCount = $db->fetchOne("SELECT COUNT(*) as count FROM skills")['count'];
$certificatesCount = $db->fetchOne("SELECT COUNT(*) as count FROM certificates")['count'];
$projectsCount = $db->fetchOne("SELECT COUNT(*) as count FROM projects WHERE featured = 1")['count'];

$skills = $db->fetchAll("SELECT * FROM skills ORDER BY order_position ASC");
$certificates = $db->fetchAll("SELECT * FROM certificates ORDER BY issue_date DESC LIMIT 6");
$allCertificates = $db->fetchAll("SELECT * FROM certificates ORDER BY issue_date DESC");
$projects = $db->fetchAll("SELECT * FROM projects WHERE featured = 1 ORDER BY order_position ASC LIMIT 6");
$allProjects = $db->fetchAll("SELECT * FROM projects WHERE featured = 1 ORDER BY order_position ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilal Lbien - Full-Stack Developer & Cybersecurity Enthusiast</title>
    <meta name="description" content="Bilal Lbien - Engineering Student at ENSA de Fès. Passionate about Full-Stack Development & Cybersecurity. Creator of TheZero Kali Linux project. Skills in Arduino, Blender 3D, Red Team tools, React, and PHP/Laravel.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <script>
        const BASE_URL = '<?php echo BASE_URL; ?>';
    </script>
</head>
<body>
    <div id="particles-bg"></div>

    <nav class="navbar">
        <div class="container">
            <a href="#home" class="nav-brand">
                <span class="brand-icon">&#x276F;</span>
                <span class="brand-text">B1L4L</span>
            </a>
            <ul class="nav-menu">
                <li><a href="#home" class="nav-link active">Home</a></li>
                <li><a href="#skills" class="nav-link">Skills</a></li>
                <li><a href="#projects" class="nav-link">Projects</a></li>
                <li><a href="#certificates" class="nav-link">Certificates</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/login" class="nav-link nav-login">Login</a></li>
            </ul>
            <div class="nav-actions">
                <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
                    <svg class="sun-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                    <svg class="moon-icon" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                </button>
                <div class="nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <div class="glitch-wrapper">
                        <h1 class="hero-title glitch" data-text="BILAL LBIEN">BILAL LBIEN</h1>
                    </div>
                    <div class="typing-container">
                        <span class="typed-text"></span>
                        <span class="cursor">&nbsp;</span>
                    </div>
                    <p class="hero-description">
                        Engineering Student at <a href="https://ensaf.ac.ma/" target="_blank" class="highlight">ENSA of Fez</a>, passionate about Full-Stack Development 
                        & Cybersecurity. Specializing in Red Team operations, IoT security, and cutting-edge web technologies. 
                        Creator of <span class="highlight">TheZero</span> - a custom Kali Linux distribution for penetration testing.
                    </p>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number" data-target="<?php echo $skillsCount; ?>">0</span>
                            <span class="stat-label">Skills Mastered</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" data-target="<?php echo $certificatesCount; ?>">0</span>
                            <span class="stat-label">Certifications</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" data-target="<?php echo $projectsCount; ?>">0</span>
                            <span class="stat-label">Featured Projects</span>
                        </div>
                    </div>
                    <div class="hero-cta">
                        <a href="#contact" class="btn btn-primary">
                            <span>Get In Touch</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                        <a href="#projects" class="btn btn-secondary">
                            <span>View Projects</span>
                        </a>
                    </div>
                    <div class="scroll-indicator-inline">
                        <span>Scroll Down</span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M19 12l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="cyber-card">
                        <div class="card-scanline"></div>
                        <div class="profile-container">
                            <div class="profile-ring"></div>
                            <div class="profile-icon">
                                <svg viewBox="0 0 100 100" fill="none">
                                    <circle cx="50" cy="35" r="15" fill="#39ff14"/>
                                    <path d="M25 75 C25 60, 35 50, 50 50 C65 50, 75 60, 75 75" stroke="#39ff14" stroke-width="3" fill="none"/>
                                </svg>
                            </div>
                        </div>
                        <div class="status-indicators">
                            <div class="status-item">
                                <span class="status-dot"></span>
                                <span>System Active</span>
                            </div>
                            <div class="status-item">
                                <span class="status-dot"></span>
                                <span>Security: HIGH</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="skills" class="skills-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">EXPERTISE</span>
                <h2 class="section-title">Skills Arsenal</h2>
                <p class="section-description">Advanced proficiency across multiple technology domains</p>
            </div>
            <div class="skills-grid">
                <?php foreach ($skills as $skill): ?>
                <div class="skill-card" data-category="<?php echo sanitize($skill['category']); ?>">
                    <div class="skill-header">
                        <div class="skill-icon">
                            <?php echo getSkillIcon($skill['icon_class']); ?>
                        </div>
                        <h3 class="skill-name"><?php echo sanitize($skill['name']); ?></h3>
                    </div>
                    <div class="skill-category"><?php echo sanitize($skill['category']); ?></div>
                    <div class="skill-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" data-progress="<?php echo $skill['proficiency']; ?>"></div>
                        </div>
                        <span class="progress-value"><?php echo $skill['proficiency']; ?>%</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="projects" class="projects-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">PORTFOLIO</span>
                <h2 class="section-title">Featured Projects</h2>
                <p class="section-description">Innovative solutions across cybersecurity, IoT, and web development</p>
            </div>
            <div class="projects-grid" id="projectsGrid">
                <?php foreach ($projects as $index => $project): ?>
                <div class="project-card" data-index="<?php echo $index; ?>">
                    <div class="project-image">
                        <?php if ($project['image_path']): ?>
                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo sanitize($project['image_path']); ?>" alt="<?php echo sanitize($project['title']); ?>">
                        <?php else: ?>
                            <div class="project-placeholder">
                                <svg viewBox="0 0 200 200" fill="none">
                                    <rect width="200" height="200" fill="rgba(57, 255, 20, 0.1)"/>
                                    <text x="100" y="100" text-anchor="middle" fill="#39ff14" font-size="48">&#x276F;</text>
                                </svg>
                            </div>
                        <?php endif; ?>
                        <div class="project-overlay">
                            <div class="project-tags">
                                <?php
                                $techs = explode(',', $project['technologies']);
                                foreach (array_slice($techs, 0, 3) as $tech):
                                ?>
                                    <span class="tag"><?php echo trim(sanitize($tech)); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title"><?php echo sanitize($project['title']); ?></h3>
                        <p class="project-description"><?php echo sanitize($project['description']); ?></p>
                        <div class="project-links">
                            <?php if ($project['github_url']): ?>
                            <a href="<?php echo sanitize($project['github_url']); ?>" target="_blank" class="project-link">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 0C4.477 0 0 4.477 0 10c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.463-1.11-1.463-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0110 4.836c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C17.137 18.165 20 14.418 20 10c0-5.523-4.477-10-10-10z"/>
                                </svg>
                                GitHub
                            </a>
                            <?php endif; ?>
                            <?php if ($project['demo_url']): ?>
                            <a href="<?php echo sanitize($project['demo_url']); ?>" target="_blank" class="project-link">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                    <path d="M10 3C5 3 1 10 1 10s4 7 9 7 9-7 9-7-4-7-9-7z"/>
                                    <circle cx="10" cy="10" r="3"/>
                                </svg>
                                Live Demo
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php if ($projectsCount > 6): ?>
            <div class="show-more-container">
                <div class="show-more-line"></div>
                <button type="button" id="showMoreProjects" class="show-more-btn">
                    <span class="show-more-text">Show More</span>
                    <svg class="show-more-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="show-more-line"></div>
            </div>
            <script>const allProjectsData = <?php echo json_encode($allProjects); ?>;</script>
            <?php endif; ?>
        </div>
    </section>

    <section id="certificates" class="certificates-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">CREDENTIALS</span>
                <h2 class="section-title">Certifications</h2>
                <p class="section-description">Industry-recognized credentials and professional certifications</p>
            </div>
            <div class="certificates-grid" id="certificatesGrid">
                <?php foreach ($certificates as $index => $cert): ?>
                <div class="certificate-card" data-index="<?php echo $index; ?>">
                    <div class="cert-badge">
                        <?php if (!empty($cert['image_path'])): ?>
                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo sanitize($cert['image_path']); ?>" alt="<?php echo sanitize($cert['title']); ?>" class="cert-image">
                        <?php else: ?>
                            <svg viewBox="0 0 100 100" fill="none">
                                <circle cx="50" cy="50" r="40" stroke="#39ff14" stroke-width="2"/>
                                <path d="M35 50 L45 60 L65 40" stroke="#39ff14" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="cert-content">
                        <h3 class="cert-title"><?php echo sanitize($cert['title']); ?></h3>
                        <p class="cert-issuer"><?php echo sanitize($cert['issuer']); ?></p>
                        <div class="cert-meta">
                            <span class="cert-date"><?php echo date('M Y', strtotime($cert['issue_date'])); ?></span>
                            <?php if ($cert['credential_id']): ?>
                            <span class="cert-id">ID: <?php echo sanitize($cert['credential_id']); ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="cert-category"><?php echo sanitize($cert['category']); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php if ($certificatesCount > 6): ?>
            <div class="show-more-container">
                <div class="show-more-line"></div>
                <button type="button" id="showMoreCertificates" class="show-more-btn">
                    <span class="show-more-text">Show More</span>
                    <svg class="show-more-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="show-more-line"></div>
            </div>
            <script>const allCertificatesData = <?php echo json_encode($allCertificates); ?>;</script>
            <?php endif; ?>
        </div>
    </section>

    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">GET IN TOUCH</span>
                <h2 class="section-title">Contact Me</h2>
                <p class="section-description">Let's collaborate on your next project</p>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="info-card highlight-card">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3>Email</h3>
                        <p><a href="mailto:bilal.lbien@usmba.ac.ma">bilal.lbien@usmba.ac.ma</a></p>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                            </svg>
                        </div>
                        <h3>Phone</h3>
                        <p><a href="tel:+212630387509">+212 6 30 38 75 09</a></p>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22"/>
                            </svg>
                        </div>
                        <h3>GitHub</h3>
                        <p><a href="https://github.com/b1l4l-sec" target="_blank">github.com/b1l4l-sec</a></p>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                                <rect x="2" y="9" width="4" height="12"/>
                                <circle cx="4" cy="4" r="2"/>
                            </svg>
                        </div>
                        <h3>LinkedIn</h3>
                        <p><a href="https://www.linkedin.com/in/bilal-lbien-5752b5237" target="_blank">Bilal Lbien</a></p>
                    </div>
                    <?php
                    // Check if resume exists
                    $resumePath = 'uploads/resume.pdf';
                    if (file_exists($resumePath)):
                    ?>
                    <div class="info-card resume-card">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </div>
                        <h3>My Resume</h3>
                        <a href="<?php echo BASE_URL; ?>uploads/resume.pdf" class="btn btn-primary btn-sm" download>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            Download CV
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="contact-form-wrapper">
                    <div class="terminal-header">
                        <div class="terminal-dots">
                            <span class="dot red"></span>
                            <span class="dot yellow"></span>
                            <span class="dot green"></span>
                        </div>
                        <span class="terminal-title">contact@bilal ~ message</span>
                    </div>
                    <form id="contactForm" class="contact-form" method="POST" action="<?php echo BASE_URL; ?>contact.php">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label>How did you find me?</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="found_via" value="Social Media" required>
                                <span class="radio-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                                    </svg>
                                </span>
                                <span class="radio-text">Social Media</span>
                                <span class="radio-check"></span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="found_via" value="GitHub">
                                <span class="radio-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.44 9.8 8.2 11.38.6.11.82-.26.82-.58v-2.03c-3.34.73-4.04-1.61-4.04-1.61-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.73.08-.73 1.2.08 1.84 1.24 1.84 1.24 1.07 1.84 2.81 1.31 3.49 1 .11-.78.42-1.31.76-1.61-2.67-.3-5.47-1.33-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.13-.3-.54-1.52.12-3.18 0 0 1-.32 3.3 1.23a11.5 11.5 0 0 1 6 0c2.3-1.55 3.3-1.23 3.3-1.23.66 1.66.25 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.8 5.63-5.48 5.92.43.37.81 1.1.81 2.22v3.29c0 .32.22.7.82.58C20.56 21.8 24 17.3 24 12c0-6.63-5.37-12-12-12z"/>
                                    </svg>
                                </span>
                                <span class="radio-text">GitHub</span>
                                <span class="radio-check"></span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="found_via" value="Referral">
                                <span class="radio-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </span>
                                <span class="radio-text">Referral</span>
                                <span class="radio-check"></span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="found_via" value="Search Engine">
                                <span class="radio-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"/>
                                        <path d="M21 21l-4.35-4.35"/>
                                    </svg>
                                </span>
                                <span class="radio-text">Search</span>
                                <span class="radio-check"></span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="found_via" value="Other">
                                <span class="radio-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                                    </svg>
                                </span>
                                <span class="radio-text">Other</span>
                                <span class="radio-check"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-submit">
                        <span>Send Message</span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M2 10L18 10M18 10L12 4M18 10L12 16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3>B1L4L</h3>
                    <p>Engineering Student at <a href="https://ensaf.ac.ma/" target="_blank">ENSA of Fez</a></p>
                </div>
                <div class="footer-links">
                    <a href="#home">Home</a>
                    <a href="#skills">Skills</a>
                    <a href="#projects">Projects</a>
                    <a href="#certificates">Certificates</a>
                    <a href="#contact">Contact</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Bilal Lbien. All rights reserved.</p>
                <p class="footer-tag">Powered by innovation and caffeine</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>
