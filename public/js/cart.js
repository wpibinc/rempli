Parse.initialize("mmcrSN69TR6IR6e6uo2pzlhpR2amZNkHl4b0GVh1", "ALR6Z7SnB2mWr2SBkZ9cnQX8dgqJph0F47b1aPjl");

function handleParseError(err) {
  switch (err.code) {
    case Parse.Error.INVALID_SESSION_TOKEN:
      Parse.User.logOut();
      break;
  }
}
$.widget('custom.autocomplete', $.ui.autocomplete, {
    _renderItem: function( ul, item ) {
        return $( "<li>" )
            .attr( "data-id", item.id )
            .attr("data-price", item.price)
            .attr("data-weight", item.weight)
            .attr("data-category", item.category)
            .append( item.label )
            .append("<img src='"+item.image+"'>")
            .appendTo( ul );
    }
});

$(document).ready(function() {
    $(document).on('click', '.ordered-item > td.total > a:nth-child(4)', function () {
        $(this).removeClass('notActiveComent').removeClass('activeComent');
        $(this).next().removeClass('activeComent').removeClass('notActiveComent');
        $(this).addClass('notActiveComent');
        $(this).next().addClass('activeComent');
    });
    $(document).on('click', '.not-save-comment', function () {
        $(this).parent().addClass('notActiveComent').removeClass('activeComent');
        $(this).parent().siblings('a').removeClass('notActiveComent');
        $(this).siblings("textarea").val('');
    });
    
    
    $(".popup-num").keydown(function(event) {
            // Allow only backspace and delete
            if ( event.keyCode == 46 || event.keyCode == 8 ) {
                    // let it happen, don't do anything
            }
            else {
                    // Ensure that it is a number and stop the keypress
                    if (event.keyCode < 48 || event.keyCode > 57 ) {
                            event.preventDefault();
                    }
            }
    });
    
    
    
    $("#cart_white .autocomplete").autocomplete({
        width: 200,
        max: 3,
        source: '/autocomplete-product-search',
        select: function( event, ui ) {
            var theId = ui.item.id;
            var weight = +ui.item.weight;
            var category = +ui.item.category;
            var image = ui.item.image;
            var title = ui.item.label;
            var price = ui.item.price;
            
            if (sessionStorage.count) {
                sessionStorage.count = Number(sessionStorage.count)+1;
            } else {
                sessionStorage.count = 1;
            }
            
            sessionStorage.mass = parseInt(sessionStorage.mass) + weight;


            if (sessionStorage[theId]) {
                sessionStorage[theId] = Number(sessionStorage[theId])+1;
            } else {
                sessionStorage[theId] = 1;
            }
            newItem = (
            '<tr data-category="'+category+'" class="ordered-item" id="cart-'+theId+'"> '+
            '<td class="quantity"> '+Number(sessionStorage[theId])+
            '<br>'+'<a href="#" class="cart-change cart-add"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><span class="cart-del-txt"> Добавить</span></a>'  +
            '<br>'+'<a href="#" class="cart-change cart-min"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><span class="cart-del-txt"> Убрать</span></a>' +
            '</td>' +
            '<td class="image hidden-xs hidden-sm"> <span class="helper"></span><img src="'+image+'" ></td>' +
            '<td class="name">'+title+'</td>'+
            '<td class="price"><span class="priceShow">'+parseFloat(price)+'</span>р</td>' +

            '<td class="total"><span class="weight" style="display:none">'+weight+'</span><span class="totalShow">'+ (Math.round(parseFloat(price))*parseFloat(Number(sessionStorage[theId])))+ '</span>р'+
            '<a href="#" class="cart-change cart-del">×</a>' +
			'<a class="add-product-comment" href="javascript:void(0)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Добавить комментарий</a>' +
			'<span><textarea rows="10" cols="45" name="text" class="special-instructions-box"></textarea><a href="javascript:void(0)" class="not-save-comment">Отмена</a></span>'+
            '</td>'+
            '</tr>');

            $('#cart-number').html(Number(sessionStorage.count));

            var itemId = theId;
            $("#cart-"+ itemId).remove();

            $("#ordered-items").prepend(newItem);

            totalCost = totalCost + Math.round(parseFloat(price));

            totalCost = Math.round(totalCost);
            console.log(totalCost);
            $('#cart-price').html(totalCost);

            if (totalCost >= 200) {
                    $('#notmin').css( "display", "none" );
            }
            $('.cart-total').find('th').html(sessionStorage.mass + ' грамм');
            sessionStorage.cart = $("#ordered-items").html();
            sessionStorage.total = totalCost;
            return newItem;
        }
    });
});


