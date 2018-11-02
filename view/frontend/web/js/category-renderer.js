define([
        'jquery',
        'Magento_Ui/js/modal/modal',
        'owlCarousel'
    ],
    function($, modal, owlCarousel) {
        var owlExist = false;
        var owl = $('.owl-carousel');

        initCustomFilter();

        function initCustomFilter() {
            owl = $('.owl-carousel');
            if(owlExist) {
                $('.owl-carousel').trigger('destroy.owl.carousel');
                owl.owlCarousel({
                    autoplay: true,
                    items: 1,
                    nav: true,
                    loop: true,
                    autoplayHoverPause: true,
                    animateOut: sliderOut,
                    animateIn: sliderIn,
                    autoplayTimeout: 10000
                });
            } else {
                owl.owlCarousel({
                    autoplay: true,
                    items: 1,
                    nav: true,
                    loop: true,
                    autoplayHoverPause: true,
                    animateOut: sliderOut,
                    animateIn: sliderIn,
                    autoplayTimeout: 10000
                });
                owlExist = true;
            }
        }

        $(".opencartpopup").on('click',function(){
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: false,
                title: false,
                buttons: [{
                    text: $.mage.__('Continue'),
                    class: 'mymodal1',
                    click: function () {
                        this.closeModal();
                    }
                }]
            };
            var modalElement = $('.cart-popup-' + $(this).data('id'));
            var popup = modal(options, modalElement);
            modalElement.modal('openModal');
        });

        $(".anchorLink").click(function(e){
            e.preventDefault();

            var id     = $(this).attr("href");
            var offset = $(id).offset();

            $("html, body").animate({
                scrollTop: offset.top
            }, 1000);
        });

        $(".categoryLink").click(function(e){
            e.preventDefault();
            var selectedCat = $(this).data('cid');

            $.ajax({
                url: '',
                data: (selectedCat ?  'cid=' + selectedCat + '&ajax=1' : 'ajax=1'),
                type: 'get',
                dataType: 'json',
                cache: true,
                showLoader: true,
                timeout: 10000
            }).done(function (response) {
                console.log(response);
                if (response.success) {
                    if(response.html.products_list){
                        $("#custom-main-container").html(response.html.products_list);
                    }
                    if(response.html.filters){
                        $("#filter-top-bar").html(response.html.filters)
                    }
                    initCustomFilter();

                } else {
                    // Error
                }
            }).fail(function (error) {
                // Error
            });
        });
    }
);