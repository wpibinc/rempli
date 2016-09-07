//var order = window.location.search.split('=');
//order = order[1];
//$.ajax({
//    type: 'POST',
//    url: '/success',
//    contentType: 'application/json',
//    dataType: 'json',
//    headers: {
//        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//    },
//    data: JSON.stringify(
//        {
//            name: localStorage.FirstName,
//            phone: localStorage.phone,
//            cost: sessionStorage.cost,
//            order:order,
//        }
//    ),
//    success: function (data) {
//        sessionStorage.clear();
//        localStorage.clear();
//    },
//    error: function (xhr, textStatus, thrownError) {
//        alert(thrownError);
//    }
//});
