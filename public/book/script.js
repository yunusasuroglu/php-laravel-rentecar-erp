;(function($) {
    "use strict";  
    
    //* Form js
    function verificationForm(){
        //jQuery time
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches
        
        $(".next").click(function () {
            if (animating) return false;
            animating = true;
            
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            
            //activate next step on progressbar using the index of next_fs
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            
            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now, mx) {
                    // Geçiş sırasında pozisyonu absolute yap
                    if (now < 1) {
                        current_fs.css({
                            'transform': 'scale(' + (1 - (1 - now) * 0.2) + ')',
                            'position': 'absolute'
                        });
                    }
                    
                    // Geçiş animasyonları
                    next_fs.css({
                        'left': (now * 50) + "%",
                        'opacity': 1 - now
                    });
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    // Geçiş bittiğinde pozisyonu tekrar statik yap
                    current_fs.css({
                        'position': 'static',
                        'transform': 'none'  // scale özelliğini de sıfırla
                    });
                    animating = false;
                },
                // Easing efekti için özel plugin
                easing: 'easeInOutBack'
            });
        });
        
        $(".previous").click(function () {
            if (animating) return false;
            animating = true;
            
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();
            
            //de-activate current step on progressbar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
            
            //show the previous fieldset
            previous_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1 - now) * 50) + "%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                        'left': left
                    });
                    previous_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'opacity': opacity
                    });
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });
        
        $(".submit").click(function () {
            return false;
        })
    }; 
    
    //* Add Phone no select
    function phoneNoselect(){
        if ($('#msform').length) {   
            // intlTelInput'ı başlat
            $("#phone").intlTelInput({
                initialCountry: "de", // Almanya'yı başlangıçta seçili yapar
                preferredCountries: ['de'], // Almanya'yı öncelikli ülke yapar
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Gerekli yardımcı script
            });
    
            // Varsayılan numara olarak Almanya numarasını ayarlayın
            $("#phone").intlTelInput("setNumber", "+49"); 
        }
    };
    //* Select js
    function nice_Select(){
        if ( $('.product_select').length ){ 
            $('select').niceSelect();
        };
    }; 
    /*Function Calls*/  
    verificationForm ();
    phoneNoselect ();
    nice_Select ();
})(jQuery);