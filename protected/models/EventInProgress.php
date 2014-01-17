<?php

/**
 * This is the model class for table "eventInProgress".
 *
 * The followings are the available columns in table 'eventInProgress':
 * @property integer $id
 * @property integer $progress_id
 * @property integer $event_id
 * @property integer $game_id
 * @property integer $event_start
 * @property integer $event_end
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Event $event
 * @property Progress $progress
 */
class EventInProgress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'eventInProgress';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('progress_id, event_id, game_id, event_start, event_end, status', 'required'),
			array('progress_id, event_id, game_id, event_start, event_end, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, progress_id, event_id, game_id, event_start, event_end, status', 'safe', 'on'=>'search'),
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
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'progress' => array(self::BELONGS_TO, 'Progress', 'progress_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'progress_id' => 'Progress',
			'event_id' => 'Event',
			'game_id' => 'Game',
			'event_start' => 'Event Start',
			'event_end' => 'Event End',
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
		$criteria->compare('progress_id',$this->progress_id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('game_id',$this->game_id);
		$criteria->compare('event_start',$this->event_start);
		$criteria->compare('event_end',$this->event_end);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventInProgress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
