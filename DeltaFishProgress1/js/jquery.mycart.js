(function(t){"use strict";var e,a,r,o,n,i=(e={},a=null,r={currencySymbol:"$",classCartIcon:"my-cart-icon",classCartBadge:"my-cart-badge",classProductQuantity:"my-product-quantity",classProductRemove:"my-product-remove",classCheckoutCart:"my-cart-checkout",affixCartIcon:!0,showCheckoutModal:!0,numberOfDecimals:2,cartItems:null,clickOnAddToCart:function(t){},afterAddOnCart:function(t,e,a){},clickOnCartIcon:function(t,e,a,r){},checkoutCart:function(t,e,a){return!1},getDiscountPrice:function(t,e,a){return null}},o=function(e){a=t.extend({},r),"object"==typeof e&&t.extend(a,e)},n=function(){return a},e.loadOptions=o,e.getOptions=n,e),c=function(){var t={},e=function(t){if(isNaN(t))throw new Error("Parameter is not a Number");t*=1;var e=i.getOptions();return t.toFixed(e.numberOfDecimals)};return t.getRoundedNumber=e,t}(),d=function(){var e={};const a="__mycart";localStorage[a]=localStorage[a]?localStorage[a]:"";var r=function(e){var a=-1,r=i();return t.each(r,function(t,r){r.id!=e||(a=t)}),a},o=function(t){localStorage[a]=JSON.stringify(t)},n=function(t,e,a,r,n,c){var d=i();d.push({id:t,name:e,summary:a,price:r,quantity:n,image:c}),o(d)},i=function(){try{var t=JSON.parse(localStorage[a]);return t}catch(t){return[]}},d=function(t,e,a){var n=r(t);if(n<0)return!1;var c=i();return c[n].quantity=a?1*c[n].quantity+(void 0===e?1:1*e):void 0===e?1*c[n].quantity+1:1*e,o(c),!0},s=function(e,a,r,o,i,c){return void 0===e?(console.error("id required"),!1):void 0===a?(console.error("name required"),!1):void 0===c?(console.error("image required"),!1):t.isNumeric(o)?t.isNumeric(i)?(r=void 0===r?"":r,void(d(e,i,!0)||n(e,a,r,o,i,c))):(console.error("quantity is not a number"),!1):(console.error("price is not a number"),!1)},u=function(){o([])},l=function(e){var a=i();a=t.grep(a,function(t,a){return t.id!=e}),o(a)},m=function(){var e=0,a=i();return t.each(a,function(t,a){e+=1*a.quantity}),e},y=function(){var e=i(),a=0;return t.each(e,function(t,e){a+=e.quantity*e.price,a=1*c.getRoundedNumber(a)}),a};return e.getAllProducts=i,e.updatePoduct=d,e.setProduct=s,e.clearProduct=u,e.removeProduct=l,e.getTotalQuantity=m,e.getTotalPrice=y,e}(),s=function(e){var a=i.getOptions(),r=t("."+a.classCartIcon),o=t("."+a.classCartBadge),n=a.classProductQuantity,s=a.classProductRemove,u=a.classCheckoutCart,l="my-cart-modal",m="my-cart-table",y="my-cart-grand-total",g="my-cart-empty-message",h="my-cart-discount-price",f="my-product-total",p="my-cart-icon-affix";a.cartItems&&a.cartItems.constructor===Array&&(d.clearProduct(),t.each(a.cartItems,function(){d.setProduct(this.id,this.name,this.summary,this.price,this.quantity,this.image)})),o.text(d.getTotalQuantity()),t("#"+l).length||t("body").append('<div class="modal fade" id="'+l+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</h4></div><div class="modal-body"><table class="table table-hover table-responsive" id="'+m+'"></table></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary '+u+'">Checkout</button></div></div></div></div>');var v=function(){var e=t("#"+m);e.empty();var r=d.getAllProducts();t.each(r,function(){var t=this.quantity*this.price;e.append('<tr title="'+this.summary+'" data-id="'+this.id+'" data-price="'+this.price+'"><td class="text-center" style="width: 30px;"><img width="30px" height="30px" src="'+this.image+'"/></td><td>'+this.name+'</td><td title="Unit Price" class="text-right">'+a.currencySymbol+c.getRoundedNumber(this.price)+'</td><td title="Quantity"><input type="number" min="1" style="width: 70px;" class="'+n+'" value="'+this.quantity+'"/></td><td title="Total" class="text-right '+f+'">'+a.currencySymbol+c.getRoundedNumber(t)+'</td><td title="Remove from Cart" class="text-center" style="width: 30px;"><a href="javascript:void(0);" class="btn btn-xs btn-danger '+s+'">X</a></td></tr>')}),e.append(r.length?'<tr><td></td><td><strong>Total</strong></td><td></td><td></td><td class="text-right"><strong id="'+y+'"></strong></td><td></td></tr>':'<div class="alert alert-danger" role="alert" id="'+g+'">Your cart is empty</div>');var o=a.getDiscountPrice(r,d.getTotalPrice(),d.getTotalQuantity());r.length&&null!==o&&e.append('<tr style="color: red"><td></td><td><strong>Total (including discount)</strong></td><td></td><td></td><td class="text-right"><strong id="'+h+'"></strong></td><td></td></tr>'),C(),x()},b=function(){v(),t("#"+l).modal("show")},P=function(){t.each(t("."+n),function(){var e=t(this).closest("tr").data("id");d.updatePoduct(e,t(this).val())})},C=function(){t("#"+y).text(a.currencySymbol+c.getRoundedNumber(d.getTotalPrice()))},x=function(){t("#"+h).text(a.currencySymbol+c.getRoundedNumber(a.getDiscountPrice(d.getAllProducts(),d.getTotalPrice(),d.getTotalQuantity())))};if(a.affixCartIcon){var T=1*r.offset().top+1*r.css("height").match(/\d+/);r.css("position");t(window).scroll(function(){t(window).scrollTop()>=T?r.addClass(p):r.removeClass(p)})}r.click(function(){a.showCheckoutModal?b():a.clickOnCartIcon(r,d.getAllProducts(),d.getTotalPrice(),d.getTotalQuantity())}),t(document).on("input","."+n,function(){var e=t(this).closest("tr").data("price"),r=t(this).closest("tr").data("id"),n=t(this).val();t(this).parent("td").next("."+f).text(a.currencySymbol+c.getRoundedNumber(e*n)),d.updatePoduct(r,n),o.text(d.getTotalQuantity()),C(),x()}),t(document).on("keypress","."+n,function(t){t.keyCode>=48&&t.keyCode<=57||t.preventDefault()}),t(document).on("click","."+s,function(){var e=t(this).closest("tr"),a=e.data("id");e.hide(500,function(){d.removeProduct(a),v(),o.text(d.getTotalQuantity())})}),t(document).on("click","."+u,function(){var e=d.getAllProducts();if(e.length){P();var r=a.checkoutCart(d.getAllProducts(),d.getTotalPrice(),d.getTotalQuantity());!1!==r&&(d.clearProduct(),o.text(d.getTotalQuantity()),t("#"+l).modal("hide"))}else t("#"+g).fadeTo("fast",.5).fadeTo("fast",1)}),t(document).on("click",e,function(){var e=t(this);a.clickOnAddToCart(e);var r=e.data("id"),n=e.data("name"),i=e.data("summary"),c=e.data("price"),s=e.data("quantity"),u=e.data("image");d.setProduct(r,n,i,c,s,u),o.text(d.getTotalQuantity()),a.afterAddOnCart(d.getAllProducts(),d.getTotalPrice(),d.getTotalQuantity())})};t.fn.myCart=function(t){return i.loadOptions(t),s(this.selector),this}})(jQuery);