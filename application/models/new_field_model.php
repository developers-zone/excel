<?
class new_field_model extends CI_Model {
 
			 
	public function createNewField($app_id)
	{
		try{
			$options = array();
			$arrFields = PodioApp::get($app_id);  //coded
			$arrExistingFields = array();
			for($p = 0;$p<count($arrFields->__attributes['fields']);$p++){
				if($arrFields->__attributes['fields'][$p]->__attributes['status'] != "active") continue;
				$arrExistingFields[] = $arrFields->__attributes['fields'][$p]->__attributes['config']['label'];
			}
			if(in_array($this->field_name,$arrExistingFields)){
				return 0;
			}
		
			if($this->required_val  == "")
				$this->required_val = false;
			else 
				$this->required_val  = true;
			$k = 1;
			if(is_array($this->optionValues) && count($this->optionValues) > 0)
			{
				foreach($this->optionValues as $opt)
				{
					$options[] = array(
										 "status"=>"active",
										 "text"=>$opt,
										 "id"=>$k,
										 "color"=>"D1F3EC"
										);
				$k++;
				}
			}
			$refArray = array();
			if(is_array($this->references) && count($this->references) > 0)
			{ 
				foreach($this->references as $ref)
				{
					$refArray[] = (int)$ref;
				}
			}
			$allowedCurreciesList = array();
			if(is_array($this->allowedCurrecies) && count($this->allowedCurrecies) > 0)
			{ 
				foreach($this->allowedCurrecies as $curr)
				{
					$allowedCurreciesList[] = $curr;
				}
			}
			 
			 $config = array(
				"label"=>$this->field_name,
				"required"=>$this->required_val,
				"description" => $this->description,
				"delta"=>$this->delta==""?0:($this->delta-1),
				"settings" => array(
						"multiple" => $this->multi_choice==""?false:true,
						"options"=> $options,
						"referenceable_types" => $refArray,
						"allowed_currencies" => $allowedCurreciesList,
						"type" => $this->contact_type
						)
				);
				//{'space_users', 'space_contacts', 'space_users_and_contacts', 'all_users'}. 
			$attributes = array(
					"type" => $this->field_type,
					"config" => $config);
				
			PodioAppField::create($app_id, $attributes);
			$this->field_name = "";
			$this->required_val = "";
			$this->description= "";
			$this->field_type = "";
			$this->delta = "";
			return 1;
		}catch (PodioError $e) {
			return $e->body['error']."##@##".$e->body['error_description'];
		}
	
	}
	 
}

?>