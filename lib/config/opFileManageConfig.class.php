<?php
class opFileManageConfig
{
  static private
    $isSetConfig = false,
    $config = array();

  public function get($key)
  {
    if (!self::$isSetConfig)
    {
      self::setConfiguration();
    }

    return self::$config[$key];
  }

  private function setConfiguration()
  {
    self::$isSetConfig = true;

    $snsConfig = Doctrine::getTable('SnsConfig');
    $tablePrefix = 'op_file_manage_plugin_';
    $widgets = array_keys(sfConfig::get('app_opFileManagePluginWidgets'));
    foreach ($widgets as $widget)
    {
      self::$config[$widget] = $snsConfig->get($tablePrefix.$widget);
    }
  }
}
