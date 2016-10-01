<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php echo $template['meta']; ?>
<link href="/css/index.css"  rel="stylesheet" type="text/css">
<link href="/css/toggle-switch.css" rel="stylesheet" type="text/css">
</head>
<body class="back">
	<div class="top_menu">
		<table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td width="230px" align="center"><p class="title_font_header"><span class="color_med">Med</span><span class="color_obmen">Obmen</span></p></td>
				<td align="left" class="title_link_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="title_link_number">&#9742; +38 097-444-5-222</span></td>
				<td align="right"><a href="#"><img src="/images/mail.gif"></a>&nbsp;&nbsp;&nbsp;<a href="#"><img src="/images/map.gif"></a></td>
			</tr>
			<tr>
				<td class="title_font_header1" align="center">МедОбмен</td>
				<td align="left" class="menu"><?php echo $template['login']; ?></td>
				<td align="right"><input class="title_search" id="search_target1" placeholder="Поиск препаратов" autocomplete="off"></td>
			</tr>
		</table>
	</div>
    <?php include 'application/views_main/'.$content_view; ?>

	<!-- начало вставки слайдера для горизонтальной рекламы -->
	<script type='text/javascript' src='/js/jquery-1.11.1.min.js'></script>	
	<script type="text/javascript" src="/js/jssor.core.js"></script>
	<script type="text/javascript" src="/js/jssor.utils.js"></script>
	<script type="text/javascript" src="/js/jssor.slider.js"></script>
	<script type="text/javascript" src="/js/datapic/jquery.plugin.js"></script> 
	<script type="text/javascript" src="/js/datapic/jquery.datepick.js"></script>
	<script type="text/javascript" src="/js/jquery.datepick-ru.js"></script>
	<script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 160,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                $SlideWidth: 200,                                   //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                $SlideHeight: 100,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 3, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 5,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                              //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 4                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(bodyWidth, 1000));
                else
                    window.setTimeout(ScaleSlider, 30);
            }

            ScaleSlider();

            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                $(window).bind('resize', ScaleSlider);
            }


            //if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
            //    $(window).bind("orientationchange", ScaleSlider);
            //}
            //responsive code end
        });
    </script>
<script>
$(function() {
	$('#popupDatepicker').datepick();
});
$(function() {
	$('#popupDatepicker1').datepick();
});
$(function() {
	$('#popupDatepicker2').datepick();
});
</script>
    <!-- Jssor Slider Begin -->
    <!-- You can move inline styles to css file or css block. -->
	<center>
    <div style="background:rgba(0, 0, 0, 0.5);">
	<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 1000px; height: 100px; overflow: hidden;">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(/img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1000px; height: 100px; overflow: hidden;">
			<?php echo $template['banner']; ?>
        </div>
        
        <!-- Bullet Navigator Skin Begin -->
        <style>
            /* jssor slider bullet navigator skin 03 css */
            /*
            .jssorb03 div           (normal)
            .jssorb03 div:hover     (normal mouseover)
            .jssorb03 .av           (active)
            .jssorb03 .av:hover     (active mouseover)
            .jssorb03 .dn           (mousedown)
            */
            .jssorb03 div, .jssorb03 div:hover, .jssorb03 .av
            {
                background: url(/img/b03.png) no-repeat;
                overflow:hidden;
                cursor: pointer;
            }
            .jssorb03 div { background-position: -5px -4px; }
            .jssorb03 div:hover, .jssorb03 .av:hover { background-position: -35px -4px; }
            .jssorb03 .av { background-position: -65px -4px; }
            .jssorb03 .dn, .jssorb03 .dn:hover { background-position: -95px -4px; }
        </style>
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb03" style="position: absolute; bottom: 4px; right: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype" style="position: absolute; width: 21px; height: 21px; text-align:center; line-height:21px; color:white; font-size:12px;"><NumberTemplate></NumberTemplate></div>
        </div>
        <!-- Bullet Navigator Skin End -->
        
        <style>
            /* jssor slider arrow navigator skin 03 css */
            /*
            .jssora03l              (normal)
            .jssora03r              (normal)
            .jssora03l:hover        (normal mouseover)
            .jssora03r:hover        (normal mouseover)
            .jssora03ldn            (mousedown)
            .jssora03rdn            (mousedown)
            */
            .jssora03l, .jssora03r, .jssora03ldn, .jssora03rdn
            {
            	position: absolute;
            	cursor: pointer;
            	display: block;
                background: url(/img/a03.png) no-repeat;
                overflow:hidden;
            }
            .jssora03l { background-position: -3px -33px; }
            .jssora03r { background-position: -63px -33px; }
            .jssora03l:hover { background-position: -123px -33px; }
            .jssora03r:hover { background-position: -183px -33px; }
            .jssora03ldn { background-position: -243px -33px; }
            .jssora03rdn { background-position: -303px -33px; }
        </style>
        <span u="arrowleft" class="jssora03l" style="width: 55px; height: 55px; top: 123px; left: 8px;">
        </span>
        <span u="arrowright" class="jssora03r" style="width: 55px; height: 55px; top: 123px; right: 8px">
        </span>
    </div>
	</div>
	</center>
    <!-- Jssor Slider End -->
	
