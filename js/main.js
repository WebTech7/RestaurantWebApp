$(document).ready(function(){
    height = $(".navbar").outerHeight();
    $("body").css('padding-top', height);
    $(".sidebar").css('top', height);
    $(".user-drop-info").css('max-height', 'calc(100vh - '+height+'px - 20px)');
    height = $("#specify").outerHeight() - $("#results-for-header").outerHeight();
    $("#map").css('height', height);
    $("#googleMap").css('height', height);
    $("#sort-wrap").css('margin-top', 0);
    if($("#results-for-header").outerHeight() > 90){
        $("#sort-wrap").css('margin-top', 20);
    } else {
        $("#sort-wrap").css('margin-top', 0);
    }
    if($(window).width() > 767){
        width = $("#restaurant-small").outerWidth();
        $("#restaurant-broad").css("width", "calc(100vw - "+width+"px)");
        $("#EnzoLeft").css("width", "calc(100vw - "+width+"px");
    } else {
        $("#restaurant-broad").css("width", "100vw");
        $("#EnzoLeft").css("width", "100vw");
        $(".pagination").css("margin-top", 0);
        $("#slogan-top").css("left", 55);
    }
    if($(window).width() > 350){
        $(".star-text-wrap").hide();
        $(".star-pics-wrap").show();
    } else {
        $(".star-text-wrap").show();
        $(".star-pics-wrap").hide();
        $(".pagination").css("margin-top", 20);
        $("#slogan-top").css("left", 60);
    }
    $("#results-loading").css('z-index', -1);
    $("#results-loading").css('opacity', 0);
});


