jQuery(document).ready(function($){
    $(".login").on('click', function(){
        $(".my-account").show();
    });
    
    $(document).on('click', function(event) {
        if ($(event.target).closest(".my-account").length||$(event.target).closest(".login").length){
            return;
        }
        $(".my-account").hide();
        event.stopPropagation();
    });
});
// var fruits = '';
// var juices = '';
// var water = '';
// var baby = '';
// var curd = '';
// var dairy = '';
// var canned = '';
// var salt = '';
// var sauces = '';
// var breakfasts = '';
// var pasta = '';
// var nuts = '';
// var oil = '';
// var frozen = '';
// var cooked = '';
// var meatdeli = '';
// var meat = '';
// var fish = '';
// var cheese = '';
// var bread = '';
// var tea = '';
// var sweet = '';
// var cookies = '';
// var choco = '';
// var test = '';

var searchvar = '';


function num2word(num,words) {
  num=num%100;
  if (num>19) { num=num%10; }
  switch (num) {
    case 1:  { return(words[0]); }
    case 2: case 3: case 4:  { return(words[1]); }
    default: { return(words[2]); }
  }
}
words=Array("рубль", "рубля", "рублей");


//for (i = 0; i < json.length; i++) {
//
//    if (Number(sessionStorage[json[i].objectId]) > 0) {
//        console.log(1);
//        window[json[i].category] += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" id="' + json[i].objectId + '"><div class="count item_count visible">' + sessionStorage[json[i].objectId] + '</div><a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '"> <img src="' + json[i].img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '">' + json[i].product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + json[i].price + ' руб</div><div class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">' + json[i].amount + '</div><br class="clearfix"></div><button href="javascript:void(0)" class="increase_count buy">Добавить</button></div>';
//    } else {
//        
//        if (typeof window[json[i].category] === 'undefined') {
//            console.log(2);
//            console.log(json[i].category);
//            window[json[i].category] = '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" id="' + json[i].objectId + '"><div class="count item_count hidden">' + sessionStorage[json[i].objectId] + '</div><a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '"> <img src="' + json[i].img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '">' + json[i].product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + json[i].price + ' руб</div><div id="weight_product" class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">' + json[i].amount + '</div><br class="clearfix"></div><button href="javascript:void(0)" class="increase_count buy">Добавить</button></div>';
//        }
//        else {
//            console.log(3);
//            console.log(json[i].category);
//            window[json[i].category] += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" id="' + json[i].objectId + '"><div class="count item_count hidden">' + sessionStorage[json[i].objectId] + '</div><a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '"> <img src="' + json[i].img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '">' + json[i].product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + json[i].price + ' руб</div><div id="weight_product" class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">' + json[i].amount + '</div><br class="clearfix"></div><button href="javascript:void(0)" class="increase_count buy">Добавить</button></div>';
//
//        }
//    }
//}





var current;

