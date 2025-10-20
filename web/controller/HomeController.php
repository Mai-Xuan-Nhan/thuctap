<?php
require_once __DIR__ . '/../model/ModuleModel.php';
require_once __DIR__ . '/../model/CommentModel.php';
require_once __DIR__ . '/../../config/captcha.php';
require_once __DIR__ . '/../lib/CaptchaVerifier.php';

use lib\CaptchaVerifier;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController {
  public function index() {
    $model = new ModuleModel();
    $modules = $model->getActiveModules();

    $commentModel = new CommentModel();

    // load captcha config (file trả về array)
    $captchaConfig = require __DIR__ . '/../../config/captcha.php';
    $captcha = $captchaConfig; // truyền vào view

    $verifier = new CaptchaVerifier($captchaConfig);

    // Nếu người dùng gửi comment
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['module_id'])) {
      // 1) verify captcha
      $remoteIp = $_SERVER['REMOTE_ADDR'] ?? null;
      $ok = $verifier->verify($_POST, $remoteIp);

      if (!$ok) {
        // captcha thất bại -> đưa thông báo (bạn có thể render lỗi lên trang)
        $loader = new FilesystemLoader(__DIR__ . '/../view');
        $twig = new Environment($loader);
        echo $twig->render('layout.twig', [
          'modules' => $modules,
          'views' => $commentModel->getViews('module1'),
          'comments' => $commentModel->getComments('module1'),
          'captcha' => $captcha,
          'error' => 'Xác thực CAPTCHA thất bại. Vui lòng thử lại.'
        ]);
        return;
      }

      // 2) khi captcha OK -> lưu comment
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
      'comments' => $comments,
      'captcha' => $captcha
    ]);
  }
}
