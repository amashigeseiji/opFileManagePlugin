<?php

/**
 * PluginManagedFileTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginManagedFileTable extends opAccessControlDoctrineTable
{
  /**
   * Returns an instance of this class.
   *
   * @return object PluginManagedFileTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('PluginManagedFile');
  }

  public function getDirectoryFileListPager($directoryId, $page = null)
  {
    $q = ManagedFileQuery::getFileListQueryByDirectoryId($directoryId);

    $size = sfConfig::get('app_file_list_max_size', 10);

    return $this->getPager($q, $size, $page);
  }

  public function getMemberFileListPager($memberId, $page = null)
  {
    $q = ManagedFileQuery::getMemberFileListQuery($memberId);

    $size = sfConfig::get('app_file_list_max_size', 10);

    return $this->getPager($q, $size, $page);
  }

  public function getCommunityFileListPager($communityId, $page = null)
  {
    $q = ManagedFileQuery::getCommunityFileListQuery($communityId);

    $size = sfConfig::get('app_file_list_max_size', 10);

    return $this->getPager($q, $size, $page);
  }

  private function getPager(Doctrine_Query $q, $size, $page = 1)
  {
    $pager = new sfDoctrinePager('ManagedFile', $size);
    $pager->setQuery($q);
    $pager->setPage($page);

    return $pager;
  }

  public function appendRoles(Zend_Acl $acl)
  {
    return $acl
      ->addRole(new Zend_Acl_Role('reject'))
      ->addRole(new Zend_Acl_Role('everyone'))
      ->addRole(new Zend_Acl_Role('member'), 'everyone')
      ->addRole(new Zend_Acl_Role('author'), 'member')
      ->addRole(new Zend_Acl_Role('admin'), 'author');
  }

  public function appendRules(Zend_Acl $acl, $resource = null)
  {
    $directory = $resource ? $resource->FileDirectory : null;
    if (!$directory)
    {
      throw new LogicException('ManagedFileTable::appendRules resource is null.');
    }

    # all community member can view file
    $acl->allow('member', $resource, 'view');
    $acl->allow('author', $resource, 'edit');
    $acl->allow('author', $resource, 'delete');

    if ('public' === $directory->type)
    {
      $acl->allow('everyone', $resource, 'view');
    }
    elseif ('community' === $directory->type)
    {
      if ('public' === $directory->getConfig()->getCommunityConfig('file_public_flag'))
      {
        $acl->allow('everyone', $resource, 'view');
      }
    }

    return $acl;
  }
}
