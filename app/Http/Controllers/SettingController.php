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
use App\Models\TDepartment;
use App\Models\TDesignation;
use App\Models\TState;
use App\Models\TCities;
use App\Models\TBranchDetails;


class SettingController extends Controller{
    public function addDepartment($id=0){
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
                    ];
       return View::make('setting.add_department', ['layoutArr' => $layoutArr]);
    }
    public function addDepartmentData($id=0){
        $viewDataObj = "";
        $id          = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('t_department')
                ->where('t_department.id', '=', "$id")
                ->first();
        }
        $layoutArr  = [
                        'viewDataObj' => $viewDataObj,
                    ];
       return View::make('setting.add_department_data', ['layoutArr' => $layoutArr]);
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
                                ->where('t_department.department_name','LIKE',$department_name)
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
                                ->where('t_department.department_name','LIKE',$department_name)
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
                    ];
       return View::make('setting.add_designation', ['layoutArr' => $layoutArr]);
    }
    public function addDesignationData($id=0){
       $viewDataObj = "";
        $id          = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('t_designation')
                ->where('t_designation.id', '=', "$id")
                ->first();
        }
        $layoutArr  = [
                        'viewDataObj'        => $viewDataObj,
                    ];
       return View::make('setting.add_designation_data', ['layoutArr' => $layoutArr]);
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
                                ->where('t_designation.designation_name','LIKE',$designation_name)
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
                                ->where('t_designation.designation_name','LIKE',$designation_name)
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
                    ];
       return View::make('setting.add_state', ['layoutArr' => $layoutArr]);
    }
    public function addStateData($id=0){
       $viewDataObj = "";
        $id          = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('t_states')
                ->where('t_states.id', '=', "$id")
                ->first();
        }
        $layoutArr  = [
                        'viewDataObj'        => $viewDataObj,
                    ];
       return View::make('setting.add_state_data', ['layoutArr' => $layoutArr]);
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
                                ->where('t_states.state_name','LIKE',$state_name)
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
                                ->where('t_states.state_name','LIKE',$state_name)
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
    public function addCityData($id=0){
       $viewDataObj = "";
        $id          = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('t_cities')
                ->where('t_cities.id', '=', "$id")
                ->first();
        }
        $stateArr                                                               = Controller::getStateLists('t_states', 'state_name');
        $layoutArr  = [
                        'viewDataObj'        => $viewDataObj,
                        'stateArr'           => $stateArr,
                    ];
       return View::make('setting.add_city_data', ['layoutArr' => $layoutArr]);
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
                                ->where('t_cities.city_name','LIKE',$city_name)
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
                                ->where('t_cities.city_name','LIKE',$city_name)
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
    
    public function changepassword(){
        $userArr = Auth::user();
        $layoutArr = array(
            'userArr' => $userArr
        );
        return View::make('setting.changepassword', ['layoutArr' => $layoutArr]);
    }
    public function updatePassword(){
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                parse_str($formData['formdata'], $formDataArr);
                if (isset($formDataArr['formdata']) && is_array($formDataArr['formdata']) && count($formDataArr['formdata']) > 0) {
                    $validator = Validator::make($formDataArr['formdata'], User::$rules['changepassword']);
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
                    }
                    if (is_array($valiationArr) && count($valiationArr) > 0) {
                        echo '****FAILURE****' . json_encode($valiationArr);
                    } else {
                        DB::beginTransaction();
                        //echo'<pre>';print_r($formDataArr);echo'</pre>';exit;
                        if (isset(Auth::user()->id) && Auth::user()->id != 0) {
                            $formDataArr['user']['updated_at']                  = date('Y-m-d h:i:s');
                            $formDataArr['user']['password']                    = Hash::make($formDataArr['formdata']['password']);
                            $formDataArr['user']['re_password']                 = Hash::make($formDataArr['formdata']['password']);
                            $formDataArr['user']['ogr_password']                = $formDataArr['formdata']['password'];
                            try{
                                DB::table('users')
                                        ->where('id', Auth::user()->id)
                                        ->update($formDataArr['user']);
                                DB::commit();
                                echo '****SUCCESS****User password has been changed successfully.';
                            }catch(ValidationException $e){
                                DB::rollback();
                                echo '****ERROR****Unable to change user password.';
                            } catch (\Exception $e) {
                                DB::rollback();
                                echo '****ERROR****Unable to change user password.';
                            }
                        }
                    }
                }
            } else {
                echo '****ERROR****Invalid form submission.';
            }
        } else {
            echo '****ERROR****Please login to register.';
        }exit;
    }
    public function userProfile(){
        $id = Auth::user()->id;
        if ($id != '') {
            $viewDataObj = DB::table('users')
                ->where('users.id','=',$id)
                ->select(array('users.id','users.full_name','users.email_id','users.user_photo','users.mobile_number'))
                ->first();
            $viewDataObjs = DB::table('users')
                ->where('users.id','=',$id)
                ->select(array('users.address'))    
                ->first();
        }
        return View::make('setting.userprofile', ['viewDataObj' => $viewDataObj,'viewDataObjs' => $viewDataObjs,'id'=>$id]);
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