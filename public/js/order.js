Parse.initialize("mmcrSN69TR6IR6e6uo2pzlhpR2amZNkHl4b0GVh1", "ALR6Z7SnB2mWr2SBkZ9cnQX8dgqJph0F47b1aPjl");
okplace = 1;

	var currentUser = Parse.User.current();
	if (currentUser) { //person is logged
	    var User = Parse.Object.extend("User");
		var query = new Parse.Query(User);
		query.get(currentUser.id, {
		  success: function(user) {
		  	// console.log(user);

		  	if (user.get("FirstName") != null ) {
		    	document.getElementById('name').value = user.get("FirstName");
		    }
    	    if (user.get("phone") != null ) {
		    	document.getElementById('phone').value = user.get("phone");
		    }
		    if (user.get("AdressField") != null ) {
		    	document.getElementById('pac-input').value = user.get("AdressField");
		    }
		    if (user.get("house") != null ) {
		    	document.getElementById('house').value = user.get("house");
		    }
		    if (user.get("flat") != null ) {
		    	document.getElementById('flat').value = user.get("flat");
		    }

		    $(document).on('click', "#toPay", function(){
				// alert(currentUser);
				user.set("FirstName", document.getElementById('name').value);
				user.set("phone", document.getElementById('phone').value);
                                if($("#optionsRadios1").prop('checked')){
                                    user.set("AdressField", document.getElementById('pac-input').value);
                                    user.set("house", document.getElementById('house').value);
                                    user.set("flat", document.getElementById('flat').value);
                                }else{
                                    var checkedAddr = $("#selectAddress option:checked").val();
                                    user.set('checkedAdress', checkedAddr);
                                }
				
				
				user.set("howpay", $("input[name=howpay]:checked").val());
				user.set("freeDelivery", 0);				

				user.save();



				sessionStorage.thephone = document.getElementById('phone').value;

				sessionStorage.userInfo = 'Имя: ' + document.getElementById('name').value + '<br>' + 'Телефон: ' + document.getElementById('phone').value + '<br>' +'Улица: ' +  document.getElementById('pac-input').value + '<br>' +'Дом: ' +  document.getElementById('house').value + '<br>' + 'Квартира: ' + document.getElementById('flat').value + '<br>' + 'Время: ' + document.getElementById('time').value + '<br>' + 'Комментарий: ' + document.getElementById('comment').value + '<br>' + 'Стоимость: ' + (Number(sessionStorage.cost) + Number(sessionStorage.dCost)) + '<br>';


				});
			  },
			  error: function(object, error) {
			  	// alert(error);
			    // The object was not retrieved successfully.
			    // error is a Parse.Error with an error code and message.
			  }
	    
			});


	$('.orderlogin').html('Выйти');
	$(".orderlogin").attr("href", "#");
	$(document).on('click', ".orderlogin", function(){
		// $('.orderlogin').html('Вход / Регистрация');
		Parse.User.logOut();
		location.reload();
	});
				    

	    
	} else { //person not logged

		if (localStorage.FirstName != undefined) {
		    	document.getElementById('name').value = localStorage.FirstName;
		}
		if (localStorage.phone != undefined) {
		    	document.getElementById('phone').value = localStorage.phone;
		}
		if (localStorage.AdressField != undefined) {
				okplace = 1;
		    	document.getElementById('pac-input').value = localStorage.AdressField;
		}
		if (localStorage.house != undefined) {
		    	document.getElementById('house').value = localStorage.house;
		}
		if (localStorage.flat != undefined) {
		    	document.getElementById('flat').value = localStorage.flat;
		}
		var id = [];
                console.log(sessionStorage);
		for (var i = 0; i < sessionStorage.length; i++) {
                    
			//console.log(sessionStorage.getItem(sessionStorage.key(i)));
			//if (parseFloat(Number(sessionStorage.key(i))))
			key = sessionStorage.key(i);
			//key= key.split('_')[1];
                        
			if (parseFloat(Number(key)))
				id.push({
					//objectId   : sessionStorage.key(i),
					objectId   : key,
					count: sessionStorage.getItem(sessionStorage.key(i))
				});
		};
		data = id;
                console.log(data);

				    $(document).on('click', "#toPay", function(){

				// alert(currentUser);
				localStorage.FirstName = document.getElementById('name').value;
				localStorage.phone = document.getElementById('phone').value;
				localStorage.AdressField = document.getElementById('pac-input').value;
				localStorage.house = document.getElementById('house').value;
				localStorage.flat = document.getElementById('flat').value;
				localStorage.korp = document.getElementById('korp').value;
				localStorage.user = document.getElementById('user').value;
				localStorage.comment = document.getElementById('comment').value;


				sessionStorage.thephone = document.getElementById('phone').value;



				//sessionStorage.userInfo = 'Имя: ' + document.getElementById('name').value + '<br>' + 'Телефон: ' + document.getElementById('phone').value + '<br>' +'Улица: ' +  document.getElementById('pac-input').value + '<br>' +'Дом: ' +  document.getElementById('house').value + '<br>' + 'Квартира: ' + document.getElementById('flat').value + '<br>' + 'Время: ' + document.getElementById('time').value + '<br>' + 'Комментарий: ' + document.getElementById('comment').value + '<br>' + 'Стоимость: ' + (Number(sessionStorage.cost) + Number(sessionStorage.dCost)) + '<br>';
			});
		// $.ajax({
		// 	type: 'POST',
		// 	url: '/order',
		// 	contentType: 'application/json',
		// 	dataType: 'json',
		// 	headers: {
		// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		// 	},
		// 	data: JSON.stringify(
		// 		{
		// 			items: data,
		// 			name: localStorage.FirstName,
		// 			phone: localStorage.phone,
		// 			address: localStorage.AdressField,
		// 			house: localStorage.house,
		// 			flat: localStorage.flat,
		// 			mass: 0,
		// 			cost: sessionStorage.cost
		// 		}
		// 		),
		// 	success: function (data) {
		// 	},
		// 	error: function (xhr, textStatus, thrownError) {
		// 		alert(thrownError);
		// 	}
		// });


		// alert("You are not logged in");
		// window.location = "index.html";

	}
