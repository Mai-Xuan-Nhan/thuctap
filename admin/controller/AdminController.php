<?php
require_once __DIR__ . '/../model/ModuleModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AdminController {
  public function index() {
    $model = new ModuleModel();
    $modules = $model->getModules();

    $loader = new FilesystemLoader(__DIR__ . '/../view');
    $twig = new Environment($loader);

    echo $twig->render('dashboard.twig', ['modules' => $modules]);
  }

  public function update() {
    $model = new ModuleModel();
    $modules = $model->getModules();

    // Cập nhật theo dữ liệu POST
    foreach ($modules as &$m) {
      $m['enabled'] = isset($_POST['enabled'][$m['id']]);
      $m['order'] = isset($_POST['order'][$m['id']]) ? (int)$_POST['order'][$m['id']] : $m['order'];
    }

    $model->saveModules($modules);
    header("Location: index.php");
  }
}
