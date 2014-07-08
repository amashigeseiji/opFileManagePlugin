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
    $this->forward404If(!$directory->isEditable($this->getUser()->getMember()));
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
    $this->forward404If(!$this->directory->isViewable($this->getUser()->getMember()));
    $this->pager = Doctrine::getTable('ManagedFile')
      ->getFileListPager($this->directory->getId(), $request->getParameter('page'));
    $this->pager->init();
  }

 /**
  * Executes list action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeList(sfWebRequest $request)
  {
    $this->member = $request->getParameter('id') ?
      $this->getRoute()->getObject() : $this->getUser()->getMember();
    // get all list or not
    $isOpenOnly =
      ($this->member->getId() === $this->getUser()->getMemberId()) ? false : true;
    $this->pager = FileDirectoryTable::getInstance()
      ->getMemberDirectoryListPager($this->member->getId(), $isOpenOnly, $request->getParameter('page'));
    $this->pager->init();
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
    $this->forward404If(!$directory->isEditable($this->getUser()->getMember()));
    $directory->publish($request['private'] ? false : true);

    $this->redirect($request->getParameter('redirect', '@directory_show?id='.$directory->getId()));
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
    $this->forward404If(!$directory->isEditable($this->getUser()->getMember()));
    $this->forward404If(!$request->getParameter('name'));
    $directory->modifyName($request['name']);

    $this->redirect($request->getParameter('redirect', '@directory_show?id='.$directory->getId()));
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
    $this->forward404If(!$directory->isEditable($this->getUser()->getMember()));
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

  public function executeConfig(sfWebRequest $request)
  {
    $this->directory = $this->getRoute()->getObject();
    $this->form = new DirectoryConfigForm(array(), array('directory' => $this->directory));
    if ($request->isMethod('post'))
    {
      $this->processForm($request, $this->form);
    }
  }
}
