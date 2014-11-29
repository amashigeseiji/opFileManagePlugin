<?php

/**
 * PluginFileDirectoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginFileDirectoryTable extends opAccessControlDoctrineTable
{
  private static $types = array(
    'private',
    'community',
    'public'
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

  public function getMemberDirectoryList($memberId, $allowedTypes = array())
  {
    return FileDirectoryQuery::getListQueryByMemberId($memberId, self::getTypes($allowedTypes));
  }

  public function getCommunityDirectoryList($communityId)
  {
    return FileDirectoryQuery::getListQueryByCommunityId($communityId);
  }

  public function hasDirectory($memberId)
  {
    return (bool)$this->createQuery()->where('member_id = ?', $memberId)->count() > 0;
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
    $acl->allow('admin', $resource, 'view');
    $acl->allow('admin', $resource, 'upload');
    $acl->allow('admin', $resource, 'edit');
    $acl->allow('admin', $resource, 'delete');

    if ($resource && $resource->isPublic())
    {
      if (opFileManageConfig::isUsePublic())
      {
        $acl->allow('everyone', $resource, 'view');
        if ('everyone' === opFileManageConfig::get('public_directory_edit_setting'))
        {
          $acl->allow('everyone', $resource, 'edit');
        }
        if ('everyone' === opFileManageConfig::get('public_directory_upload_setting'))
        {
          $acl->allow('everyone', $resource, 'upload');
        }
      }
    }

    if ($resource && $resource->isCommunity())
    {
      if (opFileManageConfig::isUseCommunity())
      {
        # all community member can view file
        $acl->allow('member', $resource, 'view');

        $community = $resource->getConfig()->getCommunity();

        if ('public' === $community->getConfig('directory_authority'))
        {
          $acl->allow('author', $resource, 'edit');
          $acl->allow('author', $resource, 'delete');
        }

        if ('public' === $community->getConfig('file_public_flag'))
        {
          $acl->allow('everyone', $resource, 'view');
        }

        if ('public' === $community->getConfig('file_authority'))
        {
          $acl->allow('member', $resource, 'upload');
        }
      }
    }

    return $acl;
  }

  public static function getTypes($allowedType = array())
  {
    $types = self::$types;
    $unset_array = function($val, $array)
    {
      if (is_int($key = array_search($val, $array)))
      {
        unset($array[$key]);
      }

      return array_merge($array);
    };

    if (!opFileManageConfig::isUsePrivate())
    {
      $types = $unset_array('private', $types);
    }
    if (!opFileManageConfig::isUseCommunity())
    {
      $types = $unset_array('community', $types);
    }
    if (!opFileManageConfig::isUsePublic())
    {
      $types = $unset_array('public', $types);
    }

    if ($allowedType)
    {
      foreach ($types as $type)
      {
        if (!in_array($type, $allowedType))
        {
          $types = $unset_array($type, $types);
        }
      }
    }

    return $types;
  }
}
