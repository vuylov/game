<?php

/**
 * This is the model class for table "tool".
 *
 * The followings are the available columns in table 'tool':
 * @property integer $id
 * @property integer $institute_id
 * @property string $name
 * @property string $description
 * @property integer $levelPrestige
 * @property integer $step_min
 * @property integer $step_max
 * @property integer $step_start
 * @property integer $garanty
 * @property integer $in_total_min
 * @property integer $in_total_max
 * @property integer $in_step_min
 * @property integer $in_percent_max
 * @property integer $out_total_min
 * @property integer $out_total_max
 * @property integer $out_percent_total_min
 * @property integer $out_percent_total_max
 * @property integer $out_percent_step_min
 * @property integer $out_perscent_step_max
 * @property integer $insurance
 *
 * The followings are the available model relations:
 * @property Asset[] $assets
 * @property Currentcourse[] $currentcourses
 * @property Action $garanty0
 * @property Institute $institute
 */
class Tool extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tool';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('institute_id, name, description, levelPrestige, step_min, step_start', 'required'),
			array('institute_id, levelPrestige, step_min, step_max, step_start, garanty, in_total_min, in_total_max, in_step_min, in_percent_max, out_total_min, out_total_max, insurance', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, institute_id, name, description, levelPrestige, step_min, step_max, step_start, garanty, in_total_min, in_total_max, in_step_min, in_percent_max, out_total_min, out_total_max, out_percent_total_min, out_percent_total_max, out_perscent_step_max, insurance', 'safe', 'on'=>'search'),
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
			'assets' => array(self::HAS_MANY, 'Asset', 'tool_id'),
			'currentcourses' => array(self::HAS_MANY, 'Currentcourse', 'tool_id'),
			'garanty0' => array(self::BELONGS_TO, 'Action', 'garanty'),
			'institute' => array(self::BELONGS_TO, 'Institute', 'institute_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'institute_id' => 'Institute',
			'name' => 'Name',
			'description' => 'Description',
			'levelPrestige' => 'Level Prestige',
			'step_min' => 'Step Min',
			'step_max' => 'Step Max',
			'step_start' => 'Step Start',
			'garanty' => 'Garanty',
			'in_total_min' => 'In Total Min',
			'in_total_max' => 'In Total Max',
			'in_step_min' => 'In Step Min',
			'in_percent_max' => 'In Percent Max',
			'out_total_min' => 'Out Total Min',
			'out_total_max' => 'Out Total Max',
			'out_percent_total_min' => 'Out Percent Total Min',
			'out_percent_total_max' => 'Out Percent Total Max',
			'out_perscent_step_max' => 'Out Perscent Step Max',
			'insurance' => 'Insurance',
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
		$criteria->compare('institute_id',$this->institute_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('levelPrestige',$this->levelPrestige);
		$criteria->compare('step_min',$this->step_min);
		$criteria->compare('step_max',$this->step_max);
		$criteria->compare('step_start',$this->step_start);
		$criteria->compare('garanty',$this->garanty);
		$criteria->compare('in_total_min',$this->in_total_min);
		$criteria->compare('in_total_max',$this->in_total_max);
		$criteria->compare('in_step_min',$this->in_step_min);
		$criteria->compare('in_percent_max',$this->in_percent_max);
		$criteria->compare('out_total_min',$this->out_total_min);
		$criteria->compare('out_total_max',$this->out_total_max);
		$criteria->compare('out_percent_total_min',$this->out_percent_total_min);
		$criteria->compare('out_percent_total_max',$this->out_percent_total_max);
		$criteria->compare('out_perscent_step_max',$this->out_perscent_step_max);
		$criteria->compare('insurance',$this->insurance);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tool the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
