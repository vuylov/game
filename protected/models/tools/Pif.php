<?php
class Pif {
    private $id;
    private $basePrice;
    private $range;


    public function __construct(Tool $tool) {
        $this->id           = $tool->id;
        $this->basePrice    = $tool->in_total_min;
        $this->range        = $tool->in_total_max;
    }
    
    public function instantiateAsset(Progress $progress, array $formData){
        
    }
    
    public function startProcess(Progress $progress){
        
    }
    
    public function stepProcess(Progress $progress, Asset $asset){
        
    }
    
    public function endProcess(Progress $progress, Asset $asset){
        
    }
}
?>
