//for (i = 0; i < json.length; i++) {
//
//    consist = '';
//    ctitles = json[i].ctitles;
//    cvalues = json[i].cvalues;
//
//    for (x = 0; x < ctitles.length; x++) {
//        consist+=('<div class="product_card_prop_item mb5"> <div class="product_card_prop_item_title">'+ctitles[x]+'</div> <div class="product_card_prop_item_value">'+cvalues[x]+'</div> <div class="clear"></div> </div>');
//    }
//
//    window[json[i].category]  += '<div class="modal fade bs-example-modal-lg" id="idt' + json[i].objectId + '" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"> <div class="modal-dialog modal-lg"> <div class="modal-content row"> <div class="row"> <div class="popup-image";> <span class="popup-helper"></span> <img class="popimg" src="' + json[i].img_sm + '"> </div> <div class="popup-name"> <p class="popup-title" id="myModalLabel">' + json[i].product_name + '</p> <div class="popup-price"> ' + json[i].price + '<span class="kop">00</span> <span class="popup-rub">'+num2word(json[i].price,words)+'</span> </div> <div class="popup-mass"> '+ json[i].amount +'</div> </div> </div> <hr> <div class="row"> <div class="popup-description"> <strong>Описание</strong> <br> <div class="description-text">' + json[i].description + '</div> </div> <div class="product_card_props f32">'+ consist +' </div> </div> </div> </div> </div>';
//
//}
