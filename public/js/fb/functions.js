

function getPage(page)
{
	$('#page_no').val(page);
	$("#frmcatproduct").submit();
	$("#frmRetailerProduct").submit();
}

function reloadPageWithNewSort(val)
{
	$("#frmcatproduct").submit();
}


function addTocart(fb_userid,product_id, options_id, product_price)
{
		$('#loader2').show();
		$('#loader2').css('visibility','visible');
		$('#loader2').addClass('ui-widget-loading');
		
		var NoOfCombo = $('#Opt_Combo').val();
		var value = new Array();
		
		$.ajax({
			type: "POST",
			url:site_url+"product/addtocart",
			async: true,
			data: {
				  prodid: function() 
				  {
						return product_id; 
				  },
				  option: function() 
				  {
						return options_id; value;
				  },
				  prodPrice: function() 
				  {
						return product_price; 
				  },
				  fbuserid: function() 
				  {
						return fb_userid;
				  }
			 },
			dataType:'html',
			success:function(data)
			{ 
				
				//loadPopup2()
				$('#popupContact').html(data);
				var totalProd = $('#cartcount').val();
				//alert(totalProd);
				$('#cartCounterNumber').html(totalProd);
				  centerPopup();
				  loadPopup2();
			}		
		});
	
	
}

function validateAddToCart()
{	

	var fb_userid = $("#facebook_user_numeric_id").val();
	var fb_useremailid = $("#facebook_userid").val();
	
	if(fb_userid != '' && fb_useremailid != '' ) {
		
		var NoOfCombo = $('#Opt_Combo').val();
			var value = new Array();
			for(i=0; i < NoOfCombo; i++)
			{
				value[i] = $('#OptionCombo'+i).val(); 
			}
			
			addTocart(fb_useremailid, $('#productId').val(), value, $('#TotalPrice').val());
	
	} else { 
	
		FB.ui({
            method: 'permissions.request',
            perms: 'email'
        }, function (response) {
            if (response.status == "connected") {
				
				var fb_useremailid = response.session.uid;
				var NoOfCombo = $('#Opt_Combo').val();
				var value = new Array();
				for(i=0; i < NoOfCombo; i++)
				{
					value[i] = $('#OptionCombo'+i).val(); 
				}
				addTocart(fb_useremailid, $('#productId').val(), value, $('#TotalPrice').val());
                return false;
            } 
        });
		
	}
	 
}

function DeleteCartProduct(prodId,cartId)
{
	
		$('#loader').show();
		$('#loader').css('visibility','visible');
		$('#loader').addClass('ui-widget-loading');
		
		$(this).fadeIn(3000, function() {
			$('#breadCrumb_cart').hide();
			$('#order_review').hide();
			$('#buttonArea').hide();
			$('#SubtotalDiv').hide();
		});
	
 	 	$.ajax({
 	    type: "POST",
		url:site_url+"cart/deletecartproduct",
 		data: {
			  prodid: function() 
			  {
					return prodId;
			  },
			  cartid: function()
			  {
				  return cartId;
			  },
  			  fbuid: function()
			  {
				  return $('#facebook_userid').val();
			  }

         },
 		dataType:'json',
		success:function(data)
		{ 

		
				$('#cartCounterNumber').html(data);
				if(data != 0){
					$('#loader').hide();
					$('#loader').removeClass('ui-widget-loading');
					$('#breadCrumb_cart').show();
					$('#SubtotalDiv').show();
					$('#order_review').show();
					$('#merchantProd'+prodId).hide();
 					$('#cartRow_'+prodId).hide();
					$('#buttonArea').show();
				}else{
					$('#breadCrumb_cart').hide();
					$('#contactArea').hide();
					$('#buttonArea').hide();
					$('#EmptyCart').show();
				}
			//top.location.href = '';
			//
		}		
	});
}

