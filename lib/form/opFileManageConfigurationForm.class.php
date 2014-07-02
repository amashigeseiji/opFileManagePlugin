<?php

/**
 * opFileManagePluginConfigurationForm
 *
 * @package    OpenPNE
 * @subpackage opFileManagePlugin
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opFileManagePluginConfigurationForm extends BaseForm
{
  public function configure()
  {
    $widgetsConfig = sfConfig::get('app_opFileManagePluginWidgets');
    foreach ($widgetsConfig as $widget => $value)
    {
      $this->setWidget($widget, new $value['widget']($value['widgetOptions']));
      $this->setValidator($widget, new $value['validator']($value['validatorOptions']));
      $this->setDefault($widget, Doctrine::getTable('SnsConfig')->get('op_file_manage_plugin_'.$widget, $value['default']));
    }

    $this->widgetSchema->setNameFormat('op_file_manage_plugin[%s]');
  }

  public function save()
  {
    $names = array_keys(sfConfig::get('app_opFileManagePluginWidgets'));
    foreach ($names as $name)
    {
      Doctrine::getTable('SnsConfig')->set('op_file_manage_plugin_'.$name, $this->getValue($name));
    }
  }
}
