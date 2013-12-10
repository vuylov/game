<?php

class Deposit {
    
    private $id;
    private $procent;
    private $insurance;
    private $asset;

    public function __construct(Tool $tool) {
        $this->procent      = $tool->out_percent_total_max;
        $this->insurance    = $tool->insurance;
        $this->id           = $tool->id;
    }
    
    public function instantiateAsset(Progress $progress, array $formData)
    {
        $this->asset = new Asset;
        $this->asset->progress_id     = $progress->id;
        $this->asset->game_id         = $progress->game_id;
        $this->asset->tool_id         = $this->id;
        $this->asset->step_start      = $progress->step;
        $this->asset->step_end        = $this->asset->step_start + $formData['steps'];
        $this->asset->balance_start   = $formData['money'];
        $this->asset->balance_end     = $formData['money'];
        $this->asset->number          = 1;
        
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
       $delta               = ($asset->balance_end * $this->procent)/12; //formula
       $asset->balance_end += $delta;
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