/*
    拖动插件
*/
(function($){
$.dragInit = function(options) {
        var defalut = {
                    handle:'.header'
                  };
        if (options && typeof options === 'object') 
        {
            $.extend(defalut, options);
        }
        c = defalut;
        var trigger = $(c.trigger).find(c.handle);
        trigger.css('cursor', 'move');
        var bg = trigger.parent().css("background-color");
        var d  = $(document);
        var dragging;
        trigger.mousedown(function(e){ //按下鼠标
            var positionX = e.clientX - $(this).parent().offset().left ;
            var positionY = e.clientY - $(this).parent().offset().top ;

            dragging = true;//alert(dragging)
            this.setCapture && this.setCapture();
            d.mousemove(function(e){//移动鼠标                                      
                                        if(dragging)
                                         { 
                                            var positions = $(c.trigger).css('position')=='fixed'?'fixed':'absolute';
                                            var scrollTop = $(document).scrollTop();
                                            var scrollLeft = $(document).scrollLeft();
                                            left_pos = e.clientX - positionX; 
                                            top_pos  = e.clientY - positionY;
                                            var maxL = document.documentElement.clientWidth + scrollLeft; //- trigger.parent().width(); 
                                            var maxT = document.documentElement.clientHeight + scrollTop; //- trigger.parent().height()+$(document).scrollTop();
                                            left_pos = left_pos < 0 ? 0 : left_pos - scrollLeft;
                                            left_pos = left_pos > maxL ? maxL : left_pos;  
                                            left_pos = left_pos <= 0 ? 0 : left_pos;
                                            top_pos  = top_pos < scrollTop ? 0 : top_pos-scrollTop;
                                            if(positions=='fixed')
                                            {
                                                top_pos =   e.clientY ; 
                                            }
                                            else
                                            {
                                                top_pos = top_pos > maxT ? maxT : top_pos;  
                                            }
                                            //top_pos = top_pos + scrollTop;

                                            trigger.parent().css({
                                                    position:positions,
                                                    background:'#fff',
                                                    left: left_pos,
                                                    top: top_pos,
                                                    margin:"0px 0px",
                                                    opacity:0.7
                                                              });  
                                         }
                                });
                                    return false;
                    });
            d.mouseup(function(e){//释放鼠标 
                                    dragging = false;
                                    trigger.parent().css({
                                                        background:bg,
                                                        opacity:1
                                                        });   
                                    if(trigger[0].releaseCapture)
                                    {
                                        trigger[0].releaseCapture();
                                    }
                                    else if(window.captureEvents)
                                    {
                                        window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
                                    } 
                                    e.cancelBubble = true;
                                    return false;
                                });
                     }
})(jQuery);

