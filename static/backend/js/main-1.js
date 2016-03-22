'use strict';

(function(){
    var addEvent = (function(){
             if (window.addEventListener)
              {
               return function(el, sType, fn, capture) {
                  el.addEventListener(sType, fn, (capture));
               };
             }
            else if (window.attachEvent)
            {
              return function(el, sType, fn, capture) {
                  el.attachEvent("on" + sType, fn);
              };
            }
            else
             {
                return function(){};
            }
        })();

    var Scroll = document.getElementById('Scroll');
    var obj_Scroll =$('#Scroll');
    // IE6/IE7/IE8/Opera 10+/Safari5+
    addEvent(Scroll, 'mousewheel', function(event){
        event = window.event || event ;
        Scroll_top(event,obj_Scroll);
    }, false);

    // Firefox 3.5+
    addEvent(Scroll, 'DOMMouseScroll',  function(event){
        event = window.event || event ;
        Scroll_top(event,obj_Scroll);
    }, false);

})();

function Scroll_top(event,obj_Scroll)
{
    var h = (obj_Scroll.position().top-29);
    if(event.wheelDelta <= 0 || event.detail > 0)
    {
        var wh = obj_Scroll.height();
        var bh = $('body').height();
        if(bh >= wh)return false;
            wh = $('body').height()-wh;
         h = h <=wh ? wh :h;
    }
    else
    {
        h = h <=0 ? 0 :h;
    }
    obj_Scroll.css({'top':h+'px'});
}


function menuScroll(num){
  var obj_Scroll =$('#Scroll');
  var Scroll = document.getElementById('Scroll');
  var h = (obj_Scroll.position().top-60);
  if(num==1)
  {
    h = h <=0 ? 0 :h;

  }
  else
  {
    var wh = obj_Scroll.height();
        var bh = $('body').height();
        if(bh >= wh)return false;
            wh = $('body').height()-wh;
         h = h <=wh ? wh :h;
  }
  obj_Scroll.css({'top':h+'px'});
}

function windowW()
{
    if($('body').height()<$('#Scroll').height())
    {
        $(".scroll").show();
    }
    else
    {
        $(".scroll").hide();
    }
}
windowW();