// $('#name').change(function() {
$('#name').val().length;

// function allow() {
window.setInterval(function(){
	if ($('#name').val().length * $('#pac-input').val().length * $('#house').val().length * $('#flat').val().length * $('#phone').val().length * okplace > 0) {
		$( "#toPay" ).css( "opacity", "1" );
	} else {
		$( "#toPay" ).css( "opacity", "0.5" );
	}
}, 100);

$('input').change(function() {
	if ($('#name').val().length * $('#pac-input').val().length * $('#house').val().length * $('#flat').val().length * $('#phone').val().length * okplace > 0) {
		$( "#toPay" ).css( "opacity", "1" );
	} else {
		$( "#toPay" ).css( "opacity", "0.5" );
	}
});

$( "#toPay" ).click(function( event ) {
        var checked = $("#optionsRadios1").prop('checked');
	if (!checked||$('#name').val().length * $('#pac-input').val().length * $('#house').val().length * $('#flat').val().length * $('#phone').val().length * okplace > 0) {

		$( "#toPay" ).css( "opacity", "1" );
	} else {
		$( "#toPay" ).css( "opacity", "0.5" );
		event.preventDefault();
		event.stopPropagation();
		$( "#fillall" ).css( "display", "block" );
		return false;
	}
});


// }
// allow();

$('#name').change(function() {
	});

// window.setInterval(function(){
//   allow();
// }, 1000);

$(document).on('click', ".checkout_button", function(){
	var time = updateClock();	
}); // end checkout click




