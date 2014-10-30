<?php

/**
 * opWidgetFormSelectDirectory represents a community widget.
 *
 * @package    OpenPNE
 * @subpackage widget
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opWidgetFormSelectDirectory extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('type', $options['type']);
    $this->addOption('selected', $options['selected']);

    if ('member_directory' === $options['type'])
    {
      $this->addOption('member_id', $options['member_id']);
    }
    else if ('community_directory' === $options['type'])
    {
      $this->addOption('community_id', $options['community_id']);
    }
    else if ('directory' === $options['type'])
    {
      $this->addOption('directory_id', $options['directory_id']);
      $this->setHidden(true);
      $this->setDefault($options['directory_id']);
    }
    else
    {
      throw new Exception('opWidgetFormSelectDirectory: type is undefined.');
    }
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if ($this->isHidden())
    {
      $attributes['type'] = 'hidden';
      $attributes['value'] = $this->getDefault();

      $tag = 'input';
      $content = null;
    }
    else
    {
      $tag = 'select';
      $content = "\n".implode("\n", $this->getOptionsForSelect())."\n";
    }

    $attributes['name'] = $name;

    return $this->renderContentTag($tag, $content, $attributes);
  }

  protected function getOptionsForSelect()
  {
    $options = array();
    $choices = $this->getChoices();
    foreach ($choices as $key => $option)
    {
      $attribute = array('value' => self::escapeOnce($option['id']));
      if ($option['id'] === $this->getOption('selected'))
      {
        array_push($attribute['selected'] = true);
      }
      $options[] = $this->renderContentTag('option', self::escapeOnce($option['name']), $attribute);
    }

    return $options;
  }

  protected function getChoices()
  {
    if ('member_directory' === $this->getOption('type'))
    {
      $types = array('public');
      if (opFileManageConfig::isUsePrivate())
      {
        $types[] = 'private';
      }

      $q = FileDirectoryQuery::getListQueryByMemberId($this->getOption('member_id'), $types);
    }
    else if ('community_directory' === $this->getOption('type'))
    {
      $q = FileDirectoryQuery::getListQueryByCommunityId($this->getOption('community_id'));
    }
    else
    {
      throw new Exception();
    }

    $results = $q->select('id, name')
      ->fetchArray();

    return $results;
  }
}
