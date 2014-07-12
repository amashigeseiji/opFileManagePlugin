<?php
/**
 * FileDirectoryQuery
 */
class FileDirectoryQuery extends Doctrine_Query
{
  static public function create($conn = null, $class = null)
  {
    return parent::create($conn, 'FileDirectoryQuery')
      ->from('FileDirectory');
  }

  public function addMemberId($memberId)
  {
    return $this->andWhere('member_id = ?', $memberId);
  }

  public function addOrderBy($orderBy = null)
  {
    return $this->orderBy($orderBy ? $orderBy : 'created_at DESC');
  }

  public function addType($types = array())
  {
    if ($types)
    {
      return $this->andWhereIn('type', $types);
    }

    if (!opFileManageConfig::isUsePrivate()
      && !opFileManageConfig::isUseCommunity())
    {
      $this->andWhere('type = "public"');
    }
    elseif (!opFileManageConfig::isUseCommunity())
    {
      $this->andWhere('type <> "community"');
    }
    elseif (!opFileManageConfig::isUseCommunity())
    {
      $this->andWhere('type <> "private"');
    }

    return $this;
  }

  public function getListQueryByMemberId($memberId, $types = array())
  {
    return self::create()
      ->addMemberId($memberId)
      ->addOrderBy()
      ->addType($types);
  }

  public function getListQueryByCommunityId($communityId)
  {
    $directoryIds = Doctrine_Query::create()
      ->from('DirectoryConfig c')
      ->where('c.community_id = ?', $communityId)
      ->addSelect('c.directory_id')
      ->fetchArray();

    $max = count($directoryIds);

    $ids = array();
    for ($i = 0; $i <= $max; $i++)
    {
      $ids[] = $directoryIds[$i]['directory_id'];
    }

    return self::create()
      ->addOrderBy()
      ->addType('community')
      ->whereIn('id', $ids);
  }
}
