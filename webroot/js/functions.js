var markerAbsolute = "";
var infoWindow = "";

function getStates($url, $pref){
    var id = $('#' + $pref + 'country-id').val();
    $.ajax({
        type: 'POST',
        url: $url,
        data: {country_id: id},
        async: true,
        success: function(data){
            data = jQuery.parseJSON(data);
            $('#' + $pref + 'state-id').html('');
            $('#' + $pref + 'state-id').append('<option value="">-- Seleccione Dpto. --</option>');
            $('#' + $pref + 'province-id').html('');
            $('#' + $pref + 'province-id').append('<option value="">-- Seleccione Ciudad --</option>');
            $.each(data, function(key, value) 
            {
                $('#' + $pref + 'state-id').append('<option value=' + key + '>' + value + '</option>');
            });
        },
        error: function (xhr, textStatus, error) {
            console.log(error);
        }
    });
}

function getProvinces($url, $pref){
    var id = $('#' + $pref + 'state-id').val();
    $.ajax({
        type: 'POST',
        url: $url,
        data: {state_id: id},
        async: true,
        success: function(data){
            data = jQuery.parseJSON(data);
            $('#' + $pref + 'province-id').html('');
            $('#' + $pref + 'province-id').append('<option value="">-- Seleccione Ciudad --</option>');
            $.each(data, function(key, value) 
            {
                $('#' + $pref + 'province-id').append('<option value=' + key + '>' + value + '</option>');
            });
        },
        error: function (xhr, textStatus, error) {
            console.log(error);
        }
    });
}

function loadImage($this, $img){
    $input = ($($this))[0];
    if ($input.files && $input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + $img).attr('src', e.target.result);
        }
        reader.readAsDataURL($input.files[0]);
    }
}

function checkNewProduct($this, $no_image) {
    if (!isNaN($this.value) && $this.value != '') {
        var $idSelected = $('#product-ajax-selected');
        $('#is-new').val(0);
        $('#category-id').val($idSelected.data('category_id'));
        $('#measure-id').val($idSelected.data('measure_id'));
        $('#content').val($idSelected.data('content'));
        $('#temp-input-image').attr('required', false);
        $('#imgPhoto').attr('src', $idSelected.attr('src'));
        $('.selected-product option:not(:selected)').attr('disabled', true);
        $('.selected-product').attr('readonly', true);
        $('#product-ajax-check').attr("class", "fa fa-check");
        $("#product-ajax-check").css("color", "#7AC29A");
    } else if ($this.value != '') {
        $('#is-new').val(1);
        //$('.selected-product option').attr('disabled', false);
        //$('.selected-product').attr('readonly', false);
        //$('#temp-input-image').attr('required', true);
        //$('#imgPhoto').attr('src', $no_image);
        $('#product-ajax-check').attr("class", "fa fa-plus");
        $("#product-ajax-check").css("color", "#EB5E28");
    } else {
        $('.selected-product').val('');
        $('.selected-product option').attr('disabled', false);
        $('.selected-product').attr('readonly', false);
        $('#temp-input-image').attr('required', true);
        $('#imgPhoto').attr('src', $no_image);
        $('#product-ajax-check').attr("class", "fa fa-circle-thin");
        $("#product-ajax-check").css("color", "#252422");
    }
}

/*function validateTime($this){
	var time = $($this).val();
	if (time != '') {
		re=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;	
		if (re.test(time)) {
			$('#error-' + $($this).attr('id')).html('');
		} else {
			$('#error-' + $($this).attr('id')).html('formato incorrecto');
		}
	} else {
		$('#error-' + $($this).attr('id')).html('');
	}
}

function pressAvailable($this, $inputs){
	for (i = 0; i < $inputs.length; i++) {
		if ($($this).prop('checked')) {
			$('#' + $inputs[i]).val('');
        	$('#error-' + $inputs[i]).html('');
        	$('#' + $inputs[i]).prop('readonly', true);
        } else {
        	$('#' + $inputs[i]).prop('readonly', false);
        }
	}
}*/

