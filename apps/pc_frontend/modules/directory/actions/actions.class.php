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

 /**
  * Executes show action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->directory = $this->getRoute()->getObject();
    $this->forward404If(!$this->directory->isViewable());
    $this->files = Doctrine::getTable('ManagedFile')
      ->getFileListByDirectoryId($this->directory->getId());
  }

 /**
  * Executes list action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeList(sfWebRequest $request)
  {
    $this->directories = Doctrine_Query::create()
      ->from('FileDirectory f')
      ->where('f.member_id = ?', $this->getUser()->getMemberId())
      ->execute();
  }

 /**
  * process form
  *
  * @param sfWebRequest $request A request object
  * @param sfForm $form A form object
  */
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