var setTileWidth = function() {
	if($("#item-wrap-inner")[0]) {
		var clientWidth = $("#item-wrap-inner")[0].clientWidth;
		var noOfTiles = clientWidth / 200; //232
		//noOfTiles = Math.floor(noOfTiles);
		if(noOfTiles >= Math.floor(noOfTiles) + 0.75) {
			noOfTiles = Math.ceil(noOfTiles);
		} else {
			noOfTiles = Math.floor(noOfTiles);
		}
		$("#item-wrap-inner")[0].className = "products-wrap " + "tile-" + noOfTiles;
	}
};



$(window).resize(setTileWidth);
$(window).load(setTileWidth);
$(setTileWidth);


var basedCost = 100;
var totalCost = 0;
var newItem = '';
var dCost = 100;
var mass = 0;
if (!sessionStorage.mass) {
	sessionStorage.mass = 0;
}
if (!sessionStorage.total) {
	sessionStorage.total = 0;
}

if (sessionStorage["ids"]) {
	ids = JSON.parse(sessionStorage["ids"]);
	counts = JSON.parse(sessionStorage["counts"]);
} else {
	var ids = [];
	var counts = [];
}


var currentUser = Parse.User.current();
// if (currentUser) {
// 	var User = Parse.Object.extend("User");
// 			var query = new Parse.Query(User);
// 			query.get(currentUser.id, {
// 			  success: function(user) {
// 			  	if (user.get("freeDelivery")) {
// 			  			dCost = 0;
// 						basedCost = 0;
// 						$('#delivery_cost').html(dCost);
// 						$('#cart-price').html(totalCost);
// 						$('#total_main').html((totalCost + dCost) + '  &#8381;');
// 						$('#freeDelivery').css('display', 'block');
// 			  	}
// 			  }
// 			});
// } else {
// 	dCost = 0;
// 	basedCost = 0;
// 	$('#delivery_cost').html(dCost);
// 	$('#cart-price').html(totalCost);
// 	$('#total_main').html((totalCost + dCost) + '  &#8381;');
// 	$('#freeDelivery').css('display', 'block');
// }

if (currentUser) {
	$('#freeDelivery').css('display', 'none');
} else {
	$('#freeDelivery').css('display', 'block');
}


if (sessionStorage.cart) {
	$("#ordered-items").prepend(sessionStorage.cart);
}
if (sessionStorage.total) {
	totalCost = Number(sessionStorage.total);
	$('#total_main').html(totalCost + '  &#8381;');
	$('#grocery-price').html(totalCost);
	$('#cart-price').html(totalCost);
}
if (sessionStorage.count) {
	$('#cart-number').html(Number(sessionStorage.count));
	$('#cart-number').css( "display", "inline" );
	$('#cart-number').css( "margin-left", "5px" );
}

// alert(dCost);

