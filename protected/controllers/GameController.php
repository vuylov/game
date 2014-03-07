<?php
class GameController extends SecureController
{
        
        public function actionReload()
        {
            $this->disableJSScript();
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
            $games = Game::model()->findAll('user_id = :id AND status = :status', array(':id'=>$userId, ':status'=> 1));
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
            $userId     = Yii::app()->user->id;
            
            $countActiveGame = Game::model()->count('user_id = :id AND status = :status', array(':id'=>$userId, ':status'=> 1));
            if($countActiveGame)//if user has active game
            {
                $this->render('error', array('msg' => 'У вас есть активная игра.'));
            }
            else
            {
                $game = new Game;
                $game->user_id = $userId;
                $game->hash = substr(md5(rand(1, 9999).time()), 0, 10);  

                if($game->validate() && $game->save(false))
                {
                    //Инициализируем значения по институтам по игре
                    $tools = Tool::model()->findAll();
                    foreach ($tools as $tool)
                    {
                        $userTool               = new UserToolConfig;
                        $userTool->tool_id      = $tool->id;
                        $userTool->game_id      = $game->id;
                        $userTool->step_min     = ($tool->step_min)?$tool->step_min:0;
                        $userTool->step_max     = ($tool->step_max)?$tool->step_max:0;
                        $userTool->base_price   = ($tool->in_total_min)?$tool->in_total_min:0;
                        $userTool->range        = ($tool->in_total_max)?$tool->in_total_max:0;
                        $userTool->procent      = ($tool->in_step_min)?$tool->in_step_min:0;
                        $userTool->status       = 1;
                        $userTool->save();
                    }
                    
                    $this->redirect(array('game/play', 'id'=>$game->id));
                    Yii::app()->end();
                }
                else
                {
                    Yii::log("errors saving Game model: " . var_export($game->getErrors(), true), CLogger::LEVEL_ERROR, __METHOD__);
                    $this->render('error', array('model'=>$game));
                }
            }
            
        }
        
        public function actionPlay($id)//id - номер игры
        {
            //check game
            $user   = Yii::app()->user->getState('id');
            $game   = Game::model()->findByAttributes(array('user_id' => $user, 'id' => (int)$id));
            if(!$game)
            {
                $this->redirect(array('site/login'));
                Yii::app()->end();
            }
            
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
                
                //делаем инициализацию первичных значений для пользователя,
                //в частности, 
                //1. арендуем для него жилье
                $action                 = new Action;
                $action->actiontype_id  = 1; //покупка за наличные
                $action->game_id        = $step->game_id;
                $action->worth_id       = 7; //аренда жилья
                $action->progress_id    = $step->id;
                $action->status         = 'b';//статус - "куплен"
                $action->save();
                
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
            $newStep->deposit   = $lastStep->deposit;
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
            //check dates of insure worthes
            $this->checkInsureList($newStep);
            //store new step in user session
            Yii::app()->user->setState('lastStep', $newStep);
            
            /*
             * Start integrating event model
             */
            //fetch current going events
            $eventsInProgress = EventInProgress::model()->with('event')->findAllByAttributes(array('status' => 1, 'game_id' => $newStep->game_id));
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
                'condition' => 't.status = 1 AND t.id NOT IN (SELECT news_id FROM newsInProgress WHERE status = 1 AND game_id ='.$newStep->game_id.')'
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
            
            //calculate income without credit payment
            $newStep->deposit += ProgressIncome::getStepProgressIncome($newStep);
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
            $assets     = Asset::model()->with('tool')->findAllByAttributes(array('game_id'=> $progress->game_id, 'status' => 'o'));
            foreach ($assets as $asset)
            {
                $tool       = ToolFactory::getTool($asset->tool_id, $progress);
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
        
        public function checkInsureList(Progress $progress)
        {
            $worthInsures = WorthInsure::model()->findAll(array(
                'condition' => 'game_id = :game AND status = 1',
                'params'    => array(':game'=> $progress->game_id)
            ));
            
            foreach($worthInsures as $insure)
            {
                if($insure->step_end == $progress->step)
                    $insure->endInsure();
            }
        }


        //public function 
        public function actionBuy($id)
        {
            $this->disableJSScript();
            $step = Yii::app()->user->getState('lastStep');
            $game = Yii::app()->user->getState('currentGameId');
            //делаем выборку по благу
            $worth = Worth::model()->findByPk($id);
            
            if($step->deposit < $worth->price_buy)
            {
                $response = $this->renderPartial('buyFail', array(), true, true);
                echo $response;
            }
            else
            {
                //тут убираем аренду при покупке квартиры или коттеджа
                 if(in_array((int)$worth->id, array(5, 6))){
                     $rent = Action::model()->findAll('game_id = :game AND worth_id = :worth', array(':game' => $step->game_id, ':worth' => 7));
                     //CVarDumper::dump($rent, 10, true);
                     $rent[0]->status = 's';
                     $rent[0]->save();
                 }
                 
                //логируем запись о покупке
                $action = new Action;
                $action->actiontype_id = 1;
                $action->game_id = $game;
                $action->worth_id = $id;
                $action->progress_id = $step->id; //need get id
                $action->status = 'b';
                $action->save();


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

                $response = $this->renderPartial('buySuccess', array('step'=>$step), true, true);
                echo $response;
            }
        }
        
        public function actionSell($id)
        {
            $this->disableJSScript();
            $step = Yii::app()->user->getState('lastStep');
            $game = Yii::app()->user->getState('currentGameId');
            
            $action = Action::model()->with('worth', 'worthInsures')->findByPk($id);
            if(!$action){
                echo 'Данный параметр не доступен';
                Yii::app()->end();
            }
            
            $insureRemainsMoney = 0;
            if(count($action->worthInsures) > 0){
                $insure             = $action->worthInsures[0];
                $insureRemainsMoney = InsureRemainsCalculator::Calculate($step, $insure);
                $insure->endInsure();
            }
            
            $action->status = 's';
            if($action->save())
            {
                $step->deposit += $action->worth->price_sell + $insureRemainsMoney;
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
            
            $action = Action::model()->with('worth', 'worthInsures')->findByPk($id);
            if(!$action){
                echo 'Ценность с таким значением не найдена';
                Yii::app()->end();
            }
            
            $response = $this->renderPartial('worth', array('action' => $action, 'progress'=>$step), true, true);
            echo $response;
        }
        
        private function disableJSScript()
        {
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        }
        
        public function actionTip()
        {
            $this->disableJSScript();
            $progress   = Yii::app()->user->getState('lastStep');
            $tips       = Tip::model()->with(array(
                'level' => array(
                    'alias'     => 'l',
                    'condition' => 'l.prestige_low <= :prestige AND l.prestige_high > :prestige',
                    'params'    => array(':prestige' => $progress->prestige)
                )
            ))->findAll();
            if($tips){
                $index = mt_rand(0, count($tips) - 1);
                $response  = $this->renderPartial('tip', array('tip' => $tips[$index]), true, true);
            }else{
                $tip = new Tip();
                $tip->description = 'Доступных подсказок нет';
                $response  =  $this->renderPartial('tip', array('tip' => $tip), true, true);
            }
            echo $response;
        }
        
}