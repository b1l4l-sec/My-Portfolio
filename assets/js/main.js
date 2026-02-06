document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initThemeToggle();
    initTypingEffect();
    initScrollAnimations();
    initSkillsAnimation();
    initContactForm();
    initCounters();
    initSmoothScroll();
    initShowMore();
});

function initNavigation() {
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
        });
    }

    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
            if (navMenu && navToggle) {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
            }
        });
    });

    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        const isLightTheme = document.body.classList.contains('light-theme');
        if (window.scrollY > 100) {
            navbar.style.background = isLightTheme ? 'rgba(245, 245, 245, 0.98)' : 'rgba(10, 10, 10, 0.95)';
        } else {
            navbar.style.background = isLightTheme ? 'rgba(245, 245, 245, 0.9)' : 'rgba(10, 10, 10, 0.8)';
        }
    });
}

function initThemeToggle() {
    const themeToggle = document.querySelector('.theme-toggle');
    if (!themeToggle) return;
    
    // Check for saved theme preference
    const savedTheme = localStorage.getItem('portfolio-theme');
    if (savedTheme === 'light') {
        document.body.classList.add('light-theme');
    }
    
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('light-theme');
        
        // Save preference
        const isLight = document.body.classList.contains('light-theme');
        localStorage.setItem('portfolio-theme', isLight ? 'light' : 'dark');
        
        // Update navbar background
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 100) {
            navbar.style.background = isLight ? 'rgba(245, 245, 245, 0.98)' : 'rgba(10, 10, 10, 0.95)';
        } else {
            navbar.style.background = isLight ? 'rgba(245, 245, 245, 0.9)' : 'rgba(10, 10, 10, 0.8)';
        }
    });
}

function initTypingEffect() {
    const typedTextSpan = document.querySelector('.typed-text');
    if (!typedTextSpan) return;

    const textArray = [
        'Full-Stack Developer',
        'Cybersecurity Enthusiast',
        'Red Team Specialist',
        'IoT Security Engineer',
        '3D Artist & Modeler'
    ];
    const typingDelay = 100;
    const erasingDelay = 50;
    const newTextDelay = 2000;
    let textArrayIndex = 0;
    let charIndex = 0;

    function type() {
        if (charIndex < textArray[textArrayIndex].length) {
            typedTextSpan.textContent += textArray[textArrayIndex].charAt(charIndex);
            charIndex++;
            setTimeout(type, typingDelay);
        } else {
            setTimeout(erase, newTextDelay);
        }
    }

    function erase() {
        if (charIndex > 0) {
            typedTextSpan.textContent = textArray[textArrayIndex].substring(0, charIndex - 1);
            charIndex--;
            setTimeout(erase, erasingDelay);
        } else {
            textArrayIndex++;
            if (textArrayIndex >= textArray.length) textArrayIndex = 0;
            setTimeout(type, typingDelay + 500);
        }
    }

    setTimeout(type, newTextDelay + 250);
}

function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    const animateElements = document.querySelectorAll('.skill-card, .project-card, .certificate-card');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

function initSkillsAnimation() {
    const progressBars = document.querySelectorAll('.progress-fill');

    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressValue = entry.target.getAttribute('data-progress');
                entry.target.style.width = progressValue + '%';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    progressBars.forEach(bar => observer.observe(bar));
}

function initContactForm() {
    const contactForm = document.getElementById('contactForm');
    if (!contactForm) return;

    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(contactForm);
        const submitButton = contactForm.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;

        submitButton.disabled = true;
        submitButton.innerHTML = '<span>Sending...</span>';

        try {
            // Use BASE_URL if available, otherwise fallback to relative path
            const baseUrl = typeof BASE_URL !== 'undefined' ? BASE_URL : '';
            const response = await fetch(baseUrl + 'contact', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showNotification('Message sent successfully! I will get back to you soon.', 'success');
                contactForm.reset();
            } else {
                // Show specific validation errors if available
                let errorMessage = data.message || 'Failed to send message. Please try again.';
                if (data.errors && data.errors.length > 0) {
                    errorMessage = data.errors.join(', ');
                }
                showNotification(errorMessage, 'error');
            }
        } catch (error) {
            showNotification('An error occurred. Please try again later.', 'error');
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        }
    });
}

