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

    $this->postSave();
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

  private function postSave()
  {
    $navigationYml = sfYaml::load(sfConfig::get('sf_root_dir').'/plugins/opFileManagePlugin/data/fixtures/020_navigation.yml');
    $nav =& $navigationYml['Navigation'];

    $directory =& $nav['directory_navigation'];
    $fileGlobal =& $nav['file_global_navigation'];
    $friendDirectory =& $nav['friend_directory_navigation'];
    $friendFile =& $nav['friend_file_navigation'];
    $communityFile =& $nav['community_file_navigation'];
    $communityDirectory =& $nav['community_directory_navigation'];

    if(!opFileManageConfig::isUsePublic())
    {
      $this->deleteNavigation(array($fileGlobal, $friendDirectory, $friendFile));
    }
    else
    {
      $this->setNavigation($fileGlobal);
      $this->setNavigation($friendDirectory);
      $this->setNavigation($friendFile);
    }

    if (!opFileManageConfig::isUsePublic() and !opFileManageConfig::isUsePrivate())
    {
      $this->deleteNavigation(array($directory));
    }
    else
    {
      $this->setNavigation($directory);
    }

    if (!opFileManageConfig::isUseCommunity())
    {
      $this->deleteNavigation(array($communityFile, $communityDirectory));
    }
    else
    {
      $this->setNavigation($communityFile);
      $this->setNavigation($communityDirectory);
    }

    opToolkit::clearCache();
  }

  private function setNavigation(array $data)
  {
    if (!Doctrine::getTable('Navigation')->findOneByTypeAndUri($data['type'], $data['uri']))
    {
      $nav = new Navigation();
      $nav->setType($data['type']);
      $nav->setUri($data['uri']);
      $nav->setSortOrder($data['sort_order']);
      $nav->setCaption($data['Translation']['en']['caption'], 'en');
      $nav->setCaption($data['Translation']['ja_JP']['caption'], 'ja_JP');
      $nav->save();
    }
  }

  private function deleteNavigation(array $arrays)
  {
    $q = Doctrine::getTable('Navigation')->createQuery()
      ->delete();

    foreach ($arrays as $data)
    {
      $q->orWhere('(type = ? AND uri = ?)', array($data['type'], $data['uri']));
    }

    $q->execute();
  }
}