$(window).resize(function(){
    height = $(".navbar").outerHeight();
    $("body").css('padding-top', height);
    $(".sidebar").css('top', height);
    $(".user-drop-info").css('max-height', 'calc(100vh - '+height+'px - 20px)');
    height = $("#specify").outerHeight() - $("#results-for-header").outerHeight();
    $("#map").css('height', height);
    $("#googleMap").css('height', height);
    $("#sort-wrap").css('margin-top', 0);
    if($("#results-for-header").outerHeight() != 73){
        $("#sort-wrap").css('margin-top', 20);
    } else {
        $("#sort-wrap").css('margin-top', 0);
    }
    if($(window).width() > 767){
        width = $("#restaurant-small").outerWidth();
        $("#restaurant-broad").css("width", "calc(100vw - "+width+"px)");
        $("#EnzoLeft").css("width", "calc(100vw - "+width+"px");
    } else {
        $("#restaurant-broad").css("width", "100vw");
        $("#EnzoLeft").css("width", "100vw");
        $(".pagination").css("margin-top", 0);
    }
    if($(window).width() > 350){
        $(".star-text-wrap").hide();
        $(".star-pics-wrap").show();
    } else {
        $(".star-text-wrap").show();
        $(".star-pics-wrap").hide();
        $(".pagination").css("margin-top", 20);
    }
});

            loginScreen = false;

            function showLogin(){
                $("#login-form").show();
                $("#signup-form").hide();
                $("#login-without-fb").show();
                $("#signup-without-fb").hide();
                $(".login-button").css('background', '#CCC');
                $(".signup-button").css('background', '#e6e6e6');
                $(".login-button").css('pointer-events', 'none');
                $(".signup-button").css('pointer-events', 'auto');
                        $(".fb-login-button").html("<h3>FACEBOOK LOGIN</h3>");
            }

            function showSignUp(){
                $("#signup-form").show();
                $("#login-form").hide();
                $("#signup-without-fb").show();
                $("#login-without-fb").hide();
                $(".signup-button").css('background', '#CCC');
                $(".login-button").css('background', '#e6e6e6');
                $(".signup-button").css('pointer-events', 'none');
                $(".login-button").css('pointer-events', 'auto');
                        $(".fb-login-button").html("<h3>FACEBOOK SIGN UP</h3>");
            }

            function openLogin(type){
                $("#login-screen-wrapper").show();
                if(type == 'login'){
                    showLogin();
                } else if(type == 'signup'){
                    showSignUp();
                }
            }

            $("#login-screen-wrapper").on('click', function() {
              $("#login-screen-wrapper").hide();
            }).children().on('click',function(){
                return false;
            });

             $(".login-screen-cross").on('click', function() {
                $("#login-screen-wrapper").hide();
            })

            $(document).ready(function(){
                $("#login-screen-wrapper").hide();
            });

            function checkEmail(email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }

            function submitSignUp(){
                    $("#signup-feedback-success").hide();
                    $("#signup-feedback-danger").hide();
                    $("#ajax-response").show();
                if(checkEmail($("#signup-email").val())){
                    $.post( "signup.php", {email: $("#signup-email").val()} , function( data ) {
                      $( "#ajax-response" ).html( data );
                        $(".remove-signup").hide();
                    });
                } else {
                   document.getElementById("signup-feedback-danger").innerHTML = 'This is not a valid email address.';
                    $("#signup-feedback-danger").show();
                    $("#signup-feedback-success").hide();
                    $("#ajax-response").hide();
                }
            }

            function loginSuccess(){
                if($("#login-email").val() == 'success'){
                    return true;
                } else {
                    return false;
                }
            }

            function login(){
                //some AJAX
            }

            function submitLogin(){
                if(loginSuccess()){
                    $("#login-screen-wrapper").hide();
                    $("#signup-feedback-danger").hide();
                    login();
                } else {
                    $("#login-feedback-danger").show();
                    document.getElementById("login-feedback-danger").innerHTML = 'The combination of email address and password is not known by us.';
                }
            }

            var clicked = 0;

            $(".star-large-none").click(function(){
                clicked = 0;
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                for(a=0;a<=5;a++){
                    $("#"+a+"").attr("src", emptySrc);
                }
                refineRating(0);
                $("#hidden-rating").html("0");
                $(".star-large-none").hide();
            });

            $(".star-large").click(function(){
                $(".star-large-none").show();
                clicked = 0;
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    this.src = emptySrc;
                    for(a=0;a<=5;a++){
                        $("#"+a+"").attr("src", emptySrc);
                    }
                fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                this.src = fullSrc;
                for(a=0;a<$(this).val();a++){
                    $("#"+a+"").attr("src", fullSrc);
                    if(a+1==$(this).val()){refineRating($(this).val());}
                }
                clicked = $(this).val();
                $("#hidden-rating").html($(this).val());
            });
            $(".star-large").hover(function(){
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    this.src = emptySrc;
                    for(a=0;a<=5;a++){
                        $("#"+a+"").attr("src", emptySrc);
                    }
                fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                this.src = fullSrc;
                for(a=1;a<=$(this).val();a++){
                    $("#"+a+"").attr("src", fullSrc);
                }
            }, function(){
                    fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                    emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    for(a=0;a<=5;a++){
                        if(a > parseInt(clicked)){
                            $("#"+a+"").attr("src", emptySrc);
                        } else {
                            $("#"+a+"").attr("src", fullSrc);
                        }
                }
            });

                $(".star-large-a").click(function(e){
                    e.preventDefault();
                clicked = 0;
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    this.src = emptySrc;
                    for(a=0;a<=5;a++){
                        $("#"+a+"").attr("src", emptySrc);
                    }
                fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                this.src = fullSrc;
                for(a=0;a<$(this).val();a++){
                    $("#"+a+"").attr("src", fullSrc);
                }
                clicked = $(this).val();
                $("#hidden-rating").val($(this).val());
            });
            $(".star-large-a").hover(function(){
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    this.src = emptySrc;
                    for(a=0;a<=5;a++){
                        $("#"+a+"").attr("src", emptySrc);
                    }
                fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                this.src = fullSrc;
                for(a=1;a<=$(this).val();a++){
                    $("#"+a+"").attr("src", fullSrc);
                }
            }, function(){
                    fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                    emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    for(a=0;a<=5;a++){
                        if(a > parseInt(clicked)){
                            $("#"+a+"").attr("src", emptySrc);
                        } else {
                            $("#"+a+"").attr("src", fullSrc);
                        }
                }
            });

