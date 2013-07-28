<?php
class product_batchwise_stock_model extends IgnitedRecord {
 /* var $habtm = array(array("table" => "providers",
			   "join_table" => "provider_location_affiliation"));
	function is_name($text) {
	  $ps = $this->like('name',$text,'both')->find_all();

	  if($ps)
	  	return $ps;
	  else return false;	
	}*/
  var $belongs_to = "product";
  
  function update_consumable($product,$qunatity,$location_id){
  	$ret_val = true;
    $prod_stocks = $this->where('location_id',$location_id)
		->where('product_id',$product->id)
		->order_by('expiry_date','ASC')
		->find_all();
    if($product->form != 'proc' && sizeof($prod_stocks) > 0){
		$bal_qty = ($qunatity)/($product->retail_units_per_purchase_unit);
	    $negative_balance = 0;
	    foreach ($prod_stocks as $prod_stock){
	    	if($bal_qty !=0){
				if($prod_stock->quantity < $bal_qty){
		    		if($prod_stock->quantity < 0){
		       			$negative_balance = $negative_balance + abs($prod_stock->quantity);
		       			$prod_stock->quantity=0;
		       		}else{
						$bal_qty = $bal_qty - $prod_stock->quantity;
						$prod_stock->quantity=0;
		       		}
				}else{
	    			$prod_stock->quantity = $prod_stock->quantity - $bal_qty;
					$bal_qty = 0;
		    	}  
			 	if(!$prod_stock->save()){
			    	$tx_status = false;
			    }
			}
	    }
	    if($bal_qty > 0){
	    	$temp_prod = end($prod_stocks);
			$temp_prod->quantity=-($negative_balance+$bal_qty);
		    $temp_prod->save();
		}
    }else{
    	$ret_val = false;
    }
  	return $ret_val;
  }
  
  //update medication only +ve stock
  function update_medication($m,$prod,$c,$pl_rec,$tx_status){

          $prod_stocks = $this->where('location_id',$pl_rec->scm_org_id,false)
				->where('product_id',$m->product_id,false)
				->where('quantity >','0',false)
				->order_by('expiry_date','ASC')
				->find_all();
//          $prod = $this->product->find($entry->product_id);
          if($prod->form != 'proc'){
            $bal_qty = ($c->number)/($prod->retail_units_per_purchase_unit);
            foreach ($prod_stocks as $prod_stock){
	     		if($bal_qty !=0){
	       			if($prod_stock->quantity < $bal_qty){
						$bal_qty = $bal_qty - $prod_stock->quantity;
						$prod_stock->quantity = 0;
	       			}else{
    					$prod_stock->quantity = $prod_stock->quantity - $bal_qty;
						$bal_qty = 0;
	       			}  
		       		if(!$prod_stock->save()){
		       			$tx_status = false;
		       		}
	    		}
           } 
	   	   if($bal_qty > 0){
  	      	  $tx_status = false;
           }
        }
      return $tx_status;   
  }
  
  function update_opd_product($opd_prod,$prod,$prod_stocks,$tx_status){
  	if($prod->form != 'proc'){
        $bal_qty = $opd_prod->number/($prod->retail_units_per_purchase_unit);
         foreach ($prod_stocks as $prod_stock){
     		if($bal_qty !=0){
       			if($prod_stock->quantity < $bal_qty){
					$bal_qty = $bal_qty - $prod_stock->quantity;
					$prod_stock->quantity = 0;
       			}else{
    				$prod_stock->quantity = $prod_stock->quantity - $bal_qty;
					$bal_qty = 0;
       			}  
	       		if(!$prod_stock->save()){
	       			$tx_status = false;
	       		}
	    	}
       } 
   	   if($bal_qty > 0){
  	     $tx_status = false;
        }
     }
     return $tx_status;						
  }
  
  
}
