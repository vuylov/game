<?php
class ConsumerCredit{
	private $id;
	private $asset;
	private $money;
	private $procent;

	public function __construct(Tool $tool)
	{
		$this->id	= $tool->id;
		$this->procent 	= $tool->userConfig->procent;
		$this->money 	= $tool->userConfig->range;
	}
        
        public function getProcent()
        {
            return $this->procent;
            //CVarDumper::
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
            $this->asset->number          = 1;

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
        
        /*
         * Formula for calculate coefficient of annuity payment
         * @param float $procent current procent rate
         * @param int $interval total credit monthes
         * return float $K coefficient of annuity payment
         */
        public function annuitetPayment($procent, $interval)
        {
            $monthProcent   = $procent / 12;
            $K              =   ($monthProcent*(pow(1 + $monthProcent, $interval))) / (pow(1+$monthProcent, $interval) - 1);
            return $K;
        }
        
        /*
         * Calculate month payment of credit based on procent, time interval
         * and amount money.
         * @param float $procent procent rate of credit
         * @param int $interval total credit monthes
         * @param int $credit total amount credit
         * @return int month payment
         */
        public function monthPayment($procent, $interval, $credit)
        {
            return round($this->annuitetPayment($procent, $interval) * $credit);
        }

        /*
         * Close credit payments earlier if enough money
         * @param Progress $progress current step of game
         * @param Asset $asset current asset of user
         * @return boolean TRUE/FALSE
         */
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