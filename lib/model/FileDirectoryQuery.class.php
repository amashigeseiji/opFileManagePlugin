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

  public function addType($type = null)
  {
    if ($type)
    {
      return $this->andWhere('type = ?', $type);
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

  public function getListQueryByMemberId($memberId, $type = null)
  {
    return self::create()
      ->addMemberId($memberId)
      ->addOrderBy()
      ->addType($type);
  }
}