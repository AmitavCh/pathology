<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Role;
use App\Models\RoleMenu;
use DB;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
    public static function getRoleName($id) {
        $response = '';
        $studentObj = DB::table('roles')
                ->where('roles.id', '=', $id)
                ->select(array(
                    'roles.role_name',
                        )
                )
                ->first();
        if (isset($studentObj->role_name) && $studentObj->role_name != '') {
            $response = $studentObj->role_name;
        }
        return $response;
    }
    public static function getMenuSubmenu() {
		$menuSubmenuArr = array();
		$menuSubMenuObj = Menu::with(array('submenus' => function($query) {

                        $query->where('sub_menus.is_active', '=', 'Y')
                        ->orderBy('sub_menus.sub_menu_order');
                    }))
                ->where('menus.is_active', '=', 'Y')
                ->orderBy('menus.menu_order')
                ->get();
		if ($menuSubMenuObj) {
			$menuSubmenuArr = $menuSubMenuObj->toArray();
        }
		return $menuSubmenuArr;
    }
    public static function getRoleMenuAdminLeftPane($editMenuListFind = array()) {
		$roleMenuArr = array();
		//$editMenuListFind = array();
			if (isset(Auth::user()->role_id) && Auth::user()->role_id != 0) {
				$editMenuListFind = DB::table('role_menus')
                    ->where('role_menus.role_id', '=', Auth::user()->role_id)
                    ->select(array('role_menus.menu_id', 'role_menus.sub_menu_id'))
                    ->get();
					
			//if (is_array($editMenuListFind) && count($editMenuListFind) > 0) {
				foreach ($editMenuListFind as $editMenuListKey => $editMenuListVal) {
					
					$editMenuList[] = $editMenuListVal->menu_id;
					$editSubMenuList[] = $editMenuListVal->sub_menu_id;
                }
				$roleMenuArr['editMenuList'] = $editMenuList;
				$roleMenuArr['editSubMenuList'] = $editSubMenuList;
            //}
        }
		//echo'<pre>';print_r( $roleMenuArr);echo'</pre>';exit;
		return $roleMenuArr;
    }
    public static function getMasterList($table_name = '', $col_name = ''){
        $response               = '';
        $responseArr[0]['id']   = "";
        $responseArr[0]['name'] = "Select";
        $responseObjArr         = DB::table($table_name)->select($col_name, 'id')->where('is_active','Y')->get();
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->$col_name;

        }
        return $responseArr;
    }
    public static function getMasterLists($table_name = '', $col_name = ''){
        $response               = '';
        $responseArr[0]['id']   = "";
        $responseArr[0]['name'] = "Select";
        $responseObjArr         = DB::table($table_name)->select($col_name, 'id')->where('status','Y')->get();
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->$col_name;

        }
        return $responseArr;
    }
    public static function getStateLists($table_name = '', $col_name = ''){
        $response               = '';
        $responseObjArr         = DB::table($table_name)->select($col_name, 'id')->where('status','Y')->orderby('state_name','asc')->get();
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->$col_name;

        }
        return $responseArr;
    }
    public static function getOrganizationLists($table_name = '', $col_name = ''){
        $response               = '';
        $responseObjArr         = DB::table($table_name)->select($col_name, 'id')->where('status','Y')->orderby('organization_name','asc')->get();
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->$col_name;

        }
        return $responseArr;
    }
    public static function getBranchLists($table_name = '', $col_name = ''){
        $response               = '';
        $responseArr[0]['id']   = "";
        $responseArr[0]['name'] = "Select";
        $responseObjArr         = DB::table($table_name)->select($col_name, 'id')->where('status','Y')->orderby('branch_name','asc')->get();
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->$col_name;

        }
        return $responseArr;
    }
    public static function getLabLists($table_name = '', $col_name = ''){
        $response               = '';
        $responseArr[0]['id']   = "";
        $responseArr[0]['name'] = "Select";
        if(isset(Auth::user()->role_id) && Auth::user()->role_id == 2){
        $responseObjArr         = DB::table($table_name)->select($col_name, 'id')->where('status','Y')->where('t_branch_details_id','=',0)->orderby('business_logistic_name','asc')->get();
        }else{
        $responseObjArr         = DB::table($table_name)->select($col_name, 'id')->where('status','Y')->where('t_branch_details_id','!=',0)->orderby('business_logistic_name','asc')->get();    
        }
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->$col_name;

        }
        return $responseArr;
    }
    public static function getRoleListForMasterAdmin($role_id = 0) {
        $response               = '';
        if(Auth::user()->role_id == 1){
            $responseObjArr         = DB::table('roles')->select('role_name', 'id')->where('id','=',2)->orWhere('id','=',1)->where('is_active','0')->orderby('id','asc')->get();
        }else if(Auth::user()->role_id == 2){
            $responseObjArr         = DB::table('roles')->select('role_name', 'id')->where('id','!=',1)->where('id','!=',3)->where('is_active','0')->orderby('id','asc')->get();
        }else{
            $responseObjArr         = DB::table('roles')->select('role_name', 'id')->where('id','2')->where('is_active','0')->orderby('id','asc')->get();
        }
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->role_name;

        }
        return $responseArr;
    }
    public static function getRoleListForBranchAdmin($role_id = 0) {
        $response               = '';
        if(Auth::user()->role_id == 2){
            $responseObjArr         = DB::table('roles')->select('role_name', 'id')->where('id','3')->where('is_active','0')->orderby('id','asc')->get();
        }
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->role_name;

        }
        return $responseArr;
    }
    public static function getRoleListForLabAdmin($role_id = 0) {
        $response               = '';
        $responseObjArr         = DB::table('roles')->select('role_name', 'id')->where('id','!=',1)->where('id','!=',2)->where('id','!=',3)->where('is_active','0')->orderby('id','asc')->get();
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->role_name;

        }
        return $responseArr;
    }
    public static function getDisplayFieldName($id = 0, $table_name = '', $fieldArr = array()){
        $response      = '';
        $dbResponseObj = '';
        if ((int) $id) {
            $responseObj = DB::table("$table_name")
                ->where("$table_name.id", '=', $id);

            if (is_array($fieldArr) && count($fieldArr) > 0) {
                foreach ($fieldArr as $colKey => $cloName) {
                    $selectArr[] = "$table_name.$cloName";
                }
                $responseObj->select($selectArr);
            }
            $dbResponseObj = $responseObj->first();
        }
        if (is_array($fieldArr) && count($fieldArr) > 0) {
            foreach ($fieldArr as $colKey => $cloName) {
                if (isset($dbResponseObj->$cloName) && $dbResponseObj->$cloName != '') {
                    $response .= $dbResponseObj->$cloName;
                }
            }
        }
        return $response;
    }
    public static function date2DB($dt = null, $separator = '-') {
        if ($dt) {
            $dateArray = explode($separator, $dt);
            if (count($dateArray) >= 1) {
                $formatedDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
                return $formatedDate;
            } else {
                return '0000-00-00';
            }
        } else {
            return '0000-00-00';
        }
    }
    public static function DB2Date($dt = null, $separator = '-') {
        if ($dt && $dt != '' && $dt != '0000-00-00') {
            $dateArray = explode($separator, $dt);
            if (count($dateArray) > 1) {
                $formatedDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
                return $formatedDate;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
    public static function getMasterID($id = 0, $table_name = '', $col_name = ''){
        $response      = '';
        $dbResponseObj = '';
        if ((int) $id) {
            $responseObj = DB::table("$table_name")
                ->select("$table_name.$col_name")
                ->where("$table_name.id", '=', $id)
                ->first();
        }
        if (isset($responseObj) && is_object($responseObj)) {
            if (isset($responseObj->$col_name) && $responseObj->$col_name != '') {
                $response = $responseObj->$col_name;
            }
        }
        return $response;
    }
     
    public static function getUserName($id) {
        $response = '';
        $userObj = DB::table('users')
                ->where('users.id', '=', $id)
                ->select(array(
                    'users.fullname',
                        )
                )
                ->first();
        if (isset($userObj->fullname) && $userObj->fullname != '') {
            $response = $userObj->fullname;
        }
        return $response;
    }
    public static function getOrganizationIdByBranchId($id) {
        $response = '';
        $userObj = DB::table('t_branch_details')
                ->where('t_branch_details.id', '=', $id)
                ->select(array(
                    't_branch_details.t_organizations_id',
                        )
                )
                ->first();
        if (isset($userObj->t_organizations_id) && $userObj->t_organizations_id != '') {
            $response = $userObj->t_organizations_id;
        }
        return $response;
    }
    public static function getOrganizationIdByLabId($id) {
        $response = '';
        $userObj = DB::table('t_business_logistic_dtls')
                ->where('t_business_logistic_dtls.id', '=', $id)
                ->select(array(
                    't_business_logistic_dtls.t_organizations_id',
                        )
                )
                ->first();
        if (isset($userObj->t_organizations_id) && $userObj->t_organizations_id != '') {
            $response = $userObj->t_organizations_id;
        }
        return $response;
    }
    public static function getBranchIdByLabId($id) {
        $response = 0;
        $userObj = DB::table('t_business_logistic_dtls')
                ->where('t_business_logistic_dtls.id', '=', $id)
                ->select(array(
                    't_business_logistic_dtls.t_branch_details_id',
                        )
                )
                ->first();
        if (isset($userObj->t_branch_details_id) && $userObj->t_branch_details_id != '') {
            $response = $userObj->t_branch_details_id;
        }
        return $response;
    }
    public static function getCityNameById($id) {
        $response = '';
        $userObj = DB::table('t_cities')
                ->where('t_cities.id', '=', $id)
                ->select(array(
                    't_cities.city_name',
                        )
                )
                ->first();
        if (isset($userObj->city_name) && $userObj->city_name != '') {
            $response = $userObj->city_name;
        }
        return $response;
    }
    public static function getOrganizationNameById($id) {
        $response = '';
        $userObj = DB::table('t_organizations')
                ->where('t_organizations.id', '=', $id)
                ->select(array(
                    't_organizations.organization_name',
                        )
                )
                ->first();
        if (isset($userObj->organization_name) && $userObj->organization_name != '') {
            $response = $userObj->organization_name;
        }
        return $response;
    }
    public static function getDesignationName($id) {
        $response = '';
        $userObj = DB::table('t_designation')
                ->where('t_designation.id', '=', $id)
                ->select(array(
                    't_designation.designation_name',
                        )
                )
                ->first();
        if (isset($userObj->designation_name) && $userObj->designation_name != '') {
            $response = $userObj->designation_name;
        }
        return $response;
    }
    public static function getDepartmentName($id) {
        $response = '';
        $userObj = DB::table('t_department')
                ->where('t_department.id', '=', $id)
                ->select(array(
                    't_department.department_name',
                        )
                )
                ->first();
        if (isset($userObj->department_name) && $userObj->department_name != '') {
            $response = $userObj->department_name;
        }
        return $response;
    }
    public static function getPackagesList(){
	$packageArr                 =   array();
        $dbResArr		    =   DB::table('t_features')
                                        ->orderBy('t_features.id','asc')
                                        ->where('t_features.status','=','Y')
                                        ->pluck('feature_name','id');

            if(count($dbResArr) > 0){
                    $packageArr	=	$dbResArr;
            }
            return $packageArr;
    }
    public static function getOrgTakenPackagesList(){
	$packageArr                 =   array();
        $dbResArr		    =   DB::table('t_features_details')
                                        ->join('t_features','t_features_details.t_features_id','=','t_features.id')
                                        ->select(array('t_features.id','t_features.feature_name','t_features_details.t_features_id','t_features_details.status'))
                                        ->where('t_features_details.status','=','Y')
                                        ->where('t_features_details.t_organizations_id','=',Auth::user()->t_organizations_id)
                                        ->groupby('t_features_details.t_features_id')
                                        ->pluck('feature_name','id');

            if(count($dbResArr) > 0){
                    $packageArr	=	$dbResArr;
            }
            return $packageArr;
    }
}