$(document).on('click', ".increase_count", function(){
	var theId = $(this).closest('.product').attr('id');
        var weight = +$(this).attr("data-weight");
        var category = $(this).parent().attr('data-category');
        
        
        
	if (sessionStorage.count) {
    	sessionStorage.count = Number(sessionStorage.count)+1;
	} else {
	    sessionStorage.count = 1;
	}
	//sessionStorage.mass = parseFloat(sessionStorage.mass) + parseFloat($(this).closest('.product').find('.product-howmuch').html());
	//console.log( parseInt(sessionStorage.mass));
	sessionStorage.mass = parseInt(sessionStorage.mass) + weight;

	// console.log( $(this).closest('.product').find('.reduce_count'));
	$(this).closest('div').children('.reduce_count').removeClass( "hidden" ).addClass( "visible" );
	$(this).closest('.product').children('.item_count').removeClass( "hidden" ).addClass( "visible" );

	if (sessionStorage[theId]) {
    	sessionStorage[theId] = Number(sessionStorage[theId])+1;
	} else {
	    sessionStorage[theId] = 1;
	}
	newItem = (
	'<tr data-category="'+category+'" class="ordered-item" id="cart-'+$(this).closest('.product').attr('id')+'"> '+
	'<td class="quantity"> '+Number(sessionStorage[theId])+
	'<br>'+'<a href="#" class="cart-change cart-add"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><span class="cart-del-txt"> Добавить</span></a>'  +
	'<br>'+'<a href="#" class="cart-change cart-min"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><span class="cart-del-txt"> Убрать</span></a>' +
	'</td>' +
	'<td class="image hidden-xs hidden-sm"> <span class="helper"></span>'+ $(this).closest('.product').find('img')[0].outerHTML + '</td>' +
	'<td class="name">'+$(this).closest('.product').find('.product-title').html()+'</td>'+
	'<td class="price"><span class="priceShow">'+parseFloat($(this).closest('.product').find('.price').html())+'</span>р</td>' +

	'<td class="total"><span class="weight" style="display:none">'+weight+'</span><span class="totalShow">'+ (Math.round(parseFloat($(this).closest('.product').find('.price').html()))*parseFloat(Number(sessionStorage[theId])))+ '</span>р'+
	'<a href="#" class="cart-change cart-del">×</a>' +
	'<a class="add-product-comment" href="javascript:void(0)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Добавить комментарий</a>' +
	'<span><textarea rows="10" cols="45" name="text" class="special-instructions-box"></textarea><a href="javascript:void(0)" class="not-save-comment">Отмена</a></span>'+
	'</td>'+

	'</tr>');


	// console.log(theId + sessionStorage[theId]);
	$(this).closest('.product').children('.item_count').html(sessionStorage[theId]);

	$('#cart-number').html(Number(sessionStorage.count));

	var itemId = $(this).closest('.product').attr('id');
	// if (value > 1) {
		$("#cart-"+ itemId).remove();
	// }
	$("#ordered-items").prepend(newItem);
	totalCost = totalCost + Math.round(parseFloat($(this).closest('.product').find('.price').html()));
        
	totalCost = Math.round(totalCost);
	$('#cart-price').html(totalCost);

	if (totalCost >= 200) {
		$('#notmin').css( "display", "none" );
	}
	$('.cart-total').find('th').html(sessionStorage.mass + ' грамм');
	sessionStorage.cart = $("#ordered-items").html();
	sessionStorage.total = totalCost;
        
        $(".modal").each(function(){
            if($(this).attr('id')=='idt'+theId){
                $(this).find('.item_count').removeClass('hidden').addClass('visible').text(sessionStorage[theId]);
            }
        });
	return newItem;
});

$(document).on('click', '.add-to-cart', function(e){
	var theId = $(this).attr('data-id');
        var weight = +$(this).attr("data-weight");
        var category = $(this).attr('data-category');
        var price = $(this).parents(".modal-dialog").find(".popup-price")
        
        
	if (sessionStorage.count) {
            sessionStorage.count = Number(sessionStorage.count)+1;
	} else {
	    sessionStorage.count = 1;
	}
	
	sessionStorage.mass = parseInt(sessionStorage.mass) + weight;
        
	if (sessionStorage[theId]) {
            sessionStorage[theId] = Number(sessionStorage[theId])+1;
	} else {
	    sessionStorage[theId] = 1;
	}
        $(this).closest('.modal').find('.item_count').removeClass( "hidden" ).addClass( "visible" ).html(sessionStorage[theId]);
	newItem = (
	'<tr data-category="'+category+'" class="ordered-item" id="cart-'+theId+'"> '+
	'<td class="quantity"> x '+Number(sessionStorage[theId])+
	'<br>'+'<a href="#" class="cart-change cart-add"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><span class="cart-del-txt"> Добавить</span></a>'  +
	'<br>'+'<a href="#" class="cart-change cart-min"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><span class="cart-del-txt"> Убрать</span></a>' +
	'</td>' +
	'<td class="image hidden-xs hidden-sm"> <span class="helper"></span>'+ $(this).parents(".modal-dialog").find(".popup-image").find('img')[0].outerHTML + '</td>' +
	'<td class="name">'+$(this).parents(".modal-dialog").find(".popup-name").find('.popup-title').html()+'</td>'+
	'<td class="price"><span class="priceShow">'+parseFloat($(this).parents(".modal-dialog").find(".popup-price").html())+'</span>р</td>' +

	'<td class="total"><span class="weight" style="display:none">'+weight+'</span><span class="totalShow">'+ (parseFloat($(this).parents(".modal-dialog").find(".popup-price").html())*parseFloat(Number(sessionStorage[theId]))).toFixed(0)+                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  '</span>р'+
	'<a href="#" class="cart-change cart-del">×</a>' +
	'<a class="add-product-comment" href="javascript:void(0)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Добавить комментарий</a>' +
	'<span><textarea rows="10" cols="45" name="text" class="special-instructions-box"></textarea><a href="javascript:void(0)" class="not-save-comment">Отмена</a></span>'+
	'</td>'+
	'</tr>');

	$('#cart-number').html(Number(sessionStorage.count));
        var itemId = theId;
        $("#cart-"+ itemId).remove();
	$("#ordered-items").prepend(newItem);


	totalCost = totalCost + parseFloat($(this).parents(".modal-dialog").find(".popup-price").html());

	totalCost = Math.round(totalCost);

	$('#cart-price').html(totalCost);

	if (totalCost >= 200) {
		$('#notmin').css( "display", "none" );
	}
	$('.cart-total').find('th').html(sessionStorage.mass + ' грамм');
	sessionStorage.cart = $("#ordered-items").html();
	sessionStorage.total = totalCost;
        $(".product").each(function(){
            if($(this).attr('id')==theId){
                $(this).find('.item_count').removeClass('hidden').addClass('visible');
                $(this).find('.item_count').text(sessionStorage[theId]);
            }
        });
	return newItem;

});