function submitTopSearch(){
    $("#sort-by").val(0);
    $("#radius").val("");
    $("#kind-of-rest").val("");
    $("#order").val("");
    $("#postal-wrapper").hide();
    $(".star-large-none").hide();
    emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
    for(a=0;a<=5;a++){
        $("#"+a+"").attr("src", emptySrc);
    }
    var askedArray = new Array();
    askedArray["q"] = $("#top-search-q").val();
    askedArray["place"] = $("#top-search-place").val();
    askedArray["useq"] = 1;
    refreshResults(askedArray);
    resultsfor = "";
    title = "";
    if($("#top-search-q").val() != ""){
        resultsfor = "<i>" + resultsfor + $("#top-search-q").val() + "</i> around ";
        title = title + $("#top-search-q").val() + " | ";
    }
    if($("#top-search-place").val() != ""){
        resultsfor = resultsfor + "<i>" + $("#top-search-place").val() + "</i>";
        title = title + $("#top-search-place").val();
    }
    document.getElementById("results-for").innerHTML = resultsfor;
    $(document).prop('title', title + ' | RestaurantWebApp');
}

function refreshResults(askedArray){
    $("#results-loading").css('z-index', 1000);
    if($(window).width() > 767){
        width = $("#results-for-header").outerWidth();
        $("#results-loading").css('width', width);
    } else {        
        $("#results-loading").css('padding-top', 70);
        $("#results-loading").css('width', '100vw');
    }
    $("#results-loading").css('opacity', 0.9);
    get = "";
    get = get + "&radius_filter=" + $("#radius").val();
    get = get + "&rating=" + $("#hidden-rating").html();
    get = get + "&sort=" + $("#sort-by").val();
    get = get + "&order=" + $("#order").val();
    get = get + "&kindofrest=" + $("#kind-of-rest").val();
    get = get + "&postalcode=" + $("#postal-code").val();
    if(askedArray.hasOwnProperty("q")){
        get = get + "&q="+askedArray["q"];
        $.cookie("q", askedArray["q"]);
    }
    if(askedArray.hasOwnProperty("place")){
        get = get + "&place="+askedArray["place"];
        $.cookie("place", askedArray["place"]);
    }
    if(askedArray.hasOwnProperty("sort")){
        get = get + "&sort=" + askedArray["sort"];
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("radius_filter")){
        get = get + "&radius_filter=" + askedArray["radius_filter"];
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("rating")){
        get = get + "&rating=" + askedArray["rating"];
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("kindofrest")){
        get = get + "&kindofrest=" + (askedArray["kindofrest"]);
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("order")){
        get = get + "&order=" + (askedArray["order"]);
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("usecookieget")){
        if(askedArray["usecookieget"]){
            get = get + "&usecookieget=1";
        }
    }
    if(askedArray.hasOwnProperty("useq")){
        if(askedArray["useq"]){
            get = get + "&useq=1";
        }
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("results-content-wrapper").innerHTML = xmlhttp.responseText;
            $("#results-loading").css('opacity', 0);
            height = $("#specify").outerHeight() - $("#results-for-header").outerHeight();
            $("#map").css('height', height);
                if($("#choose-list").hasClass("active")){
                    $("#list").show();
                    $("#map").hide();
                } else {
                    $("#list").hide();
                    $("#map").show();
                }
            $("#amount-results-show").html($("#amount-results-dont-show").html());
            setTimeout(function(){
                $("#results-loading").css('z-index', -20);
            }, 500);
            if($("#results-for-header").outerHeight() != 73){
                $("#sort-wrap").css('margin-top', 20);
            } else {
                $("#sort-wrap").css('margin-top', 0);
            }
//            addresses = new Array('Amsterdam', 'Eindhoven');contents = new Array('Stad');
//            refreshMap($("#address-json-results").html(), $("#contents-json-results").html());
//            $.cookie('contents-json-results','');
//            $.cookie('addresses-json-results', $("#addresses-json-results").html());
//            $.cookie('contents-json-results', $("#contents-json-results").html());
//            $.cookie('contents2-json-results', $("#contents2-json-results").html());
//            alert($.cookie('contents2-json-results'));
            refreshMap();
//            alert($("#contents2-json-results").html());
//            refreshMap(addresses, contents);
            if($(window).width() > 350){
        $(".star-text-wrap").hide();
        $(".star-pics-wrap").show();
    } else {
        $(".star-text-wrap").show();
        $(".star-pics-wrap").hide();
    }
        }
    }
    xmlhttp.open("GET", "refreshResults.php?"+get, true);
    xmlhttp.send();
}

