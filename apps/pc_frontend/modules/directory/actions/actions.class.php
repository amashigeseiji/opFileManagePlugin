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
  public function preExecute()
  {
    if ($this->getRequest()->isSmartphone())
    {
      $this->setLayout('smtLayoutSns');
    }
  }

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

    $this->redirect('@directory_list');
  }

 /**
  * Executes show action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->directory = $this->getRoute()->getObject();

    if ('community' === $this->directory->type)
    {
      $community = $this->directory->getConfig()->getCommunity();
      $this->forward404If(!opFileManageUtil::isViewableCommunityFile($community, $this->getUser()->getMember()));
      opFileManageUtil::setLocalNav('community', $community->id);
    }
    elseif (!$this->directory->isAuthor())
    {
      opFileManageUtil::setLocalNav('friend', $this->directory->Member->id);
    }

    $this->pager = Doctrine::getTable('ManagedFile')
      ->getDirectoryFileListPager($this->directory->getId(), $request->getParameter('page'));
    $this->pager->init();
  }

 /**
  * Executes list action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeList(sfWebRequest $request)
  {
    $this->isFriendPage =
       $request->getParameter('id') ? true : false;

    $this->member = $this->isFriendPage ?
      $this->getRoute()->getObject() : $this->getUser()->getMember();

    if ($this->isFriendPage)
    {
      opFileManageUtil::setLocalNav('friend', $this->member->id);
    }

    $allowedTypes = array('public');
    if (!$this->isFriendPage)
    {
      $allowedTypes[] = 'private';
    }
    $types = Doctrine::getTable('FileDirectory')->getTypes($allowedTypes);

    $this->pager = FileDirectoryTable::getInstance()
      ->getMemberDirectoryListPager($this->member->getId(), $types, $request->getParameter('page'));
    $this->pager->init();
  }

 /**
  * Executes list action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeListCommunity(sfWebRequest $request)
  {
    $this->forward404If(!opFileManageConfig::isUseCommunity());

    $this->community = $this->getRoute()->getObject();

    $this->forward404If(!opFileManageUtil::isViewableCommunityFile($this->community, $this->getUser()->getMember()));

    opFileManageUtil::setLocalNav('community', $this->community->id);

    $this->pager = FileDirectoryTable::getInstance()
      ->getCommunityDirectoryListPager($this->community->getId(), null, $request->getParameter('page'));
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
    $directory->publish($request['publish']);

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
    if ($request->hasParameter('name') && $name = trim($request->getParameter('name')))
    {
      $directory->modifyName($name);
    }

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
    $redirectTo = 'community' === $directory->type ?
      '@community_home?id='.$directory->getConfig()->getCommunityId() : '@directory_list';

    if ($directory->delete())
    {
      $this->getUser()->setFlash('notice', 'Directory is deleted.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Failed to delete directory.');
    }

    $this->redirect($redirectTo);
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
      $result = $form->save();
      $state = 'notice';
      $message = 'Directory is created.';
    }
    else
    {
      $result = false;
      $state = 'error';
      $message = 'Failed to create directory.';
    }

    $this->getUser()->setFlash($state, $message);

    return $result;
  }
}
