<?php

/**
 * This is the model class for table "action".
 *
 * The followings are the available columns in table 'action':
 * @property integer $id
 * @property integer $actiontype_id
 * @property integer $worth_id
 * @property integer $progress_id
 * @property string $date_create
 *
 * The followings are the available model relations:
 * @property Actiontype $actiontype
 * @property Worth $worth
 * @property Progress $progress
 */
class Action extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'action';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('actiontype_id, worth_id, progress_id, date_create', 'required'),
			array('actiontype_id, worth_id, progress_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, actiontype_id, worth_id, progress_id, date_create', 'safe', 'on'=>'search'),
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
			'actiontype' => array(self::BELONGS_TO, 'Actiontype', 'actiontype_id'),
			'worth' => array(self::BELONGS_TO, 'Worth', 'worth_id'),
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
			'actiontype_id' => 'Actiontype',
			'worth_id' => 'Worth',
			'progress_id' => 'Progress',
			'date_create' => 'Date Create',
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
		$criteria->compare('actiontype_id',$this->actiontype_id);
		$criteria->compare('worth_id',$this->worth_id);
		$criteria->compare('progress_id',$this->progress_id);
		$criteria->compare('date_create',$this->date_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Action the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeValidate() {
            if(parent::beforeValidate())
            {
                $this->date_create = new CDbExpression('NOW()');
            }
            return true;
        }
}
