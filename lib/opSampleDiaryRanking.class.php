<?php

class opSampleDiaryRanking
{
  private $redisRanking;

  public function __construct()
  {
    $key = sfContext::getInstance()->getUser()->generateSiteIdentifier().'::opSampleDiaryRanking';

    $this->redisRanking = new opRedisRanking($key);
  }

  public function incrementScore(Diary $diary)
  {
    $this->redisRanking->incrementScore($this->getRankId($diary));
  }

  public function getCount(Diary $diary)
  {
    return $this->redisRanking->getScore($this->getRankId($diary));
  }

  public function getRank(Diary $diary)
  {
    return 1 + $this->redisRanking->getRevRank($this->getRankId($diary));
  }

  public function getTop($limit = 10, $withScores = true)
  {
    $range = $this->redisRanking->getRevRange(0, $limit - 1, $withScores);

    $results = array();
    foreach ($range as $value)
    {
      $diaryId = $value[0];
      $score   = $value[1];

      $diary = Doctrine::getTable('Diary')->find($diaryId);

      $results[] = array(
        'diary' => $diary,
        'score' => $score,
      );
    }

    return $results;
  }

  private function getRankId(Diary $diary)
  {
    return $diary->getId();
  }
}
