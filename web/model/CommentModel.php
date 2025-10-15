<?php
class CommentModel {
  private $commentPath;
  private $viewPath;

  public function __construct() {
    $this->commentPath = __DIR__ . '/../../data/comments.json';
    $this->viewPath = __DIR__ . '/../../data/views.json';
  }

  private function readJson($path) {
    if (!file_exists($path)) return [];
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : [];
  }

  private function writeJson($path, $data) {
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  }

  // 💬 Lấy comment theo module ID
  public function getComments($moduleId) {
    $data = $this->readJson($this->commentPath);
    return isset($data[$moduleId]) ? $data[$moduleId] : [];
  }

  // 💬 Lưu comment mới
  public function addComment($moduleId, $author, $text) {
    $data = $this->readJson($this->commentPath);
    $data[$moduleId][] = [
      'author' => htmlspecialchars($author),
      'text' => htmlspecialchars($text),
      'time' => date('Y-m-d H:i:s')
    ];
    $this->writeJson($this->commentPath, $data);
  }

  // 👁️‍🗨️ Tăng lượt xem
  public function incrementView($moduleId) {
    $views = $this->readJson($this->viewPath);
    if (!isset($views[$moduleId])) $views[$moduleId] = 0;
    $views[$moduleId]++;
    $this->writeJson($this->viewPath, $views);
  }

  // 👁️‍🗨️ Lấy số view
  public function getViews($moduleId) {
    $views = $this->readJson($this->viewPath);
    return isset($views[$moduleId]) ? $views[$moduleId] : 0;
  }
}
