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
  public function executeFormModal()
  {
    $this->form = new FileDirectoryForm();
  }
}