$('#orderBtn2').on({
	"click":function(e){

		var id = [];

		if (totalCost < 200) {
			e.stopPropagation();
			$('#notmin').css( "display", "block" );
		}
		else {
			$('#notmin').css("display", "none");

			for (var i = 0; i < sessionStorage.length; i++) {
				//console.log(sessionStorage.getItem(sessionStorage.key(i)));
				if (parseFloat(Number(sessionStorage.key(i))))
				//console.log(sessionStorage.key(i));
					id.push({
						id   : sessionStorage.key(i),
						count: sessionStorage.getItem(sessionStorage.key(i))
					});
			};


			data = id;
			//console.log(data);

			$.ajax({
				type: 'POST',
				url: '/order',
				contentType: 'application/json',
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: JSON.stringify({ items: data }),
				success: function (data) {
				},
				error: function (xhr, textStatus, thrownError) {
					alert(thrownError);
				}
			});

		}
	}
	});
var confirmAlcohol = false;
$(document).on('click', ".dropdown-toggle", function(){
    $(this).after('<div class="dropdown-backdrop"></div>')
});
$(document).on('click', '.popup-alcogol .close-popup', function(){
    $(this).parents('.popup-alcogol').removeClass('active-popup');
});
$(document).on('click', '.popup-alcogol .ok-popup', function(){
    $(this).parents('.popup-alcogol').removeClass('active-popup');
    confirmAlcohol = true;
    $('#orderBtn').click();
});
//старая
$('#orderBtn').on({
	"click":function(e){
        var isAlcohol = false;
        $("tr.ordered-item").each(function(){
            var category = $(this).attr("data-category");
            if(category == '29'||category == '30'){
                $('.popup-alcogol').addClass('active-popup');
                isAlcohol = true;
            }
        });
        if(isAlcohol&&!confirmAlcohol){
            return true;
        }
// $(document).on('click', "#orderBtn", function(){ // Parse
	if (totalCost < 200) {
		e.stopPropagation();
		$('#notmin').css( "display", "block" );
	}
	else {

		$('#notmin').css( "display", "none" );

        var comments = sessionStorage.getItem('comments');
        if(!comments){
            comments = {};
        }else{
            comments = JSON.parse(comments);
        }
        $("#ordered-items textarea.special-instructions-box").each(function(){
            var id = $(this).closest('tr').attr('id').substring(5);
            var comment = $(this).val();
            comments[id] = comment;
        });
        comments = JSON.stringify(comments);
        sessionStorage.setItem('comments', comments);

	var OrderArchive = Parse.Object.extend("OrdersArchive");
	var orderArchive = new OrderArchive();
	orderArchive.set("html", $('#cart-items').html());
	orderArchive.save(null, {
	  success: function(order) {
	  	sessionStorage.cOrderArchive = orderArchive.id;
                console.log(sessionStorage);
	  },
	  error: function(order, error) {
	  }
	});


	var Order = Parse.Object.extend("Orders");
	var order = new Order();
	order.set("html", $('#cart-items').html());

        
	order.save(null, {
	  success: function(order) {
	  	sessionStorage.cOrder = order.id;
	  	sessionStorage.cost = totalCost;
	  	sessionStorage.dCost = dCost;
	    // if (currentUser) {
	    	window.location = "/order";
	    // } else {
	    // 	window.location = "signin.html";
	    // }


	  },
	  error: function(order, error) {
	    // Execute any logic that should take place if the save fails.
	    // error is a Parse.Error with an error code and message.
	    console.log(error.message);
	    // alert('Не удалось создать заказ: ' + error.message);

	  }
	});

}//end else
}//end on click
});
// $('.reduce_count').click(function () {
$(document).on('click', ".reduce_count", function(){

                        console.log('reduce_count');
		var theId = $(this).closest('.product').attr('id');
		sessionStorage[theId] = Number(sessionStorage[theId]) - 1;
		if (sessionStorage.count) {
			sessionStorage.count = Number(sessionStorage.count) - 1;
		}
		$(this).closest('.product').children('.item_count').html(sessionStorage[theId]);

		//sessionStorage.mass = parseFloat(sessionStorage.mass) - parseFloat($(this).closest('.product').find('.product-howmuch').html());
		sessionStorage.mass = parseInt(sessionStorage.mass) + json.find(function (element, index, array) {
				if (element.objectId === theId)
					return element
			}).weight;

		$('.cart-total').find('th').html(sessionStorage.mass + ' грамм');
		newItem = (
		'<tr class="ordered-item" id="cart-' + $(this).closest('.product').attr('id') + '"> ' +
		'<td class="quantity"> x ' + Number(sessionStorage[theId]) +
		'<br>' + '<a href="#" class="cart-change cart-add"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><span class="cart-del-txt"> Добавить</span></a>' +
		'<br>' + '<a href="#" class="cart-change cart-min"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><span class="cart-del-txt"> Убрать</span></a>' +
		'</td>' +
		'<td class="image hidden-xs hidden-sm"> <span class="helper"></span>' + $(this).closest('.product').find('img')[0].outerHTML + '</td>' +
		'<td class="name">' + $(this).closest('.product').find('.product-title').html() + '</td>' +
		'<td class="price"><span class="priceShow">' + parseFloat($(this).closest('.product').find('.price').html()) + '</span>р</td>' +

		'<td class="total"><span class="totalShow">' + (parseFloat($(this).closest('.product').find('.price').html()) * parseFloat(Number(sessionStorage[theId]))).toFixed(0) + '</span>р' +
		'<a href="#" class="cart-change cart-del">×</a>' +
		'<a class="add-product-comment" href="javascript:void(0)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Добавить комментарий</a>' +
		'<span><textarea rows="10" cols="45" name="text" class="special-instructions-box"></textarea><a href="javascript:void(0)" class="not-save-comment">Отмена</a></span>'+
		'</td>' +
		'</tr>');


		var itemId = $(this).closest('.product').attr('id');

		var idIndex = ids.indexOf($(this).closest('.product').attr('id'));
		counts[idIndex] -= 1;

		sessionStorage["ids"] = JSON.stringify(ids);
		sessionStorage["counts"] = JSON.stringify(counts);

		$("#cart-" + itemId).remove();


		if (sessionStorage[theId] <= 0) {
			$(this).closest('div').children('.reduce_count').removeClass("visible").addClass("hidden");
			$(this).closest('.product').children('.item_count').removeClass("visible").addClass("hidden");
			// sessionStorage[theId] = Number(sessionStorage[theId])-1;
		}
		else {
			$("#ordered-items").prepend(newItem);
		}

		$('#cart-number').html(sessionStorage.count);

		totalCost = totalCost - parseFloat($(this).closest('.product').find('.product-price').html());

		totalCost = Math.round(totalCost);


		$('#total_main').html((totalCost + dCost) + '  &#8381;');
		$('#grocery-price').html(totalCost);
		$('#cart-price').html(totalCost);

		sessionStorage.cart = $("#ordered-items").html();
		sessionStorage.total = totalCost;
		return newItem;

});
var h;
var m;
function updateClock() {
	var d = new Date();
	var h = d.getHours() + 1;
	var m = d.getMinutes();
	$("#cart_time_b").html(h+':'+ (m<10?'0':'') + m);
	// $(".order-time").html(h+':'+ (d.getMinutes()<10?'0':'') + m);
	// если верный работает с 9 до 22
	if (h > 22){
		$("#cart_time_b").html('10:30');
		$("#delivery_day").html('Доставим завтра до 10:30');

	}
	if (h < 11){
		$("#cart_time_b").html('11:00');
	}


    setTimeout(updateClock, 6000);
    return [h,m];
}
updateClock(); // initial call

