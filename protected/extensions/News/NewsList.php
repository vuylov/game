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
        $news = NewsInProgress::model()->with('news', 'progress')->findAll('status = :status', array(':status'=> 1));
        
        $this->render('list', array('news' => $news, 'step'=> $this->step));
    }
}
