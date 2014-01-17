<?php
class CharityMicrosoft implements IEvent{
    public function beforeEventHandler(\Progress $progress, \Event $event) {
        echo 'start event CHARITY OF MICROSOFT<br>';
    }
    
    public function afterEventHandler(\Progress $progress, \EventInProgress $event) {
        echo 'end event CHARITY OF MICROSOFT<br>';
    }
}
