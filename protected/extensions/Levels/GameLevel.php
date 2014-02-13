<?php
/*
 * Check vlue of level. Compare with prestige table
 */
class GameLevel extends CWidget {
    public $step;
    public function run(){
        $step   = $this->step;
        $levels = Yii::app()->params['levels'];
        foreach ($levels as $prestigeLevel => $rangeLevel)
        {
            /*
            if(in_array($step->prestige, $rangeLevel))
            {
                $currentLevel = $prestigeLevel;
            }*/
            if($step->prestige > $rangeLevel[0] && $step->prestige < $rangeLevel[1])
            {
                $currentLevel = $prestigeLevel;
                break;
            }
        }
        $dbLevel  = Yii::app()->db->createCommand()
                ->select('id, max(value) as lev')
                ->from('level')
                ->where('game_id=:game', array(':game'=>$step->game_id))
                ->queryRow(true);  
        $isUp = FALSE; // flag describes up level
        if($currentLevel <= (int)$dbLevel['lev']){
            $level = $dbLevel['lev'];
        }else
        {
            $newLevel               = new Level();
            $newLevel->game_id      = $step->game_id;
            $newLevel->progress_id  = $step->id;
            $newLevel->value        = (int)$currentLevel;
            $newLevel->save();
            
            $level  = $currentLevel;
            $isUp   = TRUE;
            $video  = "<div><video controls='' autoplay='' name='media'><source src='".Yii::app()->baseUrl."/video/H264_test1.mp4' type='video/mp4'></video></div>";
        }
        $response = $this->render('index', array('level' => $level, 'up'=>$isUp, 'video'=> $video), true);
        echo $response;
    }
}
