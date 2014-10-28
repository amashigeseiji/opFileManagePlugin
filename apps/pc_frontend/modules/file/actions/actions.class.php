<?php

/**
 * file actions.
 *
 * @package    OpenPNE
 * @subpackage file
 * @author     Seiji Amashige <amashige@tejimaya.com>
 */
class fileActions extends sfActions
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
    $directory = $this->getRoute()->getObject();
    $form = new ManagedFileForm(array(), array('type' => 'directory', 'directory_id' => $directory->id));
    $form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->processForm($request, $form);

    $this->redirect('@directory_show?id='.$directory->id);
  }

 /**
  * Executes create community file action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeCreateFileCommunity(sfWebRequest $request)
  {
    $community = $this->getRoute()->getObject();
    $form = new ManagedFileForm(array(), array('type' => 'community_directory', 'community_id' => $community->id));
    $form->getObject()->setMemberId($this->getUser()->getMemberId());

    $this->processForm($request, $form);

    $this->redirect('@file_list_community?id='.$community->id);
  }

 /**
  * Executes create member file action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeCreateFileMember(sfWebRequest $request)
  {
    $member = $this->getRoute()->getObject();
    $form = new ManagedFileForm(array(), array('type' => 'member_directory', 'member_id' => $member->id));
    $form->getObject()->setMemberId($this->getUser()->getMemberId());

    $this->processForm($request, $form);

    $this->redirect('@file_list_member?id='.$member->id);
  }

 /**
  * Executes edit action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeEdit(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $file = $this->getRoute()->getObject();
    if ($request->hasParameter('name') && $name = trim($request->getParameter('name')))
    {
      $file->editName($name);
    }

    $this->redirect($request->getParameter('redirect', '@file_show?id='.$file->getId()));
  }

  public function executeMoveDirectory(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $file = $this->getRoute()->getObject();
    if ($request->hasParameter('directory_id'))
    {
      try
      {
        $validator = new opValidatorDirectory();
        $clean = $validator->clean($request->getParameter('directory_id'));
        $file->moveDirectory($clean);
      }
      catch(sfValidatorError $e)
      {
        $this->getUser()->setFlash('error', $e->getMessage());
      }
    }

    $this->redirect('@file_show?id='.$file->id);
  }

 /**
  * Executes show action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->file = $this->getRoute()->getObject();

    $this->directory = $this->file->FileDirectory;
    if ('community' === $this->directory->type)
    {
      opFileManageUtil::setLocalNav('community', $this->directory->getConfig()->getCommunityId());
    }
  }

 /**
  * Executes listMember action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeListMember(sfWebRequest $request)
  {
    $this->member = $this->getRoute()->getObject();
    if ($this->member->id !== $this->getUser()->getMemberId())
    {
      opFileManageUtil::setLocalNav('friend', $this->member->id);
    }

    $this->pager = Doctrine::getTable('ManagedFile')->getMemberFileListPager($this->member->id, $request->getParameter('page'));
    $this->pager->init();
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

    $this->pager = Doctrine::getTable('ManagedFile')
      ->getCommunityFileListPager($this->community->id, $request->getParameter('page'));
    $this->pager->init();
  }

 /**
  * Executes download action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeDownload(sfWebRequest $request)
  {
    $file = $this->getRoute()->getObject();

    return opToolkit::fileDownload($file->getName(), $file->getFile()->getFileBin()->getBin());
  }

 /**
  * Executes delete action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->file = $this->getRoute()->getObject();
    $directoryId = $this->file->getFileDirectory()->getId();
    if ($this->file->delete())
    {
      $this->getUser()->setFlash('notice', 'File is deleted.');
      $this->redirect('@directory_show?id='.$directoryId);
    }
    else
    {
      $this->getUser()->setFlash('error', 'Failed to delete file.');
    }
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
      $request->getParameter($form->getName()),
      $request->getFiles($form->getName())
    );

    if ($form->isValid())
    {
      $result = $form->save();
      $state = 'notice';
      $message = 'File is uploaded.';
    }
    else
    {
      $state = 'error';
      $message = 'Failed to upload.';
    }

    $this->getUser()->setFlash($state, $message);
  }
}
