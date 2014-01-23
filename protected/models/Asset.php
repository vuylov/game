<?php

/**
 * This is the model class for table "asset".
 *
 * The followings are the available columns in table 'asset':
 * @property integer $id
 * @property integer $progress_id
 * @property integer $tool_id
 * @property integer $course_id
 * @property integer $step_start
 * @property integer $step_end
 *
 * The followings are the available model relations:
 * @property Currentcourse $course
 * @property Progress $progress
 * @property Tool $tool
 */
class Asset extends CActiveRecord
{
	//merge with open status rows parameter
	public function defaultScope()
	{
		return array();
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('progress_id, tool_id, step_start, step_end', 'required'),
			array('progress_id, tool_id, step_start, step_end', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, progress_id, tool_id, step_start, step_end', 'safe', 'on'=>'search'),
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
			'progress' => array(self::BELONGS_TO, 'Progress', 'progress_id'),
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
			'progress_id' => 'Progress',
			'tool_id' => 'Tool',
			'step_start' => 'Step Start',
			'step_end' => 'Step End',
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
		$criteria->compare('tool_id',$this->tool_id);
		$criteria->compare('step_start',$this->step_start);
		$criteria->compare('step_end',$this->step_end);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Asset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}