$("a[href='#top']").click(function() {
  $("html, body").animate({ scrollTop: 0 }, "fast");
  return false;
});


$('.dropdown-menu').click(function(e) {
        e.stopPropagation();
});


$(".cart-del").click(function() {
	var remid = $(this).closest('.ordered-item').attr('id');

	remid = remid.substring(5, remid.length);
	// alert(remid);
	// $("#"+remid).find(".reduce_count").click();
	$("#"+remid).find(".reduce_count").click();
	// alert($("#"+remid).find(".name").html());
	// alert(remid);
});


$("#ordered-items").on('click', '.cart-add', function(e) {
        
	var str = $(this).closest('tr').attr('id');
	var theId = str.substring(5);
	var thePrice = Number($(this).closest('tr').find('.priceShow').html());
        var weight = +$(this).parents('tr').find('td.total .weight').text();
        console.log(thePrice * Number(sessionStorage[theId]));
        
	sessionStorage.count = Number(sessionStorage.count)+1;
	$('#cart-number').html(Number(sessionStorage.count));
	sessionStorage[theId] = Number(sessionStorage[theId])+1;
        $(this).closest('tr').find('.totalShow').html(Math.round(thePrice) * Number(sessionStorage[theId]));
	$(this).closest('tr').find('.quantity').html('' + sessionStorage[theId]+
	'<br>'+'<a href="#" class="cart-change cart-add"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><span class="cart-del-txt"> Добавить</span></a>'  +
	'<br>'+'<a href="#" class="cart-change cart-min"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><span class="cart-del-txt"> Убрать</span></a>'
	);
        
	

	//sessionStorage.mass = parseFloat(sessionStorage.mass) + parseFloat($(this).closest('tr').find('.mass').html());
	sessionStorage.mass = parseInt(sessionStorage.mass) + weight;
	totalCost = totalCost + Math.round(thePrice);
	//totalCost = Math.round(totalCost);
	sessionStorage.total = totalCost;
	$('.cart-total').find('th').html(sessionStorage.mass + ' грамм');
	$('#cart-price').html(totalCost);


	if ($('#'+theId).length === 0) {
	} else {
		$('#'+theId).find('.item_count').html(sessionStorage[theId])
	}

	sessionStorage.cart = $("#ordered-items").html();
});


