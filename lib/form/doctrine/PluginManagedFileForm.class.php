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
      $this['name'],
      $this['created_at'], $this['updated_at']
    );

    if (!$this->getOption('directoryChoices'))
    {
      throw new Exception('The directory choices are not specified.');
    }

    $this->widgetSchema['directory_id'] = new opWidgetFormSelectDirectory(array('choices' => $this->getOption('directoryChoices')));
    $this->validatorSchema['directory_id'] = new opValidatorDirectory(array('required' => true));

    $this->widgetSchema['file'] = new sfWidgetFormInputFile();
    $this->validatorSchema['file'] = new sfValidatorFile(array('required' => true));
    $this->widgetSchema{'file'}->setLabel('File name');
  }

  public function save()
  {
    $file = new File();
    $file->setFromValidatedFile($this->getValue('file'));
    if (!$this->getObject()->getName())
    {
      $this->getObject()->setName($file->getOriginalFilename());
    }

    $this->getObject()->setFile($file);

    return parent::save();
  }
}
