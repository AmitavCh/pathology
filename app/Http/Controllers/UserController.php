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

class UserController extends Controller {

    public function login() {
        return view('users.login');
    }

    public function signup(Request $request) {
        $userObj = DB::table('users')
            ->where('users.email_id', '=', Input::get('email'))
            ->select('users.status', 'users.is_reset_req', 'users.id')
            ->first();
        //echo "<pre>"; print_r($userObj); echo "<pre>"; exit;
        if (is_object($userObj)) {
            if (isset($userObj->status) && $userObj->status == 0) {
                if (isset($userObj->is_reset_req) && $userObj->is_reset_req == 0) {
                    if (isset($userObj->status)) {
                        if ($userObj->status == 0) {
                            if (Auth::attempt(array('email_id' => Input::get('email'), 'password' => Input::get('password')))) {
                                return Redirect::to('dashboard/dashboard');
                            } else {
                                return Redirect::to('/')
                                        ->with('error', 'username/password combination was incorrect')
                                        ->withInput();
                            }
                        } else {
                            return Redirect::to('/')
                                    ->with('error', 'Your account is expired.')
                                    ->withInput();
                        }
                    }
                } else {
                    return Redirect::to('/')
                            ->with('error', 'Your have reset your password.Check your mail for password reset link.')
                            ->withInput();
                }
            } else if (isset($userObj->status) && $userObj->status == 2) {
                return Redirect::to('/')
                        ->with('error', 'Your account is Pending.')
                        ->withInput();
            } else {
                return Redirect::to('/')
                        ->with('error', 'Your account is inactive.')
                        ->withInput();
            }
        } else {
            return Redirect::to('/')
                    ->with('error', 'Invalid login.')
                    ->withInput();
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->to('/')->with('message', 'Your are logged out!');
    }

    public function addUser($id = 0) {
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $roleArr                                                                = Controller::getRoleListForMasterUser('roles','role_name');
        $orgArr                                                                 = Controller::getOrganizationLists('t_organizations','organization_name');
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
                                                )
                                            )    
                                    ->first();
            $viewDataObjs       =   DB::table('users')
                                    ->where('users.id', '=',$id)
                                    ->select(array('users.address'))
                                    ->first();
        }
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
            'roleArr'           => $roleArr,
            'orgArr'            => $orgArr,
            'branchArr'         => $branchArr,
            'sortFilterArr'     => ['user_name' => $user_name, 'reqType' => $reqType],
            'custompaginatorres'=> $custompaginatorres,
        ];
        if (isset($inputArr['reqType']) && $inputArr['reqType'] = 'XLS') {
            $this->layout = View::make('layouts.exportxls');
        }
        return view('users.add_user', ['layoutArr' => $layoutArr]);
    }
    
    public function validateMasterUser() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['User']) && is_array($formValArr['User']) && count($formValArr['User']) > 0) {
                $validator = Validator::make($formValArr['User'], User::$rules['master'], User::$messages);
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
    public function validateMasterUsers() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['User']) && is_array($formValArr['User']) && count($formValArr['User']) > 0) {
                $validator = Validator::make($formValArr['User'], User::$rules['update'], User::$messages);
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
    public function saveMasterUser(Request $request) {
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['User']) && $formData['User'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                $id = (int) $formData['User']['id'];
                if (isset($formData['User']['t_organizations_id']) && $formData['User']['t_organizations_id'] != '') {
                    $t_organizations_id                                         = $formData['User']['t_organizations_id'];
                } else {
                    $t_organizations_id                                         = '';
                }
                if (isset($formData['User']['t_branch_details_id']) && $formData['User']['t_branch_details_id'] != '') {
                    $t_branch_details_id                                        = $formData['User']['t_branch_details_id'];
                } else {
                    $t_branch_details_id                                        = '';
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
                            return Redirect::to('/user/add_user')->with('message', 'Data update successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/user/add_user')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/user/add_user')->with('error', ' Data Already Exist');
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
                            ->where('status', '=', 'Y')
                            ->count();
                    if ($tableObjCnt == 0) {
                        
                        try {
                            $loopCnt++;
                            $formCDataArr['User']['role_id']                    = $role_id;
                            $formCDataArr['User']['t_organizations_id']         = $t_organizations_id;
                            $formCDataArr['User']['t_branch_details_id']        = $t_branch_details_id;
                            $formCDataArr['User']['t_business_logistic_dtl_id'] = 0;
                            $formCDataArr['User']['full_name']                  = $full_name;
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
                            return Redirect::to('/user/add_user')->with('message', 'Data saved successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/user/add_user')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/user/add_user')->with('error', 'User Data Already Exist');
                    }
                }
            } else {
                return Redirect::to('/user/add_user')->with('error', 'Invalid form submission');
            }
        } else {
            return Redirect::to('/user/login')->with('error', 'Please login to register');
        }exit;
    }
    public function changepassword(){
        $userArr = Auth::user();
        $layoutArr = array(
            'userArr' => $userArr
        );
        return View::make('users.changepassword', ['layoutArr' => $layoutArr]);
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
    public function Profile(){
        $id = Auth::user()->id;
        if ($id != '') {
            $viewDataObj = DB::table('users')
                ->where('users.id','=',$id)
                ->select(array('users.id','users.fullname','users.email','users.gender','users.user_photo','users.mobile_number'))
                ->first();
            $viewDataObjs = DB::table('users')
                ->where('users.id','=',$id)
                ->select(array('users.address'))    
                ->first();
        }
        return View::make('setting.user_profile', ['viewDataObj' => $viewDataObj,'viewDataObjs' => $viewDataObjs,'id'=>$id]);
    }
    
}