function updatecart(prodId,cartId)
{
	
		$.ajaxSetup({
		   beforeSend : function(){ 
				$('#loader').show();
				$('#loader').css('visibility','visible');
				$('#loader').addClass('ui-widget-loading');
				
				$(this).fadeIn(3000, function() {
					$('#breadCrumb_cart').hide();
					$('#order_review').hide();
					$('#buttonArea').hide();
					$('#SubtotalDiv').hide();
					
				});
		   },
		   complete : function(){ 
				$('#loader').hide();
				$('#loader').removeClass('ui-widget-loading');
		   }		   
		});
	
	
  	 	$.ajax({
 	    type: "POST",
		url:site_url+"cart/updatecart",
 		data: {
			  prodid: function() 
			  {
					return prodId;
			  },
			  cartid: function()
			  {
				  return cartId;
			  },
			  prodPrice: function()
			  {
				  //alert($('#IndivisualPrice'+prodId).val());
				  return $('#IndivisualPrice'+prodId).val();
			  },
			  prodQty: function()
			  {
				  //alert($('#ProductQty'+prodId).val());
				  return $('#ProductQty'+prodId).val();
			  },
			  fbuid: function()
			  {
				  return $('#facebook_userid').val();
			  }

         },
 		dataType:'json',
		success:function(data)
		{ 
			//alert(data);return false;
			var totalCost = 0;
			var ProdQty = 0;
			
 			for(i in data)
			{
				
				$('#itemPrice'+data[i]['product_id']).html(cartCurrSymbol+" "+roundVal( parseFloat(data[i]['price'])*parseInt(data[i]['product_qty'])));
				$('#IndivisualPrice'+data[i]['product_id']).val(roundVal(data[i]['price']));
				$('#ProductQty'+data[i]['product_id']).val(data[i]['product_qty']);
				ProdQty = parseInt(ProdQty)+parseInt(data[i]['product_qty']);
				totalCost = parseFloat(totalCost)+parseFloat(data[i]['product_total_cost']);
				//$('#cartCounterNumber').html(ProdQty);
				$('#SubtotalDiv').show();
				$('#cartSubTotal').html("$"+totalCost);
				$('#breadCrumb_cart').show();
				$('#order_review').show();
				$('#buttonArea').show();
			}	
			
		}		
	});
}

