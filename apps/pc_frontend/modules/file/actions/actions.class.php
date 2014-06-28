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
 /**
  * Executes create action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeCreate(sfWebRequest $request)
  {
    $directory = $this->getRoute()->getObject();
    $this->form = new ManagedFileForm(array(), array('directory' => $directory));
    $file = $this->processForm($request, $this->form);

    if ($file)
    {
      $notice = 'notice';
      $message = 'ファイルをアップロードしました。';
    }
    else
    {
      $notice = 'error';
      $message = 'ファイルのアップロードに失敗しました。';
    }
    $this->getUser()->setFlash($notice, $message);

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

    $file = $this->getRoute()->getObject();
    $this->forward404If(!$file->isAuthor());
    $this->forward404If(!$request->hasParameter('name'));
    $file->editName($request->getParameter('name'));

    $this->redirect('@file_show?id='.$file->getId());
  }

 /**
  * Executes show action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->file = $this->getRoute()->getObject();
    $this->forward404If(!$this->file->isViewable($this->getUser()->getMemberId()));
    $this->directory = $this->file->getFileDirectory();
  }

 /**
  * Executes download action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeDownload(sfWebRequest $request)
  {
    $file = $this->getRoute()->getObject();
    $this->forward404If(!$file->isViewable());
    $data = $file->getFile()->getFileBin()->getBin();

    $this->getResponse()->setHttpHeader('Content-Type', $file->getFile()->getType());
    $this->getResponse()->setHttpHeader('Content-Length', strlen($data));

    $filename = $file->getName();
    // for ie
    if (1 === preg_match('/MSIE/', $request->getHttpHeader('User-Agent')))
    {
      $filename = mb_convert_encoding($filename, 'sjis-win', 'utf8');
    }
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');

    return $this->renderText($data);
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
    $this->forward404If(!$this->file->isAuthor());
    $directoryId = $this->file->getFileDirectory()->getId();
    if ($this->file->delete())
    {
      $this->getUser()->setFlash('notice', 'ファイルを削除しました。');
      $this->redirect('@directory_show?id='.$directoryId);
    }
    else
    {
      $this->getUser()->setFlash('error', 'ファイルの削除に失敗しました。');
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
      return $form->save($directory);
    }
  }
}
