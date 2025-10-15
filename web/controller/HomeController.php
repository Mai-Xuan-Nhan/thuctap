<?php
require_once __DIR__ . '/../model/ModuleModel.php';
require_once __DIR__ . '/../model/CommentModel.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController {
  public function index() {
    $model = new ModuleModel();
    $modules = $model->getActiveModules();

    $commentModel = new CommentModel();

    // Nếu người dùng gửi comment
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['module_id'])) {
      $commentModel->addComment($_POST['module_id'], $_POST['author'], $_POST['text']);
      header("Location: " . $_SERVER['REQUEST_URI']);
      exit;
    }

    // Tăng lượt xem cho module1 (demo)
    $commentModel->incrementView('module1');
    $views = $commentModel->getViews('module1');
    $comments = $commentModel->getComments('module1');

    $loader = new FilesystemLoader(__DIR__ . '/../view');
    $twig = new Environment($loader);

    echo $twig->render('layout.twig', [
      'modules' => $modules,
      'views' => $views,
      'comments' => $comments
    ]);
  }
}
