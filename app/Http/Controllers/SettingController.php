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
use App\Models\TOrganizations;
use App\Models\TDepartment;
use App\Models\TDesignation;
use App\Models\TState;
use App\Models\TCities;
use App\Models\TBranchDetails;


class SettingController extends Controller{
    public function addOrganizationDetails($id=0){
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $organization_name                                                      = '';
        $id                                                                     = base64_decode(base64_decode($id));
        if($id){
            $viewDataObj                                                        = DB::table('t_organizations')
                                                                                ->where('t_organizations.id', '=',$id)
                                                                                ->select(array('t_organizations.id',
                                                                                               't_organizations.organization_name',
                                                                                               't_organizations.mobile_number',
                                                                                               't_organizations.mobile_number1',
                                                                                               't_organizations.email_id',
                                                                                               't_organizations.logo',
                                                                                               't_organizations.status',
                                                                                            )
                                                                                        )
                                                                                ->first();
            $viewDataObjs                                                       = DB::table('t_organizations')
                                                                                ->where('t_organizations.id', '=',$id)
                                                                                ->select(array('t_organizations.address'))
                                                                                ->first();
        }
        $organization_name                                                      = Input::get('search_organization_name');
            $dbObj                                                              = DB::table('t_organizations')
                                                                                ->orderby('t_organizations.id','desc');
        if (isset($inputArr['reqType']) && $inputArr['reqType'] != '') {
            $reqType                                                            = $inputArr['reqType'];
        }
        $custompaginatorres = $dbObj->paginate('5');
        $layoutArr = [
                        'viewDataObj'           => $viewDataObj,
                        'viewDataObjs'          => $viewDataObjs,
                        'sortFilterArr'         => ['organization_name'    => $organization_name,'reqType' => $reqType],
                        'custompaginatorres'    => $custompaginatorres,
                    ];
        return view('setting.add_organization_details',['layoutArr' => $layoutArr]);
    }
    public function validateOrganizationDetails() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['TOrganizations']) && is_array($formValArr['TOrganizations']) && count($formValArr['TOrganizations']) > 0) {
                $validator = Validator::make($formValArr['TOrganizations'], TOrganizations::$rules, TOrganizations::$messages);
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
    public function saveOrganizationDetails(Request $request) {
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['TOrganizations']) && $formData['TOrganizations'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                $id = (int) $formData['TOrganizations']['id'];
                if (isset($formData['TOrganizations']['organization_name']) && $formData['TOrganizations']['organization_name'] != '') {
                    $organization_name                                          = $formData['TOrganizations']['organization_name'];
                } else {
                    $organization_name                                          = '';
                }
                if (isset($formData['TOrganizations']['email_id']) && $formData['TOrganizations']['email_id'] != '') {
                    $email_id                                                   = $formData['TOrganizations']['email_id'];
                } else {
                    $email_id                                                   = '';
                }
                if (isset($formData['TOrganizations']['mobile_number']) && $formData['TOrganizations']['mobile_number'] != '') {
                    $mobile_number                                              = $formData['TOrganizations']['mobile_number'];
                } else {
                    $mobile_number                                              = '';
                }
                if (isset($formData['TOrganizations']['mobile_number1']) && $formData['TOrganizations']['mobile_number1'] != '') {
                    $mobile_number1                                             = $formData['TOrganizations']['mobile_number1'];
                } else {
                    $mobile_number1                                             = '';
                }
                if (isset($formData['TOrganizations']['address']) && $formData['TOrganizations']['address'] != '') {
                    $address                                                    = $formData['TOrganizations']['address'];
                } else {
                    $address                                                    = '';
                }
                if (isset($id) && $id != 0) {
                    $tableObjCnt = DB::table('t_organizations')
                            ->where('organization_name', '=', $organization_name)
                            ->where('id', '!=', $id)
                            ->count();
                    if ($tableObjCnt == 0) {
                        //for fetch image file exist or not
                        $tableObjCnt2 = DB::table('t_organizations')
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
                            $formCDataArr['TOrganizations']['organization_name']     = strtoupper($organization_name);
                            $formCDataArr['TOrganizations']['email_id']              = $email_id;
                            $formCDataArr['TOrganizations']['mobile_number']         = $mobile_number;
                            $formCDataArr['TOrganizations']['mobile_number1']        = $mobile_number1;
                            $formCDataArr['TOrganizations']['address']               = $address;
                            $formCDataArr['TOrganizations']['logo']                  = $photoName;
                            $formCDataArr['TOrganizations']['updated_at']            = date('Y-m-d h:i:s');
                            //echo'<pre>';print_r($formCDataArr);echo'</pre>';exit;
                            DB::table('t_organizations')
                                    ->where('id', $id)
                                    ->update($formCDataArr['TOrganizations']);
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
                            return Redirect::to('/setting/add_organization_details')->with('message', 'Data update successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/setting/add_organization_details')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/setting/add_organization_details')->with('error', ' Data Already Exist');
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
                          
                    $tableObjCnt = DB::table('t_organizations')
                            ->where('organization_name', '=', $organization_name)
                            ->where('status', '=', 'Y')
                            ->count();
                    if ($tableObjCnt == 0) {
                        
                        try {
                            $loopCnt++;
                            $formCDataArr['TOrganizations']['organization_name']     = strtoupper($organization_name);
                            $formCDataArr['TOrganizations']['email_id']              = $email_id;
                            $formCDataArr['TOrganizations']['mobile_number']         = $mobile_number;
                            $formCDataArr['TOrganizations']['mobile_number1']        = $mobile_number1;
                            $formCDataArr['TOrganizations']['address']               = $address;
                            $formCDataArr['TOrganizations']['logo']                  = $photoName;
                            $formCDataArr['TOrganizations']['status']                = "Y";
                            $formCDataArr['TOrganizations']['created_by']            = Auth::user()->id;
                            $formCDataArr['TOrganizations']['created_at']            = date('Y-m-d h:i:s');
                            $formCDataArr['TOrganizations']['updated_at']            = date('Y-m-d h:i:s');
                            DB::table('t_organizations')->insert($formCDataArr['TOrganizations']);
                            $saveCnt++;
                        } catch (ValidationException $e) {
                            DB::rollback();
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
                        //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                        if ($loopCnt == $saveCnt) {
                            DB::commit();
                            return Redirect::to('/setting/add_organization_details')->with('message', 'Data saved successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/setting/add_organization_details')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/setting/add_organization_details')->with('error', 'Data Already Exist');
                    }
                }
            } else {
                return Redirect::to('/setting/add_organization_details')->with('error', 'Invalid form submission');
            }
        } else {
            return Redirect::to('/user/login')->with('error', 'Please login to register');
        }exit;
    }
    public function organizationDetailsActive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['TOrganizations']['status'] = 'Y';
                $formCDataArr['TOrganizations']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_organizations')
                    ->where('id', $id)
                    ->update($formCDataArr['TOrganizations']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
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
    public function organizationDetailsDeactive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['TOrganizations']['status'] = 'N';
                $formDataArr['TOrganizations']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_organizations')
                    ->where('id', $id)
                    ->update($formDataArr['TOrganizations']);
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

    public function addDepartment($id=0){
       $viewDataObj = "";
        $id          = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('t_department')
                ->where('t_department.id', '=', "$id")
                ->first();
        }
        $department_name                                                         = Input::get('search_department_name');
        $dbObj                                                                  = DB::table('t_department')
                                                                                ->orderby('t_department.id','desc');
        if(isset($department_name) && $department_name != ''){
            $dbObj->where('t_department.department_name','LIKE',"$department_name%");
        }
        $custompaginatorres                                                     = $dbObj->paginate('10');
        $layoutArr  = [
                        'sortFilterArr'      => ['department_name' => $department_name],
                        'custompaginatorres' => $custompaginatorres,
                        'viewDataObj' => $viewDataObj,
                    ];
       return View::make('setting.add_department', ['layoutArr' => $layoutArr]);
    }
    public function saveDepartment(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData    = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                parse_str($formData['formdata'], $formDataArr);
                // echo "<pre>"; print_r($formDataArr); echo "<pre>"; exit;
                if (isset($formDataArr['TDepartment']) && is_array($formDataArr['TDepartment']) && count($formDataArr['TDepartment']) > 0) {
                    $validator = Validator::make($formDataArr['TDepartment'], TDepartment::$rules, TDepartment::$messages);
                    if ($validator->fails()) {
                        $errorArr = $validator->getMessageBag()->toArray();
                        if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                            foreach ($errorArr as $errorKey => $errorVal) {
                                $valiationArr[] = array(
                                    'modelField'    => $errorKey,
                                    'modelErrorMsg' => $errorVal[0],
                                );
                            }
                            echo '****FAILURE****' . json_encode($valiationArr);exit;
                        }
                    } else {
                        $id   = (int) $formDataArr['id'];
                        $department_name = trim($formDataArr['TDepartment']['department_name']);
                        
                        if (isset($id) && $id != 0) {
                            $tableObjCnt = DB::table('t_department')
                                ->where('t_department.department_name','=',$department_name)
                                ->where('id', '!=', $id)
                                ->count();
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TDepartment']['department_name'] = $department_name;
                                    $formCDataArr['TDepartment']['created_by']      = Auth::user()->id;
                                    $formCDataArr['TDepartment']['updated_at']      = date('Y-m-d h:i:s');
                                    DB::table('t_department')
                                        ->where('id', $id)
                                        ->update($formCDataArr['TDepartment']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Data has been updated successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Data already Exist.';
                            }
                        } else {
                            $tableObjCnt = DB::table('t_department')
                                ->where('t_department.department_name','=',$department_name)
                                ->count();
                            //echo'<pre>';print_r($tableObjCnt);echo'</pre>';exit;
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TDepartment']['department_name'] = $department_name;
                                    $formCDataArr['TDepartment']['status']          = "Y";
                                    $formCDataArr['TDepartment']['created_by']      = Auth::user()->id;
                                    $formCDataArr['TDepartment']['created_at']      = date('Y-m-d h:i:s');
                                    $formCDataArr['TDepartment']['updated_at']      = date('Y-m-d h:i:s');
                                    DB::table('t_department')->insert($formCDataArr['TDepartment']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Data has been saved successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Data already Exist.';
                            }
                        }
                    }
                }
            }exit;
        } else {
            echo '****ERROR****please login to save data.';
        }exit;
    }
    public function departmentActive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['TDepartment']['status']     = "Y";
                $formCDataArr['TDepartment']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_department')
                    ->where('id', $id)
                    ->update($formCDataArr['TDepartment']);
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
    public function departmentDeactive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['TDepartment']['status']     = "N";
                $formDataArr['TDepartment']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_department')
                    ->where('id', $id)
                    ->update($formDataArr['TDepartment']);
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
    
    public function addDesignation($id=0){
       $viewDataObj = "";
        $id          = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('t_designation')
                ->where('t_designation.id', '=', "$id")
                ->first();
        }
        $designation_name                                                       = Input::get('search_designation_name');
        $dbObj                                                                  = DB::table('t_designation')
                                                                                ->orderby('t_designation.id','desc');
        if(isset($designation_name) && $designation_name != ''){
            $dbObj->where('t_designation.designation_name','LIKE',"$designation_name%");
        }
        $custompaginatorres                                                     = $dbObj->paginate('10');
        $layoutArr  = [
                        'sortFilterArr'      => ['designation_name' => $designation_name],
                        'custompaginatorres' => $custompaginatorres,
                        'viewDataObj'        => $viewDataObj,
                    ];
       return View::make('setting.add_designation', ['layoutArr' => $layoutArr]);
    }
    public function saveDesignation(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData    = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                parse_str($formData['formdata'], $formDataArr);
                // echo "<pre>"; print_r($formDataArr); echo "<pre>"; exit;
                if (isset($formDataArr['TDesignation']) && is_array($formDataArr['TDesignation']) && count($formDataArr['TDesignation']) > 0) {
                    $validator = Validator::make($formDataArr['TDesignation'], TDesignation::$rules, TDesignation::$messages);
                    if ($validator->fails()) {
                        $errorArr = $validator->getMessageBag()->toArray();
                        if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                            foreach ($errorArr as $errorKey => $errorVal) {
                                $valiationArr[] = array(
                                    'modelField'    => $errorKey,
                                    'modelErrorMsg' => $errorVal[0],
                                );
                            }
                            echo '****FAILURE****' . json_encode($valiationArr);exit;
                        }
                    } else {
                        $id   = (int) $formDataArr['id'];
                        $designation_name = trim($formDataArr['TDesignation']['designation_name']);
                        
                        if (isset($id) && $id != 0) {
                            $tableObjCnt = DB::table('t_designation')
                                ->where('t_designation.designation_name','=',$designation_name)
                                ->where('id', '!=', $id)
                                ->count();
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TDesignation']['designation_name'] = $designation_name;
                                    $formCDataArr['TDesignation']['created_by']      = Auth::user()->id;
                                    $formCDataArr['TDesignation']['updated_at']      = date('Y-m-d h:i:s');
                                    DB::table('t_designation')
                                        ->where('id', $id)
                                        ->update($formCDataArr['TDesignation']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Data has been updated successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Data already Exist.';
                            }
                        } else {
                            $tableObjCnt = DB::table('t_designation')
                                ->where('t_designation.designation_name','=',$designation_name)
                                ->count();
                            //echo'<pre>';print_r($tableObjCnt);echo'</pre>';exit;
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TDesignation']['designation_name']=$designation_name;
                                    $formCDataArr['TDesignation']['status']          = "Y";
                                    $formCDataArr['TDesignation']['created_by']      = Auth::user()->id;
                                    $formCDataArr['TDesignation']['created_at']      = date('Y-m-d h:i:s');
                                    $formCDataArr['TDesignation']['updated_at']      = date('Y-m-d h:i:s');
                                    DB::table('t_designation')->insert($formCDataArr['TDesignation']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Data has been saved successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Data already Exist.';
                            }
                        }
                    }
                }
            }exit;
        } else {
            echo '****ERROR****please login to save data.';
        }exit;
    }
    public function designationActive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['TDesignation']['status']     = "Y";
                $formCDataArr['TDesignation']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_designation')
                    ->where('id', $id)
                    ->update($formCDataArr['TDesignation']);
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
    public function designationDeactive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['TDesignation']['status']     = "N";
                $formDataArr['TDesignation']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_designation')
                    ->where('id', $id)
                    ->update($formDataArr['TDesignation']);
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
    
    public function addState($id=0){
       $viewDataObj = "";
        $id          = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('t_states')
                ->where('t_states.id', '=', "$id")
                ->first();
        }
        $state_name                                                             = Input::get('search_state_name');
        $dbObj                                                                  = DB::table('t_states')
                                                                                ->orderby('t_states.state_name','asc');
        if(isset($state_name) && $state_name != ''){
            $dbObj->where('t_states.state_name','LIKE',"$state_name%");
        }
        $custompaginatorres                                                     = $dbObj->paginate('10');
        $layoutArr  = [
                        'sortFilterArr'      => ['state_name' => $state_name],
                        'custompaginatorres' => $custompaginatorres,
                        'viewDataObj'        => $viewDataObj,
                    ];
       return View::make('setting.add_state', ['layoutArr' => $layoutArr]);
    }
    public function saveState(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData    = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                parse_str($formData['formdata'], $formDataArr);
                // echo "<pre>"; print_r($formDataArr); echo "<pre>"; exit;
                if (isset($formDataArr['TState']) && is_array($formDataArr['TState']) && count($formDataArr['TState']) > 0) {
                    $validator = Validator::make($formDataArr['TState'], TState::$rules, TState::$messages);
                    if ($validator->fails()) {
                        $errorArr = $validator->getMessageBag()->toArray();
                        if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                            foreach ($errorArr as $errorKey => $errorVal) {
                                $valiationArr[] = array(
                                    'modelField'    => $errorKey,
                                    'modelErrorMsg' => $errorVal[0],
                                );
                            }
                            echo '****FAILURE****' . json_encode($valiationArr);exit;
                        }
                    } else {
                        $id   = (int) $formDataArr['id'];
                        $state_name = trim($formDataArr['TState']['state_name']);
                        
                        if (isset($id) && $id != 0) {
                            $tableObjCnt = DB::table('t_states')
                                ->where('t_states.state_name','=',$state_name)
                                ->where('id', '!=', $id)
                                ->count();
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TState']['state_name']       = $state_name;
                                    $formCDataArr['TState']['created_by']       = Auth::user()->id;
                                    $formCDataArr['TState']['updated_at']       = date('Y-m-d h:i:s');
                                    DB::table('t_states')
                                        ->where('id', $id)
                                        ->update($formCDataArr['TState']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Data has been updated successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Data already Exist.';
                            }
                        } else {
                            $tableObjCnt = DB::table('t_states')
                                ->where('t_states.state_name','=',$state_name)
                                ->count();
                            //echo'<pre>';print_r($tableObjCnt);echo'</pre>';exit;
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TState']['state_name']       = $state_name;
                                    $formCDataArr['TState']['status']           = "Y";
                                    $formCDataArr['TState']['created_by']       = Auth::user()->id;
                                    $formCDataArr['TState']['created_at']       = date('Y-m-d h:i:s');
                                    $formCDataArr['TState']['updated_at']       = date('Y-m-d h:i:s');
                                    DB::table('t_states')->insert($formCDataArr['TState']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Data has been saved successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Data already Exist.';
                            }
                        }
                    }
                }
            }exit;
        } else {
            echo '****ERROR****please login to save data.';
        }exit;
    }
    public function stateActive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['TState']['status']     = "Y";
                $formCDataArr['TState']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_states')
                    ->where('id', $id)
                    ->update($formCDataArr['TState']);
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
    public function stateDeactive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['TState']['status']     = "N";
                $formDataArr['TState']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_states')
                    ->where('id', $id)
                    ->update($formDataArr['TState']);
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
    
    public function addCity($id=0){
       $viewDataObj = "";
        $id          = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('t_cities')
                ->where('t_cities.id', '=', "$id")
                ->first();
        }
        $stateArr                                                               = Controller::getStateLists('t_states', 'state_name');
        $city_name                                                              = Input::get('search_city_name');
        $dbObj                                                                  = DB::table('t_cities')
                                                                                ->orderby('t_cities.t_states_id','asc');
        if(isset($city_name) && $city_name != ''){
            $dbObj->where('t_cities.city_name','LIKE',"$city_name%");
        }
        $custompaginatorres                                                     = $dbObj->paginate('20');
        $layoutArr  = [
                        'sortFilterArr'      => ['city_name' => $city_name],
                        'custompaginatorres' => $custompaginatorres,
                        'viewDataObj'        => $viewDataObj,
                        'stateArr'           => $stateArr,
                    ];
       return View::make('setting.add_city', ['layoutArr' => $layoutArr]);
    }
    public function saveCity(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData    = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                parse_str($formData['formdata'], $formDataArr);
                // echo "<pre>"; print_r($formDataArr); echo "<pre>"; exit;
                if (isset($formDataArr['TCities']) && is_array($formDataArr['TCities']) && count($formDataArr['TCities']) > 0) {
                    $validator = Validator::make($formDataArr['TCities'], TCities::$rules, TCities::$messages);
                    if ($validator->fails()) {
                        $errorArr = $validator->getMessageBag()->toArray();
                        if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                            foreach ($errorArr as $errorKey => $errorVal) {
                                $valiationArr[] = array(
                                    'modelField'    => $errorKey,
                                    'modelErrorMsg' => $errorVal[0],
                                );
                            }
                            echo '****FAILURE****' . json_encode($valiationArr);exit;
                        }
                    } else {
                        $id   = (int) $formDataArr['id'];
                        $city_name = trim($formDataArr['TCities']['city_name']);
                        $t_states_id = trim($formDataArr['TCities']['t_states_id']);
                        
                        if (isset($id) && $id != 0) {
                            $tableObjCnt = DB::table('t_cities')
                                ->where('t_cities.city_name','=',$city_name)
                                ->where('t_cities.t_states_id','=',$t_states_id)
                                ->where('id', '!=', $id)
                                ->count();
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TCities']['t_states_id']      = $t_states_id;
                                    $formCDataArr['TCities']['city_name']        = $city_name;
                                    $formCDataArr['TCities']['created_by']       = Auth::user()->id;
                                    $formCDataArr['TCities']['updated_at']       = date('Y-m-d h:i:s');
                                    DB::table('t_cities')
                                        ->where('id', $id)
                                        ->update($formCDataArr['TCities']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Data has been updated successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Data already Exist.';
                            }
                        } else {
                            $tableObjCnt = DB::table('t_cities')
                                ->where('t_cities.city_name','=',$city_name)
                                ->where('t_cities.t_states_id','=',$t_states_id)
                                ->count();
                            //echo'<pre>';print_r($tableObjCnt);echo'</pre>';exit;
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TCities']['t_states_id']      = $t_states_id;
                                    $formCDataArr['TCities']['city_name']        = $city_name;
                                    $formCDataArr['TCities']['status']           = "Y";
                                    $formCDataArr['TCities']['created_by']       = Auth::user()->id;
                                    $formCDataArr['TCities']['created_at']       = date('Y-m-d h:i:s');
                                    $formCDataArr['TCities']['updated_at']       = date('Y-m-d h:i:s');
                                    DB::table('t_cities')->insert($formCDataArr['TCities']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Data has been saved successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Data already Exist.';
                            }
                        }
                    }
                }
            }exit;
        } else {
            echo '****ERROR****please login to save data.';
        }exit;
    }
    public function cityActive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['TCities']['status']     = "Y";
                $formCDataArr['TCities']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_cities')
                    ->where('id', $id)
                    ->update($formCDataArr['TCities']);
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
    public function cityDeactive(){
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt   = 0;
            $saveCnt   = 0;
            $inputData = Input::all();
            $id        = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['TCities']['status']     = "N";
                $formDataArr['TCities']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('t_cities')
                    ->where('id', $id)
                    ->update($formDataArr['TCities']);
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
   
    public function citylist(){
        $this->layout								=   View::make('layouts.ajax');
        $sectionArr								=   array();
        $dateArr								=   Input::all();			
        $response               = '';
        $responseArr[0]['id']   = "";
        $responseArr[0]['name'] = "Select";
        $responseObjArr         = DB::table('t_cities')
                                ->select('city_name','id')
                                ->where('t_cities.t_states_id','=',$dateArr['selectedVal'])
                                ->where('status','Y')
                                ->get();
        foreach ($responseObjArr as $resKey => $resVal) {
            $responseArr[$resKey + 1]['id']   = $resVal->id;
            $responseArr[$resKey + 1]['name'] = $resVal->city_name;
        }
        return $responseArr;
    }
    
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
        return view('setting.add_regional_branch',['layoutArr' => $layoutArr,'id'=>$id]);
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
                        //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                        if ($loopCnt == $saveCnt) {
                            DB::commit();
                            return Redirect::to('/setting/add_regional_branch')->with('message', 'Data update successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/setting/add_regional_branch')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/setting/add_regional_branch')->with('error', ' Data Already Exist');
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
                        //echo'<pre>';print_r($loopCnt.'=='.$saveCnt);echo'</pre>';exit;
                        if ($loopCnt == $saveCnt) {
                            DB::commit();
                            return Redirect::to('/setting/add_regional_branch')->with('message', 'Data saved successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/setting/add_regional_branch')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/setting/add_regional_branch')->with('error', 'Data Already Exist');
                    }
                }
            } else {
                return Redirect::to('/setting/add_regional_branch')->with('error', 'Invalid form submission');
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
   
    public function addBusinessLogistics($id=0){
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $branch_name                                                            = '';
        $t_cities_id                                                            = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $stateArr                                                               = Controller::getMasterLists('t_states', 'state_name');
        $orgArr                                                                 = Controller::getRegionalBranchLists('t_organizations','organization_name');
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
        return view('setting.add_business_logistics',['layoutArr' => $layoutArr,'id'=>$id]);
    }
}