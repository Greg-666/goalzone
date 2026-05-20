<?php
require_once 'includes/header.php';
require_once 'includes/auth.php';

deconnecter_utilisateur();

header('Location: /index.php');
exit;