<?php
class StockShare {
    protected $id;    
    protected $number;
    protected $level;
    protected $basePrice;
    protected $range;
    protected $asset;

    public function __construct(Tool $tool) 
    {
        $this->id           = $tool->id;
        $this->level        = $tool->levelPrestige;
        $this->basePrice    = $tool->in_total_min;
        $this->range        = $tool->in_total_max;
    }
    
    public function instantiateAsset(Progress $progress, array $formData)
    {
        $this-> number = $formData['number'];
        $existAsset = Asset::model()->findByAttributes(array('tool_id' => $this->id, 'game_id' => $progress->game_id));
        if($existAsset)
        {
            $this->asset = $existAsset;
            $this->asset->balance_end       += $this->number * ShareRateManager::getLastRate($this->id, $progress);
            $this->asset->number         += $this->number;
            if($this->asset->save())
            {
                $shareStore                 = new ShareStore;
                $shareStore->tool_id        = $this->id;
                $shareStore->progress_id    = $progress->id;
                $shareStore->game_id        = $progress->game_id;
                $shareStore->step           = $progress->step;
                $shareStore->number         = $this->number;
                $shareStore->price          = ShareRateManager::getLastRate($this->id, $progress);
                $shareStore->total          = $shareStore->number * $shareStore->price;
                $shareStore->type           = 'b';
                if(!$shareStore->save())
                    echo CVarDumper::dump ($shareStore->getErrors (), 10, true);
            }
        }
        else
        {
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
            else // Store fact of buying new stock shares
            {
                $shareStore                 = new ShareStore;
                $shareStore->tool_id        = $this->id;
                $shareStore->progress_id    = $progress->id;
                $shareStore->game_id        = $progress->game_id;
                $shareStore->step           = $progress->step;
                $shareStore->number         = $this->number;
                $shareStore->price          = ShareRateManager::getLastRate($this->id, $progress);
                $shareStore->total          = $this->asset->balance_start;
                $shareStore->type           = 'b';
                if(!$shareStore->save())
                    echo CVarDumper::dump ($shareStore->getErrors (), 10, true);
            }
        }
    }
   public function setAsset(Asset $asset)
   {
       $this->asset = $asset;
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
       $price               =  ShareRateManager::getLastRate($asset->tool_id, $progress);
       $total               = $asset->number * $price;
       
       //logging selling process
       $this->logShareStore($progress, $asset, $asset->number, 's');
       
       $progress->deposit   += $total;
       $progress->save();
       
        //$asset->number       = 0;
        //$asset->balance_end -= $total;
        $asset->step_end    = $progress->step;
        $asset->status = 'c';
        $asset->save();
        
   }
   
   public function sellShare(Asset $asset, Progress $progress, $number)
   {
       $price   = ShareRateManager::getLastRate($asset->tool_id, $progress);
       $total   = $number * $price;
       //logging selling process
       $this->logShareStore($progress, $asset, $number, 's');
       
       $progress->deposit   += $total;
       
       
       $asset->number       -= $number;
       $asset->balance_end  -= $total;
       
       if($asset->save() && $progress->save())
           return TRUE;
       return FALSE;
   }
   
   private function logShareStore(Progress $progress, Asset $asset, $number, $status)
   {
       $price   = ShareRateManager::getLastRate($asset->tool_id, $progress);
       $total   = $number * $price;
       
       $shareStore                  = new ShareStore;
       $shareStore->tool_id         = $asset->tool_id;
       $shareStore->progress_id     = $progress->id;
       $shareStore->game_id         = $progress->game_id;
       $shareStore->step            = $progress->step;
       $shareStore->number          = $number;
       $shareStore->price           = $price;
       $shareStore->total           = $total;
       $shareStore->type            = $status;
       if($shareStore->save())
           return TRUE;
       return FALSE;
   }
}
