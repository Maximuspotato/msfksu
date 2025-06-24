   <!-- Javascripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.9.1.min.js"><\/script>')</script>
    <script src="{{URL('/')}}/assets/js/bootstrap.min.js"></script>
    {{-- <script src="https://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js"></script> --}}
    <script src="{{URL('/')}}/assets/js/jquery.fitvids.js"></script>
    <script src="{{URL('/')}}/assets/js/jquery.sequence-min.js"></script>
    <script src="{{URL('/')}}/assets/js/jquery.bxslider.js"></script>
    <script src="{{URL('/')}}/assets/js/main-menu.js"></script>
    <script src="{{URL('/')}}/assets/js/main.js?random=<?php echo uniqid(); ?>"></script>
    <script src="{{URL('/')}}/assets/js/template.js"></script>
    {{-- <script src="{{URL('/')}}/assets/js/jquery-editable-select.js"></script> --}}
    <script src="{{URL('/')}}/assets/client/jquery.fine-uploader.js"></script>
    <script type="text/javascript" src="{{URL('/')}}/assets/js/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    {{-- <script src="{{URL('/')}}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script> --}}
    <script type="text/javascript" src="{{URL('/')}}/assets/slick/slick.min.js"></script>

    <script src="{{URL('/')}}/assets/js/jquery.magnify.js"></script>
