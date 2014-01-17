<?php

/**
 * This is the model class for table "newsInProgress".
 *
 * The followings are the available columns in table 'newsInProgress':
 * @property integer $id
 * @property integer $news_id
 * @property integer $progress_id
 * @property integer $game_id
 * @property integer $event_start
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property News $news
 * @property Progress $progress
 * @property Game $game
 */
class NewsInProgress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'newsInProgress';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('news_id, progress_id, game_id, event_start, status', 'required'),
			array('news_id, progress_id, game_id, event_start, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, news_id, progress_id, game_id, event_start, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'news' => array(self::BELONGS_TO, 'News', 'news_id'),
			'progress' => array(self::BELONGS_TO, 'Progress', 'progress_id'),
			'game' => array(self::BELONGS_TO, 'Game', 'game_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'news_id' => 'News',
			'progress_id' => 'Progress',
			'game_id' => 'Game',
			'event_start' => 'Event Start',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('news_id',$this->news_id);
		$criteria->compare('progress_id',$this->progress_id);
		$criteria->compare('game_id',$this->game_id);
		$criteria->compare('event_start',$this->event_start);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NewsInProgress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /*
         * Return prepeared list of events for raised process
         * @param Progress $progress current progress of game
         * @return Event array array of event
         */
        public static function getRelatedEvents(Progress $progress)
        {
            //fetch ongoing news current game, current progress equal news delay and active status
            $ongoings    = NewsInProgress::model()->findAll(
                    'game_id = :game AND event_start = :progress AND  status = 1', 
                    array(
                        'game'      => $progress->game_id,
                        'progress'  => $progress->step,
                        ));
            $eventsStack     = array();
            foreach($ongoings as $new)
            {
                //fetch related with news events and not exist in eventInProgress table
                $events = Event::model()->findAll(array(
                    'select'    => 't.id, t.news_id, t.name, t.description, t.duration, t.chance, t.multiplicity, t.eventHandlerClass',
                    'condition' => 't.news_id = :news and t.id NOT IN (SELECT event_id FROM eventInProgress WHERE status = 1)',
                    'params'    => array('news' => $new->news_id)
                ));
                $eventsStack = array_merge($eventsStack, $events);
                //change status for ongoing news to inactive
                $new->status = 0;
                $new->save();
            }
            return $eventsStack;
        }
}
