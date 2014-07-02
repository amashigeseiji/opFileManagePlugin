<?php
class opFileManageConfig
{
  static private
    $isSetConfig = false,
    $tablePrefix = 'op_file_manage_plugin_',

    /**
     * sfParameterHolder
     */
    $formConfig;

  public function get($key)
  {
    self::loadConfiguration();

    if (!self::has($key))
    {
      throw new Exception('Global configuration of opFileManagePlugin does not have '.$key);
    }

    $result = Doctrine::getTable('SnsConfig')->get(self::$tablePrefix.$key);

    return (is_null($result)) ? self::getDefault($key) : $result;
  }

  public function set($key, $value)
  {
    self::loadConfiguration();

    if (!self::has($key))
    {
      throw new Exception('Global configuration of opFileManagePlugin does not have '.$key);
    }

    Doctrine::getTable('SnsConfig')->set(self::$tablePrefix.$key, $value);
  }

  private function loadConfiguration()
  {
    if (!self::$isSetConfig)
    {
      self::$isSetConfig = true;

      self::$formConfig = new sfParameterHolder();
      self::$formConfig->add(sfConfig::get('app_opFileManagePluginWidgets'));
    }
  }

  public function getFormConfig()
  {
    self::loadConfiguration();

    return self::$formConfig;
  }

  public function getNames()
  {
    self::loadConfiguration();

    return self::$formConfig->getNames();
  }

  public function getDefault($key)
  {
    self::loadConfiguration();

    $formConfig = self::$formConfig->get($key);

    return $formConfig['default'];
  }

  public function has($key)
  {
    self::loadConfiguration();

    return (bool)self::$formConfig->has($key);
  }
}