var cats = $('.cats');
cats.each(function(i){

    $(this).click(function () {
        $(".center").show();
        $(".bg-shadow").show();
        
        var value = $(this).attr('data-id');
        $(".inmoscow").empty();
        $(".header_cat").prepend($(this).find("img").attr('alt'));
        
        $(".av-categ-menu").empty();
        $.ajax({
           url: '/category',
           data: {
               id: value,
           },
           dataType: 'json',
           success: function(res){
                var json = res.products.sort(function(a, b) {
                    return parseFloat((new Date(b.updatedAt)).getTime()) - parseFloat((new Date(a.updatedAt)).getTime());
                });
                var output = '';
                for (i = 0; i < json.length; i++) {
                    if (Number(sessionStorage[json[i].objectId]) > 0) {
                        output += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" data-category="'+json[i].category+'" id="' + json[i].objectId + '"><div class="count item_count visible">' + sessionStorage[json[i].objectId] + '</div><a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '"> <img src="' + json[i].img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '">' + json[i].product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + json[i].price + ' руб</div><div class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">' + json[i].amount + '</div><br class="clearfix"></div><button href="javascript:void(0)" data-weight="'+json[i].weight+'" class="increase_count buy">Добавить</button></div>';
                    } else {
                        output += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" data-category="'+json[i].category+'" id="' + json[i].objectId + '"><div class="count item_count hidden">' + sessionStorage[json[i].objectId] + '</div><a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '"> <img src="' + json[i].img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '">' + json[i].product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + json[i].price + ' руб</div><div id="weight_product" class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">' + json[i].amount + '</div><br class="clearfix"></div><button href="javascript:void(0)" data-weight="'+json[i].weight+'" class="increase_count buy">Добавить</button></div>';
                    }
                }
                for (i = 0; i < json.length; i++) {
                    consist = '';
                    ctitles = json[i].ctitles;
                    cvalues = json[i].cvalues;

                    for (x = 0; x < ctitles.length; x++) {
                        consist+=('<div class="product_card_prop_item mb5"> <div class="product_card_prop_item_title">'+ctitles[x]+'</div> <div class="product_card_prop_item_value">'+cvalues[x]+'</div> <div class="clear"></div> </div>');
                    }
                    var vis = "hidden";
                    if(Number(sessionStorage[json[i].objectId]) > 0){
                        vis = "visible";
                    }
                    output  += '<div class="modal fade bs-example-modal-lg" id="idt' + json[i].objectId + '" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"> <div class="modal-dialog modal-lg"> <div class="modal-content row"> <div class="row"><i class="fa fa-times close-popups close" aria-hidden="true"  data-dismiss="modal" aria-label="Close"></i> <div class="popup-image";><div class="count item_count '+vis+'">' + sessionStorage[json[i].objectId] + '</div> <span class="popup-helper"></span> <img class="popimg" src="' + json[i].img_sm + '"> </div> <div class="popup-name"> <p class="popup-title" id="myModalLabel">' + json[i].product_name + '</p> <div class="popup-price"> ' + json[i].price + ' <span class="popup-rub">'+num2word(json[i].price,words)+'</span> </div> <div class="popup-mass"> '+ json[i].amount +'</div><button href="javascript:void(0)" data-id="'+json[i].objectId+'" data-category="'+json[i].category+'" data-weight="'+json[i].weight+'" class="add-to-cart buy">Добавить</button> </div> </div> <hr> <div class="row"> <div class="popup-description"> <strong>Описание</strong> <br> <div class="description-text">' + json[i].description + '</div> </div> <div class="product_card_props f32">'+ consist +' </div> </div> </div> </div> </div>';

                }
                if(res.avCategories){
                    var categoriesOutput = "<div class='av-categories'><ul>";
                    for(var i=0; i<res.avCategories.length; i++){
                        categoriesOutput += "<li><a href='#' data-id='"+res.avCategories[i].id+"'>"+res.avCategories[i].name+"</a></li>";
                    }
                    categoriesOutput += "</ul></div>";
                }
                $(".header_cat").empty();
                $(".products-wrap").empty();
                $(".products-wrap").prepend(output);
                $(".av-categ-menu").prepend(categoriesOutput);
                $('.av-categories a').on('click', function(){
                    $(".center").show();
                    $(".bg-shadow").show();
                    
                    
                    var id = $(this).attr("data-id");
                    $.ajax({
                        url: '/getavcategory',
                        data: {
                            id: id
                        },
                        success: function(res){
                            var json = res.sort(function(a, b) {
                                return parseFloat((new Date(b.updatedAt)).getTime()) - parseFloat((new Date(a.updatedAt)).getTime());
                            });
                            var output = '';
                            for (i = 0; i < json.length; i++) {
                                if (Number(sessionStorage[json[i].objectId]) > 0) {
                                    output += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" data-category="'+json[i].category+'" id="' + json[i].objectId + '"><a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '"> <img src="' + json[i].img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '">' + json[i].product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + json[i].price + ' руб</div><div class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">' + json[i].amount + '</div><br class="clearfix"></div><button href="javascript:void(0)" data-weight="'+json[i].weight+'" class="increase_count buy">Добавить</button></div>';
                                } else {
                                    output += '<div class="col-lg-1 col-md-2 col-sm-3 col-xs-6 product-wrap product" data-category="'+json[i].category+'" id="' + json[i].objectId + '"><div class="count item_count hidden">' + sessionStorage[json[i].objectId] + '</div><a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '"> <img src="' + json[i].img_sm + '" alt=""></a><div class="desc"><div class="product-title"> <a href="#" data-toggle="modal" data-target="#idt' + json[i].objectId + '">' + json[i].product_name + '</a></div><div class="col-lg-6 col-md-8 col-xs-12 col-sm-8 price">' + json[i].price + ' руб</div><div id="weight_product" class="col-lg-6 col-md-4 col-xs-12 col-sm-4 quantity">' + json[i].amount + '</div><br class="clearfix"></div><button href="javascript:void(0)" data-weight="'+json[i].weight+'" class="increase_count buy">Добавить</button></div>';
                                }
                            }
                            for (i = 0; i < json.length; i++) {
                                consist = '';
                                ctitles = json[i].ctitles;
                                cvalues = json[i].cvalues;

                                for (x = 0; x < ctitles.length; x++) {
                                    consist+=('<div class="product_card_prop_item mb5"> <div class="product_card_prop_item_title">'+ctitles[x]+'</div> <div class="product_card_prop_item_value">'+cvalues[x]+'</div> <div class="clear"></div> </div>');
                                }

                                output  += '<div class="modal fade bs-example-modal-lg" id="idt' + json[i].objectId + '" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"> <div class="modal-dialog modal-lg"> <div class="modal-content row"> <div class="row"> <div class="popup-image"> <span class="popup-helper"></span> <img class="popimg" src="' + json[i].img_sm + '"> </div> <div class="popup-name"> <p class="popup-title" id="myModalLabel">' + json[i].product_name + '</p> <div class="popup-price"> ' + json[i].price + ' <span class="popup-rub">'+num2word(json[i].price,words)+'</span> </div> <div class="popup-mass"> '+ json[i].amount +'</div> <button href="javascript:void(0)" data-id="'+json[i].objectId+'" data-category="'+json[i].category+'" data-weight="'+json[i].weight+'" data-weight="'+json[i].weight+'" class="add-to-cart buy">Добавить</button></div> </div> <hr> <div class="row"> <div class="popup-description"> <strong>Описание</strong> <br> <div class="description-text">' + json[i].description + '</div> </div> <div class="product_card_props f32">'+ consist +' </div> </div> </div> </div> </div>';

                            }
                            $(".products-wrap").empty();
                            $(".products-wrap").prepend(output);
                            $(".center").hide();
                            $(".bg-shadow").hide();
                        }
                    });
                });
                $(".center").hide();
                $(".bg-shadow").hide();
           }
        });
//        
//
//        $(".inmoscow").empty();
//        $(".header_cat").css('top', '20px');
//
//
//        $(".products-wrap").empty();
//        $(".products-wrap").prepend(window[value]);
//        current = value;
    });

});