<!-- Optional mobile plugin (uncomment the line below to enable): -->
<!-- <script src="/js/jquery.magnify-mobile.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/egg.js/1.0/egg.min.js"></script>

    <script type="text/javascript" src="{{URL('/')}}/assets/js/FeedEk.min.js"></script>

    <!-- Fine Uploader Gallery template
    ====================================================================== -->
    {{-- <script type="text/template" id="qq-template-gallery">
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
    </script> --}}

    {{-- <script>
      $(document).ready(function () {
        

        //upload pics
        //$('#save').on('click', function(e){
            //console.log("beat the p up");
        //     $('#fine-uploader-gallery').fineUploader('uploadStoredFiles');
        // });

        //make selection editable
        // $('#editable-select').editableSelect({ effects: 'slide' });

        //jquery plugin for multiple file upload
        // $('#fine-uploader-gallery').fineUploader({
        //     template: 'qq-template-gallery',
        //     request: {
        //         customHeaders: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         endpoint: '{{URL::to("/uploadPics")}}',
        //     },
        //     deleteFile: {
        //         enabled: false,
        //         customHeaders: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         endpoint: '{{URL("/deletePics")}}'
        //     },
        //     thumbnails: {
        //         placeholders: {
        //             waitingPath: '/ksu/public/assets/client/waiting-generic.png',
        //             notAvailablePath: '/ksu/public/assets/client/not_available-generic.png'
        //         }
        //     },
        //     validation: {
        //         allowedExtensions: ['jpeg', 'jpg', 'png'],
        //         itemLimit: 3,
        //         sizeLimit: 2048000
        //     },
        //     callbacks: {
        //         onAllComplete: function(){
        //             window.location.href = '{{URL("/upload")}}';
        //         },
        //     },
        //     autoUpload: false,
        //     maxConnections: 1
        // });

        
    
        
   </script> --}}

   <script type="text/javascript">
    //$(document).ready(function () {
        // $('#rss').FeedEk({
		// 	FeedUrl: 'https://www.msf.org/rss/all', MaxCount: 3, ShowDesc: true, ShowPubDate: false, DescCharacterLimit: 100
		// });
    //});

    if (document.getElementById('phead').innerHTML == 'Picking') {
        if (document.getElementById('rc').value == 1) {
            document.getElementById("buttBack").style.display = 'none';
        } else {
            document.getElementById("buttBack").style.display = 'inline-block';
        }

        if (document.getElementById('rc').value == document.getElementById('count').value-1) {
            document.getElementById("buttConfirm").style.display = 'inline-block';
            document.getElementById("buttNext").style.display = 'none';
        } else {
            document.getElementById("buttConfirm").style.display = 'none';
        }

        var form = document.getElementById("formPick");

        document.getElementById("buttNext").addEventListener("click", function () {
            document.getElementById('pg').value = 'next'
            form.submit();
        });
        document.getElementById("buttBack").addEventListener("click", function () {        
            document.getElementById('pg').value = 'back';
            form.submit();
        });
        document.getElementById("buttConfirm").addEventListener("click", function () {
            document.getElementById('pg').value = 'confirm';
            form.submit();
        });
    } else if(document.getElementById('phead').innerHTML == 'Packing') {
        var form = document.getElementById("formPack");
        document.getElementById("buttNextPack").addEventListener("click", function () {
            document.getElementById('pg').value = 'next'
            form.submit();
        });
        
        if (document.getElementById('rcp').value == 0) {
            document.getElementById("buttBackPack").style.display = 'none';
        } else {
            document.getElementById("buttBackPack").style.display = 'inline-block';
        }
        document.getElementById("buttBackPack").addEventListener("click", function () {        
            document.getElementById('pg').value = 'back';
            form.submit();
        });

        if (document.getElementById('rcp').value == document.getElementById('count').value-1) {
            document.getElementById("buttConfirmPack").style.display = 'inline-block';
             document.getElementById("buttNextPack").style.display = 'none';
        } else {
            document.getElementById("buttConfirmPack").style.display = 'none';
        }
        document.getElementById("buttConfirmPack").addEventListener("click", function () {
            document.getElementById('pg').value = 'confirm';
            form.submit();
        });
    }


    function delfile(file, url) {
        if (confirm("A you sure you want to delete the file "+file) == true) {
            window.location.replace(url);
        }
    }

    function delPacker(pkno, url) {
        if (confirm("A you sure you want to delete the file "+pkno) == true) {
            window.location.replace(url);
        }
    }

    function pickfile(file, url) {
        if (confirm("A you sure you want to pick the file "+file) == true) {
            window.location.replace(url);
        }
    }

    function confPack(file) {        
        if (confirm("A you sure you want to pack the file "+file+" selecting "+document.getElementById('packer').value) == true) {
            document.getElementById("choosePacker").submit();
        }
    }

    function packing(file, url) {
        if (confirm("A you sure you want to pack the file "+file) == true) {
            window.location.replace(url);
        }
    }

    function intPack(file, url) {
        if (confirm("A you sure you want to intgrate this file "+file) == true) {
            window.location.replace(url);
        }
    }

    function intpkg(file, url) {
        if (confirm("A you sure you want to intgrate this file "+file) == true) {
            window.location.replace(url);
        }
    }

    var rss = [
        'all',
        'Afghanistan',
        'Albania',
        'Algeria',
        'Angola',
        'Armenia',
        'Azerbaijan',
        'Bahrain',
        'Bangladesh',
        'Belarus',
        'Belgium',
        'Benin',
        'Bolivia',
        'bosnia-and-herzegovina',
        'Brazil',
        'Bulgaria',
        'Burkina-Faso',
        'Burundi',
        'Cambodia',
        'Cameroon',
        'cape-verde',
        'central-african-republic',
        'Chad',
        'Chile',
        'China',
        'Colombia',
        'cote-divoire',
        'Croatia',
        'Cuba',
        'democratic-peoples-republic-korea',
        'democratic-republic-congo-drc',
        'Djibouti',
        'Ecuador',
        'Egypt',
        'el-salvador',
        'Eritrea',
        'eSwatini',
        'Ethiopia',
        'france',
        'georgia',
        'germany',
        'greece',
        'guatemala',
        'guinea',
        'Guinea-Bissau',
        'haiti',
        'honduras',
        'hungary',
        'india',
        'indonesia',
        'iran',
        'iraq',
        'italy',
        'japan',
        'jordan',
        'kenya',
        'kosovo',
        'Kyrgyzstan',
        'laos',
        'lebanon',
        'lesotho',
        'liberia',
        'libya',
        'madagascar',
        'malawi',
        'malaysia',
        'mali',
        'malta',
        'mauritania',
        'mexico',
        'moldova',
        'mongolia',
        'montenegro',
        'morocco',
        'mozambique',
        'myanmar',
        'nauru',
        'nepal',
        'nicaragua',
        'niger',
        'nigeria',
        'pakistan',
        'palestine',
        'papua-new-guinea',
        'paraguay',
        'peru',
        'Philippines',
        'republic-congo',
        'romania',
        'russian-federation',
        'rwanda',
        'serbia',
        'sierra-leone',
        'slovenia',
        'Solomon-Islands',
        'somalia',
        'south-africa',
        'south-sudan',
        'sri-lanka',
        'sudan',
        'sweden',
        'syria',
        'tajikistan',
        'tanzania',
        'thailand',
        'timor-leste',
        'tunisia',
        'turkey',
        'turkmenistan',
        'uganda',
        'ukraine',
        'united-states-america',
        'uzbekistan',
        'Venezuela',
        'vietnam',
        'yemen',
        'zambia',
        'Zimbabwe',
        'antibiotic-resistance',
        'child-health',
        'cholera',
        'ebola',
        'hepatitis-c',
        'hepatitis-e',
        'hivaids',
        'kala-azar',
        'malaria',
        'malnutrition',
        'measles',
        'meningitis',
        'mental-health',
        'neglected-diseases',
        'non-communicable-diseases',
        'sexual-violence',
        'sleeping-sickness',
        'surgery-trauma-care',
        'tuberculosis',
        'womens-health',
        'yellow-fever',
        'access-medicines',
        'epidemics-and-pandemics',
        'natural-disasters',
        'refugees-idps-and-people-move',
        'social-violence-and-exclusion',
        'war-and-conflict',
        'countries',
        'topics'
    ];
    var count = rss.length;
    var rand = Math.floor(Math.random() * count);

    $('#rss').FeedEk({
        FeedUrl: 'https://www.msf.org/rss/'+rss[rand], MaxCount: 3, ShowDesc: true, ShowPubDate: false, DescCharacterLimit: 100
    });

    function search() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("countries");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

    $("#countries").click(function(e){
        e.stopPropagation();
    });

    var header = $('#tablenav');
			var offTop = header.offset().top + -90;
			

			$(window).scroll(function(){
				var top = $(window).scrollTop();
				if (top > offTop) {
					header.addClass("sticky");
                    $('#mainmenu-wrapper').hide();
				} else {
					header.removeClass("sticky");
                    $('#mainmenu-wrapper').show();
				}
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