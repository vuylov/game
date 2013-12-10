<?php
class StockShare {
    private $id;    
    private $number;
    private $level;
    private $basePrice;
    private $range;
    private $asset;

    public function __construct(Tool $tool) 
    {
        $this->id           = $tool->id;
        $this->level        = $tool->levelPrestige;
        $this->basePrice    = $tool->in_total_min;
        $this->range        = $tool->in_total_max;
    }
    
    public function instantiateAsset(Progress $progress, array $formData)
    {
        $this->number                 = $formData['number']; 
        $this->asset                  = new Asset;
        $this->asset->progress_id     = $progress->id;
        $this->asset->game_id         = $progress->game_id;
        $this->asset->tool_id         = $this->id;
        $this->asset->step_start      = $progress->step;
        $this->asset->step_end        = 0;// this for tools without end action
        $this->asset->balance_start   = $this->number * ShareRateManager::getLastRate($this->id, $progress);
        $this->asset->balance_end     = $this->asset->balance_start;
        $this->asset->number          = $this->number;
        
        if(!$this->asset->save() && defined('YII_DEBUG'))
        {
            echo CVarDumper::dump($this->asset->getErrors(), 10, true);
        }
    }
    
    public function startProcess(Progress $progress)
   {
        $progress->deposit = $progress->deposit - $this->asset->balance_start;    
        $progress->save();
   }
   
   public function stepProcess(Progress $progress, Asset $asset)
   {
       $asset->balance_end = $asset->number * ShareRateManager::getLastRate($asset->tool_id, $progress);
       $asset->save();
   }

   public function endProcess(Progress $progress, Asset $asset)
   {
        //calculate last step
        $this->stepProcess($progress, $asset);
        //change state of current step
        $progress->deposit += floor($asset->balance_end);
        $progress->save();
        //close asset with status 'c - close'
        $asset->status = 'c';
        $asset->save();
   }
}
