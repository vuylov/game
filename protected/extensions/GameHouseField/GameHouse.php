<?php
class GameHouse extends CWidget{
    public $step;
    
    public function run(){
        /*
         * Выбираем записи с наибольшим престижем
         */
        $criteria               = new CDbCriteria();
        $criteria->join         = 'INNER JOIN (
                                        SELECT worth.*
                                        FROM worth
                                        WHERE worth.prestige IN (
                                                SELECT MAX(w.prestige)
                                                FROM worth AS w
                                                INNER JOIN action AS a ON a.worth_id = w.id AND (a.game_id = :game AND a.status = "b")
                                                GROUP BY w.worthtype_id
                                                ORDER BY w.order ASC)
                                ) AS w ON t.worth_id = w.id';
        $criteria->condition    = 't.game_id = :game AND t.status = "b"';
        $criteria->params       = array(':game' => $this->step->game_id);
        
        $worthes = Action::model()->with('worth')->findAll($criteria);
        
        //CVarDumper::dump($worthes, 10, true);
       // exit;
        
        $response = $this->render('house', array('progress' => $this->step, 'worthes' => $worthes), true);
        echo $response;
    }
}
