<?php
interface IEvent {
    public function beforeEventHandler(Progress $progress, Event $event);
    public function afterEventHandler(Progress $progress, EventInProgress $event);
}
