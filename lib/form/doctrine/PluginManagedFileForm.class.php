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

    $options = array('type' => $this->getOption('type'));
    if ('member_directory' === $options['type'])
    {
      $options['member_id'] = $this->getOption('member_id');
    }
    else if ('community_directory' === $options['type'])
    {
      $options['community_id'] = $this->getOption('community_id');
    }
    else if ('directory' === $options['type'])
    {
      $options['directory_id'] = $this->getOption('directory_id');
    }

    $this->widgetSchema['directory_id'] = new opWidgetFormSelectDirectory($options);
    $this->validatorSchema['directory_id'] = new opValidatorDirectory(array(
      'required' => true,
      'privilege' => 'upload',
      'member' => sfContext::getInstance()->getUser()->getMember()
    ));

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
