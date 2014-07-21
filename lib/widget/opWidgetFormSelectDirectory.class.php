<?php

/**
 * opWidgetFormSelectDirectory represents a community widget.
 *
 * @package    OpenPNE
 * @subpackage widget
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opWidgetFormSelectDirectory extends sfWidgetFormSelect
{
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
      $options[] = $this->renderContentTag('option', self::escapeOnce($option['name']), $attribute);
    }

    return $options;
  }
}