<center>
	<!--div class="blocks">
		<table border="0" cellpadding="0" cellspacing="0" align="center" class="block_height">
			<tr height="75px">
				<td class="bloks_ads_arrow" align="right" valign="middle"><p>«</p></td>
				<td><div class="bloks_ads"><br>Реклама</div><div class="bloks_ads"><br>Реклама</div><div class="bloks_ads"><br>Реклама</div><div class="bloks_ads"><br>Реклама</div></td>
				<td class="bloks_ads_arrow" align="left" valign="middle"><p>»</p></td>
			</tr>
		</table>
	</div-->
	<br>
	<div class="footter_prim">
		<p class="footter_prim_text">Сколько не нужных медикаментов Вам не нужны и/или подходит к окончанию их срок применения? Возможно кто-то нуждается в них!</p>
		<p class="footter_prim_text1">Сделайте доброе дело, добавьте медикаменты и/или медтехнику, которые Вы готовы отдать бесплатно. Помимо этого тут Вы можете найти для себя медпрепараты, которые вам нужны</p>
	</div>
</center>
<br><br>
<div class="sochial_net">
	<div><?php if(isset($template['link']['fb'])) echo $template['link']['fb'];?><img src="/images/swf/facebook.png"><br>Facebook<?php if(isset($template['link']['fb'])) echo "</a>";?></div>
	<div><?php if(isset($template['link']['li'])) echo $template['link']['li'];?><img src="/images/swf/linkedin.png"><br>Linkedin<?php if(isset($template['link']['li'])) echo "</a>";?></div>
	<div><?php if(isset($template['link']['od'])) echo $template['link']['od'];?><img src="/images/swf/odnoklassniki.png"><br>Odnoklassniki<?php if(isset($template['link']['od'])) echo "</a>";?></div>
	<div><?php if(isset($template['link']['tw'])) echo $template['link']['tw'];?><img src="/images/swf/twitter.png"><br>Twitter<?php if(isset($template['link']['tw'])) echo "</a>";?></div>
	<div><?php if(isset($template['link']['vk'])) echo $template['link']['vk'];?><img src="/images/swf/vkontakte.png"><br>Vkontakte<?php if(isset($template['link']['vk'])) echo "</a>";?></div>
	<div><?php if(isset($template['link']['go'])) echo $template['link']['go'];?><img src="/images/swf/g_plas.png"><br>Google+<?php if(isset($template['link']['go'])) echo "</a>";?></div>
</div>	
<script type="text/javascript" src="/js/cookies/jquery.cookie.js"></script>
<script type='text/javascript' src='/js/lib.js'></script>
</body>
</html>
