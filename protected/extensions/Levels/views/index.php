<?php for($i = 1; $i <=5; $i++):?>
    <span class="<?php echo ($i<=$level)?'game-level-star':'game-little-star';?>"></span>
<?php endfor;?>
<?php //echo $level; ?>
<?php if($up && !$win && !$fail):?>
    <?php if(!$start):?>
    <script>
		$(document).ready(function(){
			$("#game-layout-overlay").fadeIn("fast");
			$("#game-popup-header").remove();
			$("#game-popup").css({
				"left"		: "35px",
				"top"		: "3%",
				"max-width"	: "100%",
				"max-height": "100%"
			});
			$("#game-popup-content").css({
				"max-width"	: "100%",
				"max-height": "100%"
			});
			$("#game-popup-content").html("<video controls='' autoplay='' name='media' id='lvideo'><source src='<?php echo Yii::app()->baseUrl;?>/video/<?php echo $video; ?>' type='video/mp4'></video>");
			$("#lvideo").on("ended", function(){
				$("#popup-close-button").trigger("click");
                                return false;
			});
			$("#game-popup").fadeIn("fast");
			});
    </script>
    <?php else:?>
    
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/hopscotch.min.css" />
    <script src="<?php echo Yii::app()->baseUrl.'/js/hopscotch.min.js' ?>"></script>
    <script>
    $(document).ready(function(){
        //prepare tour config
        var tour = {
                    id: "Game guide",
                    i18n:{
                            nextBtn: "Далее",
                            prevBtn: "Назад",
                            doneBtn: "Готово",
                            closeTooltip: "Закрыть",
                    },
                    steps: [
                            {
                                title: "Игровая панель",
                                content: "Тут доступна основная информация об игре",
                                target: ".person-information",
                                placement: 'bottom',
                                xOffset: "center",
                                arrowOffset: "center"
                            },
                            {
                                title: "Аватар",
                                content: "Аватар игрока. Пока изменять нельзя, но мы над этим работаем",
                                target: ".game-panel-block-avatar",
                                placement: "right"
                            },
                            {
                                title: "Ход",
                                content: "Текущий ход в игре",
                                target: "#game-panel-step",
                                placement: "bottom"
                            },
                            {
                                title: "Наличные",
                                content: "Текущая сумма доступных денежных средств",
                                target: "#game-panel-money",
                                placement: "bottom"
                            },
                            {
                                title: "Ежеходный доход",
                                content: "Количество денежных средств, которые будут получены игроком на следующем ходу",
                                target: "#game-panel-money-step",
                                placement: "bottom"
                            },
                            {
                                title: "Престиж",
                                content: "Очки престижа даются игроку за покупки ценностей в магазине",
                                target: "#game-prestige",
                                placement: "bottom"
                            },
                            {
                                title: "Уровень",
                                content: "Текущий уровень игрока",
                                target: "#game-level-stars",
                                placement: "bottom"
                            },
                            {
                                title: "Ход",
                                content: "Следующий ход",
                                target: ".next-step",
                                placement: "left"
                            },
                            {
                                title: "Игровое поле",
                                content: "Игровая локация. Все визуальные изменения в игре будут происходить здесь",
                                target: "#game-field",
                                placement: "left"
                            },
                            {
                                title: "Магазин",
                                content: "Здесь продаются игровые ценности",
                                target: "#game-shop",
                                placement: "left"
                            },
                            {
                                title: "Дом игрока",
                                content: "Здесь отображаются купленные игроком ценности, а также учитываются используемые финансовые инструменты",
                                target: "#game-trailer",
                                placement: "top",
                                arrowOffset: "center"
                            },
                            {
                                title: "Руководство",
                                content: "Ссылка на полнотекстовое руководство пользователя по игре",
                                target: "#game-manual",
                                placement: "top"
                            },
                            {
                                title: "Подсказки",
                                content: "Игровые подсказки по основным финансовым институтам и инструментам",
                                target: "#game-tips",
                                placement: "top"
                            },
                            {
                                title: "Новости",
                                content: "Перечень новостей, возникающих в текущем ходе игры. Новости являются причиной (с некоторой долей верочтности) событий, поэтому следует уделять им особое внимание",
                                target: "#game-news",
                                placement: "top",
                                arrowOffset: "center"
                            },
                            {
                                title: "События",
                                content: "Перечень свершившихся событий",
                                target: "#game-events",
                                placement: "top",
                                arrowOffset: "center"
                            }
                                    
                    ],
                    showPrevButton: true,
                    showNextButton: true,
                    onEnd: function(){
                        $("#game-layout-overlay").fadeOut("fast");
                        $("#popup-close-button").trigger("click");
                    },
                    onClose: function(){
                        $("#game-layout-overlay").fadeOut("fast");
                        $("#popup-close-button").trigger("click");
                    }
            };
        $("#game-layout-overlay").fadeIn("fast");
        $("#game-popup-header, #popup-close-button").hide();
        $("#game-popup").css({
                "left"		: "35px",
                "top"		: "3%",
                "max-width"	: "100%",
                "max-height": "100%"
        });
        $("#game-popup-content").css({
                "max-width"	: "100%",
                "max-height": "100%"
        });
        $("#game-popup-content").html("<video controls='' autoplay='' name='media' id='lvideo'><source src='<?php echo Yii::app()->baseUrl;?>/video/<?php echo $video; ?>' type='video/mp4'></video>");
        $("#lvideo").on("ended", function(){
                $("#game-popup").fadeOut("fast");
                hopscotch.startTour(tour);
                return false;
        });
        $("#game-popup").fadeIn("fast");
        });     
    </script>
    <?php endif;?>
<?php elseif($fail || $win):?>
    <script>
    $(document).ready(function(){
        $("#popup-close-button").remove();//remove standard close button with his click handler
        $("<div class='alt-close-button'></div>").appendTo($("#game-popup"));
        $("#game-layout-overlay").fadeIn("fast");
		$("#game-popup-header").remove();
		$("#game-popup").css({
				"left"		: "35px",
				"top"		: "3%",
				"max-width"	: "100%",
				"max-height": "100%"
			});
			$("#game-popup-content").css({
				"max-width"	: "100%",
				"max-height": "100%"
			});
        $("#game-popup-content").html("<video controls='' autoplay='' name='media' id='evideo'><source src='<?php echo Yii::app()->baseUrl;?>/video/<?php echo $video; ?>' type='video/mp4'></video>");
		$("#evideo").on("ended", function(){
				window.location.href = "<?php echo Yii::app()->createAbsoluteUrl('site/ranking'); ?>";
			});
        $("#game-popup").fadeIn("fast");
		
        $(".alt-close-button").on('click', function(){
            window.location.href = "<?php echo Yii::app()->createAbsoluteUrl('site/ranking'); ?>";
            })
        });
    </script>
<?php endif; ?>