/*
    弹出框
*/
jQuery.dialog = {          
    alert:function(param,callback)
    {   
        param.type = 1;
        $.dialog.init(param,callback);
    },          
    confirm:function(param,callback)
    {          
        param.type = 2;
        $.dialog.init(param,callback);
    },
    prompt:function(param,callback)
    {          
        param.type = 3;
        $.dialog.init(param,callback);
    },
    loading:function(param,callback)
    {          
        param.type = 4;
        $.dialog.init(param,callback);
    },
    actions:function(param,callback)
    {          
        var defaults = {msg:js_lang.title,content:'-'};
             options = $.extend(defaults,param);
             obj     = $('#'+options.obj.attr('data-id'));
             if(!obj.length)
             {
                $.dialog.dark({'msg':js_lang.missing_url_objects});
                return false;
             }
        var str  = '';
            str += '<div class="modal-actions">';
            str += '<div class="modal-actions-group">';
            str += obj.html();
            str += '</div>';
            str += '<div class="modal-actions-group">';
            str += '<button class="button-secondary pure-button button-block modal-actions-cancel">'+js_lang.cancel+'</button>';
            str += '</div>';
            str += '</div>';
        var overlay = $("<div id='lean_overlay' class='ui-mask'></div>");
        if(!document.getElementById('lean_overlay')){$('body').append(overlay);}
        $('#lean_overlay').fadeIn(200);
        $('body').append(str);
        $('.modal-actions .list').css({'max-height':$('body').height()/2});
        $('.modal-actions').animate({height: 'toggle'}, 500);
        $('.modal-actions-cancel').click(function(){
            $('#lean_overlay').fadeOut();
            $('.modal-actions').slideUp(500,function(){$('.modal-actions').remove();});
        })
    },
    dark:function(param,callback)
    {
        var defaults  = {msg:js_lang.title,time:'3'};
             options  = $.extend(defaults,param);
             var str  = '<div class="modal-dark">';
                 str += '<p>';
                 str += options.msg;
                 str += '</p>';
                 str += '</div>';
        function inters()
        {
            $('.modal-dark').fadeOut('slow',function(){$('.modal-dark').remove();});
            clearTimeout(window.clear_interrs);
        }
        if(window.clear_interrs) clearTimeout(window.clear_interrs);
        $('.modal-dark').remove();
        $('body').append(str);
        w = $('.modal-dark').outerWidth() / 2;
        h = $('.modal-dark').outerHeight() / 2;
        $('.modal-dark').css({'margin-left': '-'+w+'px','margin-top': '-'+h+'px'});
        $('.modal-dark').fadeIn('slow');
        if(options.time)
        {
            window.clear_interrs = setTimeout(inters,options.time * 1000);
        }
    },
    popup:function(param,callback)
    {
        var defaults = {msg:js_lang.title,obj:''};
             options = $.extend(defaults,param);
             obj     = $('#'+options.obj.attr('data-id'));
             if(!obj.length)
             {
                $.dialog.dark({'msg':js_lang.missing_url_objects});
                return false;
             }
        var str  = '<div class="modal-popup">';
            str += '<div class="popup-inner">';
            str += '<div class="popup-header">';
            str += '<h4 class="popup-title">'+options.msg+'</h4>';
            str += '<i class="fa fa-close popup-close"></i>';
            str += '</div>';
            str += '<div class="popup-body">';
            str += obj.html();
            str += '</div>';
            str += '</div>';
            str += '</div>';
        $('.modal-popup').remove();
        $('body').append(str);
        $('.popup-close').click(function(){
            h = $('.modal-popup').height();
            $('.modal-popup').animate({top: h+'px'}, 400,function(){$('.modal-popup').remove();});
        })
        $('.modal-popup').animate({top: '0px'}, 400);    
    },
    notifi:function(param,callback)
    {   
        var defaults = {msg:'-',info:js_lang.system_infos,time:'5'};
             options = $.extend(defaults,param);     
        var str  = '<div class="notification" style="display:none">';
            str += '<div class="notification-content">';
            str += '<h3 class="notification-title"><i class="fa fa-commenting-o fa-yellow"></i> '+options.info+'</h3>';
            str += '<span>'+options.msg+'</span>';
            str += '</div>';
            str += '<i class="fa fa-close notification-close"></i>';
            str += '</div>';
        function ints()
        {
            $('.notification').animate({height: 'toggle', opacity: 'toggle'}, 200,function(){$('.notification').remove();});
            clearTimeout(window.clear_ints);
        }
        if(window.clear_ints) clearTimeout(window.clear_ints);
        $('.notification').remove();
        $('body').append(str);
        $('.notification').animate({height: 'toggle', opacity: 'toggle'}, 200);

        if(options.time)
        {
            window.clear_ints = setTimeout(ints,options.time * 1000);
        }

        $('.notification-close').click(function(){
            ints();
        })
    },
    init:function(options,callback)
    {
        var defaults = {msg:'-',closeButton:null,info:js_lang.system_infos,placeholder:'','close':''};
             options = $.extend(defaults,options);
             style   = '';
        if(options.type == 4) style = 'style="border:0px"';
        var str  = '<div class="ui-dialog" >';
            str += '<div class="ui-dialog-title">';
            if(options.close)
            {
                str += '<a class="ui-dialog-close">';
                str += '<i class="fa fa-close fa-lg"></i>';
                str += '</a>';
            }
            str += '<h3>'+options.info+'</h3>';
            str += '</div>';
            str += '<div class="ui-dialog-content" '+style+'>';
            str += '<div class="vote-dialog" >';
            if(options.type == 4)
            {
                str += '<div class="loader-bounce1"></div><div class="loader-bounce2"></div><div ></div>';
            }
            else
            {
                str += '<p>'+options.msg+'</p>';
            }

            if(options.type == 3)
            {
                str += '<input class="prompt-input" type="text" placeholder="'+options.placeholder+'">';
            }
            str += '</div>';
            str += '</div>';
            str += '<div class="ui-dialog-btns" >';
            if(options.type != 4) str += '<a class="ui-btn ui-btn-2">'+js_lang.confirm+'</a>';
            if(options.type == 2 || options.type == 3)
            {
                str += '<a class="ui-btn ui-btn-1">'+js_lang.cancel+'</a>';
            }
            str += '</div>';
            str += '</div>'; 
        $('.ui-dialog').remove();
        var overlay = $("<div id='lean_overlay' class='ui-mask'></div>");
        if(!document.getElementById('lean_overlay')){$('body').append(overlay);}
        $('body').append(str);
        if(options.type == 4)
        {
            $('#lean_overlay').fadeIn(1);$('.ui-dialog').fadeIn(1);
        }
        else
        {
            $('#lean_overlay').fadeIn(200);$('.ui-dialog').fadeIn('fast');
        }    
        $('.ui-btn-2,.ui-btn-1,.ui-dialog-close').click(function(){
            $('.ui-dialog').fadeOut('fast',function(){$('.ui-dialog').remove();$('#lean_overlay').fadeOut();});
            if(options.type == 4)return false;
            if(options.type == 2 && $(this).hasClass('ui-btn-2'))
            {
                if(callback)callback();
            }
            else if(options.type == 3 && $(this).hasClass('ui-btn-2'))
            {
                val = $.trim($('.ui-dialog .prompt-input:first').val());
                if(val && callback)
                {
                    callback(val);
                }
            }
            return false;
        })
    }
};