//$.each([ 'fruits', 'juices', 'water', 'baby',  'curd', 'dairy', 'canned', 'salt', 'sauces', 'breakfasts', 'pasta', 'nuts', 'oil' , 'frozen' , 'cooked' , 'meatdeli' , 'meat' , 'fish' , 'cheese' , 'bread' , 'tea' , 'sweet' , 'cookies', 'choco'  ], function( index, value ) {
// $.each(rubric, function( index, value ) {
//     $('#' + value).click(function () {
//         $(".header_cat").empty();
//
//
//         if (value == 'fruits') {
//             $(".header_cat").prepend('Фрукты и овощи');
//         } else if (value == 'juices') {
//             $(".header_cat").prepend('Соки');
//         } else if (value == 'water') {
//             $(".header_cat").prepend('Вода и напитки');
//         } else if (value == 'baby') {
//             $(".header_cat").prepend('Детское питание');
//         } else if (value == 'curd') {
//             $(".header_cat").prepend('Творог и йогурты');
//         } else if (value == 'dairy') {
//             $(".header_cat").prepend('Молочные продукты');
//         } else if (value == 'canned') {
//             $(".header_cat").prepend('Консервы');
//         } else if (value == 'salt') {
//             $(".header_cat").prepend('Соль и специи');
//         } else if (value == 'sauces') {
//             $(".header_cat").prepend('Соусы');
//         } else if (value == 'breakfasts') {
//             $(".header_cat").prepend('Завтраки и чипсы');
//         } else if (value == 'pasta') {
//             $(".header_cat").prepend('Макароны и крупы');
//         } else if (value == 'nuts') {
//             $(".header_cat").prepend('Орехи и масла');
//         } else if (value == 'frozen') {
//             $(".header_cat").prepend('Замороженные продукты');
//         } else if (value == 'cooked') {
//             $(".header_cat").prepend('Кулинарея');
//         } else if (value == 'meatdeli') {
//             $(".header_cat").prepend('Мясные деликатесы');
//         } else if (value == 'meat') {
//             $(".header_cat").prepend('Мясо');
//         } else if (value == 'fish') {
//             $(".header_cat").prepend('Рыба');
//         } else if (value == 'cheese') {
//             $(".header_cat").prepend('Сыры');
//         } else if (value == 'bread') {
//             $(".header_cat").prepend('Хлеб');
//         } else if (value == 'tea') {
//             $(".header_cat").prepend('Чай и кофе');
//         } else if (value == 'sweet') {
//             $(".header_cat").prepend('Сладости');
//         } else if (value == 'cookies') {
//             $(".header_cat").prepend('Печенье');
//         } else if (value == 'choco') {
//             $(".header_cat").prepend('Шоколад');
//         }
//
//
//         $(".inmoscow").empty();
//         $(".header_cat").css('top', '20px');
//
//
//
//
//         window[current] = '';
//         window[current] = $(".products-wrap").html();
//         $(".products-wrap").empty();
//         $(".products-wrap").prepend(window[value]);
//         current = value;
//     });
// });

