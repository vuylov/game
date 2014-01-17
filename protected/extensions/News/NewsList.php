<?php
/**
 * Description of NewsList
 *
 * @author admin
 */
class NewsList extends CWidget {
    //put your code here
    public $step;

    public function run() {
        $news = NewsInProgress::model()->with('news', 'progress')->findAll('t.status = :status AND t.game_id = :game', array(':status'=> 1, ':game'=>  $this->step->game_id));
        
        $this->render('list', array('news' => $news, 'step'=> $this->step));
    }
}
