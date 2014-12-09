<?
class home_model extends CI_Model {

	public function retrieveOrganizations()
	{
		$attributes = array();
		$arrOrganaizationsDetails = PodioOrganization::get_all($attributes);
		$arrOrganaizations = array();
		foreach($arrOrganaizationsDetails as $row){
			$arrOrganaizations[$row->org_id] = array(
				"id" => $row->org_id,
				"name" => $row->name
			);
		}
		// print_r($arrOrganaizations);
		return $arrOrganaizations;
	}
	public function retrieveWorkSpace($org_id)
	{
		$workSpace = array();
		if($org_id == "" || $org_id == 0)return $workSpace;
		$master_workspaces  = 	PodioSpace::get_for_org($org_id); // get workspaces within a organization		
		
		
		foreach($master_workspaces as $row)
			$workSpace [$row->space_id] = array(
					'id' =>$row->space_id,
					'name' =>$row->name
			);
		 
		return $workSpace;
	}
	public function retrieveApps($space_id)
	{
		$arrApps = array();
		if($space_id == "" || $space_id == "0") return $arrApps;
		$workspaceApps = PodioApp::get_for_space( $space_id );  //all apps by space
		$arrApps = array();
		foreach($workspaceApps as $row)
		{
			 $arrApps[$row->id] = array(
				'id' => $row->id,
				'name' => $row->config['name']);
		}
		return $arrApps;
	}
 	public function retrieveViews($app_id)
	{
		$arrViews = array();
		if($app_id == "" || $app_id == "0") return $arrViews;
		$appViews = PodioView::get_for_app( $app_id );;  //all apps by space
		$arrViews = array();
		foreach($appViews as $row)
		{
			 $arrViews[$row->view_id] = array(
				'view_id' => $row->view_id,
				'name' => $row->name);
				// print_r($row);echo "<br/><br/>";print_r($row->name);
		}
		return $arrViews;
	}
}
?>