function validateCoordinates($string){
    var coords = $string;
    re=/^(\-?\d+(\.\d+)?),(\-?\d+(\.\d+)?)$/;
    return re.test(coords);
}

function getStatsModelbyCard($idDiv, $url, $isTotal, $footer_text){
    $.ajax({
        type: 'POST',
        url: $url,
        data: {},
        async: true,
        success: function(data){
            data = jQuery.parseJSON(data);
            if ($isTotal) {
            	$('#' + $idDiv + ' .numbers-sub span').html(data[0]['total'] + ((data.length > 1) ? data[1]['total'] : 0));	
            } else {
            	$('#' + $idDiv + ' .numbers-sub span').html(data[0]['total']);	
            }
			if (data.length > 1) {
				$('#' + $idDiv + ' .footer span').html(data[1]['total'] + ' ' + $footer_text);
			} else {
				$('#' + $idDiv + ' .footer span').html('sin movimientos');
			}
        },
        error: function (xhr, textStatus, error) {
            console.log(error);
        }
    });
}

function getDiffDates($date1, $date2, $str) {
    var dmoment1 = moment($date1);
    var dmoment2 = moment($date2);
    var diff = dmoment1.diff(dmoment2, 'days');
    if (diff == 0) {
        diff = dmoment1.diff(dmoment2, 'hours');
        if (diff == 0) {
            return "Últ. " + $str + " hace " + dmoment1.diff(dmoment2, 'minutes') + " min.";
        } else {
            return "Últ. " + $str + " hace " + diff + " hora(s)";
        }
    } else {
        return "Últ. " + $str + " hace " + diff + " dia(s)";
    }
}

function getStatsHomeModelbyCard($idDiv, $url, $footer_text) {
    $.ajax({
        type: 'POST',
        url: $url,
        data: {},
        async: true,
        success: function(data){
            data = jQuery.parseJSON(data);
            $('#' + $idDiv + ' .numbers-sub span').html(data['count']);
            if (data['last'] != null) {
                $('#' + $idDiv + ' .footer span').html(getDiffDates(new Date().toISOString().substr(0, 19), data['last']['created'].substr(0, 19), $footer_text));    
            } else{
                $('#' + $idDiv + ' .footer span').html('Aún no hay ' + $footer_text);
            }
        },
        error: function (xhr, textStatus, error) {
            console.log(error);
        }
    });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                            'Error: El servicio de Geolocalización ha fallado.' :
                            'Error: Tu navegador no soporta la Geolocalización.');
}

function setOutputLocation($divs, $lat, $lng) {
    $('#' + $divs['idLat']).val($lat);
    $('#' + $divs['idLng']).val($lng);
}

function geocodeAddress(geocoder, resultsMap, $divs, $zoom) {
    var address = document.getElementById($divs['idInput']).value;
    if(markerAbsolute) { markerAbsolute.setMap(null); }
    if(infoWindow) { infoWindow.close(); }
    if(validateCoordinates(address)) {
        var latlngStr = address.split(',', 2);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
        geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK') {
                if (results[1]) {
                    resultsMap.setCenter(latlng);
                    resultsMap.setZoom($zoom);
                    markerAbsolute = new google.maps.Marker({
                        map: resultsMap,
                        draggable: true,
                        position: latlng,
                        title: 'Arrastre el marcador para una mayor presición.'
                    });
                    setOutputLocation($divs, latlng['lat'], latlng['lng']);
                    google.maps.event.addListener(markerAbsolute, "dragend", function(event) { 
                        setOutputLocation($divs, event.latLng.lat(), event.latLng.lng());
                    });
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
    } else {
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);
                resultsMap.setZoom($zoom);
                markerAbsolute = new google.maps.Marker({
                    map: resultsMap,
                    draggable: true,
                    position: results[0].geometry.location,
                    title: 'Arrastre el marcador para una mayor presición.'
                });
                setOutputLocation($divs, results[0].geometry.location['lat'], results[0].geometry.location['lng']);
                google.maps.event.addListener(markerAbsolute, "dragend", function(event) {
                    setOutputLocation($divs, event.latLng.lat(), event.latLng.lng());
                }); 
            } else {
                //alert('No se encontro la dirección buscada: ' + status);
                alert('No se encontro la dirección buscada, ingrese valores reales.');
            }
        });
    }
}

