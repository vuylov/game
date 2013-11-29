<?php
/**
 * Description of SecureController
 *
 * @author admin
 */
class SecureController extends Controller {
    //put your code here
    public function filters() {
        //parent::filters();
        return array('accessControl');
    }
    
    public function accessRules() {
        //parent::accessRules();
        return array(
            array('allow', 'users'=>array('@')),
            array('deny', 'users'=>array('*'))
        );
    }
}
