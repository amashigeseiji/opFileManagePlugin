<?php

/**
 * ManagedFileQuery
 *
 */
class ManagedFileQuery extends Doctrine_Query
{
  static public function create($conn = null, $class = null)
  {
    return parent::create($conn, 'ManagedFileQuery')
      ->from('ManagedFile f');
  }

  public function addDirectoryId($directoryId)
  {
    if (is_array($directoryId))
    {
      return $this->andWhereIn('f.directory_id', $directoryId);
    }

    return $this->andWhere('f.directory_id = ?', $directoryId);
  }

  public function addMemberId($memberId)
  {
    return $this->andWhere('f.member_id = ?', $memberId);
  }

  public function addOrderBy($orderBy = null)
  {
    return $this->orderBy($orderBy ? $orderBy : 'f.created_at DESC');
  }

  public function addDirectoryType(array $types)
  {
    if ($types)
    {
      return $this->andWhereIn('d.type', $types);
    }
    else
    {
      return $this->andWhere('d.type IS NULL');
    }
  }

  public function addLeftJoinDirectory($alias = 'd')
  {
    return $this->leftJoin("f.FileDirectory AS $alias");
  }

  public function getPager($page = 1)
  {
    $pager = new sfDoctrinePager('ManagedFile', sfConfig::get('app_file_list_max_size', 10));
    $pager->setQuery($this);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  /*
   * private function
   */

  private function addSearchQuery($searchParameter)
  {
    foreach ($searchParameter as $key => $val)
    {
      if ($val)
      {
        if ($key === 'name' || $key === 'note')
        {
          $this->andWhere("f.$key LIKE ?", "%$val%");
        }
        elseif ($key === 'member_id')
        {
          $this->addMemberId($val);
        }
      }
    }

    return $this;
  }

  /*
   * static functions
   */

  public static function getOrderedQuery()
  {
    return self::create()->addOrderBy();
  }

  public static function getFileListQueryByDirectoryId($directoryId)
  {
    return self::getOrderedQuery()->addDirectoryId($directoryId);
  }

  /**
   * @param community_id
   * @return Doctrine_Query コミュニティで共有しているファイル一覧を取得するクエリ
   */
  public static function getCommunityFileListQuery($communityId)
  {
    $directoryIds = Doctrine::getTable('DirectoryConfig')->getDirectoryIdsByCommunityId($communityId);

    return self::getOrderedQuery()->addDirectoryId($directoryIds);
  }

  public static function getMemberFileListQuery($memberId)
  {
    $allowedTypes = array('public');
    if ($memberId === sfContext::getInstance()->getUser()->getMemberId())
    {
      $allowedTypes[] = 'private';
    }

    return self::getFileListQuery($allowedTypes)
      ->where('d.member_id = ?', $memberId);
  }

  public static function getPublicFileListQuery($searchParameter = null)
  {
    $q = self::getFileListQuery(array('public'));

    if ($searchParameter)
    {
      $q->addSearchQuery($searchParameter);
    }

    return $q;
  }

  public static function getFileListQuery(array $allowedTypes)
  {
    return self::getOrderedQuery()
      ->addLeftJoinDirectory()
      ->addDirectoryType(Doctrine::getTable('FileDirectory')->getTypes($allowedTypes));
  }
}
