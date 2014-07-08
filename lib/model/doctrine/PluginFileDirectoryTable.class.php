<?php

/**
 * PluginFileDirectoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginFileDirectoryTable extends opAccessControlDoctrineTable
{
  private static $types = array(
    'private'   => 'private',
    'community' => 'community',
    'public'    => 'public'
  );

  /**
   * Returns an instance of this class.
   *
   * @return object PluginFileDirectoryTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('PluginFileDirectory');
  }

  public function getMemberDirectoryListPager($memberId, $type = null, $page = null)
  {
    $q = $this->getListQueryByMemberId($memberId, $type);

    $size = sfConfig::get('app_directory_list_max_size', 10);

    $pager = new sfDoctrinePager('FileDirectory', $size);
    $pager->setQuery($q);
    $pager->setPage($page, 1);

    return $pager;
  }

  public function getListQueryByMemberId($memberId, $type = null)
  {
    $q = $this->createQuery()
      ->where('member_id = ?', $memberId)
      ->orderBy('created_at DESC');

    if ($type)
    {
      $q->andWhere('type = ?', $type);
    }
    elseif (!opFileManageConfig::get('use_private_directory'))
    {
      $q->andWhere('type = ?', 'public');
    }

    return $q;
  }

  public function appendRoles(Zend_Acl $acl)
  {
    return $acl
      ->addRole(new Zend_Acl_Role('everyone'))
      ->addRole(new Zend_Acl_Role('member'), 'everyone')
      ->addRole(new Zend_Acl_Role('author'), 'member');
  }

  public function appendRules(Zend_Acl $acl, $resource = null)
  {
    $acl->allow('member', $resource, 'view');
    $acl->allow('member', $resource, 'edit');
    if ($resource && 'public' === $resource->getType())
    {
      $acl->allow('everyone', $resource, 'view');
    }

    return $acl;
  }

  public function getTypes()
  {
    $types = self::$types;
    if (!opFileManageConfig::get('use_private_directory'))
    {
      unset($types['private']);
    }
    if (!opFileManageConfig::get('use_community_directory'))
    {
      unset($types['community']);
    }

    return $types;
  }
}
