<?php
class ModuleModel {
  private $dataPath;

  public function __construct() {
    // In ra để kiểm tra xem PHP đang đọc ở đâu
    $this->dataPath = realpath(__DIR__ . '/../../data/modules.json');
  }

  public function getModules() {
    if (!$this->dataPath || !file_exists($this->dataPath)) {
      echo "<p style='color:red;'>❌ Không tìm thấy file modules.json!</p>";
      return [];
    }

    $json = file_get_contents($this->dataPath);
    return json_decode($json, true);
  }

  public function getActiveModules() {
    $modules = $this->getModules();

    // Nếu file JSON bị lỗi hoặc rỗng
    if (!is_array($modules)) {
      return [];
    }

    // Lọc các module đang bật
    $active = array_filter($modules, function($m) {
      return isset($m['enabled']) && $m['enabled'];
    });

    // Sắp xếp theo thứ tự order (tương thích PHP cũ)
    usort($active, function($a, $b) {
      if ($a['order'] == $b['order']) return 0;
      return ($a['order'] < $b['order']) ? -1 : 1;
    });

    return $active;
  }
}
