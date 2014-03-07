<?php
class GrandBaDeath implements IEvent{
    public function beforeEventHandler(\Progress $progress, \Event $event) {
        $progress->deposit += 100000.0;
        $progress->save();
    }
    
    public function afterEventHandler(\Progress $progress, \EventInProgress $event) {
        
    }
}
