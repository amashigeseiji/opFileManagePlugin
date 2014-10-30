<?php

/**
 * opFileManagePluginMigrationVersion1
 *
 * @package    opFileManagePlugin
 * @author     Seiji Amashige <tenjuu99@gmail.com>
 */
class opFileManagePluginMigrationVersion2 extends opMigration
{
  public function up()
  {
    $options = array('notnull' => true);
    $this->addColumn('managed_file', 'text', 'string', null, $options);
    $this->addColumn('file_directory', 'text', 'string', null, $options);
  }

  public function down()
  {
    $this->removeColumn('managed_file', 'text');
    $this->removeColumn('file_directory', 'text');
  }
}
