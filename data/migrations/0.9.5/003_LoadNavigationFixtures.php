<?php

/**
 * opFileManagePluginMigrationVersion3
 *
 * @package    opFileManagePlugin
 * @author     Seiji Amashige <tenjuu99@gmail.com>
 */
class opFileManagePluginMigrationVersion3 extends opMigration
{
  public function migrate($direction)
  {
    $navigations = array(
      array('type' => 'secure_global', 'uri' => '@file_index'),
      array('type' => 'default', 'uri' => '@directory_list'),
      array('type' => 'community', 'uri' => 'directory/listCommunity'),
      array('type' => 'community', 'uri' => 'file/listCommunity'),
      array('type' => 'friend', 'uri' => '@file_list_member'),
      array('type' => 'friend', 'uri' => '@directory_list_member'),
    );

    foreach ($navigations as $navigation)
    {
      Doctrine_Query::create()->delete('navigation')
        ->where('type = ?', $navigation['type'])
        ->andWhere('uri = ?', $navigation['uri'])
        ->execute();
    }
  }
}
