<?php

/**
 * This is the model class for table "worthInsure".
 *
 * The followings are the available columns in table 'worthInsure':
 * @property integer $id
 * @property integer $game_id
 * @property integer $progress_id
 * @property integer $action_id
 * @property integer $worth_id
 * @property integer $step_start
 * @property integer $step_end
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Worth $worth
 * @property Game $game
 * @property Progress $progress
 * @property Action $action
 */
class WorthInsure extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'worthInsure';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('game_id, progress_id, action_id, worth_id, step_start, step_end, status', 'required'),
			array('game_id, progress_id, action_id, worth_id, step_start, step_end, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, game_id, progress_id, action_id, worth_id, step_start, step_end, status', 'safe', 'on'=>'search'),
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
			'worth' => array(self::BELONGS_TO, 'Worth', 'worth_id'),
			'game' => array(self::BELONGS_TO, 'Game', 'game_id'),
			'progress' => array(self::BELONGS_TO, 'Progress', 'progress_id'),
			'action' => array(self::BELONGS_TO, 'Action', 'action_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'game_id' => 'Game',
			'progress_id' => 'Progress',
			'action_id' => 'Action',
			'worth_id' => 'Worth',
			'step_start' => 'Step Start',
			'step_end' => 'Step End',
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
		$criteria->compare('game_id',$this->game_id);
		$criteria->compare('progress_id',$this->progress_id);
		$criteria->compare('action_id',$this->action_id);
		$criteria->compare('worth_id',$this->worth_id);
		$criteria->compare('step_start',$this->step_start);
		$criteria->compare('step_end',$this->step_end);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WorthInsure the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function endInsure()
        {
            $this->status = 0;
            $this->save();
        }
}