function showCatWaitingOnIndex(name,city){
    $("#results-loading").html('<h1>Loading data from <i>'+name+'</i> in <i>'+city+'</i>...</h1>');
    $("#results-loading").css('z-index', 1000);
    if($(window).width() > 767){
        width = $("#results-for-header").outerWidth();
        $("#results-loading").css('width', width);
    } else {        
        $("#results-loading").css('padding-top', 70);
        $("#results-loading").css('width', '100vw');
    }
    $("#results-loading").css('opacity', 0.9);
}

$("#sort-by").on("change", function(){
    var askedArray = new Array();
    askedArray["sort"] = $("#sort-by").val();
    askedArray["usecookieget"] = 1;
    refreshResults(askedArray);
});

$("#kind-of-rest").on("change", function(){
    var askedArray = new Array();
    askedArray["kindofrest"] = $("#kind-of-rest").val();
    askedArray["usecookieget"] = 1;
    refreshResults(askedArray);
});

$("#order").on("change", function(){
    if($("#order").val() != "order"){
        var askedArray = new Array();
        askedArray["order"] = $("#order").val();
        askedArray["usecookieget"] = 1;
        refreshResults(askedArray);
    }
});

$("#radius").on("change", function(){
    var askedArray = new Array();
    askedArray["radius_filter"] = $("#radius").val();
    askedArray["usecookieget"] = 1;
    refreshResults(askedArray);
});

function refineRating(rating){
    var askedArray = new Array();
    askedArray["rating"] = rating;
    askedArray["usecookieget"] = 1;
    refreshResults(askedArray);
}

var points = 0;
function topSearchLocation() {
        $("#location-or-load").attr('src', 'http://www.ballarat.vic.gov.au/media/2651383/loading.gif');
    if (navigator.geolocation) {
        $("#location-or-load").attr('src', 'http://www.ballarat.vic.gov.au/media/2651383/loading.gif');
        navigator.geolocation.getCurrentPosition(showTopPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
        $("#location-or-load").attr('src', 'https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/location-24-48.png');
    }
}

function showTopPosition(position) {
    str = position.coords.latitude + ',' + position.coords.longitude;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                $("#top-search-place").val(xmlhttp.responseText);
                $("#top-search-place").css('background-color', '#86cea6');
                $("#top-search-place").css('border-color', '#86cea6');
                setTimeout(function(){$("#top-search-place").css('background-color', '#FFF');
                $("#top-search-place").css('border-color', '#ccc');}, 300);
                $("#location-or-load").attr('src', 'https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/location-24-48.png');
            }
        }
        xmlhttp.open("GET", "geo.php?latlng=" + str, true);
        xmlhttp.send();
}


function showList(){
  $("#choose-map").attr("class", "");
  $("#choose-list").attr("class", "active");
  $("#list").show();
  $("#map").hide();
    $("#results-content-wrapper").css('padding', '0px 10px');
    $(".results").css('padding-bottom', 25);
    $.cookie('showMap', 0);
}

function showMap(){
  $("#choose-map").attr("class", "active");
  $("#choose-list").attr("class", "");
  $("#list").hide();
  $("#map").show();
    $("#results-content-wrapper").css('padding', 0);
    $(".results").css('padding-bottom', 0);
    $.cookie('showMap', 1);
}

$(".top-search-input").on("keypress", function(e){
    if(e.keyCode == 13){
        if($(location).attr('pathname').split("/").pop() == "index.php" || $(location).attr('pathname').split("/").pop() == ""){
            submitTopSearch();
        } else {
            document.location.href = "index.php?q="+$("#top-search-q").val()+"&place="+$("#top-search-place").val();
        }
    }
});

function showLessOfComment(commentId){
    document.getElementById('comment-'+commentId).innerHTML = document.getElementById('comment-summary-'+commentId).innerHTML;
}

