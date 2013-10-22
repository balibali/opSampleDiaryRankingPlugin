<?php

class diaryRankingActions extends sfActions
{
  public function executeIndex($request)
  {
    $ranking = new opSampleDiaryRanking();
    $this->results = $ranking->getTop(10);
  }
}
