<h2>Таблица рекордов</h2>
<?php $i = 1; ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'  => $dataProvider,
        'enableSorting' => false,
        'columns'       => array(
            array(
                'header' => 'Место',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
                'name'      => 'user.name',
                'header'    => 'Игрок',
                'value'     => '$data->user->name',
            ),
            array(
                'name'      => 'deposit',
                'header'    => 'Наличные'
            ),
            array(
                'name'      => 'scores',
                'header'    => 'Очки',
                'value'     => function($data){
                    printf("%d", $data->scores);
                }
            )
        ),
    ));?>
<?php //CVarDumper::dump($dataProvider, 15, true);