function showMoreOfComment(commentId){
    document.getElementById('comment-'+commentId).innerHTML = document.getElementById('comment-full-content-'+commentId).innerHTML;
}

function addDish(id){
    if(typeof $.cookie("dish-"+id) !== "undefined"){
        $.cookie("dish-"+id, parseInt($.cookie("dish-"+id)) + 1);
    } else {
        $.cookie("dish-"+id, 1);
    }
    if($.cookie("dish-"+id) == 0){
        $("#remove-dish-"+id).hide();
    } else {
        $("#remove-dish-"+id).show();
    }
    total = parseInt($("#get-total").val());
    total = total + parseInt($("#get-price-"+id).val());
    $("#get-total").val(total);
    refreshDishes(id);
}

function removeDish(id){
    if(typeof $.cookie("dish-"+id) !== "undefined"){
        if($.cookie("dish-"+id) > 0){
            $.cookie("dish-"+id, parseInt($.cookie("dish-"+id)) - 1);
        }
    }
    if($.cookie("dish-"+id) == 0){
        $("#remove-dish-"+id).hide();
    } else {
        $("#remove-dish-"+id).show();
    }
    total = parseInt($("#get-total").val());
    total = total - parseInt($("#get-price-"+id).val());
    $("#get-total").val(total);
    refreshDishes(id);
}

function refreshDishes(id){
    $("#amount-dishes-"+id).html($.cookie("dish-"+id));
    $("#amount-dishes-"+id+"-hidden").val($.cookie("dish-"+id));
    total = $("#get-total").val();
    total = total / 100;total1 = total;
    total = total.toString().replace('.', ',');
    if(total == total1){
        total = total + ",00";
    } else {
        arr = total.split(",");
        if(arr[1].length == 1){
            total = total + "0";
        }
    }
    $("#total-script").html(total);
    $("#error").html("");
}

$(".order-conclusion-bottom").on("click", function(e){
    e.preventDefault();
    total = parseInt($("#get-total").val());
    if(total == 0){
        $("#error").html('<div class="alert alert-danger" role="alert">Please, choose at least one dish.</div>');
    } else {
    $("#error").html('<img src="http://upload.wikimedia.org/wikipedia/commons/5/53/Loading_bar.gif" alt="Loading" width="100%" />&nbsp;&nbsp;&nbsp;Checking your postal code... <br /><br />');
            var from = $("#postal-from").html();
            var distance = $("#distance").html();
            var to = $("#postal-code").val();
            $.get("checkPostal.php?distance="+distance+"&from="+from+"&to="+to, function(data) {
                $("#error").html(data);
                if($("#error").html() != '<div class="alert alert-success" role="alert">This restaurant orders at your place!</div>'){
                    $("#error").html('<div class="alert alert-danger" role="alert">Not a valid postal code.</div>');
                } else {
                    $("#order-submit-form").submit();
                    $("#error").html('<div class="alert alert-success" role="alert">This restaurant orders at your place!</div> <img src="http://upload.wikimedia.org/wikipedia/commons/5/53/Loading_bar.gif" alt="Loading" width="100%" /><br /><br />');
                }
            });
    }
});

function refreshMap(addresses,contents){
    document.getElementById("map-iframe").src = 'mapsiframe.php';//?addresses='+addresses+'&contents='+contents;
}

function showOrHideUserInfo(){
//    $("#user-drop-info-wrapper").show();
}

$("#user-info-li").click(function(){
    $(".user-drop-info-wrapper").hide();
    if($(".navbar").outerHeight() >= 100){
        document.location.href="mobileorders.php";
    } else {
        if(!$(".user-drop-info-wrapper").is(":visible")){ //&& !($("#user-info-a").is(":clicked") && $(".user-drop-info-wrapper").is(":visible"))){
            $(".user-drop-info-wrapper").show();
            $("#user-drop-info").css('border-radius', '0 0 5px 5px');
            $("#order-spec .user-drop-info").css('border-radius', '5px 0 0 5px');
            $("#order-spec .user-drop-info").css('border-right', 'none');
            $("#order-spec-wrap").hide();
            $(".user-drop-info").html('<div class="user-drop-item"><img src="http://upload.wikimedia.org/wikipedia/commons/5/53/Loading_bar.gif" alt="Loading" width="100%" /></div>');
            if($("#logged-in").html() == 1){
                $.get("refreshuserorders.php?loggedin=1", function(data) {
                    $(".user-drop-info-wrapper-wrapper").html('');
                    $(".user-drop-info-wrapper").html(data);
                }); 
            } else {
                $.get("refreshuserorders.php?loggedin=false", function(data) {
                    $(".user-drop-info-wrapper").html('');
                    $(".user-drop-info-wrapper").html(data);
                });
            } 
        } else {
            $(".user-drop-info-wrapper").hide();
        }
    }
});

