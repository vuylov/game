<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    /**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
            $record = User::model()->findByAttributes(array('email'=>  $this->username));
            if($record === null)
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            elseif($record->password!==  crypt($this->password, $this->password))
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            else
            {
                $this->_id = $record->id;
                $this->setState('id', $record->id);
                $this->setState('name', $record->name);
                $this->errorCode = self::ERROR_NONE;
            }
            
            return !$this->errorCode;
	}
        
        public function getId() {
            //parent::getId();
            return $this->_id;
        }
}