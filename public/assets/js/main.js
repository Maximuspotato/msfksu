//slideshow
var myIndex = 0;
carousel();
function carousel() {
    myIndex++;
    if (myIndex > 3) {myIndex = 1}
    $('.bg').css('background-image', 'url(./assets/img/homepage-slider/bg'+myIndex+'.jpg)');
    setTimeout(carousel, 3000); // Change image every 2 seconds
}

//ajax send to rfq catalogue
$('.carting').on('submit', function(e){
    e.preventDefault();
    form = $(this);
    $.ajax({
        url: "http://localhost/msfksu/public/carting?det=catalogue",
        dataType: 'text',
        type: 'post',
        contentType: 'application/x-www-form-urlencoded',
        data: $(this).serialize(),
        success: function( data, textStatus, jQxhr ){
            var cart = $('.shopping-cart-items');
            var imgtodrag = form.parents('.shop-item').find("img").eq(0);
            if (imgtodrag) {
                var imgclone = imgtodrag.clone()
                    .offset({
                    top: imgtodrag.offset().top,
                    left: imgtodrag.offset().left
                })
                    .css({
                    'opacity': '0.5',
                        'position': 'absolute',
                        'height': '100px',
                        'width': '100px',
                        'z-index': '100'
                })
                    .appendTo($('body'))
                    .animate({
                    'top': cart.offset().top + 10,
                        'left': cart.offset().left + 10,
                        'width': 75,
                        'height': 75
                }, 'easeInOutExpo');
    
                // setTimeout(function () {
                //     cart.effect("shake", {
                //         times: 2
                //     }, 200);
                // }, 1500);
    
                imgclone.animate({
                    'width': 0,
                        'height': 0
                }, function () {
                    $(this).detach();
                    $('#cart_count').text(data);
                    cart.effect("shake");
                });
            }
        },
        error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
        }
    });
});

//ajax send to rfq item
$('#carting').on('submit', function(e){
    e.preventDefault();
    form = $(this);
    $.ajax({
        url: "http://localhost/msfksu/public/carting?det=catalogue",
        dataType: 'text',
        type: 'post',
        contentType: 'application/x-www-form-urlencoded',
        data: $(this).serialize(),
        success: function( data, textStatus, jQxhr ){
            var cart = $('.shopping-cart-items');
            var imgtodrag = form.parents('.item').find("img").eq(0);
            if (imgtodrag) {
                var imgclone = imgtodrag.clone()
                    .offset({
                    top: imgtodrag.offset().top,
                    left: imgtodrag.offset().left
                })
                    .css({
                    'opacity': '0.5',
                        'position': 'absolute',
                        'height': '100px',
                        'width': '100px',
                        'z-index': '100'
                })
                    .appendTo($('body'))
                    .animate({
                    'top': cart.offset().top + 10,
                        'left': cart.offset().left + 10,
                        'width': 75,
                        'height': 75
                }, 'easeInOutExpo');
    
                // setTimeout(function () {
                //     cart.effect("shake", {
                //         times: 2
                //     }, 200);
                // }, 1500);
    
                imgclone.animate({
                    'width': 0,
                        'height': 0
                }, function () {
                    $(this).detach();
                    $('#cart_count').text(data);
                    cart.effect("shake");
                });
            }
        },
        error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
        }
    });
});

$(document).ready(function () {
    //cookie for pop up login
    var popStatus =  readCookie('show');
    console.log(popStatus);
    if(popStatus == null){
        $('#loginModal').modal();
    }
    $('.again').click(function(){
        createCookie('show', 'never', 10*365);
    });
    function createCookie(name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name,"",-1);
    }

    //easter egg
    var egg = new Egg();
    egg
    .addCode("t,h,e,w,e,t,c,h,i,c,k,e,n", function() {
        jQuery('#twc').fadeIn(3000, function() {
            jQuery('#twc').fadeOut(3000, function(){
                jQuery(this).hide();
            });
            //window.setTimeout(function() { jQuery('#twc').hide(); }, 5);
        });
    }).listen();

    $('.popover-dismiss').popover({
        trigger: 'focus'
    })

    //update comments and qty
    $(".refresh").on('click', function(){
        $(this).parents(".cart-items").find("form").submit();
    });

    //zoom pic effect
    $('.zoom').magnify();

    //disabled navbar
    $(".disabled a").click(function() {
        return false;
    });

    //slider
    $('.image').slick();

    //slider
    $('.backimage').slick({
        arrows:false,
        autoplay: true,
        autoplaySpeed: 5000,
    });

    //choose families from group selection
    $('#group').on('change', function(e){
        $('#family').empty();
        $('#family').append('<option value="">Please wait...</option>');
        var group = e.target.value;
        $.get('http://localhost/msfksu/public/getfam?group='+group, function(data){
            $('#family').empty();
            $('#family').append('<option value="">Please choose Family</option>');
            $.each(data, function(index, unicode){
                $('#family').append('<option value="'+unicode.family+'">'+unicode.desc+'</option>');
            });
        })
    });

    //article autocomplete
    $('#group').on('change', function(e){
        $('#article_code').val(e.target.value);
    });
    $('#family').on('change', function(e){
        var group = $('#group').val();
        var fam = e.target.value;
        var grofam = group+fam;
        $('#article_code').val(grofam);
        //get family descrition
        $text = $(this).children('option').filter(':selected').text();
        $('#fam_desc').val($text);
    });

    //Get group and fam from article
    $('#article_code').on('change', function(e){
        var groupfam = $(this).val();
        if(groupfam.length >= 4){
            var group = groupfam.charAt(0);
            $('#group').val(group);
            $.get('http://localhost/msfksu/public/getfam?group='+group, function(data){
                $('#family').empty();
                $('#family').append('<option value="">Please choose one</option>');
                $.each(data, function(index, unicode){
                    $('#family').append('<option value="'+unicode.family+'">'+unicode.desc+'</option>');
                });
                $('#family').val(groupfam.slice(1,4));
                //get family descrition
                $text = $("#family").children('option').filter(':selected').text();
                $('#fam_desc').val($text);
            })
        }
    });

    //date time picker
    $(function () {
            $('#datetimepicker4').datetimepicker({
                format: 'L'
            });
    });

    //ck editor
    CKEDITOR.replace( 'article-ckeditor' );

    //date on placeholder
    var date = new Date();
    var fullDate = date.getUTCMonth()+'/'+date.getUTCDay()+'/'+date.getUTCFullYear();
    $('#datetimepicker4').attr('placeholder', fullDate);

    //upload buttons visiblity on form
    $('#upload_article').on('change', function(){
        var article_code = $('#article_code').val();
        var category = $('#category').val();
        var group = $('#group').val();
        var family = $('#family').val();
        var price = $('#price').val();
        var datetimepicker4 = $('#datetimepicker4').val();
        var stock = $('#stock').val();
        var lead_time = $('#lead_time').val();
        var desc_eng = $('#desc_eng').val();

        if(article_code != "" && category != "" && group != "" && family != "" && price != "" && datetimepicker4 != "" && stock != "" && lead_time != "" && desc_eng != ""){
            $('#upload_butt').show();
            $('#photo_butt').show();
        }
    });
});