function defaultGeolocationStore($divs, $point, $zoom, $zoomLocation, $existLocation) {
    var map = new google.maps.Map(document.getElementById($divs['idDiv']), {
        center: $point,
        zoom: $zoom
    });

    if ($existLocation) {

        map.setCenter($point);
        map.setZoom($zoomLocation);
        markerAbsolute = new google.maps.Marker({
            map: map,
            draggable: true,
            position: $point,
            title: 'Arrastre el marcador para una mayor presición.'
        });

        google.maps.event.addListener(markerAbsolute, "dragend", function(event) { 
            setOutputLocation($divs, event.latLng.lat(), event.latLng.lng());
        });

    } else {

        infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.   
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                infoWindow.setPosition(pos);
                infoWindow.setContent('Por favor, ingrese en la caja de busqueda una latitud y longitud<br>tal como se muestra, presione buscar, y luego arrastre el marcador<br>si es necesario para una mayor presición.');
                map.setCenter(pos);
                map.setZoom($zoomLocation);
            }, function() {
                infoWindow.setPosition(map.getCenter());
                infoWindow.setContent('Por favor, ingrese en la caja de busqueda una latitud y longitud<br>tal como se muestra, presione buscar, y luego arrastre el marcador<br>si es necesario para una mayor presición.');
                /*handleLocationError(true, infoWindow, map.getCenter());*/
            });
        } else {
            infoWindow.setPosition(map.getCenter());
            infoWindow.setContent('Por favor, ingrese en la caja de busqueda una latitud y longitud<br>tal como se muestra, presione buscar, y luego arrastre el marcador<br>si es necesario para una mayor presición.');
            // Browser doesn't support Geolocation
            /*handleLocationError(false, infoWindow, map.getCenter());*/
        }
    }

    var geocoder = new google.maps.Geocoder();

    document.getElementById($divs['idSearch']).addEventListener('click', function() {
        geocodeAddress(geocoder, map, $divs, $zoomLocation);
    });
}

$('#map-address').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});

/*$('.select2-search__field').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    console.log(keyCode, e);
})*/

