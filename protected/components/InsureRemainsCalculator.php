<?php
class InsureRemainsCalculator {
    public static function Calculate(Progress $progress, WorthInsure $worthInsure)
    {
        $remainsSteps = $worthInsure->step_end - $progress->step;
        return floor($worthInsure->value / Yii::app()->params['insure_period'] * $remainsSteps * Yii::app()->params['insure_rate']);
    }
}
