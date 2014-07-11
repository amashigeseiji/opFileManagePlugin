<?php

/**
 * opFileDirectoryValidatorSchema validates a FileDirectoryForm
 *
 * @package    OpenPNE
 * @subpackage validator
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opFileDirectoryValidatorSchema extends sfValidatorSchema
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addMessage('community_id', 'The community_id is required when type is community.');
  }

  protected function doClean($values)
  {
    $errorSchema = new sfValidatorErrorSchema($this);
    if ('community' === $values['type']
      && !$values['community_id'])
    {
      sfContext::getInstance()->getUser()->setFlash('error', $this->getMessage('community_id'));
      $errorSchema->addError(new sfValidatorError($this, 'required'), 'community_id');
    }

    if (!'community' === $values['type']
      && $values['community_id'])
    {
      unset($values['community_id']);
    }

    if(count($errorSchema))
    {
      throw new sfValidatorErrorSchema($this, $errorSchema);
    }

    return $values;
  }
}
