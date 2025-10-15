<?php
require_once __DIR__ . '/../vendor/autoload.php';

$url = isset($_GET['url']) ? $_GET['url'] : 'web';
$parts = explode('/', $url);

if ($parts[0] === 'admin') {
  require_once __DIR__ . '/../admin/index.php';
} elseif ($parts[0] === 'api') {
  require_once __DIR__ . '/../api/module_api.php';
} else {
  require_once __DIR__ . '/../web/index.php';
}
