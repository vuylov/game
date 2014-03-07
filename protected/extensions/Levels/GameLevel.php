<?php
/*
 * Check vlue of level. Compare with prestige table
 * Increase level
 */
class GameLevel extends CWidget {
    public $step;
    public function run(){
        define("VIDEO_NAME", 2); // 2 index in params array in levels
        $step   = $this->step;
        $levels = Yii::app()->params['levels'];
        $isLevelUp = FALSE;
        
        if($step->deposit < 0)//failed
        {
            $game           = Game::model()->findByPk($step->game_id);
            $game->endGame($step, Game::$FAILED);
            $video          = Yii::app()->params['video_game_over'];
            $response = $this->render('endGame', array('video'=> $video, 'level' => 0), true);
            echo $response;
        }
        elseif($step->prestige >=164001)
        {
            $game           = Game::model()->findByPk($step->game_id);
            $game->endGame($step, Game::$WIN);
            $video          = Yii::app()->params['levels'][5][VIDEO_NAME];
            $response = $this->render('endGame', array('video'=> $video, 'level' => 5), true);
            echo $response;
        }
        foreach ($levels as $prestigeLevel => $rangeLevel)
        {
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
        
        
        if($dbLevel['lev'] !== '0' && !$dbLevel['lev']){ // level 0
            $newlevel              = new Level;
            $newlevel->game_id     = $step->game_id;
            $newlevel->progress_id = $step->id;
            $newlevel->value       = 0;
            $newlevel->save();
            
            $level                  = $newlevel->value;
            $isLevelUp = TRUE;
            $video = Yii::app()->params['levels'][$level][VIDEO_NAME];
        }
        else{
            //CVarDumper::dump($currentLevel, 10, true);
            //CVarDumper::dump($dbLevel['lev'], 10, true);
            if((int)$currentLevel === (int)$dbLevel['lev']){
                $level  = $dbLevel['lev'];
                $video = FALSE;
            }
            elseif((int)$currentLevel < (int)$dbLevel['lev']){//case: user sold worth -> prestege decreased
                $level  = $dbLevel['lev'];
                $video = FALSE;
            }
            else{
                $newLevel               = new Level();
                $newLevel->game_id      = $step->game_id;
                $newLevel->progress_id  = $step->id;
                $newLevel->value        = (int)$currentLevel;
                $newLevel->save();

                $level  = $currentLevel;
                $isLevelUp   = TRUE;
                $video = Yii::app()->params['levels'][$level][VIDEO_NAME];
            }
        }
               
        $response = $this->render('index', array('level' => $level, 'up'=>$isLevelUp, 'video'=> $video), true);
        echo $response;
    }
}
