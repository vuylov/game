<?php
/*
 * Событие: ежеквартальный отчет гугл о прибыли
 */
class GoogleReport implements IEvent {
      
    public function beforeEventHandler(Progress $progress, Event $event)
    {
        echo 'bHandler of Google Report';
    }
    
    public function afterEventHandler(Progress $progress, EventInProgress $event)
    {
        echo 'aHandler of Google Report';
    }
}