$("#ordered-items").on('click', '.cart-min', function() {

		var str = $(this).closest('tr').attr('id');
		var theId = str.substring(5);
                var weight = +$(this).parents('tr').find('td.total .weight').text();
		var thePrice = Number($(this).closest('tr').find('.priceShow').html());
	if (parseInt(sessionStorage.count) >1 && Number(sessionStorage[theId])>1) {
		sessionStorage.count = Number(sessionStorage.count) - 1;
		$('#cart-number').html(Number(sessionStorage.count));
		sessionStorage[theId] = Number(sessionStorage[theId]) - 1;
                $(this).closest('tr').find('.totalShow').html(Math.round(thePrice) * Number(sessionStorage[theId]));
		$(this).closest('tr').find('.quantity').html('' + sessionStorage[theId] +
			'<br>' + '<a href="#" class="cart-change cart-add"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><span class="cart-del-txt"> Добавить</span></a>' +
			'<br>' + '<a href="#" class="cart-change cart-min"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><span class="cart-del-txt"> Убрать</span></a>'
		);
		
		//sessionStorage.mass = parseFloat(sessionStorage.mass) - parseFloat($(this).closest('tr').find('.mass').html());
		sessionStorage.mass = parseInt(sessionStorage.mass) - weight;
		totalCost = totalCost - Math.round(thePrice);
		totalCost = Math.round(totalCost);
		sessionStorage.total = totalCost;
		$('.cart-total').find('th').html(sessionStorage.mass + ' грамм');
		$('#cart-price').html(totalCost);


		if ($('#' + theId).length === 0) {
		} else {
			$('#' + theId).find('.item_count').html(sessionStorage[theId]);
		}

		if (Number(sessionStorage[theId]) <= 0) {
			$(this).closest('tr').remove();
			if ($('#' + theId).length === 0) {
			} else {
				$('#' + theId).find('.reduce_count').removeClass("visible").addClass("hidden");
				$('#' + theId).find('.item_count').removeClass("visible").addClass("hidden");
			}
		}

		sessionStorage.cart = $("#ordered-items").html();
	}

});

