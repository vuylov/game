<div>Поздравляем с покупкой. Вовзращайтесь к нам еще!</div>
<div><?php echo CHtml::ajaxLink(
                    'Закрыть',
                    $this->createUrl('game/reload'),
                    array('success'=>'function(response){$("#game-content").html(response);}'),
                    array('id' => mt_rand(1, 10000))
                    ); 
?></div>