$(document).mouseup(function(e){
    if($(".user-drop-info-wrapper").is(":visible") && !$("#user-drop-info").is(e.target)){
        $(".user-drop-info-wrapper").hide();
    }
});
//    alert($(this).attr('id'));

function showOrderSpec(id){
    $("#user-drop-info").css('border-radius', '0 0 5px 5px');
    $("#order-spec .user-drop-info").css('border-radius', '5px 0 0 5px');
    $("#order-spec .user-drop-info").css('border-right', 'none');
    $("#order-spec").show();
    $("#order-spec-content").html($("#order-"+id).html());
    if(window.location.pathname.substring(window.location.pathname.lastIndexOf('/')+1)!="mobileorders.php"){
        $("#order-spec").css('margin-top', $("#finished-order-"+id).position().top - $(".navbar").outerHeight() + 31);
        if($("#finished-order-"+id).position().top + $("#order-spec").outerHeight() > $("#finished-wrap").outerHeight() && $("#order-spec").outerHeight() < $("#finished-wrap").outerHeight()){
            $("#order-spec").css('margin-top', $("#finished-wrap").outerHeight() - $("#order-spec").outerHeight() - 18);
            if($("#finished-wrap").outerHeight() + 5 > $("#user-drop-info").outerHeight()){
                $("#user-drop-info").css('border-radius', '0 0 5px 0');
            }
        } else if($("#order-spec").outerHeight() > $("#finished-wrap").outerHeight()){
            $("#order-spec .user-drop-info").css('border-radius', '5px 0 5px 5px');
            if($("#finished-wrap").outerHeight() + 5 > $("#user-drop-info").outerHeight()){
                $("#user-drop-info").css('border-radius', '0 0 5px 0');
            }
            $("#order-spec .user-drop-info").css('border-right', '1px solid #F2A003');
            $("#order-spec .user-drop-info").css('left', '11px');
        }
    }
}

$("#order").on("change", function(){
    if($("#order").val() == "order"){
        $("#postal-wrapper").show();
        var rege = /^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i;
        if(rege.test($("#top-search-place").val())){
            $("#postal-code").val($("#top-search-place").val());
        }
        if(!rege.test($("#postal-code").val())){
            $("#postal-code").css("background", "#f45656");
            $("#postal-code").css("color", "#FFF");
        } else {
            $("#postal-code").css("background", "#FFF");
            $("#postal-code").css("color", "#555");
            var askedArray = new Array();
            refreshResults(askedArray);
        }
    } else {
        $("#postal-wrapper").hide();
    }
});

$("#postal-code").on("keyup", function(){
    var rege = /^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i;
    if(!rege.test($("#postal-code").val())){
            $("#postal-code").css("background", "#f45656");
            $("#postal-code").css("color", "#FFF");
            $("#error").html('<div class="alert alert-danger" role="alert">Not a valid postal code.</div>');
        } else {
            $("#error").html('<img src="http://upload.wikimedia.org/wikipedia/commons/5/53/Loading_bar.gif" alt="Loading" width="100%" />&nbsp;&nbsp;&nbsp;Checking your postal code... <br /><br />');
            var from = $("#postal-from").html();
            var distance = $("#distance").html();
            var to = $("#postal-code").val();
            $.get("checkPostal.php?distance="+distance+"&from="+from+"&to="+to, function(data) {
                $("#error").html(data);
            });
                $("#postal-code").css("background", "#FFF");
                $("#postal-code").css("color", "#555");     
            var askedArray = new Array();
            refreshResults(askedArray);
        }
});