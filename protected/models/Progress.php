<?php

/**
 * This is the model class for table "progress".
 *
 * The followings are the available columns in table 'progress':
 * @property integer $id
 * @property integer $game_id
 * @property integer $step
 * @property integer $prestige
 * @property integer $deposit
 * @property string $date_making
 *
 * The followings are the available model relations:
 * @property Action[] $actions
 * @property Game $game
 */
class Progress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'progress';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('game_id, step, prestige, deposit, date_making', 'required'),
			array('game_id, step, prestige, deposit', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, game_id, step, date_making', 'safe', 'on'=>'search'),
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
			'actions' => array(self::HAS_MANY, 'Action', 'progress_id'),
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
			'game_id' => 'Game',
			'step' => 'Step',
			'date_making' => 'Date Making',
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
		$criteria->compare('step',$this->step);
		$criteria->compare('date_making',$this->date_making,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Progress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeValidate() {
            if(parent::beforeValidate())
            {
                $this->date_making = new CDbExpression('NOW()');
            }
            return true;
        }
}
