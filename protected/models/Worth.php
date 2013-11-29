<?php

/**
 * This is the model class for table "worth".
 *
 * The followings are the available columns in table 'worth':
 * @property integer $id
 * @property integer $worthtype_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property integer $price_buy
 * @property integer $price_sell
 * @property integer $prestige
 *
 * The followings are the available model relations:
 * @property Action[] $actions
 * @property Worthtype $worthtype
 */
class Worth extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'worth';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, image, price_buy, price_sell, prestige', 'required'),
			array('worthtype_id, price_buy, price_sell, prestige', 'numerical', 'integerOnly'=>true),
			array('name, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, worthtype_id, name, description, image, price_buy, price_sell, prestige', 'safe', 'on'=>'search'),
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
			'actions' => array(self::HAS_MANY, 'Action', 'worth_id'),
			'worthtype' => array(self::BELONGS_TO, 'Worthtype', 'worthtype_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'worthtype_id' => 'Worthtype',
			'name' => 'Name',
			'description' => 'Description',
			'image' => 'Image',
			'price_buy' => 'Price Buy',
			'price_sell' => 'Price Sell',
			'prestige' => 'Prestige',
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
		$criteria->compare('worthtype_id',$this->worthtype_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('price_buy',$this->price_buy);
		$criteria->compare('price_sell',$this->price_sell);
		$criteria->compare('prestige',$this->prestige);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Worth the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
