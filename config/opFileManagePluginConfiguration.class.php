<?php
class opFileManagePluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    $this->dispatcher->connect('op_action.pre_execute', array($this, 'addSmartphoneHelper'));
  }

  public function addSmartphoneHelper()
  {
    $context = sfContext::getInstance();
    $request = $context->getRequest();
    $moduleName = $context->getModuleName();
    if ($request->isSmartphone() && ('directory' === $moduleName || 'file' === $moduleName))
    {
      $context->getConfiguration()->loadHelpers(array('opAsset'));
      $context->getResponse()->addSmtStylesheet('/opFileManagePlugin/css/smt');
    }
  }
}
