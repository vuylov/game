<div id="actives-passives">
    <table>
        <caption>Активы / Пассивы</caption>
        <tr><td>Наименование</td><td>Стоимость продажи</td><td>Доход</td><td>Расход</td></tr>
        <tr>
            <td>Заработная плата</td><td>-</td><td><?php echo Yii::app()->params['income']; ?></td><td>-</td>
        </tr>
        <?php $this->widget('ext.ActivitiesList.ActivitiesList', array(
            'step' => $step,
        )); ?>
        <?php $this->widget('ext.Assets.MyAssets', array('step'=> $step)); ?>
        <tr>
            <td colspan="4">
                <hr>
                Ежеходный доход: <?php echo ProgressIncome::getStepProgressIncome($step, TRUE); ?>
            </td>
        </tr>
    </table>
</div>
<div class="insure">
    <div class="insure title">Страхование</div>
    <div>
        <?php $this->widget('ext.Insurance.InsuranceList', array('step'=> $step)); ?>
    </div>
</div>