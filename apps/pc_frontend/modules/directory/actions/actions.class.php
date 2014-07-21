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
      sfConfig::set('sf_nav_type', 'community');
      sfConfig::set('sf_nav_id', $this->directory->getConfig()->getCommunityId());
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
    $this->member = $request->getParameter('id') ?
      $this->getRoute()->getObject() : $this->getUser()->getMember();
    $types = array('public');
    if (opFileManageConfig::isUsePrivate() && $this->member->getId() === $this->getUser()->getMemberId())
    {
      $types[] = 'private';
    }
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
    $this->forward404If(!Doctrine::getTable('CommunityMember')
      ->isMember($this->getUser()->getMemberId(), $this->community->id));

    sfConfig::set('sf_nav_type', 'community');
    sfConfig::set('sf_nav_id', $this->community->getId());

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