$("#ordered-items").on('click', '.cart-del', function() {
	var str = $(this).closest('tr').attr('id');
	var theId = str.substring(5);
	var thePrice = Number($(this).closest('tr').find('.priceShow').html());
        var weight = +$(this).parents('td.total').find('.weight').text();
	sessionStorage.count = Number(sessionStorage.count)-Number(sessionStorage[theId]);
	$('#cart-number').html(Number(sessionStorage.count));
	//sessionStorage.mass = parseFloat(sessionStorage.mass) - (parseFloat($(this).closest('tr').find('.mass').html() * Number(sessionStorage[theId])));
	sessionStorage.mass = parseInt(sessionStorage.mass) - weight * Number(sessionStorage[theId]);

	totalCost = totalCost - (Math.round(thePrice) * Number(sessionStorage[theId]));
	totalCost = Math.round(totalCost);
	sessionStorage.total = totalCost;
	$('.cart-total').find('th').html(sessionStorage.mass + ' грамм');
	$('#cart-price').html(totalCost);

	$(this).closest('tr').remove();
	if ($('#'+theId).length === 0) {
	} else {
		$('#'+theId).find('.reduce_count').removeClass( "visible" ).addClass( "hidden" );
		$('#'+theId).find('.item_count').html(sessionStorage[theId]);
		$('#'+theId).find('.item_count').removeClass( "visible" ).addClass( "hidden" );
	}

	sessionStorage[theId] = 0;
	sessionStorage.cart = $("#ordered-items").html();

});


$(document).scroll(function() {
  var y = $(this).scrollTop();
  if (y > 1950) {
    $('#cattop').css('display', 'block');
    $('#clicktop').css('display', 'block');
    $('#texttop').css('display', 'block');
  } else {
    $('#cattop').css('display', 'none');
    $('#clicktop').css('display', 'none');
    $('#texttop').css('display', 'none');
  }
});




// $('.product').click(function () {
//     // alert($(this).attr('id'));
//     alert("sadf");
// });
$(document).ready(function() {
	$(document).on('click', ".product", function(){
	  src = $('#idt' + $(this).attr('id')).find('img').attr('src');
	  newsrc = src.replace("table", "big");
	  $('#idt' + $(this).attr('id')).find('img').attr({
	  	src: newsrc,
	  });
	});
});

$(document).on('click', ".product_card_prop_item_value", function(e){
// $('.product_card_prop_item_value').find('a').click(function(e) {
 e.preventDefault();
});

$(document).on('click', "#dd_btn", function(){
	$('#dd_body').toggle();
	$('.backdrop').toggle();

});


$(document).on('click', ".backdrop", function(){
	$('#dd_body').toggle();
	$('.backdrop').hide();

});


