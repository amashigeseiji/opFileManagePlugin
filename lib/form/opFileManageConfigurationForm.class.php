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
    $widgetsConfig = opFileManageConfig::getFormConfig()->getAll();
    $this->generateWidgets($widgetsConfig);

    $this->widgetSchema->setNameFormat('op_file_manage_plugin[%s]');
  }

  public function save()
  {
    $names = opFileManageConfig::getNames();
    foreach ($names as $name)
    {
      opFileManageConfig::set($name, $this->getValue($name));
    }
  }

  private function generateWidgets($widgetsConfig)
  {
    foreach ($widgetsConfig as $widget => $value)
    {
      $this->setWidget($widget, new $value['widget']($value['widgetOptions']));
      $this->setValidator($widget, new $value['validator']($value['validatorOptions']));
      $this->setDefault($widget, Doctrine::getTable('SnsConfig')->get('op_file_manage_plugin_'.$widget, $value['default']));
    }
  }
}
