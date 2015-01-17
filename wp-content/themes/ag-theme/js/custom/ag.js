// On document ready:

$(function(){

	// Instantiate MixItUp:

	$('#Container').mixItUp();

});


// Swipebox

$( document ).ready(function() {
		/* Basic Gallery */
		$( '.swipebox' ).swipebox();		
		/* Video */
		$( '.swipebox-video' ).swipebox();
    });
		

//	Simple Text Rotator	
		
$(".rotate").textrotator({
        animation: "dissolve",
        separator: ",",
    speed: 2000
    });		
		
		
//	Clear Input Default Values
		
		/* 
		 * Cross-browser event handling, by Scott Andrew
		 */
		function addEvent(element, eventType, lamdaFunction, useCapture) {
		    if (element.addEventListener) {
		        element.addEventListener(eventType, lamdaFunction, useCapture);
		        return true;
		    } else if (element.attachEvent) {
		        var r = element.attachEvent('on' + eventType, lamdaFunction);
		        return r;
		    } else {
		        return false;
		    }
		}

		/* 
		 * Kills an event's propagation and default action
		 */
		function knackerEvent(eventObject) {
		    if (eventObject && eventObject.stopPropagation) {
		        eventObject.stopPropagation();
		    }
		    if (window.event && window.event.cancelBubble ) {
		        window.event.cancelBubble = true;
		    }
    
		    if (eventObject && eventObject.preventDefault) {
		        eventObject.preventDefault();
		    }
		    if (window.event) {
		        window.event.returnValue = false;
		    }
		}

		/* 
		 * Safari doesn't support canceling events in the standard way, so we must
		 * hard-code a return of false for it to work.
		 */
		function cancelEventSafari() {
		    return false;        
		}

		/* 
		 * Cross-browser style extraction, from the JavaScript & DHTML Cookbook
		 * <http://www.oreillynet.com/pub/a/javascript/excerpt/JSDHTMLCkbk_chap5/index5.html>
		 */
		function getElementStyle(elementID, CssStyleProperty) {
		    var element = document.getElementById(elementID);
		    if (element.currentStyle) {
		        return element.currentStyle[toCamelCase(CssStyleProperty)];
		    } else if (window.getComputedStyle) {
		        var compStyle = window.getComputedStyle(element, '');
		        return compStyle.getPropertyValue(CssStyleProperty);
		    } else {
		        return '';
		    }
		}

		/* 
		 * CamelCases CSS property names. Useful in conjunction with 'getElementStyle()'
		 * From <http://dhtmlkitchen.com/learn/js/setstyle/index4.jsp>
		 */
		function toCamelCase(CssProperty) {
		    var stringArray = CssProperty.toLowerCase().split('-');
		    if (stringArray.length == 1) {
		        return stringArray[0];
		    }
		    var ret = (CssProperty.indexOf("-") == 0)
		              ? stringArray[0].charAt(0).toUpperCase() + stringArray[0].substring(1)
		              : stringArray[0];
		    for (var i = 1; i < stringArray.length; i++) {
		        var s = stringArray[i];
		        ret += s.charAt(0).toUpperCase() + s.substring(1);
		    }
		    return ret;
		}

		/*
		 * Disables all 'test' links, that point to the href '#', by Ross Shannon
		 */
		function disableTestLinks() {
		  var pageLinks = document.getElementsByTagName('a');
		  for (var i=0; i<pageLinks.length; i++) {
		    if (pageLinks[i].href.match(/[^#]#$/)) {
		      addEvent(pageLinks[i], 'click', knackerEvent, false);
		    }
		  }
		}

		/* 
		 * Cookie functions
		 */
		function createCookie(name, value, days) {
		    var expires = '';
		    if (days) {
		        var date = new Date();
		        date.setTime(date.getTime() + (days*24*60*60*1000));
		        var expires = '; expires=' + date.toGMTString();
		    }
		    document.cookie = name + '=' + value + expires + '; path=/';
		}

		function readCookie(name) {
		    var cookieCrumbs = document.cookie.split(';');
		    var nameToFind = name + '=';
		    for (var i = 0; i < cookieCrumbs.length; i++) {
		        var crumb = cookieCrumbs[i];
		        while (crumb.charAt(0) == ' ') {
		            crumb = crumb.substring(1, crumb.length); /* delete spaces */
		        }
		        if (crumb.indexOf(nameToFind) == 0) {
		            return crumb.substring(nameToFind.length, crumb.length);
		        }
		    }
		    return null;
		}

		function eraseCookie(name) {
		    createCookie(name, '', -1);
		}

	 /*
	  * Clear Default Text: functions for clearing and replacing default text in
	  * <input> elements.
	  *
	  * by Ross Shannon, http://www.yourhtmlsource.com/
	  */

	 addEvent(window, 'load', init, false);

	 function init() {
	     var formInputs = document.getElementsByTagName('input');
	     for (var i = 0; i < formInputs.length; i++) {
	         var theInput = formInputs[i];
        
	         if (theInput.type == 'text' && theInput.className.match(/\bcleardefault\b/)) {  
	             /* Add event handlers */          
	             addEvent(theInput, 'focus', clearDefaultText, false);
	             addEvent(theInput, 'blur', replaceDefaultText, false);
            
	             /* Save the current value */
	             if (theInput.value != '') {
	                 theInput.defaultText = theInput.value;
	             }
	         }
	     }
	     var formInputs = document.getElementsByTagName('textarea');
	     for (var i = 0; i < formInputs.length; i++) {
	         var theInput = formInputs[i];
        
	         if (theInput.className.match(/\bcleardefault\b/)) {  
	             /* Add event handlers */          
	             addEvent(theInput, 'focus', clearDefaultText, false);
	             addEvent(theInput, 'blur', replaceDefaultText, false);
            
	             /* Save the current value */
	             if (theInput.value != '') {
	                 theInput.defaultText = theInput.value;
	             }
	         }
	     }
			 
	 }

	 function clearDefaultText(e) {
	     var target = window.event ? window.event.srcElement : e ? e.target : null;
	     if (!target) return;
    
	     if (target.value == target.defaultText) {
	         target.value = '';
	     }
	 }

	 function replaceDefaultText(e) {
	     var target = window.event ? window.event.srcElement : e ? e.target : null;
	     if (!target) return;
    
	     if (target.value == '' && target.defaultText) {
	         target.value = target.defaultText;
	     }
	 }
	 
	 
	 
// Google Maps Styling
	 
    google.maps.event.addDomListener(window, 'load', init);
    var map;
    function init() {
        var mapOptions = {
            center: new google.maps.LatLng(1.297317,103.85155),
            zoom: 17,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
            },
            disableDoubleClickZoom: true,
            mapTypeControl: false,
            scaleControl: true,
            scrollwheel: false,
            panControl: true,
            streetViewControl: false,
//          draggable : true,
            overviewMapControl: false,
            overviewMapControlOptions: {
                opened: false,
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [
    {
        "featureType": "administrative.province",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 65
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "lightness": "-10"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 51
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 30
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 40
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
            {
                "hue": "#ffff00"
            },
            {
                "lightness": -25
            },
            {
                "saturation": -97
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "lightness": -25
            },
            {
                "saturation": -100
            }
        ]
    }
],
        }
				var mapElement = document.getElementById('ag_map');
				        var map = new google.maps.Map(mapElement, mapOptions);
				        var locations = [
				['Awaken Group', '51 Waterloo St. #03-06<br />Singapore 187969<br />', '+65 6337 6642', '', 'undefined', 1.2980448153109914, 103.85142729881136, 'http://agtest.squorange.com/resources/icon-map-pin.png'],['NTUC Carpark', 'Enter from Queen St.', 'undefined', 'undefined', 'undefined', 1.2968434912953895, 103.8514464318771, 'http://agtest.squorange.com/resources/icon-map-p.png']
				        ];
				        for (i = 0; i < locations.length; i++) {
							if (locations[i][1] =='undefined'){ description ='';} else { description = locations[i][1];}
							if (locations[i][2] =='undefined'){ telephone ='';} else { telephone = locations[i][2];}
							if (locations[i][3] =='undefined'){ email ='';} else { email = locations[i][3];}
				           if (locations[i][4] =='undefined'){ web ='';} else { web = locations[i][4];}
				           if (locations[i][7] =='undefined'){ markericon ='';} else { markericon = locations[i][7];}
				            marker = new google.maps.Marker({
				                icon: markericon,
				                position: new google.maps.LatLng(locations[i][5], locations[i][6]),
				                map: map,
				                title: locations[i][0],
				                desc: description,
				                tel: telephone,
				                email: email,
				                web: web
				            });
				link = '';            bindInfoWindow(marker, map, locations[i][0], description, telephone, email, web, link);
				     }
				 function bindInfoWindow(marker, map, title, desc, telephone, email, web, link) {
				      var infoWindowVisible = (function () {
				              var currentlyVisible = false;
				              return function (visible) {
				                  if (visible !== undefined) {
				                      currentlyVisible = visible;
				                  }
				                  return currentlyVisible;
				               };
				           }());
				           iw = new google.maps.InfoWindow();
				           google.maps.event.addListener(marker, 'click', function() {
				               if (infoWindowVisible()) {
				                   iw.close();
				                   infoWindowVisible(false);
				               } else {
				                   var html= "<div style='color:#000;background-color:#fff;padding:5px;width:150px;'><h2 class='form__input'>"+title+"</h2>"+desc+telephone+"</div>";
				                   iw = new google.maps.InfoWindow({content:html});
				                   iw.open(map,marker);
				                   infoWindowVisible(true);
				               }
				        });
				        google.maps.event.addListener(iw, 'closeclick', function () {
				            infoWindowVisible(false);
				        });
				 }
				}       