function roundVal(val){
	var dec = 2;
	var result = Math.round(val*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}


var OptionCost = new Array();
function changePrice(detailId,prodId,OptId)
{
	
/*	if(Optprice == 0)
	{
		$('#prod_price').html("$"+prodPrice);
 	}
	else{
		var total = parseFloat(prodPrice)+parseFloat(Optprice);
		$('#prod_price').html("$"+total);
	}
*/	
	
	$.ajax({
 	    type: "POST",
		url:site_url+"product/updateprice",
 		data: {
			  opt_detail_id: function() 
			  {
					return detailId;
			  },
			  prodid: function() 
			  {
					return prodId;
			  }  
         },
 		dataType:'json',
		success:function(data)
		{ 
					
				//alert(data['option_price']);return false;
					var dft_price = $('#DefaultPrice').val();
					//var total = parseFloat(dft_price)+parseFloat(data);
					if(data != false)
					{
						var opt_price = data['Opt_convert_price'];
					}else{
						
						var opt_price = 0;
					}
					OptionCost[OptId] =  parseFloat(opt_price);
					
					var total = 0;
 					for(temp in OptionCost)
					{
						//alert(temp+" => "+ OptionCost[temp]);
						total = total + OptionCost[temp];
						
					}
 					$('#hiddenPrice').val(parseFloat(total));
					var OptPrice = $('#hiddenPrice').val();
 					var total = parseFloat(dft_price)+parseFloat(OptPrice);
					//alert(total);
					
 					$('#prod_price').html(def_curr_symbol+total.toFixed(2));
					$('#TotalPrice').val(total);
 		}		
	});
}


function addShippingDetail()
{
		//alert(id);
		$.ajaxSetup({
		   beforeSend : function(){ 
				$('#loader').show();
				$('#loader').css('visibility','visible');
				$('#loader').addClass('ui-widget-loading');
				
				$(this).fadeIn(3000, function() {
					$('#breadCrumb_cart').hide();
					$('#div2').hide();
					$('#buttonArea').hide();
						
				});
		   },
		   complete : function(){ 
				$('#loader').hide();
				$('#loader').removeClass('ui-widget-loading');
		   }		   
		});
		
		$.ajax({
 	    type: "POST",
		url:site_url+"cart/updateshipping",
 		data: {
			  cartid: function()
			  {
				  return $('#cartID').val();
			  },
			  fname: function()
			  {
				  return $('#firstname').val();
			  },
			  lname: function()
			  {
				 return $('#lastname').val();
			  },
			  email: function()
			  {
				  return $('#email').val();
			  },
			  telephone: function()
			  {
				  return $('#phone').val();
			  },
//			  carr_email: function()
//			  {
//				  return $('#c_email').val();
//			  },
			  add_type: function()
			  {
				  return $('#addressType').val();
			  },
			  country: function()
			  {
				  return $('#Shippingcountry').val();
			  },
			  add: function()
			  {
				  add = $('#address').val();
				  add1 = $('#address1').val();
				  return add+"@"+add1;
			  },
			  city: function()
			  {
				  return $('#city').val();
			  },
			  state: function()
			  {
				  return $('#Shippingstate').val();
			  },
			  postcode: function()
			  {
				  return $('#postcode').val();
			  },
			  isbilling: function()
			  {
				  
				  return $('#IsBilling').is(':checked');
			  },
			   fbuid: function()
			  {
				  return $('#facebook_userid').val();
			  }
			  
         },
 		dataType:'html',
		success:function(data)
		{ 
			//alert(data);
			//return false;
			//alert($('#IsBilling').is(':checked'));
					if($('#IsBilling').is(':checked') == true)
					{
						//alert("in");
						//$('#div2').show();
						//$('#cartRow_'+prodId).hide();
						ShowTab(3);
						$('#div3').html(data);
						$('#breadCrumb_cart').show();
						
					}else{
						//alert("out");
						$('#breadCrumb_cart').show();
						$('#buttonArea').show();
						$('#div8').show();
						$('#shipping_li').hide();
						$('#billing_li').show();
						$('#billing_li a').addClass('active');
						$('#div2').hide();
					}
				
			//top.location.href = '';
			//
		}		
		});
	
}

function addBillingDetail()
{
		$.ajaxSetup({
		   beforeSend : function(){ 
				$('#loader').show();
				$('#loader').css('visibility','visible');
				$('#loader').addClass('ui-widget-loading');
				
				$(this).fadeIn(3000, function() {
					$('#breadCrumb_cart').hide();
					$('#div8').hide();
					$('#buttonArea').hide();
						
				});
		   },
		   complete : function(){ 
				$('#loader').hide();
				$('#loader').removeClass('ui-widget-loading');
		   }		   
		});

	$.ajax({
 	    type: "POST",
		url:site_url+"cart/updatebilling",
 		data: {
			  Bill_cartid: function()
			  {
				  return $('#cartID').val();
			  },
			  Bill_fname: function()
			  {
				  return $('#bfirstname').val();
			  },
			  Bill_lname: function()
			  {
				 return $('#blastname').val();
			  },
			  Bill_email: function()
			  {
				  return $('#bemail').val();
			  },
			  Bill_telephone: function()
			  {
				  return $('#bphone').val();
			  },
//			  carr_email: function()
//			  {
//				  return $('#c_email').val();
//			  },
			  Bill_add_type: function()
			  {
				  return $('#baddressType').val();
			  },
			  Bill_country: function()
			  {
				  return $('#Billingcountry').val();
			  },
			  Bill_add: function()
			  {
				  add = $('#baddress').val();
				  add1 = $('#baddress1').val();
				  return add+"@"+add1;
			  },
			  Bill_city: function()
			  {
				  return $('#bcity').val();
			  },
			  Bill_state: function()
			  {
				  return $('#Billingstate').val();
			  },
			  Bill_postcode: function()
			  {
				  return $('#bpostcode').val();
			  }
			  
         },
 		dataType:'html',
		success:function(data)
		{ 
			ShowTab(3);
			$('#breadCrumb_cart').show();
			$('#SubtotalDiv').show();
 			$('#buttonArea').show();
			$('#div8').hide();
			$('#shipping_li').hide();
			$('#billing_li').show();
		}		
		});
	
}



function addShippingDetail1()
{
		$.ajaxSetup({
		   beforeSend : function(){ 
				$('#loader2').show();
				$('#loader2').css('visibility','visible');
				$('#loader2').addClass('ui-widget-loading');
				
				$(this).fadeIn(3000, function() {
					$('#settingarea').hide();						  
					$('#div7').hide();
					$('#buttonArea').hide();
						
				});
		   },
		   complete : function(){ 
				$('#loader2').hide();
				$('#loader2').removeClass('ui-widget-loading');
		   }		   
		});

	$.ajax({
 	    type: "POST",
		url:site_url+"cart/updateshipping",
 		data: {
			  cartid: function()
			  {
				  return $('#cartID').val();
			  },
			  fname: function()
			  {
				  return $('#firstname1').val();
			  },
			  lname: function()
			  {
				 return $('#lastname1').val();
			  },
			  email: function()
			  {
				  return $('#email1').val();
			  },
			  telephone: function()
			  {
				  return $('#phone1').val();
			  },
//			  carr_email: function()
//			  {
//				  return $('#c_email1').val();
//			  },
			  add_type: function()
			  {
				  return $('#addressType1').val();
			  },
			  country: function()
			  {
				  return $('#Shippingcountry1').val();
			  },
			  add: function()
			  {
				  add = $('#address2').val();
				  add1 = $('#address3').val();
					return add+"@"+add1;
			  },
			  city: function()
			  {
				  return $('#city1').val();
			  },
			  state: function()
			  {
				  return $('#Shippingstate1').val();
			  },
			  postcode: function()
			  {
				  return $('#postcode1').val();
			  }
			  
         },
 		dataType:'html',
		success:function(data)
		{ 
			//alert(data);
			
 					$('#div7').show();
					$('#div3').html(data);
					$('#settingarea').show();
					//$('#cartRow_'+prodId).hide();
					$('#buttonArea').show();
				
			//
		}		
		});
	
}


function GetStateforCountry(id)
{
	
	
	$.ajax({
 	    type: "POST",
		url:site_url+"cart/getcountrystate",
 		data: {
			  countryid: function() 
			  {
					return $('#Shippingcountry').val();
			  }  
         },
 		dataType:'json',
		success:function(data)
		{ 
			var combo = '';
			if(data != '')
			{
				for(i in data)
				{
					//alert(i+"=>"+data[i]['state_name']);
					combo +="<option value='"+data[i]['state_id']+"'>"+data[i]['state_name']+"</option>";
					$('#Shippingstate').html(combo);
				}
			}else{
					combo ="<option value='0'>Select State</option>";
					$('#Shippingstate').html(combo);
			}
  			//top.location.href = '';
 		}		
	});

}

function GetStateforCountry1(id)
{

	$.ajax({
 	    type: "POST",
		url:site_url+"cart/getcountrystate",
 		data: {
			  countryid: function() 
			  {
					return $('#Shippingcountry1').val();
			  }  
         },
 		dataType:'json',
		success:function(data)
		{ 
			var combo = '';
			if(data != '')
			{
				for(i in data)
				{
					//alert(i+"=>"+data[i]['state_name']);
					combo +="<option value='"+data[i]['state_id']+"'>"+data[i]['state_name']+"</option>";
					$('#Shippingstate1').html(combo);
				}
			}else{
					combo ="<option value='0'>Select State</option>";
					$('#Shippingstate1').html(combo);
			}
  			//top.location.href = '';
 		}		
	});

}
		



function showProductThumbImage(ThumbIndex,ImagePath,Imagename) {
	for(i=0; i<4; i++)
	{
		otherid = '#Tiny'+i;
		$(otherid).addClass("otherimg");
	}
	
	var id = '#Tiny'+ThumbIndex;
	
	$(id).removeClass("otherimg");
	$(id).addClass("active");
	
	var ThumbURLs = produImagePath+ImagePath+"/"+Imagename;
	
	//alert(ThumbURLs);
 	
	$('#bigimg1 img').attr('src', ThumbURLs);
 
}

var ShippingCost = new Array();

function GetShippingCost(ShippMethodId,prodId)
{
	
	
		$.ajaxSetup({
		   beforeSend : function(){ 
 				$('#ShippingCost'+prodId).html('');
				$('#ShippingCost'+prodId).addClass('ui-widget2-loading');
				
 		   },
		   complete : function(){ 
 				$('#ShippingCost'+prodId).removeClass('ui-widget2-loading');
		   }		   
		});

	$.ajax({
 	    type: "POST",
		url:site_url+"cart/getshippingcost",
 		data: {
			  shipmethodid: function() 
			  {
					return ShippMethodId;
			  },
			  prodid: function() 
			  {
					return prodId;
			  },
			  current_currencyId: function() 
			  {
					return $('#CurrentCurrencyId').val();
			  },
         },
 		dataType:'json',
		success:function(data)
		{ 
		
			$(this).fadeIn(3000, function() {
				$('#breadCrumb_cart').show();
				$('#buttonArea').show();
				$('#div3').show();
			
			
				$('#ShippingSpace'+prodId).show();
				$('#ShippingRow'+prodId).show();
				$('#ShippingCost'+prodId).html(cartCurrSymbol+" "+data);
				
				ShippingCost[prodId] =  parseFloat(data);
				
				var total = 0;
				for(temp in ShippingCost)
				{
					//alert(temp+" => "+ShippingCost[temp]);
					total = total + ShippingCost[temp];
				}
				
				$('#ShippingtotalAmount').val(total);
				
		});
 		}		
	});

	
}

var ids = new Array();
var methodids = new Array();
var taxrate = new Array();
function UpdateShipping(CartId,prodId)
{
	//alert();
	//alert(prodId);
	//console.log(prodId);
	
		$.ajaxSetup({
		   beforeSend : function(){ 
				$('#loader').show();
				$('#loader').css('visibility','visible');
				$('#loader').addClass('ui-widget-loading');
				
				$(this).fadeIn(3000, function() {
					$('#breadCrumb_cart').hide();
					$('#buttonArea').hide();
					$('#div3').hide();
				});
		   },
		   complete : function(){ 
				$('#loader').hide();
				$('#loader').removeClass('ui-widget-loading');
				ShowTab(4);
		   }		   
		});
	
		$.ajax({
 	    type: "POST",
		url:site_url+"cart/updateshippingmethod",
 		data: {
			  cartid: function() 
			  {
					return CartId;
			  },
			  prodid: function() 
			  {
				  	for(i=0; i<prodId.length; i++ )
					{
						ids[i] = prodId[i];
					}
 					return ids;
			  },
			  methodid: function() 
			  {
				  	for(j=0; j<prodId.length; j++ )
					{
						methodids[j] = $('#Shipping_Method_'+prodId[j]).val();
						
					}
   					return methodids;
			  },
			  taxrate: function() 
			  {
				  	for(k=0; k<prodId.length; k++ )
					{
						taxrate[k] = $('#taxRate'+prodId[k]).html().replace('$','');
						
					}
					
   					return taxrate;
			  },
			  fbuid: function()
			  {
				  return $('#facebook_userid').val();
			  },
			  current_currencyId: function() 
			  {
					return $('#CurrentCurrencyId').val();
			  },
         },
 		dataType:'json',
		success:function(data)
		{ 
			//alert(data);
			$('#FinalAmount').val(data);
			$('#breadCrumb_cart').show();
			ShowTab(4);
			//$('#buttonArea').show();

 		}		
	});

	
}



function loadPopup()
{
	ShowTab(1);
	$('#sellerarea').hide();
	$('#cartarea').show();
	$('#order_review').show();
	$('#shipping_li').show();
	$('#billing_li').hide();
	$('#div8').hide();
	$('#buttonArea').show();
	$("#backgroundPopup").css({"opacity": "0.1"});
	$("#backgroundPopup").fadeIn("fast");
	$("#popupContact").slideDown("slow");
 
 
}

function loadPopup1()
{
	$('#cartarea').hide();
	$('#sellerarea').show();
	$("#backgroundPopup").css({"opacity": "0.1"});
	$("#backgroundPopup").fadeIn("fast");
	$("#popupContact").slideDown("slow");
}

function loadPopup2()
{
	//alert("test");
	ShowTab(1);
	$('#sellerarea').hide();
	$('#cartarea').show();
	$('#order_review').show();
	$('#shipping_li').show();
	$('#billing_li').hide();
	$('#div8').hide();
	$('#buttonArea').show();
	$("#backgroundPopup").css({"opacity": "0.1"});
	$("#backgroundPopup").fadeIn("fast");
	$("#popupContact").slideDown("slow");
}


function disablePopup()
{
	$("#backgroundPopup").fadeOut("slow");
	$("#popupContact").slideUp("slow");
}
function centerPopup()
{
/* $("#popupContact").height('auto');	*/
  
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	//var popupHeight = $("#innerDIV").height();
	var popupWidth = $("#popupContact").width();
	$("#popupContact").css({"position": "absolute","top": 85,"left": windowWidth/2-popupWidth/2});
	$("#backgroundPopup").css({"height": windowHeight});

}

$(document).ready(function()
{
 $(".cart_wrapper").click(function()
 {
  centerPopup();
  loadPopup();
 });
 $("#btn1").click(function()
 {
  centerPopup();
  loadPopup1();
 });
// $("#btn").click(function()
// {
//  centerPopup();
//  loadPopup2();
// });
	 $("#popupContactClose").click(function()
	 {
		 disablePopup();
	 });
  
 $(document).keypress(function(e)
 {
  if(e.keyCode==27)//Disable popup on pressing `ESC`
  {
   disablePopup();
  }
 });
});



function addUserLike(likeurl,widget)
{
	$.ajax({
 	    type: "POST",
		url:site_url+"index/adduserlike",
 		data: {
				likeurl: function() 
				{
					return likeurl;
				},
				facebook_user_email: function() 
				{
					return $("#facebook_userid").val();
				},
				facebook_user_id: function() 
				{
					return $("#facebook_user_numeric_id").val();
				}
		},
		dataType:'html',
		success:function(data)
		{ 
 		}		
	});
}

function removeUserLike(url,widget)
{
	$.ajax({
 	    type: "POST",
		url:site_url+"index/removeuserlike",
 		data: {
				likeurl: function() 
				{
					return url;
				},
				facebook_user_email: function() 
				{
					return $("#facebook_userid").val();
				},
				facebook_user_id: function() 
				{
					return $("#facebook_user_numeric_id").val();
				}
		},
		dataType:'html',
		success:function(data)
		{ 
 		}		
	});
}


function ChangeCartCurrency()
{
	
		$('#settingarea').hide();
		$('#loader2').show();
		$('#loader2').css('visibility','visible');
		$('#loader2').addClass('ui-widget-loading');
								  
	$.ajax({
 	    type: "POST",
		url:site_url+"cart/updatecartcurrency",
 		data: {
				currencyId: function() 
				{
					return $('#CartCurrency').val();
				},
				current_currencyId: function() 
				{
					return $('#CurrentCurrencyId').val();
				},
				fbuid: function()
				{
				  return $('#facebook_userid').val();
				}
		},
		dataType:'html',
		success:function(data)
		{ 
			$(this).fadeIn(3000, function() {
				$('#loader2').hide();
				$('#loader2').removeClass('ui-widget-loading');
				$('#cartarea').hide();
				$('#popupContact').html(data);
				ShowTab(1);
			});
		}		
	});
	
}