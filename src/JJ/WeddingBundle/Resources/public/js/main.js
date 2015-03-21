// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Main js source for application
$(document)
    .on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label])
    })
    .ready(function() {

    /* AFFIX NAV */
    resizeDiv();

    window.onresize = function(event) {
        resizeDiv();
    }

    if ($('#nav').length > 0) {

        var stickyNavTop = $('#nav').offset().top;

        var stickyNav = function(){
            var scrollTop = $(window).scrollTop();

            if (scrollTop > stickyNavTop) {
                $('#nav').removeClass('affix-top');
                $('#nav').addClass('affix');
            } else {
                $('#nav').removeClass('affix');
                $('#nav').addClass('affix-top');
            }
        };

        stickyNav();

        $(window).scroll(function() {
            stickyNav();
        });

    };
    /* END AFFIX NAV */

    /* OWL CAROUSEL */
    //Initialize Plugin
    $('.owl-carousel').owlCarousel({
        items:            1,
        singleItem:    true,
        navigation:   false,
        pagination:   false,
        lazyLoad:      true,
        autoHeight:    true,
        itemsScaleUp: false
    })
 
    //get carousel instance data and store it in variable owl
    var owl = $('.owl-carousel').data('owlCarousel');

    $(".carousel-nav-item-img").click(function(){
        index = $(this).data('image-index');
        owl.goTo(index);
    });
    /* END OWL CAROUSEL */

    /* FANCY BOX */
    $('.fancybox').fancybox({
        openEffect:  'none',
        closeEffect: 'none',
        fitToView:     true,
        maxWidth:       960,
        maxHeight:      640,
    });
    /* END FANCY BOX */
 
    $('body').scrollspy({ offset: 50, target: '#main-nav' });
    
    $('.navbar-nav li a.scrollspies').click(function(event) {
        event.preventDefault();
        var elem = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(elem).offset().top - 50
        }, 500);
        return false;
    });

    // not sure what this is
    // maybe file upload?
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }

        readURL(this);
        
    });

    $('body')
        .on('click', '#rsvp-search', function(e){
            e.preventDefault();
            $('#rsvp-rotator')
                .removeClass('bounceInLeft')
                .addClass('bounceOutRight');
            var data = new Object();

            data.search = $('input#rsvp-search-input').val();

            if(data.search == ''){ return false; }

            ajax('search', data, 'GET')
                .done(function(response){
                    $('#rsvp-rotator')
                        .removeClass('bounceOutRight')
                        .addClass('bounceInLeft');
                    $('#rsvp-rotator').html(response);
                })
                .fail(function(){
                    $('#rsvp-rotator').html(response);
                });
        })
        .on('click', '.party-selectable', function(e){
            e.preventDefault();
            $('#rsvp-rotator')
                .removeClass('bounceInLeft')
                .addClass('bounceOutRight');
            var data = new Object();

            data.partyId = $(this).attr('id');

            if(data.partyId == ''){ return false; }

            ajax('rsvpwebcheck', data, 'GET')
                .done(function(response){
                    $('#rsvp-rotator')
                        .removeClass('bounceOutRight')
                        .addClass('bounceInLeft');
                    $('#rsvp-rotator').html(response);
                })
                .fail(function(){
                    $('#rsvp-rotator').html(response);
                });
        })
        .on('click', '.try-again', function(e){
            e.preventDefault();
            $('#rsvp-rotator')
                .removeClass('bounceInLeft')
                .addClass('bounceOutRight');
            var data = new Object();

            data.form = 'reload';

            if(data.form == ''){ return false; }

            ajax('searchform', data, 'GET')
                .done(function(response){
                    $('#rsvp-rotator')
                        .removeClass('bounceOutRight')
                        .addClass('bounceInLeft');
                    $('#rsvp-rotator').html(response);
                })
                .fail(function(){
                    $('#rsvp-rotator').html(response);
                });
        })
        .on('submit', '#jj_weddingbundle_rsvp_new', function(e){
            e.preventDefault();
            $('#rsvp-rotator')
                .removeClass('bounceInLeft')
                .addClass('bounceOutRight');
            var route = $(this).attr('action');
            var data = new Object();

            $.each($(this).serializeArray(), function(i, field) {
                data[field.name] = field.value;
            });

            ajax(route, data, 'POST')
                .done(function(response){
                    $('#rsvp-rotator')
                        .removeClass('bounceOutRight')
                        .addClass('bounceInLeft');
                    $('#rsvp-rotator').html(response);
                })
                .fail(function(){
                    $('#rsvp-rotator').html(response);
                });
            return false;
        })
        .on('submit', '#jj_weddingbundle_rsvp_edit', function(e){
            e.preventDefault();
            $('#rsvp-rotator')
                .removeClass('bounceInLeft')
                .addClass('bounceOutRight');
            var route = $(this).attr('action');
            var data = new Object();

            $.each($(this).serializeArray(), function(i, field) {
                data[field.name] = field.value;
            });

            ajax(route, data, 'PUT')
                .done(function(response){
                    $('#rsvp-rotator')
                        .removeClass('bounceOutRight')
                        .addClass('bounceInLeft');
                    $('#rsvp-rotator').html(response);
                })
                .fail(function(){
                    $('#rsvp-rotator').html(response);
                });
            return false;
        });

});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
 
function scrollUp(){
    var voffset = 49;
    var href = $('.navbar-nav').find('li.active').children('a').attr('href');
    if(undefined == $(href).prev().attr('id')){
        var elem = $(href).attr('id');
    }
    else{
        var elem = $(href).prev().attr('id');
    }
    $('html, body').animate({
        scrollTop: $('#' + elem).offset().top - voffset
    }, 500);
    return false;
}
 
function scrollDown(){
    var voffset = 50;
    var href = $('.navbar-nav').find('li.active').children('a').attr('href');
    if(undefined == $(href).next().attr('id')){
        alert($(href).next().attr('id'));
    }
    else{
        var elem = $(href).next().attr('id');
    }
    $('html, body').animate({
        scrollTop: $('#' + elem).offset().top - voffset
    }, 500);
    return false;
}

function ajax(route, data, method){
    if(undefined == data){
        data = new Object();
    }
    else{
        if(data.search){
            data.params = data.search;
        }
        else if(data.partyId){
            data.params = data.partyId;
        }
        else if(data.form){
            data.params = data.form;
        }
        else{
            data;
        }
    }
    if('GET' == method || undefined == method || '' == method){
        return $.ajax({
            type:     'GET',
            url:      location.protocol + '//' + location.hostname + '/' + route + '/' + data.params,
            datatype: 'html'
        });
    }
    else if('POST' == method || 'PUT' == method){
        return $.ajax({
            type:     'POST',
            url:      location.protocol + '//' + location.hostname + route,
            data:     data
        });
    }
}

function resizeDiv() {
    vpw = $(window).width();
    vph = $(window).height() - 50;
    $('#banner').css({'height': vph});
}