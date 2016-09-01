Parse.initialize("mmcrSN69TR6IR6e6uo2pzlhpR2amZNkHl4b0GVh1", "ALR6Z7SnB2mWr2SBkZ9cnQX8dgqJph0F47b1aPjl");


$('#inputReg').click(function() {
    $( "#loginButton" ).html( "Регистрация" );
});

$('#inputLog').click(function() {
    $( "#loginButton" ).html( "Вход" );
});


$(document).on('click', "#loginButton", function(){

	if ($('#inputReg').is(':checked')) { //новый пользователь
		var user = new Parse.User();
		user.set("username", $("#loginEmail").val());
		user.set("email", $("#loginEmail").val());
		user.set("password", $("#loginPassword").val());
		user.set("freeDelivery", 1);
		user.signUp(null, {
		  success: function(user) {
		  	// setTimeout(function() {  
		  		window.location = "order.html";
		  	// }, 5000);
		  },
		  error: function(user, error) {
		    // alert("Error: " + error.code + " " + error.message);
		  }
		});
	}

	if ($('#inputLog').is(':checked')) { //старый пользователь
		  Parse.User.logIn($("#loginEmail").val(), $("#loginPassword").val(), {
		  success: function(user) {
		  	sessionStorage.total = Number(sessionStorage.total) + 100;
		  	sessionStorage.dCost = Number(sessionStorage.dCost) + 100;
		    window.location = "order.html";
		  },
		  error: function(user, error) {
		    console.log(error);
		    // alert('err' + error);
		    
		  }
		});
	}

});


