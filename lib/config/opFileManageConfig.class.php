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

  public static function get($key)
  {
    self::loadConfiguration();

    if (!self::has($key))
    {
      throw new Exception('Global configuration of opFileManagePlugin does not have '.$key);
    }

    $result = Doctrine::getTable('SnsConfig')->get(self::$tablePrefix.$key);

    return (is_null($result)) ? self::getDefault($key) : $result;
  }

  public static function set($key, $value)
  {
    self::loadConfiguration();

    if (!self::has($key))
    {
      throw new Exception('Global configuration of opFileManagePlugin does not have '.$key);
    }

    Doctrine::getTable('SnsConfig')->set(self::$tablePrefix.$key, $value);
  }

  private static function loadConfiguration()
  {
    if (!self::$isSetConfig)
    {
      self::$isSetConfig = true;

      self::$formConfig = new sfParameterHolder();
      self::$formConfig->add(sfConfig::get('app_opFileManagePluginWidgets'));
    }
  }

  public static function getFormConfig()
  {
    self::loadConfiguration();

    return self::$formConfig;
  }

  public static function getNames()
  {
    self::loadConfiguration();

    return self::$formConfig->getNames();
  }

  public static function getDefault($key)
  {
    self::loadConfiguration();

    $formConfig = self::$formConfig->get($key);

    return $formConfig['default'];
  }

  public static function has($key)
  {
    self::loadConfiguration();

    return (bool)self::$formConfig->has($key);
  }

  /**
   * @return bool
   */
  public static function isUsePrivate()
  {
    return (bool)self::get('use_private_directory');
  }

  /**
   * @return bool
   */
  public static function isUseCommunity()
  {
    return (bool)self::get('use_community_directory');
  }
}