$(document).ready(function() {
    $(document).on('click', "#toPay", function(){
                var checked = $("#optionsRadios1").prop('checked');
                var address = '';
                var house = '';
                var korp = '';
                var flat = '';
                var adressChecked = '';
                if(checked){
                    address = localStorage.AdressField;
                    house = localStorage.house;
                    korp = localStorage.korp;
                    flat = localStorage.flat;
                }else{
                    adressChecked = $("#selectAddress").val();
                }
		$.ajax({
			type: 'POST',
			url: '/order',
			contentType: 'application/json',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: JSON.stringify(
				{
					items: data,
					name: localStorage.FirstName,
					phone: localStorage.phone,
					address: address,
					house: house,
					korp: korp,
					comment: localStorage.comment,
					flat: flat,
					user_id: localStorage.user,
					mass: sessionStorage.mass,
					cost: sessionStorage.cost,
                                        addressChecked: adressChecked
				}
			),
			success: function (data) {
				window.location.href = "/payment";
			},
			error: function (xhr, textStatus, thrownError) {
				alert(thrownError);
			}
		});

        $("#submit_order_data").click();
    });
});







$(document).on('click', "#backToMain", function(){
	$('.page-container').html(mainBack);
});

$(document).on('click', "#backToOrder", function(){
	$('.page-container').html(orderBack);
});

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){var b,c=navigator.userAgent,d=/iphone/i.test(c),e=/chrome/i.test(c),f=/android/i.test(c);a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},autoclear:!0,dataName:"rawMaskFn",placeholder:"_"},a.fn.extend({caret:function(a,b){var c;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof a?(b="number"==typeof b?b:a,this.each(function(){this.setSelectionRange?this.setSelectionRange(a,b):this.createTextRange&&(c=this.createTextRange(),c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select())})):(this[0].setSelectionRange?(a=this[0].selectionStart,b=this[0].selectionEnd):document.selection&&document.selection.createRange&&(c=document.selection.createRange(),a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length),{begin:a,end:b})},unmask:function(){return this.trigger("unmask")},mask:function(c,g){var h,i,j,k,l,m,n,o;if(!c&&this.length>0){h=a(this[0]);var p=h.data(a.mask.dataName);return p?p():void 0}return g=a.extend({autoclear:a.mask.autoclear,placeholder:a.mask.placeholder,completed:null},g),i=a.mask.definitions,j=[],k=n=c.length,l=null,a.each(c.split(""),function(a,b){"?"==b?(n--,k=a):i[b]?(j.push(new RegExp(i[b])),null===l&&(l=j.length-1),k>a&&(m=j.length-1)):j.push(null)}),this.trigger("unmask").each(function(){function h(){if(g.completed){for(var a=l;m>=a;a++)if(j[a]&&C[a]===p(a))return;g.completed.call(B)}}function p(a){return g.placeholder.charAt(a<g.placeholder.length?a:0)}function q(a){for(;++a<n&&!j[a];);return a}function r(a){for(;--a>=0&&!j[a];);return a}function s(a,b){var c,d;if(!(0>a)){for(c=a,d=q(b);n>c;c++)if(j[c]){if(!(n>d&&j[c].test(C[d])))break;C[c]=C[d],C[d]=p(d),d=q(d)}z(),B.caret(Math.max(l,a))}}function t(a){var b,c,d,e;for(b=a,c=p(a);n>b;b++)if(j[b]){if(d=q(b),e=C[b],C[b]=c,!(n>d&&j[d].test(e)))break;c=e}}function u(){var a=B.val(),b=B.caret();if(a.length<o.length){for(A(!0);b.begin>0&&!j[b.begin-1];)b.begin--;if(0===b.begin)for(;b.begin<l&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}else{for(A(!0);b.begin<n&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}h()}function v(){A(),B.val()!=E&&B.change()}function w(a){if(!B.prop("readonly")){var b,c,e,f=a.which||a.keyCode;o=B.val(),8===f||46===f||d&&127===f?(b=B.caret(),c=b.begin,e=b.end,e-c===0&&(c=46!==f?r(c):e=q(c-1),e=46===f?q(e):e),y(c,e),s(c,e-1),a.preventDefault()):13===f?v.call(this,a):27===f&&(B.val(E),B.caret(0,A()),a.preventDefault())}}function x(b){if(!B.prop("readonly")){var c,d,e,g=b.which||b.keyCode,i=B.caret();if(!(b.ctrlKey||b.altKey||b.metaKey||32>g)&&g&&13!==g){if(i.end-i.begin!==0&&(y(i.begin,i.end),s(i.begin,i.end-1)),c=q(i.begin-1),n>c&&(d=String.fromCharCode(g),j[c].test(d))){if(t(c),C[c]=d,z(),e=q(c),f){var k=function(){a.proxy(a.fn.caret,B,e)()};setTimeout(k,0)}else B.caret(e);i.begin<=m&&h()}b.preventDefault()}}}function y(a,b){var c;for(c=a;b>c&&n>c;c++)j[c]&&(C[c]=p(c))}function z(){B.val(C.join(""))}function A(a){var b,c,d,e=B.val(),f=-1;for(b=0,d=0;n>b;b++)if(j[b]){for(C[b]=p(b);d++<e.length;)if(c=e.charAt(d-1),j[b].test(c)){C[b]=c,f=b;break}if(d>e.length){y(b+1,n);break}}else C[b]===e.charAt(d)&&d++,k>b&&(f=b);return a?z():k>f+1?g.autoclear||C.join("")===D?(B.val()&&B.val(""),y(0,n)):z():(z(),B.val(B.val().substring(0,f+1))),k?b:l}var B=a(this),C=a.map(c.split(""),function(a,b){return"?"!=a?i[a]?p(b):a:void 0}),D=C.join(""),E=B.val();B.data(a.mask.dataName,function(){return a.map(C,function(a,b){return j[b]&&a!=p(b)?a:null}).join("")}),B.one("unmask",function(){B.off(".mask").removeData(a.mask.dataName)}).on("focus.mask",function(){if(!B.prop("readonly")){clearTimeout(b);var a;E=B.val(),a=A(),b=setTimeout(function(){z(),a==c.replace("?","").length?B.caret(0,a):B.caret(a)},10)}}).on("blur.mask",v).on("keydown.mask",w).on("keypress.mask",x).on("input.mask paste.mask",function(){B.prop("readonly")||setTimeout(function(){var a=A(!0);B.caret(a),h()},0)}),e&&f&&B.off("input.mask").on("input.mask",u),A()})}})});

