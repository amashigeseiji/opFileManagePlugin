<?php

/**
 * opFileManagePlugin actions.
 *
 * @package    OpenPNE
 * @subpackage opFileManagePlugin
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class opFileManagePluginActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new opFileManagePluginConfigurationForm();

    if ($request->isMethod(sfRequest::POST))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $this->form->save();

        $this->getUser()->setFlash('notice', 'Saved configuration successfully.');

        $this->redirect('opFileManagePlugin/index');
      }
    }
  }
}
