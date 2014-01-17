<?php

/**
 * This is the model class for table "event".
 *
 * The followings are the available columns in table 'event':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $duration
 * @property integer $chance
 * @property integer $multiplicity
 * @property string $eventHandlerClass
 *
 * The followings are the available model relations:
 * @property EventInProgress[] $eventInProgresses
 */
class Event extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, duration, chance, multiplicity, afterEvent, beforeEvent', 'required'),
			array('duration, chance, multiplicity', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, duration, chance, multiplicity, afterEvent, beforeEvent', 'safe', 'on'=>'search'),
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
			'eventInProgresses' => array(self::HAS_MANY, 'EventInProgress', 'event_id'),
		);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Event the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /*
         * Proxy-method. Call before event handler method of class
         * @param Progress $progress object of current step
         * @param Event $event object of raised event
         */
        public function beforeEvent(Progress $progress, Event $event)
        {
            //before call dynamic callback store event in eventInProgress db
            
            
            $eventStore = new EventInProgress();
            $eventStore->progress_id    = $progress->id;
            $eventStore->event_id       = $event->id;
            $eventStore->game_id        = $progress->game_id;
            $eventStore->event_start    = $progress->value;
            $eventStore->event_end      = $eventStore->event_start + $event->duration;
            $eventStore->status         = 1;
            if(!$eventStore->save())
            {
                CVarDumper::dump($eventStore->getErrors(), 10, true);
            }
            else
            {   
                $e = new $this->eventHandlerClass;
                $e->beforeEventHandler($progress, $event);
            }
        }
        /*
         * Proxy-method. Call after event handler method of class
         * @param Progress $progress object of current step
         * @param EventInProgress $event object passed event
         */
        public function afterEvent(Progress $progress, EventInProgress $event)
        {
                $e = new $this->eventHandlerClass;
                $e->afterEventHandler($progress, $event);
                
                //close event progress
                $event->status  = 0;
                $event->save();
        }
}