function showNotification(message, type) {
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? 'rgba(127, 255, 0, 0.2)' : 'rgba(255, 68, 68, 0.2)'};
        border: 1px solid ${type === 'success' ? '#7fff00' : '#ff4444'};
        border-radius: 0.5rem;
        color: ${type === 'success' ? '#7fff00' : '#ff6666'};
        backdrop-filter: blur(20px);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        max-width: 400px;
    `;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

function initCounters() {
    const counters = document.querySelectorAll('.stat-number');

    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.getAttribute('data-target'));
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        entry.target.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        entry.target.textContent = target;
                    }
                };

                updateCounter();
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));
}

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;

            e.preventDefault();
            const target = document.querySelector(href);

            if (target) {
                const offsetTop = target.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

function initShowMore() {
    // Show More/Less Certificates
    const showMoreCertificatesBtn = document.getElementById('showMoreCertificates');
    if (showMoreCertificatesBtn && typeof allCertificatesData !== 'undefined') {
        const certificatesGrid = document.getElementById('certificatesGrid');
        let isExpanded = false;
        
        showMoreCertificatesBtn.addEventListener('click', (e) => {
            e.preventDefault();
            
            if (!isExpanded) {
                // Show more
                const remaining = allCertificatesData.slice(6);
                
                remaining.forEach((cert, index) => {
                    const certCard = createCertificateCard(cert, 6 + index);
                    certCard.classList.add('extra-item');
                    certificatesGrid.appendChild(certCard);
                    
                    setTimeout(() => {
                        certCard.style.opacity = '1';
                        certCard.style.transform = 'translateY(0)';
                    }, 40 * index);
                });
                
                showMoreCertificatesBtn.querySelector('.show-more-text').textContent = 'Show Less';
                showMoreCertificatesBtn.classList.add('expanded');
                isExpanded = true;
            } else {
                // Show less
                const extraItems = certificatesGrid.querySelectorAll('.extra-item');
                extraItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(-10px)';
                    }, 30 * index);
                });
                
                setTimeout(() => {
                    extraItems.forEach(item => item.remove());
                }, 30 * extraItems.length + 200);
                
                showMoreCertificatesBtn.querySelector('.show-more-text').textContent = 'Show More';
                showMoreCertificatesBtn.classList.remove('expanded');
                isExpanded = false;
            }
        });
    }
    
    // Show More/Less Projects
    const showMoreProjectsBtn = document.getElementById('showMoreProjects');
    if (showMoreProjectsBtn && typeof allProjectsData !== 'undefined') {
        const projectsGrid = document.getElementById('projectsGrid');
        let isExpanded = false;
        
        showMoreProjectsBtn.addEventListener('click', (e) => {
            e.preventDefault();
            
            if (!isExpanded) {
                // Show more
                const remaining = allProjectsData.slice(6);
                
                remaining.forEach((project, index) => {
                    const projectCard = createProjectCard(project, 6 + index);
                    projectCard.classList.add('extra-item');
                    projectsGrid.appendChild(projectCard);
                    
                    setTimeout(() => {
                        projectCard.style.opacity = '1';
                        projectCard.style.transform = 'translateY(0)';
                    }, 40 * index);
                });
                
                showMoreProjectsBtn.querySelector('.show-more-text').textContent = 'Show Less';
                showMoreProjectsBtn.classList.add('expanded');
                isExpanded = true;
            } else {
                // Show less
                const extraItems = projectsGrid.querySelectorAll('.extra-item');
                extraItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(-10px)';
                    }, 30 * index);
                });
                
                setTimeout(() => {
                    extraItems.forEach(item => item.remove());
                }, 30 * extraItems.length + 200);
                
                showMoreProjectsBtn.querySelector('.show-more-text').textContent = 'Show More';
                showMoreProjectsBtn.classList.remove('expanded');
                isExpanded = false;
            }
        });
    }
}

function createCertificateCard(cert, index) {
    const card = document.createElement('div');
    card.className = 'certificate-card';
    card.dataset.index = index;
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    
    const imageHtml = cert.image_path 
        ? `<img src="${BASE_URL}uploads/${escapeHtml(cert.image_path)}" alt="${escapeHtml(cert.title)}" class="cert-image">`
        : `<svg viewBox="0 0 100 100" fill="none">
            <circle cx="50" cy="50" r="40" stroke="#39ff14" stroke-width="2"/>
            <path d="M35 50 L45 60 L65 40" stroke="#39ff14" stroke-width="3" stroke-linecap="round"/>
           </svg>`;
    
    const issueDate = new Date(cert.issue_date);
    const formattedDate = issueDate.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    
    const credentialIdHtml = cert.credential_id 
        ? `<span class="cert-id">ID: ${escapeHtml(cert.credential_id)}</span>` 
        : '';
    
    card.innerHTML = `
        <div class="cert-badge">
            ${imageHtml}
        </div>
        <div class="cert-content">
            <h3 class="cert-title">${escapeHtml(cert.title)}</h3>
            <p class="cert-issuer">${escapeHtml(cert.issuer)}</p>
            <div class="cert-meta">
                <span class="cert-date">${formattedDate}</span>
                ${credentialIdHtml}
            </div>
            <span class="cert-category">${escapeHtml(cert.category)}</span>
        </div>
    `;
    
    return card;
}

function createProjectCard(project, index) {
    const card = document.createElement('div');
    card.className = 'project-card';
    card.dataset.index = index;
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    
    const imageHtml = project.image_path 
        ? `<img src="${BASE_URL}uploads/${escapeHtml(project.image_path)}" alt="${escapeHtml(project.title)}">`
        : `<div class="project-placeholder">
            <svg viewBox="0 0 200 200" fill="none">
                <rect width="200" height="200" fill="rgba(57, 255, 20, 0.1)"/>
                <text x="100" y="100" text-anchor="middle" fill="#39ff14" font-size="48">❯</text>
            </svg>
           </div>`;
    
    const techs = project.technologies ? project.technologies.split(',').slice(0, 3) : [];
    const techTagsHtml = techs.map(tech => `<span class="tag">${escapeHtml(tech.trim())}</span>`).join('');
    
    const githubLinkHtml = project.github_url 
        ? `<a href="${escapeHtml(project.github_url)}" target="_blank" class="project-link">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 0C4.477 0 0 4.477 0 10c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.463-1.11-1.463-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0110 4.836c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C17.137 18.165 20 14.418 20 10c0-5.523-4.477-10-10-10z"/>
            </svg>
            GitHub
           </a>` 
        : '';
    
    const demoLinkHtml = project.demo_url 
        ? `<a href="${escapeHtml(project.demo_url)}" target="_blank" class="project-link">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                <path d="M10 3C5 3 1 10 1 10s4 7 9 7 9-7 9-7-4-7-9-7z"/>
                <circle cx="10" cy="10" r="3"/>
            </svg>
            Live Demo
           </a>` 
        : '';
    
    card.innerHTML = `
        <div class="project-image">
            ${imageHtml}
            <div class="project-overlay">
                <div class="project-tags">
                    ${techTagsHtml}
                </div>
            </div>
        </div>
        <div class="project-content">
            <h3 class="project-title">${escapeHtml(project.title)}</h3>
            <p class="project-description">${escapeHtml(project.description)}</p>
            <div class="project-links">
                ${githubLinkHtml}
                ${demoLinkHtml}
            </div>
        </div>
    `;
    
    return card;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

const sidebarToggle = document.getElementById('sidebarToggle');
if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
        const sidebar = document.querySelector('.admin-sidebar');
        sidebar.classList.toggle('active');
    });
}
