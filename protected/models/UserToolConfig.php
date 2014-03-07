<?php

/**
 * This is the model class for table "userToolConfig".
 *
 * The followings are the available columns in table 'userToolConfig':
 * @property integer $id
 * @property integer $tool_id
 * @property integer $game_id
 * @property integer $step_min
 * @property integer $step_max
 * @property integer $base_price
 * @property integer $range
 * @property double $procent
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Tool $tool
 * @property Game $game
 */
class UserToolConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'userToolConfig';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tool_id, game_id', 'required'),
			array('tool_id, game_id, step_min, step_max, base_price, range, status', 'numerical', 'integerOnly'=>true),
			array('procent', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tool_id, game_id, step_min, step_max, base_price, range, procent, status', 'safe', 'on'=>'search'),
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
			'tool' => array(self::BELONGS_TO, 'Tool', 'tool_id'),
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
			'tool_id' => 'Tool',
			'game_id' => 'Game',
			'step_min' => 'Step Min',
			'step_max' => 'Step Max',
			'base_price' => 'Base Price',
			'range' => 'Range',
			'procent' => 'Procent',
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
		$criteria->compare('tool_id',$this->tool_id);
		$criteria->compare('game_id',$this->game_id);
		$criteria->compare('step_min',$this->step_min);
		$criteria->compare('step_max',$this->step_max);
		$criteria->compare('base_price',$this->base_price);
		$criteria->compare('range',$this->range);
		$criteria->compare('procent',$this->procent);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserToolConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
