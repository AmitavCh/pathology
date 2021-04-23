<?php 
//Developer: Amitav
//Contact: amitavc65@gmail.com / 8917406257
?>
<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Hash;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use Redirect;
use Validator;
use App\Models\TBranchDetails;
use App\Models\TBusinessLogisticDtls;

class BranchController extends Controller{
    public function addRegionalBranch($id=0){
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $branch_name                                                            = '';
        $t_cities_id                                                            = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $stateArr                                                               = Controller::getMasterLists('t_states', 'state_name');
        $orgArr                                                                 = Controller::getOrganizationLists('t_organizations','organization_name');
        if($id){
            $viewDataObj                                                        = DB::table('t_branch_details')
                                                                                ->where('t_branch_details.id', '=',$id)
                                                                                ->select(array('t_branch_details.id',
                                                                                               't_branch_details.branch_name',
                                                                                               't_branch_details.mobile_number',
                                                                                               't_branch_details.other_mobile_number',
                                                                                               't_branch_details.email_id',
                                                                                               't_branch_details.t_organizations_id',
                                                                                               't_branch_details.t_states_id',
                                                                                               't_branch_details.t_cities_id',
                                                                                               't_branch_details.pin_code',
                                                                                               't_branch_details.logo',
                                                                                               't_branch_details.status',
                                                                                            )
                                                                                        )
                                                                                ->first();
            if(isset($viewDataObj->t_cities_id) ){
                $t_cities_id                                                    = $viewDataObj->t_cities_id;
            }
            $viewDataObjs                                                       = DB::table('t_branch_details')
                                                                                ->where('t_branch_details.id', '=',$id)
                                                                                ->select(array('t_branch_details.address'))
                                                                                ->first();
        }
        $branch_name                                                            = Input::get('search_branch_name');
        $dbObj                                                                  = DB::table('t_branch_details')
                                                                                ->where('t_branch_details.t_organizations_id','=',Auth::user()->t_organizations_id)
                                                                                ->orderby('t_branch_details.id','desc');
        if(isset($branch_name ) && $branch_name  != ''){
            $dbObj->where('t_branch_details.branch_name','LIKE',"$branch_name%");
        }
        if (isset($inputArr['reqType']) && $inputArr['reqType'] != '') {
            $reqType                                                            = $inputArr['reqType'];
        }
        $custompaginatorres = $dbObj->paginate('5');
        $layoutArr = [
                        'viewDataObj'           => $viewDataObj,
                        'stateArr'              => $stateArr,
                        'orgArr'                => $orgArr,
                        't_cities_id'           => $t_cities_id,
                        'viewDataObjs'          => $viewDataObjs,
                        'sortFilterArr'         => ['branch_name'    => $branch_name,'reqType' => $reqType],
                        'custompaginatorres'    => $custompaginatorres,
                    ];
        return view('branch.add_regional_branch',['layoutArr' => $layoutArr,'id'=>$id]);
    }
    public function addRegionalBranchData($id=0){
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $viewDataObj1                                                           = "";
        $reqType                                                                = '';
        $branch_name                                                            = '';
        $t_cities_id                                                            = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $stateArr                                                               = Controller::getMasterLists('t_states', 'state_name');
        $orgArr                                                                 = Controller::getOrganizationLists('t_organizations','organization_name');
        if($id){
            $viewDataObj                                                        = DB::table('t_branch_details')
                                                                                ->where('t_branch_details.id', '=',$id)
                                                                                ->select(array('t_branch_details.id',
                                                                                               't_branch_details.branch_name',
                                                                                               't_branch_details.mobile_number',
                                                                                               't_branch_details.other_mobile_number',
                                                                                               't_branch_details.email_id',
                                                                                               't_branch_details.t_organizations_id',
                                                                                               't_branch_details.t_states_id',
                                                                                               't_branch_details.t_cities_id',
                                                                                               't_branch_details.pin_code',
                                                                                               't_branch_details.logo',
                                                                                               't_branch_details.status',
                                                                                            )
                                                                                        )
                                                                                ->first();
            if(isset($viewDataObj->t_cities_id) ){
                $t_cities_id                                                    = $viewDataObj->t_cities_id;
            }
            $viewDataObjs                                                       = DB::table('t_branch_details')
                                                                                ->where('t_branch_details.id', '=',$id)
                                                                                ->select(array('t_branch_details.address'))
                                                                                ->first();
            $viewDataObj1                                                       = DB::table('t_features_details')
                                                                                ->where('t_features_details.t_branch_details_id','=',$id)
                                                                                ->leftjoin('t_features','t_features_details.t_features_id','=','t_features.id')
                                                                                ->select(array('t_features.id','t_features.feature_name'))
                                                                                ->pluck('id')->toArray();
        }
        $packagesArr                                                            = Controller::getOrgTakenPackagesList();
        $branch_name                                                            = Input::get('search_branch_name');
        $dbObj                                                                  = DB::table('t_branch_details')
                                                                                ->orderby('t_branch_details.id','desc');
        if(isset($branch_name ) && $branch_name  != ''){
            $dbObj->where('t_branch_details.branch_name','LIKE',"$branch_name%");
        }
        if (isset($inputArr['reqType']) && $inputArr['reqType'] != '') {
            $reqType                                                            = $inputArr['reqType'];
        }
        $custompaginatorres = $dbObj->paginate('5');
        $layoutArr = [
                        'viewDataObj'           => $viewDataObj,
                        'viewDataObj1'           => $viewDataObj1,
                        'stateArr'              => $stateArr,
                        'packagesArr'           => $packagesArr,
                        'orgArr'                => $orgArr,
                        't_cities_id'           => $t_cities_id,
                        'viewDataObjs'          => $viewDataObjs,
                        'sortFilterArr'         => ['branch_name'    => $branch_name,'reqType' => $reqType],
                        'custompaginatorres'    => $custompaginatorres,
                    ];
        return view('branch.add_regional_branch_data',['layoutArr' => $layoutArr,'id'=>$id]);
    }
    public function validateRegionalBranch() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['TBranchDetails']) && is_array($formValArr['TBranchDetails']) && count($formValArr['TBranchDetails']) > 0) {
                $validator = Validator::make($formValArr['TBranchDetails'], TBranchDetails::$rules, TBranchDetails::$messages);
                if ($validator->fails()) {
                    $errorArr = $validator->getMessageBag()->toArray();
                    if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                        foreach ($errorArr as $errorKey => $errorVal) {
                            $valiationArr[] = array(
                                'modelField' => $errorKey,
                                'modelErrorMsg' => $errorVal[0],
                            );
                        }
                    }
                    echo '****FAILURE****' . json_encode($valiationArr);
                    exit;
                } else {
                    echo '****SUCCESS****Successfully Validated.';
                }
            }
        }exit;
    }
    public function saveRegionalBranch(Request $request) {
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['TBranchDetails']) && $formData['TBranchDetails'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                $id = (int) $formData['TBranchDetails']['id'];
                if (isset($formData['TBranchDetails']['t_organizations_id']) && $formData['TBranchDetails']['t_organizations_id'] != '') {
                    $t_organizations_id                                         = $formData['TBranchDetails']['t_organizations_id'];
                } else {
                    $t_organizations_id                                         = '';
                }
                if (isset($formData['TBranchDetails']['email_id']) && $formData['TBranchDetails']['email_id'] != '') {
                    $email_id                                                   = $formData['TBranchDetails']['email_id'];
                } else {
                    $email_id                                                   = '';
                }
                if (isset($formData['TBranchDetails']['mobile_number']) && $formData['TBranchDetails']['mobile_number'] != '') {
                    $mobile_number                                              = $formData['TBranchDetails']['mobile_number'];
                } else {
                    $mobile_number                                              = '';
                }
                if (isset($formData['TBranchDetails']['other_mobile_number']) && $formData['TBranchDetails']['other_mobile_number'] != '') {
                    $other_mobile_number                                        = $formData['TBranchDetails']['other_mobile_number'];
                } else {
                    $other_mobile_number                                        = '';
                }
                if (isset($formData['TBranchDetails']['address']) && $formData['TBranchDetails']['address'] != '') {
                    $address                                                    = $formData['TBranchDetails']['address'];
                } else {
                    $address                                                    = '';
                }
                if (isset($formData['TBranchDetails']['branch_name']) && $formData['TBranchDetails']['branch_name'] != '') {
                    $branch_name                                                = $formData['TBranchDetails']['branch_name'];
                } else {
                    $branch_name                                                = '';
                }
                if (isset($formData['TBranchDetails']['t_states_id']) && $formData['TBranchDetails']['t_states_id'] != '') {
                    $t_states_id                                                = $formData['TBranchDetails']['t_states_id'];
                } else {
                    $t_states_id                                                = '';
                }
                if (isset($formData['TBranchDetails']['t_cities_id']) && $formData['TBranchDetails']['t_cities_id'] != '') {
                    $t_cities_id                                                = $formData['TBranchDetails']['t_cities_id'];
                } else {
                    $t_cities_id                                                = '';
                }
                if (isset($formData['TBranchDetails']['pin_code']) && $formData['TBranchDetails']['pin_code'] != '') {
                    $pin_code                                                   = $formData['TBranchDetails']['pin_code'];
                } else {
                    $pin_code                                                   = '';
                }
                //echo'<pre>';print_r($formData);echo'</pre>';exit;
                if(isset($formData['t_features_id']) && is_array($formData['t_features_id']) && count($formData['t_features_id']) > 0){
                    if (isset($id) && $id != 0) {
                        $tableObjCnt = DB::table('t_branch_details')
                                ->where('branch_name', '=', $branch_name)
                                ->where('id', '!=', $id)
                                ->count();
                        if ($tableObjCnt == 0) {
                            //for fetch image file exist or not
                            $tableObjCnt2 = DB::table('t_branch_details')
                                    ->where('logo', '!=', '')
                                    ->where('id', '=', $id);
                            $tableObjCnt3 = $tableObjCnt2->count();
                            $tableObjCnt4 = $tableObjCnt2->first();
                            $image = $request->file('image');
                            if ($tableObjCnt3 > 0) {
                                $photoName = $tableObjCnt4->logo;
                            } else {
                                $photoName = '';
                            }
                            //

                            if ($image != '') {
                                $image_name = $image->getClientOriginalName();
                                $fileExt = $image->getClientOriginalExtension();
                                $fileSize = $image->getSize();
                                $photo_download_name = uniqid() . '_' . time() . '.' . $fileExt;
                                $orig_file_path = public_path() . "/files/orig";
                                $thumb_file_path = public_path() . "/files/thumb";
                                if (isset(Auth::user()->id)) {
                                    $photoName = Auth::user()->id . '_' . uniqid() . '.' . $fileExt;
                                } else {
                                    $photoName = uniqid() . '.' . $fileExt;
                                }
                                $upload_success = $image->move($orig_file_path, $photoName, 100, 100);
                            }

                            try {
                                $loopCnt++;
                                $formCDataArr['TBranchDetails']['branch_name']           = strtoupper($branch_name);
                                $formCDataArr['TBranchDetails']['t_organizations_id']    = $t_organizations_id;
                                $formCDataArr['TBranchDetails']['t_states_id']           = $t_states_id;
                                $formCDataArr['TBranchDetails']['pin_code']              = $pin_code;
                                $formCDataArr['TBranchDetails']['t_cities_id']           = $t_cities_id;
                                $formCDataArr['TBranchDetails']['email_id']              = $email_id;
                                $formCDataArr['TBranchDetails']['mobile_number']         = $mobile_number;
                                $formCDataArr['TBranchDetails']['other_mobile_number']   = $other_mobile_number;
                                $formCDataArr['TBranchDetails']['address']               = $address;
                                $formCDataArr['TBranchDetails']['logo']                  = $photoName;
                                $formCDataArr['TBranchDetails']['updated_at']            = date('Y-m-d h:i:s');
                                //echo'<pre>';print_r($formCDataArr);echo'</pre>';exit;
                                DB::table('t_branch_details')
                                        ->where('id', $id)
                                        ->update($formCDataArr['TBranchDetails']);
                                DB::commit();
                                $saveCnt++;
                            } catch (ValidationException $e) {
                                DB::rollback();
                            } catch (\Exception $e) {
                                DB::rollback();
                            }
                            if (DB::table('t_features_details')
                                ->where('t_branch_details_id','=',$id)
                                ->count()) 
                            {
                                try {
                                    $loopCnt++;
                                    DB::table('t_features_details')->where('t_branch_details_id','=',$id)->delete();
                                    $saveCnt++;
                                } catch (ValidationException $e) {

                                } catch (\Exception $e) {

                                }
                            }
                            // get feature details of organization by branch id
                            $t_organizations_id        =    Controller::getOrganizationIdByBranchId($id);
                            foreach($formData['t_features_id'] as $key=>$val){
                                $tableFeaObjCnt    = DB::table('t_features_details')
                                                        ->where('t_features_details.t_organizations_id','=',$t_organizations_id)
                                                        ->where('t_features_details.t_features_id','=',$val)
                                                        ->where('t_features_details.status', '=', 'Y')
                                                        ->get();
                                foreach($tableFeaObjCnt as $keys=>$vals){
                                    try {
                                        $loopCnt++;
                                        $formCDataArr['TFeaturesDetails']['t_organizations_id']    = $t_organizations_id;
                                        $formCDataArr['TFeaturesDetails']['t_branch_details_id']   = $id;
                                        $formCDataArr['TFeaturesDetails']['t_features_id']         = $val;
                                        $formCDataArr['TFeaturesDetails']['menu_id']               = $vals->menu_id;
                                        $formCDataArr['TFeaturesDetails']['sub_menu_id']           = $vals->sub_menu_id;
                                        $formCDataArr['TFeaturesDetails']['status']                = "Y";
                                        $formCDataArr['TFeaturesDetails']['created_at']            = date('Y-m-d h:i:s');
                                        $formCDataArr['TFeaturesDetails']['updated_at']            = date('Y-m-d h:i:s');
                                        DB::table('t_features_details')->insert($formCDataArr['TFeaturesDetails']);
                                        $saveCnt++;
                                    } catch (ValidationException $e) {
                                        DB::rollback();
                                    } catch (\Exception $e) {
                                        DB::rollback();
                                    }
                                }
                            }
                            //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                            if ($loopCnt == $saveCnt) {
                                DB::commit();
                                return Redirect::to('/branch/add_regional_branch_data')->with('message', 'Data update successfully!');
                            } else {
                                DB::rollback();
                                return Redirect::to('/branch/add_regional_branch_data')->with('error', 'Unable save Data');
                            }
                        } else {
                            DB::rollback();
                            return Redirect::to('/branch/add_regional_branch_data')->with('error', ' Data Already Exist');
                        }
                    } else {
                        //count number_of_branch value of organization & match with number of account created
                        $masterBranchLimit    = DB::table('t_organizations')
                                                    ->where('t_organizations.id','=',$t_organizations_id)
                                                    ->where('status','=','Y')
                                                    ->first();
                        if (isset($masterBranchLimit->number_of_branch) && $masterBranchLimit->number_of_branch != '') {
                            $number_of_branch = $masterBranchLimit->number_of_branch;
                        }
                        $masterBranchCnt  = DB::table('t_branch_details')
                                            ->where('t_branch_details.t_organizations_id','=',$t_organizations_id)
                                            ->where('status','=',"Y")
                                            ->count();
                        //end 
                        if($masterBranchCnt < $number_of_branch){
                        $image = $request->file('image');
                        $photoName = '';
                        if ($image != '') {
                            $image_name = $image->getClientOriginalName();
                            $fileExt = $image->getClientOriginalExtension();
                            $fileSize = $image->getSize();
                            $photo_download_name = uniqid() . '_' . time() . '.' . $fileExt;
                            $orig_file_path = public_path() . "/files/orig";
                            $thumb_file_path = public_path() . "/files/thumb";
                            if (isset(Auth::user()->id)) {
                                $photoName = Auth::user()->id . '_' . uniqid() . '.' . $fileExt;
                            } else {
                                $photoName = uniqid() . '.' . $fileExt;
                            }
                            $upload_success = $image->move($orig_file_path, $photoName, 100, 100);
                        }
                        $dataObj                                                    =   DB::table('t_branch_details')
                                                                                        ->select(array('t_branch_details.branch_code'))
                                                                                        ->orderBy('t_branch_details.id','desc')
                                                                                        ->first();
                        $temp_org_name                                              =  Controller::getOrganizationNameById($t_organizations_id);
                        $result_org_name                                            =  substr($temp_org_name, 0, 3);
                        $result_branch_name                                         =  substr($branch_name, 0, 3);
                        if($dataObj != ''){
                            if(is_object($dataObj)){
                                $temp_branch_code                                   =   substr($dataObj->branch_code,8);
                                $temp_branch_new_code                               =   $temp_branch_code+1;
                                $branch_code                                        =   $result_branch_name."/".$result_org_name."/".$temp_branch_new_code;
                            }
                        }else{
                                $branch_code                                        =   $result_branch_name."/".$result_org_name."/"."1";
                        }      
                        $tableObjCnt = DB::table('t_branch_details')
                                ->where('branch_name', '=', $branch_name)
                                ->where('status', '=', 'Y')
                                ->count();
                        if ($tableObjCnt == 0) {

                            try {
                                $loopCnt++;
                                $formCDataArr['TBranchDetails']['branch_name']           = strtoupper($branch_name);
                                $formCDataArr['TBranchDetails']['t_organizations_id']    = $t_organizations_id;
                                $formCDataArr['TBranchDetails']['t_states_id']           = $t_states_id;
                                $formCDataArr['TBranchDetails']['branch_code']           = strtoupper($branch_code);
                                $formCDataArr['TBranchDetails']['pin_code']              = $pin_code;
                                $formCDataArr['TBranchDetails']['t_cities_id']           = $t_cities_id;
                                $formCDataArr['TBranchDetails']['email_id']              = $email_id;
                                $formCDataArr['TBranchDetails']['mobile_number']         = $mobile_number;
                                $formCDataArr['TBranchDetails']['other_mobile_number']   = $other_mobile_number;
                                $formCDataArr['TBranchDetails']['address']               = $address;
                                $formCDataArr['TBranchDetails']['logo']                  = $photoName;
                                $formCDataArr['TBranchDetails']['status']                = "Y";
                                $formCDataArr['TBranchDetails']['created_by']            = Auth::user()->id;
                                $formCDataArr['TBranchDetails']['created_at']            = date('Y-m-d h:i:s');
                                $formCDataArr['TBranchDetails']['updated_at']            = date('Y-m-d h:i:s');
                                DB::table('t_branch_details')->insert($formCDataArr['TBranchDetails']);
                                $saveCnt++;
                            } catch (ValidationException $e) {
                                DB::rollback();
                            } catch (\Exception $e) {
                                DB::rollback();
                            }
                            // get feature details of organization by branch id
                            $t_organizations_id        =    Controller::getOrganizationIdByBranchId($id);
                            foreach($formData['t_features_id'] as $key=>$val){
                                $tableFeaObjCnt    = DB::table('t_features_details')
                                                        ->where('t_features_details.t_organizations_id','=',$t_organizations_id)
                                                        ->where('t_features_details.t_features_id','=',$val)
                                                        ->where('t_features_details.status', '=', 'Y')
                                                        ->get();
                                foreach($tableFeaObjCnt as $keys=>$vals){
                                    try {
                                        $loopCnt++;
                                        $formCDataArr['TFeaturesDetails']['t_organizations_id']    = $t_organizations_id;
                                        $formCDataArr['TFeaturesDetails']['t_branch_details_id']   = $id;
                                        $formCDataArr['TFeaturesDetails']['t_features_id']         = $val;
                                        $formCDataArr['TFeaturesDetails']['menu_id']               = $vals->menu_id;
                                        $formCDataArr['TFeaturesDetails']['sub_menu_id']           = $vals->sub_menu_id;
                                        $formCDataArr['TFeaturesDetails']['status']                = "Y";
                                        $formCDataArr['TFeaturesDetails']['created_at']            = date('Y-m-d h:i:s');
                                        $formCDataArr['TFeaturesDetails']['updated_at']            = date('Y-m-d h:i:s');
                                        DB::table('t_features_details')->insert($formCDataArr['TFeaturesDetails']);
                                        $saveCnt++;
                                    } catch (ValidationException $e) {
                                        DB::rollback();
                                    } catch (\Exception $e) {
                                        DB::rollback();
                                    }
                                }
                            }
                            //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                            if ($loopCnt == $saveCnt) {
                                DB::commit();
                                return Redirect::to('/branch/add_regional_branch_data')->with('message', 'Data saved successfully!');
                            } else {
                                DB::rollback();
                                return Redirect::to('/branch/add_regional_branch_data')->with('error', 'Unable save Data');
                            }
                        } else {
                            DB::rollback();
                            return Redirect::to('/branch/add_regional_branch_data')->with('error', 'Data Already Exist');
                        }
                        }else{
                            return Redirect::to('/branch/add_regional_branch_data')->with('error', 'Number Of Branches(LIMIT) Exceed Contact to Super Admin'); 
                        }
                    }
                }else{
                    return Redirect::to('/branch/add_regional_branch_data')->with('error', 'Please Select One Package Details');
                }
            } else {
                return Redirect::to('/branch/add_regional_branch_data')->with('error', 'Invalid form submission');
            }
        } else {
            return Redirect::to('/user/login')->with('error', 'Please login to register');
        }exit;
    }
    public function regionalBranchActive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['TBranchDetails']['status']     = "Y";
                $formCDataArr['TBranchDetails']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_branch_details')
                    ->where('id', $id)
                    ->update($formCDataArr['TBranchDetails']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****Data has been Active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }
    public function regionalBranchDeactive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['TBranchDetails']['status']     = "N";
                $formDataArr['TBranchDetails']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_branch_details')
                    ->where('id', $id)
                    ->update($formDataArr['TBranchDetails']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****Data has been In-active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }
   
    public function createBranchUser($id = 0) {
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $user_name = Input::get('search_user_name');
        if(Auth::user()->role_id == 1){
            $dbObj = DB::table('users')
             ->orderby('users.id', 'desc'); 
        }else{
            $dbObj = DB::table('users')
             ->where('users.t_organizations_id','=',Auth::user()->t_organizations_id)
             ->where('users.t_branch_details_id','!=',0)   
             ->orderby('users.id', 'desc');
        }
        if (isset($inputArr['reqType']) && $inputArr['reqType'] != '') {
            $reqType = $inputArr['reqType'];
        }
        $custompaginatorres = $dbObj->paginate('5');
        $layoutArr = [
            'viewDataObj'       => $viewDataObj,
            'viewDataObjs'       => $viewDataObjs,
            'sortFilterArr'     => ['user_name' => $user_name, 'reqType' => $reqType],
            'custompaginatorres'=> $custompaginatorres,
        ];
        return view('branch.create_branch_user', ['layoutArr' => $layoutArr]);
    }
    public function createBranchUserData($id = 0) {
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $roleArr                                                                = Controller::getRoleListForBranchAdmin('roles','role_name');
        $branchArr                                                              = Controller::getBranchLists('t_branch_details','branch_name');
        if ($id) {
            $viewDataObj        =   DB::table('users')
                                    ->where('users.id', '=',$id)
                                    ->select(array(
                                                'users.id',
                                                'users.role_id',
                                                'users.t_organizations_id',
                                                'users.t_branch_details_id',
                                                'users.full_name',
                                                'users.email_id',
                                                'users.ogr_password',
                                                'users.user_photo',
                                                'users.mobile_number',
                                                'users.status',
                                                'users.alter_mobile_number',
                                                'users.adhar_number',
                                                )
                                            )    
                                    ->first();
            $viewDataObjs       =   DB::table('users')
                                    ->where('users.id', '=',$id)
                                    ->select(array('users.address'))
                                    ->first();
        }
        $layoutArr = [
            'viewDataObj'        => $viewDataObj,
            'viewDataObjs'       => $viewDataObjs,
            'roleArr'            => $roleArr,
            'branchArr'          => $branchArr,
            'sortFilterArr'      => ['reqType' => $reqType],
        ];
        return view('branch.create_branch_user_data', ['layoutArr' => $layoutArr]);
    }
    public function validateBranchUserDetails() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['User']) && is_array($formValArr['User']) && count($formValArr['User']) > 0) {
                $validator = Validator::make($formValArr['User'], User::$rules['branch'], User::$messages);
                if ($validator->fails()) {
                    $errorArr = $validator->getMessageBag()->toArray();
                    if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                        foreach ($errorArr as $errorKey => $errorVal) {
                            $valiationArr[] = array(
                                'modelField' => $errorKey,
                                'modelErrorMsg' => $errorVal[0],
                            );
                        }
                    }
                    echo '****FAILURE****' . json_encode($valiationArr);
                    exit;
                } else {
                    echo '****SUCCESS****Successfully Validated.';
                }
            }
        }exit;
    }
    public function validateBranchUserDetailss() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['User']) && is_array($formValArr['User']) && count($formValArr['User']) > 0) {
                $validator = Validator::make($formValArr['User'], User::$rules['branchupdate'], User::$messages);
                if ($validator->fails()) {
                    $errorArr = $validator->getMessageBag()->toArray();
                    if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                        foreach ($errorArr as $errorKey => $errorVal) {
                            $valiationArr[] = array(
                                'modelField' => $errorKey,
                                'modelErrorMsg' => $errorVal[0],
                            );
                        }
                    }
                    echo '****FAILURE****' . json_encode($valiationArr);
                    exit;
                } else {
                    echo '****SUCCESS****Successfully Validated.';
                }
            }
        }exit;
    }
    public function branchUserDetailsActive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['User']['status'] = 0;
                $formCDataArr['User']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('users')
                    ->where('id', $id)
                    ->update($formCDataArr['User']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****User has been Active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }
    public function branchUserDetailsDeactive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['User']['status'] = 1;
                $formDataArr['User']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('users')
                    ->where('id', $id)
                    ->update($formDataArr['User']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****User has been In-active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }
    public function saveBranchUserDetails(Request $request) {
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['User']) && $formData['User'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                $id = (int) $formData['User']['id'];
                if (isset($formData['User']['t_branch_details_id']) && $formData['User']['t_branch_details_id'] != '') {
                    $t_branch_details_id                                        = $formData['User']['t_branch_details_id'];
                    $t_organizations_id                                         = Controller::getOrganizationIdByBranchId($formData['User']['t_branch_details_id']);
                } else {
                    $t_branch_details_id                                        = '';
                    $t_organizations_id                                         = '';
                }
                if (isset($formData['User']['full_name']) && $formData['User']['full_name'] != '') {
                    $full_name                                                  = $formData['User']['full_name'];
                } else {
                    $full_name                                                  = '';
                }
                if (isset($formData['User']['ogr_password']) && $formData['User']['ogr_password'] != '') {
                    $password                                                   = $formData['User']['ogr_password'];
                } else {
                    $password                                                   = '';
                }
                if (isset($formData['User']['email_id']) && $formData['User']['email_id'] != '') {
                    $email_id                                                   = $formData['User']['email_id'];
                } else {
                    $email_id                                                   = '';
                }
                if (isset($formData['User']['mobile_number']) && $formData['User']['mobile_number'] != '') {
                    $mobile_number                                              = $formData['User']['mobile_number'];
                } else {
                    $mobile_number                                              = '';
                }
                if (isset($formData['User']['adhar_number']) && $formData['User']['adhar_number'] != '') {
                    $adhar_number                                               = $formData['User']['adhar_number'];
                } else {
                    $adhar_number                                               = '';
                }
                if (isset($formData['User']['alter_mobile_number']) && $formData['User']['alter_mobile_number'] != '') {
                    $alter_mobile_number                                        = $formData['User']['alter_mobile_number'];
                } else {
                    $alter_mobile_number                                        = '';
                }
                if (isset($formData['User']['address']) && $formData['User']['address'] != '') {
                    $address                                                    = $formData['User']['address'];
                } else {
                    $address                                                    = '';
                }
                if (isset($formData['User']['role_id']) && $formData['User']['role_id'] != '') {
                    $role_id                                                    = $formData['User']['role_id'];
                } else {
                    $role_id                                                    = '';
                }
                
                if (isset($id) && $id != 0) {
                    $tableObjCnt = DB::table('users')
                            ->where('full_name', '=', $full_name)
                            ->where('mobile_number', '=', $mobile_number)
                            ->where('id', '!=', $id)
                            ->count();
                    if ($tableObjCnt == 0) {
                        //for fetch image file exist or not
                        $tableObjCnt2 = DB::table('users')
                                ->where('user_photo', '!=', '')
                                ->where('id', '=', $id);
                        $tableObjCnt3 = $tableObjCnt2->count();
                        $tableObjCnt4 = $tableObjCnt2->first();
                        $image = $request->file('image');
                        if ($tableObjCnt3 > 0) {
                            $photoName = $tableObjCnt4->user_photo;
                        } else {
                            $photoName = '';
                        }
                        //
                        
                        if ($image != '') {
                            $image_name = $image->getClientOriginalName();
                            $fileExt = $image->getClientOriginalExtension();
                            $fileSize = $image->getSize();
                            $photo_download_name = uniqid() . '_' . time() . '.' . $fileExt;
                            $orig_file_path = public_path() . "/files/orig";
                            $thumb_file_path = public_path() . "/files/thumb";
                            if (isset(Auth::user()->id)) {
                                $photoName = Auth::user()->id . '_' . uniqid() . '.' . $fileExt;
                            } else {
                                $photoName = uniqid() . '.' . $fileExt;
                            }
                            $upload_success = $image->move($orig_file_path, $photoName, 100, 100);
                        }
                        
                        try {
                            $loopCnt++;
                            $formCDataArr['User']['role_id']                    = $role_id;
                            $formCDataArr['User']['t_organizations_id']         = $t_organizations_id;
                            $formCDataArr['User']['t_branch_details_id']        = $t_branch_details_id;
                            $formCDataArr['User']['t_business_logistic_dtl_id'] = 0;
                            $formCDataArr['User']['full_name']                  = $full_name;
                            $formCDataArr['User']['alter_mobile_number']        = $alter_mobile_number;
                            $formCDataArr['User']['adhar_number']               = $adhar_number;
                            $formCDataArr['User']['password']                   = Hash::make($password);
                            $formCDataArr['User']['re_password']                = Hash::make($password);
                            $formCDataArr['User']['ogr_password']               = $password;
                            $formCDataArr['User']['email_id']                   = $email_id;
                            $formCDataArr['User']['mobile_number']              = $mobile_number;
                            $formCDataArr['User']['user_photo']                 = $photoName;
                            $formCDataArr['User']['address']                    = $address;
                            $formCDataArr['User']['remember_token']             = csrf_token();
                            $formCDataArr['User']['updated_at']                 = date('Y-m-d h:i:s');
                            //echo'<pre>';print_r($formCDataArr);echo'</pre>';exit;
                            DB::table('users')
                                    ->where('id', $id)
                                    ->update($formCDataArr['User']);
                            DB::commit();
                            $saveCnt++;
                        } catch (ValidationException $e) {
                            DB::rollback();
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
                        //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                        if ($loopCnt == $saveCnt) {
                            DB::commit();
                            return Redirect::to('/branch/create_branch_user_data')->with('message', 'Data update successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/branch/create_branch_user_data')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/branch/create_branch_user_data')->with('error', ' Data Already Exist');
                    }
                } else {

                    $image = $request->file('image');
                    $photoName = '';
                    if ($image != '') {
                        $image_name = $image->getClientOriginalName();
                        $fileExt = $image->getClientOriginalExtension();
                        $fileSize = $image->getSize();
                        $photo_download_name = uniqid() . '_' . time() . '.' . $fileExt;
                        $orig_file_path = public_path() . "/files/orig";
                        $thumb_file_path = public_path() . "/files/thumb";
                        if (isset(Auth::user()->id)) {
                            $photoName = Auth::user()->id . '_' . uniqid() . '.' . $fileExt;
                        } else {
                            $photoName = uniqid() . '.' . $fileExt;
                        }
                        $upload_success = $image->move($orig_file_path, $photoName, 100, 100);
                    }
                    
                    $tableObjCnt = DB::table('users')
                            ->where('full_name', '=', $full_name)
                            ->where('mobile_number', '=', $mobile_number)
                            ->where('status','=',0)
                            ->count();
                        if ($tableObjCnt == 0) {

                            try {
                                $loopCnt++;
                                $formCDataArr['User']['role_id']                    = $role_id;
                                $formCDataArr['User']['t_organizations_id']         = $t_organizations_id;
                                $formCDataArr['User']['t_branch_details_id']        = $t_branch_details_id;
                                $formCDataArr['User']['t_business_logistic_dtl_id'] = 0;
                                $formCDataArr['User']['full_name']                  = $full_name;
                                $formCDataArr['User']['alter_mobile_number']        = $alter_mobile_number;
                                $formCDataArr['User']['adhar_number']               = $adhar_number;
                                $formCDataArr['User']['password']                   = Hash::make($password);
                                $formCDataArr['User']['re_password']                = Hash::make($password);
                                $formCDataArr['User']['ogr_password']               = $password;
                                $formCDataArr['User']['email_id']                   = $email_id;
                                $formCDataArr['User']['mobile_number']              = $mobile_number;
                                $formCDataArr['User']['user_photo']                 = $photoName;
                                $formCDataArr['User']['address']                    = $address;
                                $formCDataArr['User']['remember_token']             = csrf_token();
                                $formCDataArr['User']['status']                     = 0;
                                $formCDataArr['User']['is_reset_req']               = 0;
                                $formCDataArr['User']['created_at']                 = date('Y-m-d h:i:s');
                                $formCDataArr['User']['updated_at']                 = date('Y-m-d h:i:s');
                                DB::table('users')->insert($formCDataArr['User']);
                                $saveCnt++;
                            } catch (ValidationException $e) {
                                DB::rollback();
                            } catch (\Exception $e) {
                                DB::rollback();
                            }
                            //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                            if ($loopCnt == $saveCnt) {
                                DB::commit();
                                return Redirect::to('/branch/create_branch_user_data')->with('message', 'Data saved successfully!');
                            } else {
                                DB::rollback();
                                return Redirect::to('/branch/create_branch_user_data')->with('error', 'Unable save Data');
                            }
                        } else {
                            DB::rollback();
                            return Redirect::to('/branch/create_branch_user_data')->with('error', 'User Data Already Exist');
                        }
                    
                }
            } else {
                return Redirect::to('/branch/create_branch_user_data')->with('error', 'Invalid form submission');
            }
        } else {
            return Redirect::to('/user/login')->with('error', 'Please login to register');
        }exit;
    }

    public function createOrganizationUser(){
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $user_name = Input::get('search_user_name');
        if(Auth::user()->role_id == 1){
            $dbObj = DB::table('users')
             ->orderby('users.id', 'desc'); 
        }else{
            $dbObj = DB::table('users')
             ->where('users.role_id','=',Auth::user()->role_id)->orderby('users.id', 'desc');
        }
        if (isset($inputArr['reqType']) && $inputArr['reqType'] != '') {
            $reqType = $inputArr['reqType'];
        }
        $custompaginatorres = $dbObj->paginate('5');
        $layoutArr = [
            'viewDataObj'       => $viewDataObj,
            'viewDataObjs'       => $viewDataObjs,
            'sortFilterArr'     => ['user_name' => $user_name, 'reqType' => $reqType],
            'custompaginatorres'=> $custompaginatorres,
        ];
        return view('branch.create_organization_user', ['layoutArr' => $layoutArr]);
    }
    public function createOrganizationUserData($id = 0) {
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $roleArr                                                                = Controller::getRoleListForMasterAdmin('roles','role_name');
        $orgArr                                                                 = Controller::getOrganizationLists('t_organizations','organization_name');
        if ($id) {
            $viewDataObj        =   DB::table('users')
                                    ->where('users.id', '=',$id)
                                    ->select(array(
                                                'users.id',
                                                'users.role_id',
                                                'users.t_organizations_id',
                                                'users.t_branch_details_id',
                                                'users.full_name',
                                                'users.email_id',
                                                'users.ogr_password',
                                                'users.user_photo',
                                                'users.mobile_number',
                                                'users.status',
                                                'users.alter_mobile_number',
                                                'users.adhar_number',
                                                )
                                            )    
                                    ->first();
            $viewDataObjs       =   DB::table('users')
                                    ->where('users.id', '=',$id)
                                    ->select(array('users.address'))
                                    ->first();
        }
        $layoutArr = [
            'viewDataObj'       => $viewDataObj,
            'viewDataObjs'       => $viewDataObjs,
            'roleArr'           => $roleArr,
            'orgArr'            => $orgArr,
            'sortFilterArr'     => ['reqType' => $reqType],
        ];
        return view('branch.create_organization_user_data', ['layoutArr' => $layoutArr]);
    }
   
    public function addLabCollectionCenter($id=0){
        $business_logistic_name                                                 = '';
        $business_logistic_name                                                 = Input::get('search_business_logistic_name');
        if(Auth::user()->role_id == 2){
            $dbObj                                                              = DB::table('t_business_logistic_dtls')
                                                                                ->where('t_business_logistic_dtls.t_organizations_id','=',Auth::user()->t_organizations_id)
                                                                                ->where('t_business_logistic_dtls.t_branch_details_id','=',0)
                                                                                ->orderby('t_business_logistic_dtls.id','desc');
        }else{
            $dbObj                                                              = DB::table('t_business_logistic_dtls')
                                                                                ->where('t_business_logistic_dtls.t_organizations_id','=',Auth::user()->t_organizations_id)
                                                                                ->where('t_business_logistic_dtls.t_branch_details_id','=',Auth::user()->t_branch_details_id)
                                                                                ->orderby('t_business_logistic_dtls.id','desc');
        }
        
        if(isset($business_logistic_name ) && $business_logistic_name  != ''){
            $dbObj->where('t_business_logistic_dtls.business_logistic_name','LIKE',"$business_logistic_name%");
        }
        $custompaginatorres = $dbObj->paginate('5');
        $layoutArr = [
                        'sortFilterArr'         => ['business_logistic_name'    => $business_logistic_name],
                        'custompaginatorres'    => $custompaginatorres,
                    ];
        return view('branch.add_lab_collection_center',['layoutArr' => $layoutArr]);
    }
    public function addLabCollectionCenterData($id = 0) {
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $id                                                                     = base64_decode(base64_decode($id));
        //$roleArr                                                                = Controller::getRoleListForLabAdmin('roles','role_name');
        $branchArr                                                              = Controller::getBranchLists('t_branch_details','branch_name');
        if($id){
            $viewDataObj                                                        = DB::table('t_business_logistic_dtls')
                                                                                ->where('t_business_logistic_dtls.id', '=',$id)
                                                                                ->select(array('t_business_logistic_dtls.id',
                                                                                               't_business_logistic_dtls.business_logistic_name',
                                                                                               't_business_logistic_dtls.mobile_number',
                                                                                               't_business_logistic_dtls.other_mobile_number',
                                                                                               't_business_logistic_dtls.email_id',
                                                                                               't_business_logistic_dtls.t_organizations_id',
                                                                                               't_business_logistic_dtls.t_branch_details_id',
                                                                                               't_business_logistic_dtls.business_logistic_code',
                                                                                               't_business_logistic_dtls.logo',
                                                                                               't_business_logistic_dtls.status',
                                                                                            )
                                                                                        )
                                                                                ->first();
            $viewDataObjs                                                       = DB::table('t_business_logistic_dtls')
                                                                                ->where('t_business_logistic_dtls.id', '=',$id)
                                                                                ->select(array('t_business_logistic_dtls.address'))
                                                                                ->first();
        }
        $layoutArr = [
            'viewDataObj'        => $viewDataObj,
            'viewDataObjs'       => $viewDataObjs,
           // 'roleArr'            => $roleArr,
            'branchArr'          => $branchArr,
            'sortFilterArr'      => ['reqType' => $reqType],
        ];
        return view('branch.add_lab_collection_center_data', ['layoutArr' => $layoutArr]);
    }
    public function validateLabCollectionCenter() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['TBusinessLogisticDtls']) && is_array($formValArr['TBusinessLogisticDtls']) && count($formValArr['TBusinessLogisticDtls']) > 0) {
                $validator = Validator::make($formValArr['TBusinessLogisticDtls'], TBusinessLogisticDtls::$rules, User::$messages);
                if ($validator->fails()) {
                    $errorArr = $validator->getMessageBag()->toArray();
                    if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                        foreach ($errorArr as $errorKey => $errorVal) {
                            $valiationArr[] = array(
                                'modelField' => $errorKey,
                                'modelErrorMsg' => $errorVal[0],
                            );
                        }
                    }
                    echo '****FAILURE****' . json_encode($valiationArr);
                    exit;
                } else {
                    echo '****SUCCESS****Successfully Validated.';
                }
            }
        }exit;
    }
    public function saveLabCollectionCenter(Request $request) {
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['TBusinessLogisticDtls']) && $formData['TBusinessLogisticDtls'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                $id = (int) $formData['TBusinessLogisticDtls']['id'];
                if (isset($formData['TBusinessLogisticDtls']['t_branch_details_id']) && $formData['TBusinessLogisticDtls']['t_branch_details_id'] != '') {
                    $t_branch_details_id                                         = $formData['TBusinessLogisticDtls']['t_branch_details_id'];
                } else {
                    $t_branch_details_id                                         = '';
                }
                if (isset($formData['TBusinessLogisticDtls']['email_id']) && $formData['TBusinessLogisticDtls']['email_id'] != '') {
                    $email_id                                                   = $formData['TBusinessLogisticDtls']['email_id'];
                } else {
                    $email_id                                                   = '';
                }
                if (isset($formData['TBusinessLogisticDtls']['mobile_number']) && $formData['TBusinessLogisticDtls']['mobile_number'] != '') {
                    $mobile_number                                              = $formData['TBusinessLogisticDtls']['mobile_number'];
                } else {
                    $mobile_number                                              = '';
                }
                if (isset($formData['TBusinessLogisticDtls']['other_mobile_number']) && $formData['TBusinessLogisticDtls']['other_mobile_number'] != '') {
                    $other_mobile_number                                        = $formData['TBusinessLogisticDtls']['other_mobile_number'];
                } else {
                    $other_mobile_number                                        = '';
                }
                if (isset($formData['TBusinessLogisticDtls']['address']) && $formData['TBusinessLogisticDtls']['address'] != '') {
                    $address                                                    = $formData['TBusinessLogisticDtls']['address'];
                } else {
                    $address                                                    = '';
                }
                if (isset($formData['TBusinessLogisticDtls']['business_logistic_name']) && $formData['TBusinessLogisticDtls']['business_logistic_name'] != '') {
                    $business_logistic_name                                     = $formData['TBusinessLogisticDtls']['business_logistic_name'];
                } else {
                    $business_logistic_name                                     = '';
                }
                //echo'<pre>';print_r($formData);echo'</pre>';exit;
                
                    if (isset($id) && $id != 0) {
                        $tableObjCnt = DB::table('t_business_logistic_dtls')
                                ->where('business_logistic_name','=',$business_logistic_name)
                                ->where('id', '!=', $id)
                                ->count();
                        if ($tableObjCnt == 0) {
                            //for fetch image file exist or not
                            $tableObjCnt2 = DB::table('t_business_logistic_dtls')
                                    ->where('logo', '!=', '')
                                    ->where('id', '=', $id);
                            $tableObjCnt3 = $tableObjCnt2->count();
                            $tableObjCnt4 = $tableObjCnt2->first();
                            $image = $request->file('image');
                            if ($tableObjCnt3 > 0) {
                                $photoName = $tableObjCnt4->logo;
                            } else {
                                $photoName = '';
                            }
                            //

                            if ($image != '') {
                                $image_name = $image->getClientOriginalName();
                                $fileExt = $image->getClientOriginalExtension();
                                $fileSize = $image->getSize();
                                $photo_download_name = uniqid() . '_' . time() . '.' . $fileExt;
                                $orig_file_path = public_path() . "/files/orig";
                                $thumb_file_path = public_path() . "/files/thumb";
                                if (isset(Auth::user()->id)) {
                                    $photoName = Auth::user()->id . '_' . uniqid() . '.' . $fileExt;
                                } else {
                                    $photoName = uniqid() . '.' . $fileExt;
                                }
                                $upload_success = $image->move($orig_file_path, $photoName, 100, 100);
                            }

                            try {
                                $loopCnt++;
                                $formCDataArr['TBusinessLogisticDtls']['business_logistic_name']= strtoupper($business_logistic_name);
                                $formCDataArr['TBusinessLogisticDtls']['t_organizations_id']    = Auth::user()->t_organizations_id;
                                $formCDataArr['TBusinessLogisticDtls']['t_branch_details_id']   = Auth::user()->t_branch_details_id;
                                $formCDataArr['TBusinessLogisticDtls']['email_id']              = $email_id;
                                $formCDataArr['TBusinessLogisticDtls']['mobile_number']         = $mobile_number;
                                $formCDataArr['TBusinessLogisticDtls']['other_mobile_number']   = $other_mobile_number;
                                $formCDataArr['TBusinessLogisticDtls']['address']               = $address;
                                $formCDataArr['TBusinessLogisticDtls']['logo']                  = $photoName;
                                $formCDataArr['TBusinessLogisticDtls']['created_by']            = Auth::user()->id;
                                $formCDataArr['TBusinessLogisticDtls']['updated_at']            = date('Y-m-d h:i:s');
                                //echo'<pre>';print_r($formCDataArr);echo'</pre>';exit;
                                DB::table('t_business_logistic_dtls')
                                        ->where('id', $id)
                                        ->update($formCDataArr['TBusinessLogisticDtls']);
                                DB::commit();
                                $saveCnt++;
                            } catch (ValidationException $e) {
                                DB::rollback();
                            } catch (\Exception $e) {
                                DB::rollback();
                            }
                            //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                            if ($loopCnt == $saveCnt) {
                                DB::commit();
                                return Redirect::to('/branch/add_lab_collection_center_data')->with('message', 'Data update successfully!');
                            } else {
                                DB::rollback();
                                return Redirect::to('/branch/add_lab_collection_center_data')->with('error', 'Unable save Data');
                            }
                        } else {
                            DB::rollback();
                            return Redirect::to('/branch/add_lab_collection_center_data')->with('error', ' Data Already Exist');
                        }
                    } else {
                        $image = $request->file('image');
                        $photoName = '';
                        if ($image != '') {
                            $image_name = $image->getClientOriginalName();
                            $fileExt = $image->getClientOriginalExtension();
                            $fileSize = $image->getSize();
                            $photo_download_name = uniqid() . '_' . time() . '.' . $fileExt;
                            $orig_file_path = public_path() . "/files/orig";
                            $thumb_file_path = public_path() . "/files/thumb";
                            if (isset(Auth::user()->id)) {
                                $photoName = Auth::user()->id . '_' . uniqid() . '.' . $fileExt;
                            } else {
                                $photoName = uniqid() . '.' . $fileExt;
                            }
                            $upload_success = $image->move($orig_file_path, $photoName, 100, 100);
                        }
                        $dataObj                                                    =   DB::table('t_business_logistic_dtls')
                                                                                        ->select(array('t_business_logistic_dtls.business_logistic_code'))
                                                                                        ->orderBy('t_business_logistic_dtls.id','desc')
                                                                                        ->first();
                        $temp_org_name                                              =  Controller::getOrganizationNameById(Auth::user()->t_organizations_id);
                        $result_org_name                                            =  substr($temp_org_name, 0, 3);
                        $result_branch_name                                         =  substr($business_logistic_name, 0, 3);
                        if($dataObj != ''){
                            if(is_object($dataObj)){
                                $temp_branch_code                                   =   substr($dataObj->business_logistic_code,8);
                                $temp_branch_new_code                               =   $temp_branch_code+1;
                                $business_logistic_code                             =   $result_branch_name."/".$result_org_name."/".$temp_branch_new_code;
                            }
                        }else{
                                $business_logistic_code                             =   $result_branch_name."/".$result_org_name."/"."1";
                        }      
                        $tableObjCnt = DB::table('t_business_logistic_dtls')
                                ->where('business_logistic_name', '=', $business_logistic_name)
                                ->where('status', '=', 'Y')
                                ->count();
                        if ($tableObjCnt == 0) {

                            try {
                                $loopCnt++;
                                $formCDataArr['TBusinessLogisticDtls']['business_logistic_name']= strtoupper($business_logistic_name);
                                $formCDataArr['TBusinessLogisticDtls']['t_organizations_id']    = Auth::user()->t_organizations_id;
                                $formCDataArr['TBusinessLogisticDtls']['business_logistic_code']= strtoupper($business_logistic_code);
                                $formCDataArr['TBusinessLogisticDtls']['t_branch_details_id']   = Auth::user()->t_branch_details_id;
                                $formCDataArr['TBusinessLogisticDtls']['email_id']              = $email_id;
                                $formCDataArr['TBusinessLogisticDtls']['mobile_number']         = $mobile_number;
                                $formCDataArr['TBusinessLogisticDtls']['other_mobile_number']   = $other_mobile_number;
                                $formCDataArr['TBusinessLogisticDtls']['address']               = $address;
                                $formCDataArr['TBusinessLogisticDtls']['logo']                  = $photoName;
                                $formCDataArr['TBusinessLogisticDtls']['status']                = "Y";
                                $formCDataArr['TBusinessLogisticDtls']['created_by']            = Auth::user()->id;
                                $formCDataArr['TBusinessLogisticDtls']['created_at']            = date('Y-m-d h:i:s');
                                $formCDataArr['TBusinessLogisticDtls']['updated_at']            = date('Y-m-d h:i:s');
                                DB::table('t_business_logistic_dtls')->insert($formCDataArr['TBusinessLogisticDtls']);
                                $saveCnt++;
                            } catch (ValidationException $e) {
                                DB::rollback();
                            } catch (\Exception $e) {
                                DB::rollback();
                            }
                            
                            if ($loopCnt == $saveCnt) {
                                DB::commit();
                                return Redirect::to('/branch/add_lab_collection_center_data')->with('message', 'Data saved successfully!');
                            } else {
                                DB::rollback();
                                return Redirect::to('/branch/add_lab_collection_center_data')->with('error', 'Unable save Data');
                            }
                        } else {
                            DB::rollback();
                            return Redirect::to('/branch/add_lab_collection_center_data')->with('error', 'Data Already Exist');
                        }
                    }
                
            } else {
                return Redirect::to('/branch/add_lab_collection_center_data')->with('error', 'Invalid form submission');
            }
        } else {
            return Redirect::to('/user/login')->with('error', 'Please login to register');
        }exit;
    }
    public function labCollectionCenterActive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['TBusinessLogisticDtls']['status'] = "Y";
                $formCDataArr['TBusinessLogisticDtls']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_business_logistic_dtls')
                    ->where('id', $id)
                    ->update($formCDataArr['TBusinessLogisticDtls']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****Data has been Active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }
    public function labCollectionCenterDeactive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['TBusinessLogisticDtls']['status'] = "N";
                $formDataArr['TBusinessLogisticDtls']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_business_logistic_dtls')
                    ->where('id', $id)
                    ->update($formDataArr['TBusinessLogisticDtls']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****Data has been In-active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }
    
    public function addLabCollectionCenterUser($id = 0) {
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $user_name = Input::get('search_user_name');
        if(Auth::user()->role_id == 2){
            $dbObj = DB::table('users')
             ->where('users.t_organizations_id','=',Auth::user()->t_organizations_id)
             ->where('users.t_branch_details_id','=',0)    
             ->where('users.t_business_logistic_dtl_id','!=',0)   
             ->orderby('users.id', 'desc');
        }else{
            $dbObj = DB::table('users')
             ->where('users.t_organizations_id','=',Auth::user()->t_organizations_id)
             ->where('users.t_branch_details_id','=',Auth::user()->t_branch_details_id) 
             ->where('users.t_business_logistic_dtl_id','!=',0)   
             ->orderby('users.id', 'desc');
        }
        if (isset($inputArr['reqType']) && $inputArr['reqType'] != '') {
            $reqType = $inputArr['reqType'];
        }
        $custompaginatorres = $dbObj->paginate('5');
        $layoutArr = [
            'viewDataObj'       => $viewDataObj,
            'viewDataObjs'       => $viewDataObjs,
            'sortFilterArr'     => ['user_name' => $user_name, 'reqType' => $reqType],
            'custompaginatorres'=> $custompaginatorres,
        ];
        return view('branch.add_lab_collection_center_user', ['layoutArr' => $layoutArr]);
    }
    public function addLabCollectionCenterUserData($id = 0) {
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $roleArr                                                                = Controller::getRoleListForLabAdmin('roles','role_name');
        $collArr                                                                = Controller::getLabLists('t_business_logistic_dtls','business_logistic_name');
        if ($id) {
            $viewDataObj        =   DB::table('users')
                                    ->where('users.id', '=',$id)
                                    ->select(array(
                                                'users.id',
                                                'users.role_id',
                                                'users.t_organizations_id',
                                                'users.t_branch_details_id',
                                                'users.t_business_logistic_dtl_id',
                                                'users.full_name',
                                                'users.email_id',
                                                'users.ogr_password',
                                                'users.user_photo',
                                                'users.mobile_number',
                                                'users.status',
                                                'users.alter_mobile_number',
                                                'users.adhar_number',
                                                )
                                            )    
                                    ->first();
            $viewDataObjs       =   DB::table('users')
                                    ->where('users.id', '=',$id)
                                    ->select(array('users.address'))
                                    ->first();
        }
        $layoutArr = [
            'viewDataObj'        => $viewDataObj,
            'viewDataObjs'       => $viewDataObjs,
            'roleArr'            => $roleArr,
            'collArr'          => $collArr,
            'sortFilterArr'      => ['reqType' => $reqType],
        ];
        return view('branch.add_lab_collection_center_user_data', ['layoutArr' => $layoutArr]);
    }
    public function validateLabCollectionCenterUserDetails() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['User']) && is_array($formValArr['User']) && count($formValArr['User']) > 0) {
                $validator = Validator::make($formValArr['User'], User::$rules['lab'], User::$messages);
                if ($validator->fails()) {
                    $errorArr = $validator->getMessageBag()->toArray();
                    if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                        foreach ($errorArr as $errorKey => $errorVal) {
                            $valiationArr[] = array(
                                'modelField' => $errorKey,
                                'modelErrorMsg' => $errorVal[0],
                            );
                        }
                    }
                    echo '****FAILURE****' . json_encode($valiationArr);
                    exit;
                } else {
                    echo '****SUCCESS****Successfully Validated.';
                }
            }
        }exit;
    }
    public function validateLabCollectionCenterUserDetailss() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['User']) && is_array($formValArr['User']) && count($formValArr['User']) > 0) {
                $validator = Validator::make($formValArr['User'], User::$rules['labupdate'], User::$messages);
                if ($validator->fails()) {
                    $errorArr = $validator->getMessageBag()->toArray();
                    if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                        foreach ($errorArr as $errorKey => $errorVal) {
                            $valiationArr[] = array(
                                'modelField' => $errorKey,
                                'modelErrorMsg' => $errorVal[0],
                            );
                        }
                    }
                    echo '****FAILURE****' . json_encode($valiationArr);
                    exit;
                } else {
                    echo '****SUCCESS****Successfully Validated.';
                }
            }
        }exit;
    }
    public function labCollectionCenterUserDetailsActive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['User']['status'] = 0;
                $formCDataArr['User']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('users')
                    ->where('id', $id)
                    ->update($formCDataArr['User']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****User has been Active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }
    public function labCollectionCenterUserDetailsDeactive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['User']['status'] = 1;
                $formDataArr['User']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('users')
                    ->where('id', $id)
                    ->update($formDataArr['User']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****User has been In-active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }
    public function saveLabCollectionCenterUserDetails(Request $request) {
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['User']) && $formData['User'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                $id = (int) $formData['User']['id'];
                if (isset($formData['User']['t_business_logistic_dtl_id']) && $formData['User']['t_business_logistic_dtl_id'] != '') {
                    $t_business_logistic_dtl_id                                 = $formData['User']['t_business_logistic_dtl_id'];
                    $t_organizations_id                                         = Controller::getOrganizationIdByLabId($formData['User']['t_business_logistic_dtl_id']);
                    $t_branch_details_id                                        = Controller::getBranchIdByLabId($formData['User']['t_business_logistic_dtl_id']);
                } else {
                    $t_business_logistic_dtl_id                                 = 0;
                    $t_branch_details_id                                        = 0;
                    $t_organizations_id                                         = 0;
                }
                if (isset($formData['User']['full_name']) && $formData['User']['full_name'] != '') {
                    $full_name                                                  = $formData['User']['full_name'];
                } else {
                    $full_name                                                  = '';
                }
                if (isset($formData['User']['ogr_password']) && $formData['User']['ogr_password'] != '') {
                    $password                                                   = $formData['User']['ogr_password'];
                } else {
                    $password                                                   = '';
                }
                if (isset($formData['User']['email_id']) && $formData['User']['email_id'] != '') {
                    $email_id                                                   = $formData['User']['email_id'];
                } else {
                    $email_id                                                   = '';
                }
                if (isset($formData['User']['mobile_number']) && $formData['User']['mobile_number'] != '') {
                    $mobile_number                                              = $formData['User']['mobile_number'];
                } else {
                    $mobile_number                                              = '';
                }
                if (isset($formData['User']['adhar_number']) && $formData['User']['adhar_number'] != '') {
                    $adhar_number                                               = $formData['User']['adhar_number'];
                } else {
                    $adhar_number                                               = '';
                }
                if (isset($formData['User']['alter_mobile_number']) && $formData['User']['alter_mobile_number'] != '') {
                    $alter_mobile_number                                        = $formData['User']['alter_mobile_number'];
                } else {
                    $alter_mobile_number                                        = '';
                }
                if (isset($formData['User']['address']) && $formData['User']['address'] != '') {
                    $address                                                    = $formData['User']['address'];
                } else {
                    $address                                                    = '';
                }
                if (isset($formData['User']['role_id']) && $formData['User']['role_id'] != '') {
                    $role_id                                                    = $formData['User']['role_id'];
                } else {
                    $role_id                                                    = '';
                }
                
                if (isset($id) && $id != 0) {
                    $tableObjCnt = DB::table('users')
                            ->where('full_name', '=', $full_name)
                            ->where('mobile_number', '=', $mobile_number)
                            ->where('id', '!=', $id)
                            ->count();
                    if ($tableObjCnt == 0) {
                        //for fetch image file exist or not
                        $tableObjCnt2 = DB::table('users')
                                ->where('user_photo', '!=', '')
                                ->where('id', '=', $id);
                        $tableObjCnt3 = $tableObjCnt2->count();
                        $tableObjCnt4 = $tableObjCnt2->first();
                        $image = $request->file('image');
                        if ($tableObjCnt3 > 0) {
                            $photoName = $tableObjCnt4->user_photo;
                        } else {
                            $photoName = '';
                        }
                        //
                        
                        if ($image != '') {
                            $image_name = $image->getClientOriginalName();
                            $fileExt = $image->getClientOriginalExtension();
                            $fileSize = $image->getSize();
                            $photo_download_name = uniqid() . '_' . time() . '.' . $fileExt;
                            $orig_file_path = public_path() . "/files/orig";
                            $thumb_file_path = public_path() . "/files/thumb";
                            if (isset(Auth::user()->id)) {
                                $photoName = Auth::user()->id . '_' . uniqid() . '.' . $fileExt;
                            } else {
                                $photoName = uniqid() . '.' . $fileExt;
                            }
                            $upload_success = $image->move($orig_file_path, $photoName, 100, 100);
                        }
                        
                        try {
                            $loopCnt++;
                            $formCDataArr['User']['role_id']                    = $role_id;
                            $formCDataArr['User']['t_organizations_id']         = $t_organizations_id;
                            $formCDataArr['User']['t_branch_details_id']        = $t_branch_details_id;
                            $formCDataArr['User']['t_business_logistic_dtl_id'] = $t_business_logistic_dtl_id;
                            $formCDataArr['User']['full_name']                  = $full_name;
                            $formCDataArr['User']['alter_mobile_number']        = $alter_mobile_number;
                            $formCDataArr['User']['adhar_number']               = $adhar_number;
                            $formCDataArr['User']['password']                   = Hash::make($password);
                            $formCDataArr['User']['re_password']                = Hash::make($password);
                            $formCDataArr['User']['ogr_password']               = $password;
                            $formCDataArr['User']['email_id']                   = $email_id;
                            $formCDataArr['User']['mobile_number']              = $mobile_number;
                            $formCDataArr['User']['user_photo']                 = $photoName;
                            $formCDataArr['User']['address']                    = $address;
                            $formCDataArr['User']['remember_token']             = csrf_token();
                            $formCDataArr['User']['updated_at']                 = date('Y-m-d h:i:s');
                            //echo'<pre>';print_r($formCDataArr);echo'</pre>';exit;
                            DB::table('users')
                                    ->where('id', $id)
                                    ->update($formCDataArr['User']);
                            DB::commit();
                            $saveCnt++;
                        } catch (ValidationException $e) {
                            DB::rollback();
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
                        //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                        if ($loopCnt == $saveCnt) {
                            DB::commit();
                            return Redirect::to('/branch/add_lab_collection_center_user_data')->with('message', 'Data update successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/branch/add_lab_collection_center_user_data')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/branch/add_lab_collection_center_user_data')->with('error', ' Data Already Exist');
                    }
                } else {

                    $image = $request->file('image');
                    $photoName = '';
                    if ($image != '') {
                        $image_name = $image->getClientOriginalName();
                        $fileExt = $image->getClientOriginalExtension();
                        $fileSize = $image->getSize();
                        $photo_download_name = uniqid() . '_' . time() . '.' . $fileExt;
                        $orig_file_path = public_path() . "/files/orig";
                        $thumb_file_path = public_path() . "/files/thumb";
                        if (isset(Auth::user()->id)) {
                            $photoName = Auth::user()->id . '_' . uniqid() . '.' . $fileExt;
                        } else {
                            $photoName = uniqid() . '.' . $fileExt;
                        }
                        $upload_success = $image->move($orig_file_path, $photoName, 100, 100);
                    }
                    
                    $tableObjCnt = DB::table('users')
                            ->where('full_name', '=', $full_name)
                            ->where('mobile_number', '=', $mobile_number)
                            ->where('status','=',0)
                            ->count();
                        if ($tableObjCnt == 0) {

                            try {
                                $loopCnt++;
                                $formCDataArr['User']['role_id']                    = $role_id;
                                $formCDataArr['User']['t_organizations_id']         = $t_organizations_id;
                                $formCDataArr['User']['t_branch_details_id']        = $t_branch_details_id;
                                $formCDataArr['User']['t_business_logistic_dtl_id'] = $t_business_logistic_dtl_id;
                                $formCDataArr['User']['full_name']                  = $full_name;
                                $formCDataArr['User']['alter_mobile_number']        = $alter_mobile_number;
                                $formCDataArr['User']['adhar_number']               = $adhar_number;
                                $formCDataArr['User']['password']                   = Hash::make($password);
                                $formCDataArr['User']['re_password']                = Hash::make($password);
                                $formCDataArr['User']['ogr_password']               = $password;
                                $formCDataArr['User']['email_id']                   = $email_id;
                                $formCDataArr['User']['mobile_number']              = $mobile_number;
                                $formCDataArr['User']['user_photo']                 = $photoName;
                                $formCDataArr['User']['address']                    = $address;
                                $formCDataArr['User']['remember_token']             = csrf_token();
                                $formCDataArr['User']['status']                     = 0;
                                $formCDataArr['User']['is_reset_req']               = 0;
                                $formCDataArr['User']['created_at']                 = date('Y-m-d h:i:s');
                                $formCDataArr['User']['updated_at']                 = date('Y-m-d h:i:s');
                                DB::table('users')->insert($formCDataArr['User']);
                                $saveCnt++;
                            } catch (ValidationException $e) {
                                DB::rollback();
                            } catch (\Exception $e) {
                                DB::rollback();
                            }
                            //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                            if ($loopCnt == $saveCnt) {
                                DB::commit();
                                return Redirect::to('/branch/add_lab_collection_center_user_data')->with('message', 'Data saved successfully!');
                            } else {
                                DB::rollback();
                                return Redirect::to('/branch/add_lab_collection_center_user_data')->with('error', 'Unable save Data');
                            }
                        } else {
                            DB::rollback();
                            return Redirect::to('/branch/add_lab_collection_center_user_data')->with('error', 'User Data Already Exist');
                        }
                    
                }
            } else {
                return Redirect::to('/branch/add_lab_collection_center_user_data')->with('error', 'Invalid form submission');
            }
        } else {
            return Redirect::to('/user/login')->with('error', 'Please login to register');
        }exit;
    }

}