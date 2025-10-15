<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/controller/AdminController.php';

$controller = new AdminController();
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if ($action === 'update') {
  $controller->update();
} else {
  $controller->index();
}
