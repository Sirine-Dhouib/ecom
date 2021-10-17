<?php use App\Product; ?>
<table class="table table-bordered">
              <thead>
                <tr>
                  <th><center>Produit</center></th>
                  <th colspan="2" ><center>Description</center></th>
                  <th><center>Quantité/Mise à jour</center></th>
				  <th><center>Prix unitaire</center></th>
                  <th><center>Réduction </center><center>Produit/Categorie </center></th>
                  <th>Sous-total</th>
				</tr>
              </thead>
              <tbody>

              	<?php $total_price = 0; ?>
              	@foreach($userCartItems as $item)
              	<?php $attrPrice = Product::getDiscountedAttrPrice($item['product_id'],$item['size']); ?>
                <tr>
                  <td> <img width="60" src="{{ asset('images/product_images/small/'.$item['product']['main_image']) }}" alt=""/></td>
                  <td colspan="2" > {{ $item['product']['product_name'] }}({{ $item['product']['product_code'] }}) <br/>
                  Couleur : {{ $item['product']['product_color'] }}<br/>
                  Taille  : {{ $item['size'] }}<br/>

              </td>
				  <td>
					<div class="input-append"><input class="span1" style="max-width:34px" value="{{ $item['quantity'] }}" id="appendedInputButtons" size="16" type="text"><button class="btn btnItemUpdate qtyMinus" type="button" data-cartid="{{ $item['id'] }}" ><i class="icon-minus"></i></button>
						<button class="btn btnItemUpdate qtyPlus" type="button"  data-cartid="{{ $item['id'] }}" ><i class="icon-plus"></i></button>
						<button class="btn btn-danger btnItemDelete" type="button" data-cartid="{{ $item['id'] }}" ><i class="icon-remove icon-white"></i></button>				
					</div>
				  </td>
                  <td> {{  $attrPrice['product_price'] }} TND</td>
                  <td> {{  $attrPrice['discount']*$item['quantity'] }} TND</td>
                  <td> {{  $attrPrice['final_price']*$item['quantity'] }} TND</td>
                </tr>

                <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']); ?>
                <tr>
                  <td colspan="6" style="text-align:right">Sous Total:  </td>
                  <td>  {{ $total_price }} TND</td>
                </tr>

         <tr>
                  <td colspan="6" style="text-align:right">CODE PROMO:  </td>
                  <td> 0 TND</td>
              
                </tr>
                 
         <tr>


                  <td colspan="6" style="text-align:right"><strong>TOTAL GENERAL ( {{ $attrPrice['product_price']*$item['quantity'] }} TND - 0 TND) =</strong></td>
                  <td class="label label-important" style="display:block"> <strong>  {{ $total_price }} TND</strong></td>
                </tr>

				@endforeach
				
                
				</tbody>
            </table>