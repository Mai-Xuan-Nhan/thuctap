<?php
class ModuleModel {
  private $dataPath;

  public function __construct() {
    $this->dataPath = realpath(__DIR__ . '/../../data/modules.json');
  }

  public function getModules() {
    if (!file_exists($this->dataPath)) return [];
    $json = file_get_contents($this->dataPath);
    return json_decode($json, true);
  }

  public function saveModules($modules) {
    file_put_contents($this->dataPath, json_encode($modules, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  }
}
