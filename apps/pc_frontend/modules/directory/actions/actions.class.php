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

    if ($this->directory->isCommunity())
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
      ->getDirectoryFileList($this->directory->getId())
      ->getPager($request->getParameter('page'));
  }

 /**
  * Executes list action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeList(sfWebRequest $request)
  {
    $this->forwardUnless($request->getParameter('id'), 'directory', 'listMine');
    $this->forwardIf($request->getParameter('id') === $this->getUser()->getMemberId(), 'directory', 'listMine');
    $this->forward('directory', 'listMember');
  }

 /**
  * Executes listMember action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeListMember(sfWebRequest $request)
  {
    $this->forward404If(!opFileManageConfig::isUsePublic());
    $this->member = $this->getRoute()->getObject();

    opFileManageUtil::setLocalNav('friend', $this->member->id);

    $this->pager = FileDirectoryTable::getInstance()
      ->getMemberDirectoryList($this->member->id, array('public'))
      ->getPager($request->getParameter('page'));
  }

 /**
  * Executes listMine action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeListMine(sfWebRequest $request)
  {
    $this->forward404If(!opFileManageConfig::isUsePublic() && !opFileManageConfig::isUsePrivate());
    $this->member = $this->getUser()->getMember();
    $this->pager = FileDirectoryTable::getInstance()
      ->getMemberDirectoryList($this->member->getId(), array('public', 'private'))
      ->getPager($request->getParameter('page'));
  }

 /**
  * Executes listCommunity action
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
      ->getCommunityDirectoryList($this->community->getId())
      ->getPager($request->getParameter('page'), null);
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
    $redirectTo = $directory->isCommunity() ?
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
