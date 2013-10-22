<?php

class opSampleDiaryRankingPluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    $this->dispatcher->connect(
      'op_action.post_execute_diary_show',
      array(__CLASS__, 'listenToDiaryShow')
    );
  }

  public static function listenToDiaryShow(sfEvent $event)
  {
    $diary = $event['actionInstance']->getVar('diary');
    if ($diary instanceof Diary)
    {
      $ranking = new opSampleDiaryRanking();
      $ranking->incrementScore($diary);

      $count = $ranking->getCount($diary);
      $rank  = $ranking->getRank($diary);
      printf('アクセス数: %d (現在 %d 位)', $count, $rank);
      printf(' <a href="%s">ランキング</a>', $event['actionInstance']->generateUrl('diaryRanking'));
    }
  }
}
