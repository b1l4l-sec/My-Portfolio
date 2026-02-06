<?php
require_once '../config/config.php';
require_once '../includes/functions.php';

session_destroy();
flashMessage('You have been logged out successfully.', 'success');
redirect(BASE_URL . 'admin/login');

