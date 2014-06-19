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

    if ($request->isMethod('POST'))
    {
      $directory = $this->processForm($request, $this->form);

      $this->redirect('@directory_show?id='.$directory->getId());
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
  * Executes publish action
  *
  * @param sfWebRequest $request A request object
  */
  public function executePublish(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $directory = $this->getRoute()->getObject();
    $this->forward404If(!$directory->isAuthor());
    $directory->publish($request['private'] ? false : true);

    $this->redirect('@directory_show?id='.$directory->getId());
  }

 /**
  * Executes edit action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeEdit(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $directory = $this->getRoute()->getObject();
    $this->forward404If(!$directory->isAuthor());
    $this->forward404If(!$request->getParameter('name'));
    $directory->modifyName($request['name']);

    $this->redirect('@directory_show?id='.$directory->getId());
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
      return $form->save();
    }
  }
}