$("#phone").mask("+7 (999) 999-99-99");



var d = new Date();
var h = d.getHours();
var m = d.getMinutes();

//10-23

if (h > 8 && h < 22) { // now
	$(".chooseTime").append("<option>Сегодня до "+(h+1)+":"+m+" + 1 час</option>");
	for (h+1; h < 22; h++) {
		$(".chooseTime").append("<option>Сегодня "+(h+1)+":00"+" - "+(h+2)+":00"+" + 1 час</option>");
	}
} else { //later
	if (h >= 22) {
		for (i = 9; i < 22; i++) {
			$(".chooseTime").append("<option>Завтра "+(i+1)+":00"+" - "+(i+2)+":00"+"</option>");
		}
	} else {
		for (i = 9; i < 22; i++) {
			$(".chooseTime").append("<option>Сегодня "+(i+1)+":00"+" - "+(i+2)+":00"+"</option>");
		}
	}
}




$('#creditcard').click(function() {
    $( "#toPay" ).html( 'Оплатить <span aria-hidden="true">&rarr;</span>' );
});

$('#cash').click(function() {
    $( "#toPay" ).html( 'Завершить <span aria-hidden="true">&rarr;</span>' );
});


$('#nocomment').click(function() {
    $( "#comment" ).css( 'display', 'none' );
});

$('#yescomment').click(function() {
    $( "#comment" ).css( 'display', 'block' );
});


setTimeout(codeAddress, 1000);

