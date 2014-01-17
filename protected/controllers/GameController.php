<?php

class GameController extends SecureController
{
        
        public function actionReload()
        {
            $progress = Yii::app()->user->getState('lastStep');
            $response = $this->renderPartial('play', array('step'=>$progress), true, true);
            echo $response;
        }
        
        public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionList()
        {
            $userId = Yii::app()->user->getState('id');
            $games = Game::model()->findAll('user_id = :id', array(':id'=>$userId));
            if(!$games)
            {
                $this->render('create');
            }
            else
            {
                $this->render('list', array(
                'games'=>$games));
            }  
        }
        
        //User create new game
        public function actionCreate()
        {
            $game = new Game;
            $game->user_id = Yii::app()->user->id;
            $game->hash = substr(md5(rand(1, 9999).time()), 0, 10);  

            if($game->validate()&&$game->save(false))
            {
                $this->redirect(array('game/play', 'id'=>$game->id));
                Yii::app()->end();
            }
            else
            {
                Yii::log("errors saving Game model: " . var_export($game->getErrors(), true), CLogger::LEVEL_ERROR, __METHOD__);
                $this->render('error', array('model'=>$game));
            }
            
        }
        
        public function actionPlay($id)
        {
            Yii::app()->user->setState('currentGameId', $id);
            $step = Progress::model()->findByAttributes(array('game_id'=>$id), array('order' => 'date_making DESC' ));
            if(!$step)//если пользователь только начал играть
            {
                $step = new Progress;
                $step->game_id = $id;
                $step->step = 1;
                $step->deposit = Yii::app()->params['income'];
                $step->prestige = Yii::app()->params['prestige'];
                $step->save();
            }
            
            Yii::app()->user->setState('lastStep', $step);
            
            $this->render('play', array(
                'step' => $step
            ));
        }
        
        public function actionNext()
        {
            $this->disableJSScript();
            $game       = Yii::app()->user->getState('currentGameId');
            //Choose last step in current game
            $lastStep   = Yii::app()->user->getState('lastStep'); 
            
            
            //Create new stepp of game progress and fill with paramters
            $newStep = new Progress();
            $newStep->step      = $lastStep->step + 1;
            $newStep->deposit   = $lastStep->deposit + Yii::app()->params['income'];
            $newStep->prestige  += $lastStep->prestige;
            $newStep->game_id = $game;
            if(!$newStep->save())
            {
                var_dump($newStep->getErrors());
            }
            
            //generate rates for financinal tools
            ShareRateManager::newRates($newStep);
            
            //check assets list for process finance tools
            $this->checkAssetList($newStep);
            //store new step in user session
            Yii::app()->user->setState('lastStep', $newStep);
            
            /*
             * Start integrating event model
             */
            //fetch current going events
            $eventsInProgress = EventInProgress::model()->with('event')->findAllByAttributes(array('status' => 1));
            if (count($eventsInProgress) > 0) {//we have events in progress
                foreach ($eventsInProgress as $currentEvent) {
                    if ($currentEvent->event_end == $newStep->step) {//terminate event
                        $currentEvent->event->afterEvent($newStep, $currentEvent);
                    }
                }
            }

            //fetch news from stack news whiches not ongoing
            $news   = News::model()->findAll(array(
                'select'    => 't.id, t.name, t.description, t.chance, t.delay, t.multiplicity',
                'condition' => 't.id NOT IN (SELECT news_id FROM newsInProgress WHERE status = 1)'
            ));

            //register news in progress
            if(count($news > 0))
            {
                foreach($news as $new)
                {
                    if($this->isEventRaised($new->chance) || $this->isRoutine($newStep->step, $new->multiplicity))
                    {
                       $new->registerNewsInProgress($new, $newStep);
                    }
                }
            }

            //Fetch events from ongoing news
            $events = array();
            $events = NewsInProgress::getRelatedEvents($newStep);

            foreach ($events as $event) {
                if ($this->isEventRaised($event->chance) || $this->isRoutine($newStep->step, $event->multiplicity)) {//true: event raised
                    $event->beforeEvent($newStep, $event);
                }
            }
            //save all changes in DB
            $newStep->save();
                /*
             * Stop integratig event model
             */
            
            $response = $this->renderPartial('play', array('step'=>$newStep), true, true);
            echo $response;
        }
        //pseudo generator of random digits
        private function isEventRaised($weight) {
            $number = mt_rand(1, 100);
            return ($number <= $weight) ? true : false;
        }

        //use for interval events
        private function isRoutine($progressStep, $multiplicity) {
            return ($progressStep % $multiplicity === 0) ? true : false;
        }

    public function checkAssetList(Progress $progress)
        {
            $assets     = Asset::model()->with('tool')->findAllByAttributes(array('game_id'=> $progress->game_id));
            foreach ($assets as $asset)
            {
                $tool       = ToolFactory::getTool($asset->tool_id);
                if($progress->step == $asset->step_end)
                {
                    $tool->endProcess($progress, $asset);
                }
                else
                {
                    $tool->stepProcess($progress, $asset);
                }
            }
        }
        
        public function actionShop()
        {
            $this->disableJSScript();
            $worthes = Worth::model()->findAll();
            $response = $this->renderPartial('shop', array('worthes'=> $worthes), true, true);
            echo $response;
        }
        
        public function actionBuy($id)
        {
            $this->disableJSScript();
            $step = Yii::app()->user->getState('lastStep');
            $game = Yii::app()->user->getState('currentGameId');
            //логируем запись о покупке
            $action = new Action;
            $action->actiontype_id = 1;
            $action->game_id = $game;
            $action->worth_id = $id;
            $action->progress_id = $step->id; //need get id
            $action->status = 'b';
            $action->save();
            
            //делаем выборку по благу
            $worth = Worth::model()->findByPk($id);
            //изменяем параметры текущего хода на актуальные    
            $step->deposit -= $worth->price_buy;
            $step->prestige += $worth->prestige;
            //проверяем и сохраняем результаты в ход
            if($step->validate() && $step->save())
            {
                Yii::app()->user->setState('lastStep', $step);
            }else
            {
                var_dump($step->getErrors());
            }
            if(!$action->validate()){
                var_dump($action->getErrors());
            }
            
            $response = $this->renderPartial('play', array('step'=>$step), true, true);
            echo $response;
        }
        
        public function actionSell($id)
        {
            $this->disableJSScript();
            $step = Yii::app()->user->getState('lastStep');
            $game = Yii::app()->user->getState('currentGameId');
            
            $action = Action::model()->with('worth')->findByPk($id);
            $action->status = 's';
            if($action->save())
            {
                $step->deposit += $action->worth->price_sell;
                $step->prestige -= $action->worth->prestige;
                if($step->save())
                {
                    Yii::app()->user->setState('lastStep', $step);
                }
                
                $response = $this->renderPartial('play', array('step'=>$step), true, true);
                echo $response;
            }
            
        }
        
        public function actionWorthView($id)
        {
            $this->disableJSScript();
            $step = Yii::app()->user->getState('lastStep');
            $game = Yii::app()->user->getState('currentGameId');
            
            $action = Action::model()->with('worth')->findByPk($id);
            
            $response = $this->renderPartial('worth', array('action' => $action), true, true);
            echo $response;
        }
        
        private function disableJSScript()
        {
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        }
        
}