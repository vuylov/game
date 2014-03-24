<?php
/*
 * Check value of level. Compare with prestige table
 * Increase level
 */
class GameLevel extends CWidget {
    public $step;
    public function run(){
        define("VIDEO_NAME", 2); // 2 index in params array in levels
        $step   = $this->step;
        $levels = Yii::app()->params['levels'];
        $video      = FALSE;
        $isGameStart= FALSE;
        $isLevelUp  = FALSE;
        $isGameWin  = FALSE;
        $isGameFail = FALSE;
        $currentLevel = 0;
        
        //Get current value of game level. Value take from main configuration
        foreach ($levels as $prestigeLevel => $rangeLevel)
        {
            if($step->prestige > $rangeLevel[0] && $step->prestige < $rangeLevel[1])
            {
                $currentLevel = $prestigeLevel;
                break;
            }
        }
        //Get stired value of game level
        $dbLevel  = Yii::app()->db->createCommand()
                ->select('id, max(value) as lev')
                ->from('level')
                ->where('game_id=:game', array(':game'=>$step->game_id))
                ->queryRow(true);  
        
        
        if($dbLevel['lev'] !== '0' && !$dbLevel['lev']){ // Start game. Level 0.
            $newlevel              = new Level;
            $newlevel->game_id     = $step->game_id;
            $newlevel->progress_id = $step->id;
            $newlevel->value       = 0;
            $newlevel->save();
            
            $level                  = $newlevel->value;
            $isLevelUp  = TRUE;
            $isGameStart= TRUE;
            $video = Yii::app()->params['levels'][$level][VIDEO_NAME];
        }
        else{
            //CVarDumper::dump($currentLevel, 10, true);
            //CVarDumper::dump($dbLevel['lev'], 10, true);
            if((int)$currentLevel === (int)$dbLevel['lev']){
                $level  = $dbLevel['lev'];
                $video = FALSE;
            }
            elseif((int)$currentLevel < (int)$dbLevel['lev']){//case: user sold worth -> prestige decreased
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
        if($step->deposit < 0)//Game failed an over
            {
                $game           = Game::model()->findByPk($step->game_id);
                $game->endGame($step, Game::$FAILED);
                $video          = Yii::app()->params['video_game_over'];
                $isGameFail     = TRUE;
                //$response = $this->render('endGame', array('video'=> $video, 'level' => 0), true);
                //echo $response;
            }
            elseif($step->prestige >=164001) //Game win and over
            {
                $game           = Game::model()->findByPk($step->game_id);
                $game->endGame($step, Game::$WIN);
                $video          = Yii::app()->params['levels'][5][VIDEO_NAME];
                $isGameWin      = TRUE;
                //$response = $this->render('endGame', array('video'=> $video, 'level' => 5), true);
                //echo $response;
            }
        $response = $this->render('index', array('level' => $level, 'up'=>$isLevelUp, 'fail' => $isGameFail, 'win' => $isGameWin, 'start'=> $isGameStart,'video'=> $video), true);
        echo $response;
    }
}
