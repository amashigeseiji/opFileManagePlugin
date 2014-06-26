<?php

/**
 * directory components.
 *
 * @package    OpenPNE
 * @subpackage directory
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class directoryComponents extends sfcomponents
{
  public function executeDirectoryCreateModal()
  {
    $this->form = new FileDirectoryForm();
  }
}
