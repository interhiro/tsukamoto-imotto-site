 !(function($) {
     $.ajax({
         url: "news/_custom/?limit=50&cat=3",
         dataType: "jsonp",
         success: function(json) {

             $.each(json.data, function(i, val) {
                 var date_new = new Date(val.date);
                 var DATETIME = new Date(val.date);
                 var getYear = DATETIME.getFullYear().toString();
                 var getMonth = (DATETIME.getMonth() + 1).toString();
                 getMonth = getMonth.length < 2 ? "0" + getMonth : getMonth;
                 var getDate = DATETIME.getDate().toString();
                 getDate = getDate.length < 2 ? getDate : getDate;
                 var set_post_date = getYear + "." + "" + getMonth + "." + getDate;

                 $images = val.img ? $(val.img).attr('src') : './images/dummy_ovn.jpg';
                 var $li = $(`<div class="item">
                                <p class="img"><img src="` + $images + `" loading="lazy" width="92" height="92" alt="` + val.title + `"></p>
                                <div class="info">
                                    <p class="name_ovn"><span class="txt">` + val.title + `</span></p>
                                    <p class="desc_ovn">` + val.desc + `</p>
                                    <p class="address_ovn">` + val.address + `</p>
                                </div>
                                <a href="./news/` + val.url + `" class="full_hover" aria-label="` + val.title + `"></a>
                            </div>`);
                 $li.appendTo(".list_ovn_index");

             });
             sliderOVN();
         },
     });

     $.ajax({
         url: "news/_custom/",
         dataType: "jsonp",
         success: function(json) {
             let count = 0;
             $.each(json.data, function(i, val) {

                 if (val.category_id == 3) return;

                 if (count >= 3) return false;

                 var date_new = new Date(val.date);
                 var DATETIME = new Date(val.date);
                 var getYear = DATETIME.getFullYear().toString();
                 var getMonth = (DATETIME.getMonth() + 1).toString();
                 getMonth = getMonth.length < 2 ? "0" + getMonth : getMonth;
                 var getDate = DATETIME.getDate().toString();
                 getDate = getDate.length < 2 ? getDate : getDate;
                 var set_post_date = getYear + "." + "" + getMonth + "." + getDate;
                 count++;
                 var $li = $(`<div class="item">
                                <p class="date">` + set_post_date + `</p>
                                <p class="name"><span class="txt">` + val.title + `<a href="./news/` + val.url + `" class="full_hover" aria-label="` + val.title + `"></a></span></p>
                            </div>`);
                 $li.appendTo(".list_ovn_index2");
             });
         },
     });
 })(jQuery);


 $(document).ready(function() {
     localStorage.removeItem("en1241805126");
     localStorage.removeItem("en1245937466");
     localStorage.removeItem("en1786948497");
     $("#index .list_check_index .item").click(function() {
         if ($(this).hasClass("active")) {
             $(this).removeClass("active");
         } else {
             $("#index .list_check_index .item").removeClass("active");
             $(this).addClass("active");
         }
     });
     let val1 = "";
     let val2 = "";
     let val3 = "";
     $(".button-send").click(function() {
         val1 = $("#index .list_check_index .item.active").data("value");
         val2 = $("#en1245937466_01 option:selected").val();
         val3 = $("#en1786948497_01 option:selected").val();
         localStorage.setItem("en1241805126", val1);
         localStorage.setItem("en1245937466", val2);
         localStorage.setItem("en1786948497", val3);
         location.href = "./contact/#fmail_form";
     });
 });
 $(window).bind('load', function() {
     "use strict";
     // MAIN VISUAL SLIDER

     AOS.init({
         once: "true",
         duration: 1200,
         disable: 'mobile'
     });

     $('.box_slider').slick({
         dots: true,
         infinite: true,
         speed: 600,
         autoplaySpeed: 2000,
         slidesToShow: 1,
         slidesToScroll: 1,
         autoplay: true,
         variableWidth: true,
         responsive: [{
                 breakpoint: 1024,
                 settings: {
                     slidesToShow: 3,
                     slidesToScroll: 1,
                 }
             },
             {
                 breakpoint: 600,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 2
                 }
             },
             {
                 breakpoint: 480,
                 settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1
                 }
             }
         ]
     });


 });

 function sliderOVN() {
     $('.slick_ovn').slick({
         dots: false,
         infinite: true,
         speed: 600,
         autoplaySpeed: 2000,
         slidesToShow: 1,
         slidesToScroll: 1,
         autoplay: true,
         variableWidth: true,
         responsive: [{
                 breakpoint: 1024,
                 settings: {
                     slidesToShow: 3,
                     slidesToScroll: 1,
                 }
             },
             {
                 breakpoint: 600,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 2
                 }
             },
             {
                 breakpoint: 480,
                 settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1,
                 }
             }
             // You can unslick at a given breakpoint now by adding:
             // settings: "unslick"
             // instead of a settings object
         ]
     });
 }

 // CHANGE IMAGES PC SP 
 var $setElem = $('.swap'),
     pcName = '_pc',
     spName = '_sp';

 $(window).bind('resize load', function() {
     var windowWidth = window.innerWidth;
     $setElem.each(function() {
         var $this = $(this);
         if (windowWidth > 750) {
             $this.attr('src', $this.attr('src').replace(spName, pcName)).css({ visibility: 'visible' });
         } else {
             $this.attr('src', $this.attr('src').replace(pcName, spName)).css({ visibility: 'visible' });
         }
     });
 });