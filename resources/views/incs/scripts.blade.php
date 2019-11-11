   <!-- Javascripts -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.9.1.min.js"><\/script>')</script>
    <script src="{{URL('/')}}/assets/js/bootstrap.min.js"></script>
    <script src="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js"></script>
    <script src="{{URL('/')}}/assets/js/jquery.fitvids.js"></script>
    <script src="{{URL('/')}}/assets/js/jquery.sequence-min.js"></script>
    <script src="{{URL('/')}}/assets/js/jquery.bxslider.js"></script>
    <script src="{{URL('/')}}/assets/js/main-menu.js"></script>
    <script src="{{URL('/')}}/assets/js/template.js"></script>
    <script src="{{URL('/')}}/assets/js/jquery-editable-select.js"></script>
    <script src="{{URL('/')}}/assets/client/jquery.fine-uploader.js"></script>
    <script type="text/javascript" src="{{URL('/')}}/assets/js/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="{{URL('/')}}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="{{URL('/')}}/assets/slick/slick.min.js"></script>

    <script src="{{URL('/')}}/assets/js/jquery.magnify.js"></script>
<!-- Optional mobile plugin (uncomment the line below to enable): -->
<!-- <script src="/js/jquery.magnify-mobile.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/egg.js/1.0/egg.min.js"></script>

    <!-- Fine Uploader Gallery template
    ====================================================================== -->
    <script type="text/template" id="qq-template-gallery">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>

    <script>
        //slideshow
        var myIndex = 0;
        carousel();
        function carousel() {
            myIndex++;
            if (myIndex > 3) {myIndex = 1}
            $('.bg').css('background-image', 'url(./assets/img/homepage-slider/bg'+myIndex+'.jpg)');
            setTimeout(carousel, 3000); // Change image every 2 seconds
        }
    </script>

    {{-- editable select login --}}
    {{-- <script>
        function makeFileList() {
			var input = document.getElementById("attachment");
			var ul = document.getElementById("filelist");
			while (ul.hasChildNodes()) {
				ul.removeChild(ul.firstChild);
			}
			for (var i = 0; i < input.files.length; i++) {
				var li = document.createElement("li");
				li.innerHTML = input.files[i].name;
				ul.appendChild(li);
			}
			if(!ul.hasChildNodes()) {
				var li = document.createElement("li");
				li.innerHTML = 'No Files Selected';
				ul.appendChild(li);
			}
		}
    </script> --}}
    <script>
        //ajax send to rfq catalogue
        $('.carting').on('submit', function(e){
            e.preventDefault();
            form = $(this);
            $.ajax({
                url: "{{URL::to('/carting?det=catalogue')}}",
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
                url: "{{URL::to('/carting?det=catalogue')}}",
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
    </script>
    <script>
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
        //upload attachments

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

        //upload pics
        $('#save').on('click', function(e){
            //console.log("beat the p up");
            $('#fine-uploader-gallery').fineUploader('uploadStoredFiles');
        });

        //make selection editable
        $('#editable-select').editableSelect({ effects: 'slide' });

        //jquery plugin for multiple file upload
        $('#fine-uploader-gallery').fineUploader({
            template: 'qq-template-gallery',
            request: {
                customHeaders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                endpoint: '{{URL::to("/uploadPics")}}',
            },
            deleteFile: {
                enabled: false,
                customHeaders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                endpoint: '{{URL("/deletePics")}}'
            },
            thumbnails: {
                placeholders: {
                    waitingPath: '/ksu/public/assets/client/waiting-generic.png',
                    notAvailablePath: '/ksu/public/assets/client/not_available-generic.png'
                }
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'png'],
                itemLimit: 3,
                sizeLimit: 2048000
            },
            callbacks: {
                onAllComplete: function(){
                    window.location.href = '{{URL("/upload")}}';
                },
            },
            autoUpload: false,
            maxConnections: 1
        });

        //choose families from group selection
        $('#group').on('change', function(e){
            $('#family').empty();
            $('#family').append('<option value="">Please wait...</option>');
            var group = e.target.value;
            $.get('{{URL::to("/getfam?group=")}}'+group, function(data){
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
                $.get('{{URL::to("/getfam?group=")}}'+group, function(data){
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
   </script>

   @isset($det)
       @if ($det == "edit")
            <script>
                $(document).ready(function(){
                    //edit trigger group and family
                    $('#article_code').trigger("change");

                    //edit trigger upload butts
                    $('#upload_butt').show();
                    $('#photo_butt').show();
                });
            </script>
       @endif
   @endisset