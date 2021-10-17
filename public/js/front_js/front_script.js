$(document).ready(function() {

	$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

	$("#sort").on('change', function(){
		var sort = $(this).val();
		var fabric = get_filter('fabric');
       var sleeve = get_filter('sleeve');
       var pattern = get_filter('pattern');
       var fit = get_filter('fit');
       var occasion = get_filter('occasion');
		var url  = $("#url").val();
		$.ajax({
			url:url,
			method:"post",
			data:{fabric:fabric, sleeve : sleeve, pattern : pattern, fit : fit, occasion : occasion,sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		})

	});


     $(".fabric").on('click',function(){

       var fabric = get_filter('fabric');
       var sleeve = get_filter('sleeve');
       var pattern = get_filter('pattern');
       var fit = get_filter('fit');
       var occasion = get_filter('occasion');
       var sort = $("#sort option:selected").val();
		var url  = $("#url").val();
       

       $.ajax({
			url:url,
			method:"post",
			data:{fabric : fabric , sleeve : sleeve, pattern : pattern, fit : fit, occasion : occasion, sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		})    


     });

     $(".sleeve").on('click',function(){
       var fabric = get_filter('fabric');
       var sleeve = get_filter('sleeve');
       var pattern = get_filter('pattern');
       var fit = get_filter('fit');
       var occasion = get_filter('occasion');
       var sort = $("#sort option:selected").val();
		var url  = $("#url").val();
       

       $.ajax({
			url:url,
			method:"post",
			data:{fabric : fabric , sleeve : sleeve, pattern : pattern, fit : fit, occasion : occasion, sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		})    


     });


      $(".pattern").on('click',function(){
       var fabric = get_filter('fabric');
       var sleeve = get_filter('sleeve');
       var pattern = get_filter('pattern');
       var fit = get_filter('fit');
       var occasion = get_filter('occasion');
       var sort = $("#sort option:selected").val();
		var url  = $("#url").val();
       

       $.ajax({
			url:url,
			method:"post",
			data:{fabric : fabric , sleeve : sleeve, pattern : pattern, fit : fit, occasion : occasion, sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		})    


     });


       $(".fit").on('click',function(){
       var fabric = get_filter('fabric');
       var sleeve = get_filter('sleeve');
       var pattern = get_filter('pattern');
       var fit = get_filter('fit');
       var occasion = get_filter('occasion');
       var sort = $("#sort option:selected").val();
		var url  = $("#url").val();
       

       $.ajax({
			url:url,
			method:"post",
			data:{fabric : fabric , sleeve : sleeve, pattern : pattern, fit : fit, occasion : occasion, sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		})    


     });


        $(".occasion").on('click',function(){
       var fabric = get_filter('fabric');
       var sleeve = get_filter('sleeve');
       var pattern = get_filter('pattern');
       var fit = get_filter('fit');
       var occasion = get_filter('occasion');
       var sort = $("#sort option:selected").val();
		var url  = $("#url").val();
       

       $.ajax({
			url:url,
			method:"POST",
			data:{fabric : fabric , sleeve : sleeve, pattern : pattern, fit : fit, occasion : occasion, sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		})    


     });

     function get_filter(class_name){
     	var filter = [];

     	$('.'+class_name+':checked' ).each(function(){

     		filter.push($(this).val());

     	});
     	return filter;
     }

      

         
     $("#getPrice").change(function(){
       var size = $(this).val();
       if (size==""){
        alert("Veuillez sélectionner la taille");
        return false;
       }
       var product_id = $(this).attr("product-id");
       $.ajax({

        url:'/get-product-price',
        data:{size:size,product_id:product_id},
        type:'post',
        success:function(resp){
             
           if(resp['discount']>0){
               $(".getAttrPrice").html("<del>"+resp['product_price']+" TND</del>&nbsp;&nbsp;"+resp['final_price']+" TND");
           }else{
            $(".getAttrPrice").html(resp['product_price']+"TND");
           }
          
        },error:function(){
          alert("Error");
        }

       });
       });



       

     //Update cart Items
     $(document).on('click','.btnItemUpdate',function(){

         if ($(this).hasClass('qtyMinus')){
          // if qtyMinus button gets clicked by User
          var quantity = $(this).prev().val();
          if(quantity<=1){
            alert("La quantité de l'article doit être égale ou supérieure à 1!");
            return false;
          }else{
            new_qty = parseInt(quantity)-1;

          }
          
         }
         if ($(this).hasClass('qtyPlus')){
          //if qtyPlus Button gets clicked by User
          var quantity = $(this).prev().prev().val();
          
          new_qty = parseInt(quantity)+1;
         }
         
         
         var cartid = $(this).data('cartid');
         
         $.ajax({

          data:{"cartid":cartid,"qty":new_qty},
          url:'/update-cart-item-qty',
          type:'post',
          success:function(resp){

            if(resp.status==false){
              alert(resp.message);
            }
            
            $("#AppendCartItems").html(resp.view);
          },error:function(){
            alert("Error");
          }

         });



     });






    //Delete cart Items
     $(document).on('click','.btnItemDelete',function(){

         var cartid = $(this).data('cartid');
         var result = confirm("vous voulez supprimer cet article du panier ?");
         if (result){

              $.ajax({

                data:{"cartid":cartid},
                url:'/delete-cart-item',
                type:'post',
                success:function(resp){

                   $("#AppendCartItems").html(resp.view);
          },error:function(){
              alert("Error");
          }

         });

         }

         
         



     });


     
     // validate Register form on keyup and submit
    $("#registerForm").validate({
      rules: {

        name: "required",
        mobile: {
        required: true,
        minlength: 8 ,
        maxlength: 8 ,
        digits : true
        },
                
        email: {
          required: true,
          email: true,
          remote: "check-email"
        },
        password: {
          required: true,
          minlength: 6
        }

      },
        
      messages: {
        name: "Veuillez saisir votre nom et Votre Prènom",
        
        mobile: {
          required: "Veuillez saisir votre numèro de Télèphone",
          minlength: "Votre numéro de téléphone mobile doit être composé de 10 chiffres",
          maxlength: "Votre numéro de téléphone mobile doit être composé de 10 chiffres",
          digits:"Veuillez saisir un numèro de Télèphone valide"
        },

        email: {
        required: "Veuillez saisir votre adresse E-mail",
        email:"Veuillez saisir une adresse E-mail valide",
        remote: "L'e-mail existe déjà"
      },

        password: {
          required: "Veuillez saisir un mot de passe",
          minlength: "Votre mot de passe doit comporter au moins 6 caractères"
        }
        
        }


    
    });


     // validate Login form on keyup and submit
    $("#loginForm").validate({
      rules: {

        email: {
          required:true  ,
          email:true 
          
        },
        password: {
          required:true ,
          minlength: 6
        }

      },
        
      messages: {
        email: {
           required: "Veuillez saisir votre adresse E-mail",
          email:"Veuillez saisir une adresse E-mail valide"
      },

        password: {
          required: "Veuillez saisir Votre mot de passe",
          minlength: "Votre mot de passe doit comporter au moins 6 caractères"
        }
        
        }





});

    }); 
