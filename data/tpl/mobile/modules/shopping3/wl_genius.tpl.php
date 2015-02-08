<?php defined('IN_IA') or exit('Access Denied');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<link rel="stylesheet" type="text/css" href="<?php echo RES;?>css/wei_canyin.css" media="all" />
<script type="text/javascript" src="<?php echo RES;?>js/jQuery.js"></script>
<script type="text/javascript" src="<?php echo RES;?>js/wei_webapp_v2_common.js"></script>
<title><?php  echo $set['shop_name'];?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="format-detection" content="telephone=no" />
</head>
<body id="page_count">
    
    <div class="center main">
        <section>
            <ol>
                
            </ol>
        </section>
    </div>
    <div class="notice">
        <b>请选择您的用餐人数</b>
    </div>
        <div class="center">
		<form id="re-location" action="<?php  echo  $this->createMobileUrl('wlgenius',array('subcp'=>'disheslist'))?>" method="post">
			<input type="hidden" name="combo_nums" value=""/>
		</form>
        <a class="order" href="#" onclick="return doSelected()" id="order"><span>开始点菜</span></a>
    </div>
		<div id="footer_menu" class="footer footer_menu">
            <ul class="clear">
				<li style="width:20%"><a  href="<?php  echo  $this->createMobileUrl('wlindex')?>"><span class="icons icons_1"></span><label>店铺首页</label></a></li>	
				<li style="width:20%"><a  href="<?php  echo  $this->createMobileUrl('wlindex')?>" ><span class="icons icons_2"></span><label>选购<label></a></li>
              	<li style="width:20%"><a href="<?php  echo  $this->createMobileUrl('wlgenius')?>" class="onactive"><span class="icons icons_1"></span><label>智能选餐</label></a></li>	
				<li style="width:20%"><a href="<?php  echo  $this->createMobileUrl('wlmember',array('status'=>1))?>" ><span class="icons icons_3"></span><label>我的订单</label></a></li>
                <li style="width:20%"><a href="javascript:void(0);" id="my_menu"><span class="icons icons_5"><label id="num" class="num"><?php  echo intval($totalnum)?></label></span></a></li>			
            </ul>
        </div>
        <script>
            var footer = document.getElementById("footer_menu");
            var evtObj = {
                handleEvent: function(evt){
                    if("A" == evt.target.tagName){
                        evt.target.classList.toggle("on");
                    }
                }
            }
            footer.addEventListener("touchstart", evtObj, false);
            footer.addEventListener("touchend", evtObj, false);
        </script>
        
    <script>
        window.selected = {
            total:0,
            dishes:{}
        };
        var counts = <?php  echo count($rens)?>;
        var cardid = "3414907165";
        if(counts > 1){
            var nums = new Array(<?php  echo implode(',',$rensArr)?>);
        }else{
            var nums = new Array("<?php  echo implode(',',$rensArr)?>");
        }
        
        var _selectedCount = 0; //选择好的人数会同步到这个变量里
        function SliderChooser(config){ var container = _q(config.containerContext), inner = _q(config.innerContext, container), nums = config.nums, itemW = config.itemWidth, curr = 1, w = container.clientWidth, drag_start = {time: 0, left: 0, top: 0, x: 0, y: 0, lx: 0, ly: 0}, drag_end = {left: 0}, directionLocked = null, time = function(){ return (new Date).getTime(); }, getP = function(e){ var t = e.touches[0], c = e.currentTarget.parentNode, r = c.parentNode.getClientRects()[0]; return { x: t.pageX-r.left, y: t.pageY-r.top, px: t.pageX, py: t.pageY, cx: t.clientX, cy: t.clientY, sx: t.screenX, sy: t.screenY }; }, getLeft = function(dom){ return parseFloat( /\((\-?[\.\d]+)px/.exec( dom.style[_vendor + 'Transform'] )[1] ); }, setCurr = function(idx) { curr = idx; _forEach(_qAll(config.itemContext, inner), function(li, liIdx){ _removeClass(li, config.currentStyleClass); if (idx == liIdx){ _addClass(li, config.currentStyleClass); } }); }, doTransition = function(value, tweenMode) { var d = tweenMode? /*as idx*/-value*itemW : value, s = tweenMode ? 6.18 * 4 * .01 : 0; inner.style[_vendor + 'TransitionDuration'] = s + 's'; inner.style[_vendor + 'Transform'] = _trnOpen + d + 'px,0' + _trnClose; }, e_ts = function(e) /*touchstart*/ { if (!_touchSupport) e.preventDefault(); directionLocked = null; var p1 = getP(e), p2 = { x: drag_end.left*1, y: inner.getClientRects()[0].top }; drag_start = { time: time(), left: p2.x, top: p2.y, x: parseInt(p2.x - p1.x), y: parseInt(p2.y - p1.y), lx: e.touches[0].clientX, ly: e.touches[0].clientY, point: p1 }; e.currentTarget.addEventListener("touchmove", e_tm); e.currentTarget.addEventListener("touchend", e_te); e.currentTarget.addEventListener("touchcancel", e_te); }, e_tm = function(e) /*touchmove*/ { if (!_touchSupport) e.preventDefault(); var p = getP(e), c = e.currentTarget.parentNode, v = drag_start.x + p.x; /*横纵拖动互不干扰*/ var absDistX, absDistY, deltaX = e.touches[0].pageX - drag_start.point.px, deltaY = e.touches[0].pageY - drag_start.point.py; if (directionLocked === "y") { return } else { if (directionLocked === "x") { e.preventDefault() } else { absDistX = Math.abs(deltaX); absDistY = Math.abs(deltaY); if (absDistX < 4) { return } if (absDistY > absDistX * 0.58) { directionLocked = "y"; return } else { e.preventDefault(); directionLocked = "x"; } } } doTransition( v ); if (MData(c, 'touching') === undefined || MData(c, 'touching')*1 != 1) MData(c, 'touching', 1); }, e_te = function(e) /*touchend*/ { if (!_touchSupport)    e.preventDefault(); e.currentTarget.removeEventListener("touchmove", e_tm); e.currentTarget.removeEventListener("touchend", e_te); e.currentTarget.removeEventListener("touchcancel", e_te); var c = e.currentTarget.parentNode; MData(c, 'touching', 0); try{ drag_end.left = getLeft(c); }catch(ex){} var idx = curr, p2 = { x: drag_end.left, y: c.getClientRects()[0].top }, tTime = time() - drag_start.time, tDis = p2.x - drag_start.left, shortDis = Math.abs(tDis)<5, longTime = tTime > 300; if (!longTime && !shortDis){ /*快速拖动*/ if (tDis < 0) /*left*/ idx++; else /*right*/ idx--; }else{ /*一般拖动*/ if ( Math.abs(tDis) > .5*itemW ){ var d1 = Math.abs(Math.round(tDis/itemW)); if( tDis < 0 ) idx += d1; else idx -= d1; } } if (idx<1) idx = 1; if (idx>=nums.length-2) idx = nums.length-2; doTransition(idx-1, true); drag_end.left = getLeft(c); setCurr(idx); if ('callback' in config && !!config.callback){ config.callback.call(null, curr-1); } }; nums.unshift(-1); nums.push(-1); _forEach(nums, function(n,idx,arr){ inner.insertAdjacentHTML('beforeEnd', '<'+config.itemContext+'>'+n+'</'+config.itemContext+'>'); var li = _q(config.itemContext+':last-of-type', inner); if (idx==0 || idx == arr.length-1){ _addClass(li, 'sider'); return; } li.addEventListener("touchstart", e_ts); li = null; }); inner.style.width = itemW * nums.length + 'px'; setCurr(1); };
        function scCallback(currIdx){
            _forEach(_qAll('section li'), function(li){
                _removeClass(li, 'left');
                _removeClass(li, 'right');
            });
            var l = _q('section li:nth-of-type('+(currIdx+1)+')'),
                r = _q('section li:nth-of-type('+(currIdx+3)+')');
            _addClass(l, 'left');
            _addClass(r, 'right');
            l = null;
            r = null;
            _selectedCount = parseInt(_q('section li:nth-of-type('+(currIdx+2)+')').innerHTML);
        }
        _onPageLoaded(function(){
            _q('body').scrollTop = -1; 
            window.scrollTo(0,-1); 
            _q('body').style.height = window.innerHeight + 'px'; 
            var obtn = _q('.order'); 
            obtn.style.marginTop = '80px'; //(window.innerHeight - 280 - 75) + 'px';
            
            SliderChooser({
                nums: nums,
                containerContext: 'section',
                innerContext: 'ol',
                itemContext: 'li',
                itemWidth: 106,
                currentStyleClass: 'curr',
                callback: scCallback
            });
            scCallback(0);
        });
        function doSelected() {
               $('#re-location input[name="combo_nums"]').val(_selectedCount);
               $('#re-location').submit();
               return false;
        }
        
        function addToMenu(){  
			location.href='<?php  echo  $this->createMobileUrl('wlcart')?>';
        }

    </script>
    <script>
    $(document).ready(function(){
        $('#my_menu').click(function(){
            addToMenu();

	});
        
    });
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideToolbar');
    });
</script>
</body>
</html>
