<?php
class FallGoogle implements IEvent{
    public function beforeEventHandler(\Progress $progress, \Event $event) {
        echo 'start event Fall Google';
    }
    
    public function afterEventHandler(\Progress $progress, \EventInProgress $event) {
        echo 'stop event Fall Google';
    }
}
