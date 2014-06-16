<?php

/**
 * directory actions.
 *
 * @package    OpenPNE
 * @subpackage directory
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class directoryActions extends sfActions
{
 /**
  * Executes create action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new FileDirectoryForm();
    $this->form->getObject()->member_id = $this->getUser()->getMemberId();

    if ($request->isMethod('POST'))
    {
      $this->processForm($request, $this->form);
    }
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->directory = Doctrine::getTable('FileDirectory')->find($request['id']);
    $this->forward404If(!$this->directory);
  }

  public function executeList(sfWebRequest $request)
  {
    $this->directories = Doctrine_Query::create()
      ->from('FileDirectory f')
      ->where('f.member_id = ?', $this->getUser()->getMemberId())
      ->execute();
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind(
      $request->getParameter($form->getName())
    );

    if ($form->isValid())
    {
      $directory = $form->save();

      $this->redirect('directory/list?id='.$directory->getId());
    }
  }
}
