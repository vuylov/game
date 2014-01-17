<?php
/**
 * Description of CurrentEventsList
 *
 * @author admin
 */
class CurrentEventsList extends CWidget {
    public $step;
    
    public function run()
    {
        $currentEvents = EventInProgress::model()->with('event', 'progress')->findAll('t.status=:status AND t.game_id = :game', array(':status'=>1, ':game' => $this->step->game_id));
        $this->render('list', array('currents' => $currentEvents, 'step' => $this->step));
    }
}