var search_results = '';
function search(word) {
	$(".header_cat").empty();
	$(".header_cat").prepend('Результаты поиска');
        $(".av-categories").html('');
	word = word.toLowerCase();
	var n = 0;
	search_results = '';
        
        $.ajax({
            url: '/search',
            dataType: 'json',
            data: {
                word: word
            },
            success: function(res){
                if(!res.success){
                    search_results = '<div id="nosearch"> <h2>К сожалению по Вашему запросу ничего не найдено</h2> <h3>Попробуйте ввести другое или более короткое слово</h3> </div>'
                }else{
                    var json = res.products.sort(function(a, b) {
                        return parseFloat((new Date(b.updatedAt)).getTime()) - parseFloat((new Date(a.updatedAt)).getTime());
                    });
                    for (i = 0; i < json.length; i++) {
                        if (Number(sessionStorage[json[i].objectId]) > 0) {
			    search_results  += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" id="' + json[i].objectId + '" data-category="'+json[i].category+'"><div class="count item_count visible">'+sessionStorage[json[i].objectId]+'</div><a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '"> <img src="' + json[i].img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '">' + json[i].product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + json[i].price + ' руб</div><div class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">'+ json[i].amount +'</div><br class="clearfix"></div><button href="javascript:void(0)" data-weight="'+json[i].weight+'" class="increase_count buy">Добавить</button></div>';

			} else {
			    search_results  += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" id="' + json[i].objectId + '" data-category="'+json[i].category+'"><div class="count item_count hidden">'+sessionStorage[json[i].objectId]+'</div><a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '"> <img src="' + json[i].img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '">' + json[i].product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + json[i].price + ' руб</div><div class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">'+ json[i].amount +'</div><br class="clearfix"></div><button href="javascript:void(0)" data-weight="'+json[i].weight+'" class="increase_count buy">Добавить</button></div>';

			}
                        var consist = '';
                        var ctitles = json[i].ctitles;
                        var cvalues = json[i].cvalues;

                        for (x = 0; x < ctitles.length; x++) {
                            consist+=('<div class="product_card_prop_item mb5"> <div class="product_card_prop_item_title">'+ctitles[x]+'</div> <div class="product_card_prop_item_value">'+cvalues[x]+'</div> <div class="clear"></div> </div>');
                        }
                        var vis = "hidden";
                        if(Number(sessionStorage[json[i].objectId]) > 0){
                            vis = "visible";
                        }
                        search_results  += '<div class="modal fade bs-example-modal-lg" id="idt' + json[i].objectId + '" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg"> <div class="modal-content row"> <div class="row"> <div class="popup-image"><div class="count item_count '+vis+'">' + sessionStorage[json[i].objectId] + '</div><span class="popup-helper"></span> <img class="popimg" src="' + json[i].img_sm + '"> </div> <div class="popup-name"> <p class="popup-title" id="myModalLabel">' + json[i].product_name + '</p> <div class="popup-price"> ' + json[i].price + ' <span class="popup-rub">'+num2word(Math.floor(json[i].price),words)+'</span> <button href="javascript:void(0)" data-id="'+json[i].objectId+'" data-category="'+json[i].category+'" data-weight="'+json[i].weight+'" data-weight="'+json[i].weight+'" class="add-to-cart buy">Добавить</button> </div> <div class="popup-mass"> '+ json[i].amount +'</div> </div> </div> <hr> <div class="row"> <div class="popup-description"> <strong>Описание</strong> <br> <div class="description-text">' + json[i].description + '</div> </div> '+consist+'</div> </div> </div> </div>';
                    }
                    $(".products-wrap").empty();
                    $(".products-wrap").prepend(search_results);

                    $( ".product" ).each(function( index ) {
                          var theId = $(this).attr('id');
                          $(this).find('.item_count').html(sessionStorage[theId]);
                          if (sessionStorage[theId] > 0) {
                            $(this).find('.reduce_count').removeClass( "hidden" ).addClass( "visible" );
                            $(this).find('.item_count').removeClass( "hidden" ).addClass( "visible" );
                          } else {
                            $(this).find('.reduce_count').removeClass( "visible" ).addClass( "hidden" );
                            $(this).find('.item_count').removeClass( "visible" ).addClass( "hidden" );
                          }
                        });

                    current = 'searchvar';
                }
                
            }
        });
        
//	$.each(json, function(i, v) {
//        if (v.product_name.toLowerCase().indexOf(word) >= 0) {
//        		if (Number(sessionStorage[v.objectId]) > 0) {
//			    search_results  += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" id="' + v.objectId + '"><div class="count item_count visible">'+sessionStorage[v.objectId]+'</div><a href="#" data-toggle="modal" data-target="#idt' + v.objectId + '"> <img src="' + v.img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + v.objectId + '">' + v.product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + v.price + ' руб</div><div class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">'+ v.amount +'</div><br class="clearfix"></div><button href="javascript:void(0)" class="increase_count buy">Добавить</button></div>';
//
//			    } else {
//			    search_results  += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" id="' + v.objectId + '"><div class="count item_count hidden">'+sessionStorage[v.objectId]+'</div><a href="#" data-toggle="modal" data-target="#idt' + v.objectId + '"> <img src="' + v.img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + v.objectId + '">' + v.product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + v.price + ' руб</div><div class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">'+ v.amount +'</div><br class="clearfix"></div><button href="javascript:void(0)" class="increase_count buy">Добавить</button></div>';
//
//			    }
//
//			    search_results  += '<div class="modal fade bs-example-modal-lg" id="idt' + v.objectId + '" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"> <div class="modal-dialog modal-lg"> <div class="modal-content row"> <div class="row"> <div class="popup-image";> <span class="popup-helper"></span> <img class="popimg" src="' + v.img_sm + '"> </div> <div class="popup-name"> <p class="popup-title" id="myModalLabel">' + v.product_name + '</p> <div class="popup-price"> ' + v.price + ' <span class="popup-rub">'+num2word(Math.floor(v.price),words)+'</span> <button href="javascript:void(0)" class="increase_count buy">Добавить</button> </div> <div class="popup-mass"> '+ v.amount +'</div> </div> </div> <hr> <div class="row"> <div class="popup-description"> <strong>Описание</strong> <br> <div class="description-text">' + v.description + '</div> </div> '+v.consist+'</div> </div> </div> </div>'
//
//			    n+=1;
//        }
//        });

//		if (n == 0) {
//		search_results = '<div id="nosearch"> <h2>К сожалению по Вашему запросу ничего не найдено</h2> <h3>Попробуйте ввести другое или более короткое слово</h3> </div>'
//		}

}



$("#search").keyup(function(event){
    if(event.keyCode == 13){
    	if (document.getElementById('search').value != ''){
    		var word = document.getElementById('search').value;
                console.log(word);
        	search(word);
    	}
    }
});


$(document).on('click', ".glyphicon-search", function(){
    	if (document.getElementById('search').value != ''){
    		word = document.getElementById('search').value;
        	search(word);
    	}
});

