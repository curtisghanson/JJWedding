if ($('#map').length > 0) {
    var map = L.mapbox.map('map', 'curtisghanson.gnhh8hoi', {zoomControl: false})
        .setView([45.523668225289775, -122.65213966369629], 13);

    // disable drag and zoom handlers
    map.dragging.disable();
    map.touchZoom.disable();
    map.doubleClickZoom.disable();
    map.scrollWheelZoom.disable();
    // disable tap handler, if present.
    if (map.tap) map.tap.disable();
}

// BOOTSTRAP AFFIX IS SLOW AND UNRESPONSIVE
//$('#nav').affix({
//    offset: $('#nav').position()
//});

/*var s = skrollr.init({
    edgeStrategy: 'set',
    easing: {
        WTF: Math.random,
        inverted: function(p) {
            return 1-p;
        }
    }
});*/