$(function(){
    /**
 * Open Iframe
 */

$('body').on('click','.primary a.item,.home_a',function(){
        //$(this).addClass('active').parents('.item').addClass('active');
        var location = $(this).data('breadcrumb');
            location = typeof(location) != 'undefined' && location ? ' / '+location : '';
        $('.viewport-header .breadcrumb').html('<i class="fa fa-chevron-right"></i> <a class="home_a" href="http://www.tianbaotravel.com/admin/1.main.php" data-href="http://www.tianbaotravel.com/admin/1.main.php">'+tbt_lang.fhome+'</a>  ' + location);
        //console.log('Browser height: ' + $( window ).height());
        $("#rightMain").attr('src', $(this).data('href'));

        return false;
    });
// resize iframe with viewport
$(window).on('resize', function(){
    windowW();
    $('#rightMain').height($( window ).height() - 40);
    //$('#iframe-loader iframe').height($( window ).height() - 40);
});

/**
 * Toggle Check-in or Check-out
 */
var checkIn = false;
$('.ui.toggle.button.check').click(function(){
    var str = $(this).html();
    $(this).html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i> loading...');
    var $self = $(this);
    $.ajax({
         url:nowDirs+'/check_in',
        dataType: 'json',
        cache: false,
        success: function(res) {
            if(res.success)//数据异常处理
            {
               if(res.mod)
               {
                   // change to check out status
                   $self.removeClass('positive').addClass('negative').html('<i class="fa fa-hand-pointer-o"></i> '+res.data);
                   //$self.text(res.text);
               }
               else
               {
                   // change to check in status
                   $self.addClass('positive').removeClass('negative').html('<i class="fa fa-hand-pointer-o"></i> '+res.data);
                   //$self.text(res.text);
               }
            }
            else
            {
              $self.html(str);
              art.dialog.tips(res.msg,2);
            }
        },
        error: function(xhr, status, err)
        {
          $self.html(str);
          art.dialog.alert(tbt_lang.server_data_error);
        }
    });

    // // Check In
    // if (checkIn == true) {
    //     checkIn = false;
    //     $(this).addClass('positive').removeClass('negative');
    //     $(this).text('签 到');
    // } else {
    //     checkIn = true;
    //     $(this).removeClass('positive').addClass('negative');
    //     $(this).text('签 出');
    // }
});
$('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })
;

/**
 * Toggle Sidebar
 */
$('.toggled-menu').click(function(){
    $('.nav-dashboard').toggleClass('dodge');
    $('.viewport-content').toggleClass('dodge');
    $('.viewport-header').toggleClass('dodge');
    $('.toggled-menu').toggleClass('dodge');
});
// $('.toggled-menu').hover(
// function(){
//     if ($(this).hasClass('dodge')) {
//         console.log("show sidebar!");
//     }
// }, function(){
// });
// $('.toggled-menu .icon').click(function(){
//     $('.nav-dashboard').removeClass('dodge');
//     $('.viewport-content').removeClass('dodge');
//     //$('.toggled-menu').addClass('dodge');
// });


// var $lastSelectedSubMenu;
// $('.level').each(function(){
//     var menuKey = $(this).data('menu');
//     $(this).click(function(){
//         var $currentSelect =  $('#menu-key-' + menuKey);
//         $currentSelect.addClass('active');
//         if ($lastSelectedSubMenu) {
//             $lastSelectedSubMenu.removeClass('active');
//             // if ($lastSelectedSubMenu.attr('id') != 'menu-key-' + menuKey) {
//             //     $currentSelect.toggleClass('hidden');
//             // }
//         }
//         $lastSelectedSubMenu = $currentSelect;
//
//
//
//
//         // if ($lastSelectedSubMenu) {
//         //     //console.log($lastSelectedSubMenu.attr('id'));
//         //     console.log("toggle: ", $lastSelectedSubMenu);
//         //     if ($lastSelectedSubMenu.attr('id') != 'menu-key-' + menuKey) {
//         //
//         //     }
//         //     $lastSelectedSubMenu.toggleClass('hidden');
//         // }
//         // // if ($lastSelectedSubMenu && $lastSelectedSubMenu.attr('id') != 'menu-key-' + menuKey) {
//         // //     $lastSelectedSubMenu.toggleClass('hidden');
//         // // }
//         // $lastSelectedSubMenu = $currentSelect;
//         // $lastSelectedSubMenu.toggleClass('hidden');
//         // console.log("about to toggle: ", $lastSelectedSubMenu);
//
//     });
// });

/**
 * Hover and show accordion
 */
// $('.level').hover(function(){
//     $('.nav-dashboard').css('overflow-y', 'visible');
//     $(this).css('overflow', 'auto');
// }, function(){
//     $('.nav-dashboard').css('overflow-y', 'auto');
//     $(this).css('overflow', 'hidden');
// });
// $('.level').each(function(){
//     var menuKey = $(this).data('menu');
//     var $hoverCache = $('#menu-key-' + menuKey);
//
//     $hoverCache.hover(function(){
//         //console.log('hover in menu-key' + menuKey);
//         $hoverCache.addClass('active');
//     }, function(){
//         //console.log('hover out menu-key' + menuKey);
//         $hoverCache.removeClass('active');
//     });
//
//     $(this).hover(
//         function(){
//             $hoverCache.addClass('active');
//         },
//         function(){
//             $hoverCache.removeClass('active');
//         }
//     );
// });


/**
 * Semantic UI
 */
$('.accordion')
    .accordion()
;
$('.ui.dropdown')
    .dropdown()
;
$('.lock.screen').click(function(){
    $('.ui.modal')
      .modal('show')
    ;
});
$('#account-tab .menu .item')
  .tab({
    // special keyword works same as above
    context: $('#account-context')
  })
;


})



$(function(){
    $('.level .accordion .content .item').click(function(){
    $('.level,.level .accordion .content .item').removeClass('active');
    $(this).parents('.level:first').addClass('active');
    $(this).addClass('active');
})
    $('#reload').click(function(){
        try
        {
            $('#rightMain').contents().find("._ajaxLoading").show();
            document.getElementById('rightMain').contentWindow.location.reload(true);
        }
        catch(err)
        {

        }
    });
    var vh = $( window ).height() - 40;
        $('#rightMain').height(vh);
})
