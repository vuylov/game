<?php
class ConsumerCredit{
	private $id;
	private $asset;
	private $money;
	private $procent;

	public function __construct(Tool $tool)
	{
		$this->id	= $tool->id;
		$this->procent 	= $tool->in_step_min;
		$this->money 	= $tool->in_total_max;
	}
        
        public function getProcent()
        {
            return $this->procent;
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
            $this->asset->balance_end     = round($this->annuitetPayment($this->procent, $formData['steps']) * $this->asset->balance_start * $formData['steps']);

            if(!$this->asset->save() && defined('YII_DEBUG'))
            {
                    CVarDumper::dump($this->asset->getErrors(), 10, true);
            }
	}
        
        public function setAsset(Asset $asset)
        {
            $this->asset = $asset;
        }

        public function startProcess(Progress $progress)
	{
		$progress->deposit = $progress->deposit + $this->asset->balance_start;    
                $progress->save();
	}

	public function stepProcess(Progress $progress, Asset $asset)
	{
		$interval   = $asset->step_end - $asset->step_start;
		$delta      = $this->annuitetPayment($this->procent, $interval) * $asset->balance_start;          
		$asset->balance_end -= $delta;
		$asset->save();

		$progress->deposit -= round($delta);
		$progress->save();
	}

	public function endProcess(Progress $progress, Asset $asset)
	{
		$this->stepProcess($progress, $asset);

		$asset->status = 'c';
		$asset->save();
	}
        
        public function annuitetPayment($procent, $interval)
        {
            $monthProcent   = $procent / 12;
            $K              =   ($monthProcent*(bcpow(1 + $monthProcent, $interval, 4))) / (bcpow(1+$monthProcent, $interval, 4) - 1);
            return $K;
        }
        
        public function monthPayment($procent, $interval, $credit)
        {
            return round($this->annuitetPayment($procent, $interval) * $credit);
        }


        public function closeCredit(Progress $progress, Asset $asset)
        {
            if($progress->deposit > $asset->balance_end)
            {
                $progress->deposit -= round($asset->balance_end);
                $progress->save();
                
                $asset->status = 'c';
                $asset->save();
                return true;
            }
            else
            {
                return false;
            }
        }
}