$("#product-ajax").select2({    
    tags: true,
    placeholder: 'Encuentre un producto o ingrese uno nuevo',
    allowClear: true,
    minimumInputLength: 2,
    language: {
        inputTooShort: function(args) { return "Por favor ingrese 2 o más caracteres"; },
        noResults: function() { return "No hay resultados encontrados"; },
        searching: function() { return "Buscando.."; },
        loadingMore: function() { return "Cargando más resultados"; },
        maximumSelected: function(args) { return "No puede agregar más productos"; }
    },
    ajax: {
        dataType: 'json',
        delay: 250,
        data: function (params) { return { search: params.term }; },
        processResults: function (data, params) {
            params.page = params.page || 1;
            return {
                results: $.map(data, function(obj) {
                    return { 
                        id: obj.id, 
                        text: '<span><img id="product-ajax-selected" ' + 
                                'data-category_id="' + obj.category_id + '" ' +
                                'data-content="' + obj.content + '" ' +
                                'data-measure_id="' + obj.measure_id + '" ' +
                                'src="' + $("#product-ajax").data('app-url') + obj.path.substr(1) + obj.image + '" ' +
                                'class="img-flag" /> ' + obj.name + ' ' + obj.content + ' ' + obj.measure.abrev + '</span>'
                    };
                })
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; },
    maximumSelectionLength: 1
});

$(document).ready(function(){

	var e;

	if ($('.mercapp-page').length > 0) {
    	e = $('.mercapp-page').data("sidebar");
    	if ($('#sidebar-' + e).length > 0) {
    		$('#sidebar-' + e).addClass("active");
    	}
    }

    if ($('.mercapp-sub').length > 0) {
    	e = $('.mercapp-sub').attr("id").substr(-1);
    	$('.numbers-sub:eq(' + e + ')').addClass("active");
    }

    if ($('.mercapp-dashboard-admin').length > 0) {
        getStatsHomeModelbyCard('stores-stats-admin', $('#stores-stats-admin').data("url"), 'reg.');
        getStatsHomeModelbyCard('products-stats-admin', $('#products-stats-admin').data("url"), 'reg.');
    }

    if ($('.mercapp-dashboard-store').length > 0) {
        getStatsHomeModelbyCard('products-stats-store', $('#products-stats-store').data("url"), 'reg.');
    }

    if ($('.mercapp-others').length > 0) {
    	getStatsModelbyCard('categories-stats', $('#categories-stats').data("url"), false, 'subcat(s).');
    	getStatsModelbyCard('countries-stats', $('#countries-stats').data("url"), true, 'inactivo(s)');
    	getStatsModelbyCard('states-stats', $('#states-stats').data("url"), true, 'inactivo(s)');
    	getStatsModelbyCard('provinces-stats', $('#provinces-stats').data("url"), true, 'inactivo(s)');
    	getStatsModelbyCard('measures-stats', $('#measures-stats').data("url"), true, '');
    }

    if ($('#product-ajax').length > 0) {
        //$('#product-ajax').select2('focus');
        //console.log($("input.select2-search__field").size()); 
        //$('#product-ajax').select2('focus');
        //$('input.select2-search__field').select2('focus');
        //$("input.select2-search__field:first").focus();
    }
    
    if ($('#map').length > 0) {
    	$().ready(function(){
    		var $store = $('#map').data("store");
    		$store['address'] = ($store['address'] == '' ? 'ninguna' : $store['address']);
    		$store['phone'] = ($store['phone'] == '' ? '--' : $store['phone']);
    		$store['working_hours'] = ($store['start_time'] == '' ? 'las 24 horas' : $store['start_time'] + ' a ' + $store['close_time'] );
    		$store['rating'] = ($store['rating'] == null ? 'sin evaluar' : $store['rating']);
    		$store['description'] = ($store['description'] == '' ? 'sin descripción' : $store['description']);
            $store['url_image'] = $('#map').data("url-image");
            demo.initGoogleMaps('map', $store, 15);
        });
    }

    if ($('#map-location').length > 0) {
        var $store = $('#map-location').data('store');
        var $existLocation = false;
        var $point = {lat: 6.239933, lng: -75.567310};
        if ("latitude" in $store && $store['latitude'] != '' && $store['longitude'] != '') {
            $existLocation = true;
            $point = {lat: Number($store['latitude']), lng: Number($store['longitude'])};
        }
        var $ids = {idDiv: 'map-location', idSearch: 'map-search', idInput: 'map-address', idLat: 'latitude', idLng: 'longitude'};
        defaultGeolocationStore($ids, $point, 6, 15, $existLocation);
    }

    if ($('.msg-pop').length > 0) {
    	var $icon = 'ti-star';
    	var $type = 'success';
      	var $msg = $('.msg-pop').html();
      	
      	if ($('.msg-pop').hasClass('error')) {
        	$type = 'danger';
        	$icon = 'ti-alert';
      	}
      	demo.initChartist();
	    $.notify({
	        icon: $icon,
	        message: $msg

	    },{
	        type: $type,
	        timer: 4000,
	        placement: {
	          from: 'bottom',
	          align: 'right'
	      }
	    });
    }

});
/*$(window).on('load', function() {
    if ($('#product-ajax').length > 0) {
        //$('#product-ajax').select2('focus');
        console.log(1); 
        //$('#product-ajax').select2('focus');
        $('#product-ajax').select2('focus');
    }
});*/