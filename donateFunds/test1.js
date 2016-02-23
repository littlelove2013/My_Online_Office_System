/**
 * 编写JS弹窗组件
 * @date 2013-12-10
 * @author tugenhua
 * @email 879083421@qq.com
 */

 function Overlay(options){
    
    this.config = {

        targetCls          :   '.clickElem',          // 点击元素
        title              :  '我是龙恩',             // 窗口标题
        content            :  'text:<p style="width:100px;height:100px">我是龙恩</p>',
        //content            :  'img:http://gtms01.alicdn.com/tps/i1/T1USkqFc0dXXb5rXb6-1060-300.jpg',
                                                      // 窗口内容 {text:具体内容 | id:id名 | img:图片链接 | 
                                                      // iframe:src链接} {string}                                                                                             
        width              :  400,                    // 内容的宽度
        height             :  300,                    // 内容的高度
        theight            :  30,                     // 标题的高度 默认为30
        drag               :  true,                   // 是否可以拖动 默认为true
        time               :  3000,                   // 自动关闭窗口的时间 为空或者'undefined'则不关闭
        showBg             :  true,                   // 设置是否显示遮罩层 默认为true 遮罩
        closable           :  '#window-close',        // 关闭按钮
        bgColor            :  '#000',                 // 默认颜色
        opacity            : 0.5,                     // 默认透明度
        position           : {
            x: 0,
            y: 0                                      //默认等于0 居中
        },
        zIndex             :                          10000,
        isScroll           : true,                    //默认情况下 窗口随着滚动而滚动
        isResize           : true,                    // 默认情况下 随着窗口缩放而缩放
        callback           : null                     //弹窗显示后回调函数

    };

    this.cache = {
        isrender     :    true,            // 弹窗html结构只渲染一次
        isshow       :    false,           // 窗口是否已经显示出来
        moveable     :    false
    };

    this.init(options);
 }

 Overlay.prototype = {
    
    constructor: Overlay,
    
    init: function(options){
        this.config = $.extend(this.config,options || {});
        var self = this,
            _config = self.config,
            _cache = self.cache;
        $(_config.targetCls).each(function(index,item){
            
            $(item).unbind('click');
            $(item).bind('click',function(){

                // 渲染弹窗HTML结构
                self._renderHTML();
                
                // 窗口移动 
                self._windowMove();
            });
        });
        
        // 窗口缩放
        self._windowResize('#window-box');

        // 窗口随着滚动条一起滚动
        self._windowIsScroll('#window-box');

        
         
    },
    /*
     * 渲染弹窗HTML结构
     */
    _renderHTML: function(){
        var self = this,
            _config = self.config,
            _cache = self.cache;
        var html ='';
        if(_cache.isrender) {

            html+= '<div id="windowbg" style="display:none;position:absolute;top:0;left:0;"></div>' + 
                    '<div id="window-box" style="display:none;overflow:hidden;">' +
                        '<div class="window-title"><h2></h2><span id="window-close">关闭</span></div>'+
                        '<div id="window-content-border"><div id="window-content"></div></div>' + 
                    '</div>';
             
            $('body').append(html);
            
            $("#windowbg").css('z-index',_config.zIndex);
            $('#window-content-border').css({'width':_config.width + 'px','height':_config.height + 'px','overflow':'auto'});
            
            $('.window-title h2').html(_config.title);
            $('.window-title').css({'height':_config.theight + 'px','width':_config.width,'overflow':'hidden'});
            _cache.isrender = false;
            
            // 判断传递进来的内容格式
            self._contentType();
            if(_config.showBg) {
                // 渲染背景宽度和高度
                self._renderDocHeight();
                $("#windowbg").show();
                
                self.show();
            }else {
                $("#windowbg").hide();
                self.show();
            }
            self._showDialogPosition("#window-box");
         }else {
            
            // 如果弹窗已经创建出来的话, 只是隐藏掉了, 那么我们显示出来
            self.show();
            $("#windowbg").animate({"opacity":_config.opacity},'normal');
            if(_config.showBg) {
                $("#windowbg").show();
            }
            
            self._showDialogPosition("#window-box");
         }
         $(_config.closable).unbind('click');
         $(_config.closable).bind('click',function(){
            // 点击关闭按钮
            self._closed();
         });

         // 渲染后 回调函数
         _config.callback && $.isFunction(_config.callback) && _config.callback();
    },
    /**
     * 显示弹窗
     */
     show: function(){
        var self = this,
            _config = self.config,
            _cache = self.cache;
        $("#window-box") && $("#window-box").show();
        _cache.isshow = true;
        if(_config.time == '' || typeof _config.time == 'undefined') {
            return;
        }else {
            t && clearTimeout(t);
        var t = setTimeout(function(){
                self._closed();
            },_config.time);
        }
     },
     /**
      * 隐藏弹窗
      */
     hide: function(){
        var self = this,
            _cache = self.cache;
        $("#window-box") && $("#window-box").hide();
        _cache.isshow = false;
     },
     /**
      *    判断传进来的内容类型
      */
     _contentType: function(){
        var self = this,
            _config = self.config,
            _cache = self.cache;

        var contentType =  _config.content.substring(0,_config.content.indexOf(":")),
            content = _config.content.substring(_config.content.indexOf(":")+1,_config.content.length);
        
        switch(contentType) {
            case 'text': 
                $('#window-content').html(content);
                
            break;

            case 'id':
                $('#window-content').html($('#'+content).html());
                
            break;

            case 'img':
                $('#window-content').html("<img src='"+content+"' class='window-img'/>");
                
            break;

            case 'iframe':
                $('#window-content').html('<iframe src="'+content+'" width="100%" height="100%" scrolling="yes" frameborder="0"></iframe>');
                $("#window-content-border").css({'overflow':'visible'});
                
            break;
        }
     },
     /**
      * 点击关闭按钮
      */
     _closed: function(){
        var self = this,
            _config = self.config,
            _cache = self.cache;
        if(_cache.isshow) {
            self.hide();
        }
        if(_config.showBg) {
            $("#windowbg").hide();
        }
        $("#windowbg").animate({"opacity":0},'normal');
     },
     /**
      * 显示弹窗的位置 默认情况下居中
      */
     _showDialogPosition: function(container) {
         var self = this,
             _config = self.config,
             _cache = self.cache;
         $(container).css({'position':'absolute','z-index':_config.zIndex + 1});
         var offsetTop = Math.floor(($(window).height() - $(container).height())/2) + $(document).scrollTop(),
             offsetLeft = Math.floor(($(window).width() - $(container).width())/2) + $(document).scrollLeft();

         // 判断x,y位置默认是不是等于0 如是的话 居中 否则 根据传进来的位置重新定位
        if(0 === _config.position.x && 0 === _config.position.y){

            $(container).offset({'top':offsetTop, 'left':offsetLeft});
        }else{
            $(container).offset({'top':_config.position.y,'left':_config.position.x});
        }
     },
     /**
      * 渲染底部背景的高度
      */
      _renderDocHeight: function(){
         var self = this,
             _config = self.config;
         $("#windowbg").animate({"opacity":_config.opacity},'normal');
         if(self._isIE6()){
            $("#windowbg").css({'background':'#fff','height':$(document).height()+'px','width':$(document).width()+"px"});
         }else {
            $("#windowbg").css({'background':_config.bgColor,'height':$(document).height()+'px','width':$(document).width()+"px"});
         }
         
      },
      /*
       * 窗口缩放
       */
      _windowResize: function(elem){
         var self = this,
             _config = self.config;
         $(window).unbind('resize');
         $(window).bind('resize',function(){
             t && clearTimeout(t);
             var t = setTimeout(function(){
                 if(_config.isResize){
                     self._showDialogPosition(elem);
                     self._renderDocHeight();
                 }
             },200);
         });
      },
    /**
     * 窗口是否随着滚动条一起滚动
     */
     _windowIsScroll: function(elem){
        var self = this,
            _config = self.config;
        $(window).unbind('scroll');
        $(window).bind('scroll',function(){
            t && clearTimeout(t);
             var t = setTimeout(function(){
                 if(_config.isScroll){
                     self._showDialogPosition(elem);
                     self._renderDocHeight();
                 }
             },200);
        });
     },
     /**
      * 窗口移动
      */
     _windowMove: function(){
        var self = this,
            _config = self.config,
            _cache = self.cache;
        var mouseX = 0,
            mouseY = 0;
        
        $('.window-title').mouseenter(function(){
            $(this).css({'cursor':'move'});
        });
        $('.window-title').mouseleave(function(){
            $(this).css({'cursor':'default'});
        });
        $('.window-title').mousedown(function(e){
            _cache.moveable = true;
            mouseX = e.clientX - $(this).offset().left;
            mouseY = e.clientY - $(this).offset().top;
            $('.window-title').css({'cursor':'move'});
        });
        $(document).mouseup(function(){
            if(!_cache.moveable) {
                return;
            }
            $('.window-title').css({'cursor':'default'});
            _cache.moveable = false;
        });
        $('#window-box').mousemove(function(e){
            
            if(_cache.moveable) {
                $(this).css({'left':e.clientX - mouseX + 'px','top':e.clientY - mouseY + 'px'});
            }
            
        });

     },
     /*
      * 判断是否是IE6游览器
      * @return {Boolean}
      */
     _isIE6: function(){
        return navigator.userAgent.match(/MSIE 6.0/)!= null;
     }

 };