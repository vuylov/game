<?php
class StockShare {
    private $id;
    private $asset;


    public function __construct(Tool $tool) {
        
    }
    
    public function instantiateAsset(Progress $progress, array $formData)
    {
        
        $this->asset = new Asset;
        $this->asset->progress_id     = $progress->id;
        $this->asset->game_id         = $progress->game_id;
        $this->asset->tool_id         = $this->id;
        $this->asset->step_start      = $progress->step;
        $this->asset->step_end        = 0;// this for tools without end action
        $this->asset->balance_start   = $formData['money'];
        $this->asset->balance_end     = $formData['money'];
        
        if(!$this->asset->save() && defined('YII_DEBUG'))
        {
            echo CVarDumper::dump($this->asset->getErrors(), 10, true);
        }
    }
}
