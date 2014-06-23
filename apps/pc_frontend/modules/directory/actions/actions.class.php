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
    if ($directory = $this->processForm($request, $this->form))
    {
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
    $this->fileForm = new ManagedFileForm(array(), array('directory' => $this->directory));
  }

 /**
  * Executes list action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeList(sfWebRequest $request)
  {
    if (!$memberId = $request->getParameter('id'))
    {
      $memberId = $this->getUser()->getMemberId();
    }
    // get all list or not
    $isOpenOnly =
      ($memberId === $this->getUser()->getMemberId()) ? false : true;
    $this->directories = FileDirectoryTable::getInstance()
      ->getDirectoryListByMemberId($memberId, $isOpenOnly);
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
  * Executes delete action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $directory = $this->getRoute()->getObject();
    $this->forward404If(!$directory->isAuthor());
    $directory->delete();

    $this->redirect('@directory_list');
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
