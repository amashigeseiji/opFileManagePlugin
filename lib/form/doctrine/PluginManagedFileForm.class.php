<?php

/**
 * PluginManagedFile form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
abstract class PluginManagedFileForm extends BaseManagedFileForm
{
  public function setup()
  {
    parent::setup();

    unset(
      $this['member_id'], $this['file_id'],
      $this['directory_id'],
      $this['created_at'], $this['updated_at']
    );

    $this->widgetSchema['name'] = new sfWidgetFormInput();
    $this->widgetSchema['file'] = new sfWidgetFormInputFile();
    $this->validatorSchema['file'] = new sfValidatorFile(array('required' => true));
  }

  public function save()
  {
    $file = new File();
    $file->setFromValidatedFile($this->getValue('file'));

    $this->getObject()->setFile($file);
    $this->getObject()->setMemberId(sfContext::getInstance()->getuser()->getMemberId());
    $this->getObject()->setDirectoryId($this->getOption('directory')->getId());

    return parent::save();
  }
}
