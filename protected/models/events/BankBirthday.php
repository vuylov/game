<?php

class BankBirthday implements IEvent{
    public function beforeEventHandler(\Progress $progress, \Event $event) {
        echo 'before bank birthday';
    }
    public function afterEventHandler(\Progress $progress, \EventInProgress $event) {
        echo 'after bank birthday';
    }
}
