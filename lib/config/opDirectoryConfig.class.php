<?php
class opDirectoryConfig
{
  public function __construct($directoryId)
  {
    $this->directoryId = $directoryId;
    $this->baseQuery = Doctrine::getTable('DirectoryConfig')->getDirectoryConfigQuery($directoryId);
  }

  public function create($communityId)
  {
    $config = new DirectoryConfig();

    return $config->create($this->directoryId, $communityId);
  }

  public function has($column)
  {
    $config = $this->baseQuery
      ->andWhere($column.' <> ""')
      ->fetchOne();

    return $config ? true : false;
  }

  public function getCommunityId()
  {
    return $this->baseQuery
      ->fetchOne()
      ->andWhere('community_id <> ""')
      ->getCommunityId();
  }

  public function updateCommunityId($communityId)
  {
    return $this->baseQuery
      ->andWhere('community_id <> ""')
      ->fetchOne()
      ->updateCommunityId($communityId);
  }

  public function getCommunity()
  {
    return $this->baseQuery
      ->andWhere('community_id <> ""')
      ->fetchOne()
      ->getCommunity();
  }
}