$('#logo').click(function () {
    $(".header_cat").css('top', '14px');
    $(".header_cat").empty();
    $(".products-wrap").empty();
    $(".products-wrap").prepend('<div class="col-md-8 col-md-offset-2"><h1>Почему стоит работать с нами?</h1><p>Мы покупаем их в магазинах «Азбука Вкуса» рядом с Вами. Никаких складов, сомнительных поставщиков и испорченных товаров – только проверенное качество! После получения заказа Ваши продукты собираются в «Азбуке Вкуса» и наш курьер доставляет их до Вас за кратчайшее время.</p><br><h1>Где работаем</h1><p>На данный момент мы работаем только в центре Москвы – внутри Садового кольца. Но не волнуйтесь – прямо сейчас наши специалисты трудятся над расширением территории доставки, чтобы Вы могли заказывать продукты на дом в любом месте.</p></div>');
    current = '';
});

$( ".cats" ).click(function() {
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
});

// var resultInt = 0;
// $('body').on('click', '.increase_count.buy', function(){
//     var reg = /\D+/g;
//     var idProduct = $(this).parents('.col-lg-1.col-md-2.col-sm-3.col-xs-6.product-wrap.product').find('#weight_product').html();
//     var resultReplace = idProduct.replace(reg, "");
//     resultInt += parseInt(resultReplace, 10);
//     $('.cart-total').find('th').html(resultInt + ' грамм');
// });
