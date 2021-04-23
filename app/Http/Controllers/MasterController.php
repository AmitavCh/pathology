<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Models\TFeatures;
use App\Models\TOrganizations;
use App\User;
use DB;
use Hash;
use View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Redirect;
use Validator;
use Illuminate\Http\Request;

class MasterController extends Controller {

    public function addRole($id = 0) {
        $viewDataObj = "";
        $role_name = Input::get('search_role_name');
        $dbObj = DB::table('roles')
            ->orderby('roles.id', 'desc');
        $recordCnt = $dbObj->count();

        if (isset($role_name) && $role_name != '') {
            $dbObj->where('roles.role_name', 'LIKE', "$role_name%");
        }
        $custompaginatorres = $dbObj->paginate('5');
        $layoutArr = [
            'viewDataObj' => $viewDataObj,
            'sortFilterArr' => ['role_name' => $role_name],
            'custompaginatorres' => $custompaginatorres,
        ];
        return View::make('master.add_role', ['layoutArr' => $layoutArr]);
    }
    
    public function addRoleData($id = 0) {
        $viewDataObj = "";
        $id = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('roles')
                ->where('roles.id', '=', "$id")
                ->first();
        }
        $layoutArr = [
            'viewDataObj' => $viewDataObj,
        ];
        return View::make('master.add_role_data', ['layoutArr' => $layoutArr]);
    }
    
    public function saveRole() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                parse_str($formData['formdata'], $formDataArr);
                // echo "<pre>"; print_r($formDataArr); echo "<pre>"; exit;
                if (isset($formDataArr['Role']) && is_array($formDataArr['Role']) && count($formDataArr['Role']) > 0) {
                    $validator = Validator::make($formDataArr['Role'], Role::$rules, Role::$messages);
                    if ($validator->fails()) {
                        $errorArr = $validator->getMessageBag()->toArray();
                        if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                            foreach ($errorArr as $errorKey => $errorVal) {
                                $valiationArr[] = array(
                                    'modelField' => $errorKey,
                                    'modelErrorMsg' => $errorVal[0],
                                );
                            }
                            echo '****FAILURE****' . json_encode($valiationArr);
                            exit;
                        }
                    } else {
                        $id = (int) $formDataArr['id'];
                        $role_name = trim($formDataArr['Role']['role_name']);

                        if (isset($id) && $id != 0) {
                            $tableObjCnt = DB::table('roles')
                                ->where('role_name', '=', $role_name)
                                ->where('id', '!=', $id)
                                ->count();
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;

                                    $formCDataArr['Role']['role_name'] = $role_name;
                                    $formCDataArr['Role']['updated_at'] = date('Y-m-d h:i:s');
                                    DB::table('roles')
                                        ->where('id', $id)
                                        ->update($formCDataArr['Role']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Role has been updated successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Role already Exist.';
                            }
                        } else {
                            $tableObjCnt = DB::table('roles')
                                ->where('role_name', '=', $role_name)
                                ->count();
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['Role']['role_name'] = $role_name;
                                    $formCDataArr['Role']['created_at'] = date('Y-m-d h:i:s');
                                    $formCDataArr['Role']['updated_at'] = date('Y-m-d h:i:s');
                                    DB::table('roles')->insert($formCDataArr['Role']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Role has been saved successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Role already Exist.';
                            }
                        }
                    }
                }
            }exit;
        } else {
            echo '****ERROR****please login to save data.';
        }exit;
    }

    public function roleActive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['Role']['is_active'] = 0;
                $formCDataArr['Role']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('roles')
                    ->where('id', $id)
                    ->update($formCDataArr['Role']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****Role has been Active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }

    public function roleDeactive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['Role']['is_active'] = 1;
                $formDataArr['Role']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('roles')
                    ->where('id', $id)
                    ->update($formDataArr['Role']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****Role has been In-active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }

    public function addMenu($id = 0) {
        $viewDataObj = "";
        $menu_name = Input::get('search_menu_name');
        $dbObj = DB::table('menus')
            ->orderby('menus.id', 'desc');
        $recordCnt = $dbObj->count();

        if (isset($menu_name) && $menu_name != '') {
            $dbObj->where('menus.menu_name', 'LIKE', "$menu_name%");
        }
        $custompaginatorres = $dbObj->paginate('10');
        $layoutArr = [
            'viewDataObj' => $viewDataObj,
            'sortFilterArr' => ['menu_name' => $menu_name],
            'custompaginatorres' => $custompaginatorres,
        ];
        return View::make('master.add_menu', ['layoutArr' => $layoutArr]);
    }
    
    public function addMenuData($id = 0) {
        $viewDataObj = "";
        $id = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('menus')
                ->where('menus.id', '=', "$id")
                ->first();
        }
        $layoutArr = [
            'viewDataObj' => $viewDataObj,
        ];
        return View::make('master.add_menu_data', ['layoutArr' => $layoutArr]);
    }
    
    public function saveMenu() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                DB::beginTransaction();
                $loopCnt = 0;
                $saveCnt = 0;
                parse_str($formData['formdata'], $formDataArr);
                // echo "<pre>"; print_r($formDataArr); echo "<pre>"; exit;
                if (isset($formDataArr['Menu']) && is_array($formDataArr['Menu']) && count($formDataArr['Menu']) > 0) {
                    $validator = Validator::make($formDataArr['Menu'], Menu::$rules, Menu::$messages);
                    if ($validator->fails()) {
                        $errorArr = $validator->getMessageBag()->toArray();
                        if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                            foreach ($errorArr as $errorKey => $errorVal) {
                                $valiationArr[] = array(
                                    'modelField' => $errorKey,
                                    'modelErrorMsg' => $errorVal[0],
                                );
                            }
                            echo '****FAILURE****' . json_encode($valiationArr);
                            exit;
                        }
                    } else {
                        $id = (int) $formDataArr['id'];
                        $menu_name = trim($formDataArr['Menu']['menu_name']);
                        $menu_order = trim($formDataArr['Menu']['menu_order']);
                        if (isset($formDataArr['Menu']['menu_icon']) && $formDataArr['Menu']['menu_icon'] != '') {
                            $menu_icon = $formDataArr['Menu']['menu_icon'];
                        } else {
                            $menu_icon = '';
                        }
                        if (isset($id) && $id != 0) {
                            $tableObjCnt = DB::table('menus')
                                ->where('menu_name', '=', $menu_name)
                                ->where('id', '!=', $id)
                                ->count();
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;

                                    $formCDataArr['Menu']['menu_name'] = $menu_name;
                                    $formCDataArr['Menu']['menu_order'] = $menu_order;
                                    $formCDataArr['Menu']['menu_icon'] = $menu_icon;
                                    $formCDataArr['Menu']['updated_at'] = date('Y-m-d h:i:s');
                                    DB::table('menus')
                                        ->where('id', $id)
                                        ->update($formCDataArr['Menu']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Menu has been updated successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Menu already Exist.';
                            }
                        } else {
                            $tableObjCnt = DB::table('menus')
                                ->where('menu_name', '=', $menu_name)
                                ->count();
                            if ($tableObjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formCDataArr['Menu']['menu_name'] = $menu_name;
                                    $formCDataArr['Menu']['menu_order'] = $menu_order;
                                    $formCDataArr['Menu']['menu_icon'] = $menu_icon;
                                    $formCDataArr['Menu']['created_at'] = date('Y-m-d h:i:s');
                                    $formCDataArr['Menu']['updated_at'] = date('Y-m-d h:i:s');
                                    DB::table('menus')->insert($formCDataArr['Menu']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****Menu has been saved successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                DB::rollback();
                                echo '****ERROR****This Menu already Exist.';
                            }
                        }
                    }
                }
            }exit;
        } else {
            echo '****ERROR****please login to save data.';
        }exit;
    }

    public function menuActive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['Menu']['is_active'] = 0;
                $formCDataArr['Menu']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('menus')
                    ->where('id', $id)
                    ->update($formCDataArr['Menu']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****Menu has been Active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }

    public function menuDeactive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['Menu']['is_active'] = 1;
                $formDataArr['Menu']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('menus')
                    ->where('id', $id)
                    ->update($formDataArr['Menu']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****menu has been In-active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }

    public function addSubMenu($id = 0) {
        $viewDataObj = "";
        $sub_menu_name = Input::get('search_sub_menu_name');
        $search_menu_id = Input::get('search_menu_id');
        $dbObj = DB::table('sub_menus')
            ->orderby('sub_menus.id', 'desc');
        if (isset($sub_menu_name) && $sub_menu_name != '') {
            $dbObj->where('sub_menus.sub_menu_name', 'LIKE', "$sub_menu_name%");
        }
        if (isset($search_menu_id) && $search_menu_id != '') {
            $dbObj->where('sub_menus.menu_id','=',$search_menu_id);
        }
        $custompaginatorres = $dbObj->paginate('10');
        $menuArr = Controller::getMasterList('menus', 'menu_name');
        $layoutArr = [
            'sortFilterArr' => ['sub_menu_name' => $sub_menu_name],
            'custompaginatorres' => $custompaginatorres,
            'menuArr' => $menuArr,
        ];
        return View::make('master.add_sub_menu', ['layoutArr' => $layoutArr]);
    }
    
    public function addSubMenuData($id = 0) {
        $viewDataObj = "";
        $id = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('sub_menus')
                ->where('sub_menus.id', '=', "$id")
                ->first();
        }
        $menuArr = Controller::getMasterList('menus', 'menu_name');
        $layoutArr = [
            'viewDataObj' => $viewDataObj,
            'menuArr' => $menuArr,
        ];
        return View::make('master.add_sub_menu_data', ['layoutArr' => $layoutArr]);
    }
    
    public function saveSubMenu() {
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                parse_str($formData['formdata'], $formDataArr);
                if (isset($formDataArr['SubMenu']) && is_array($formDataArr['SubMenu']) && count($formDataArr['SubMenu']) > 0) {
                    $validator = Validator::make($formDataArr['SubMenu'], SubMenu::$rules, SubMenu::$messages);
                    if ($validator->fails()) {
                        $errorArr = $validator->getMessageBag()->toArray();
                        if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                            foreach ($errorArr as $errorKey => $errorVal) {
                                $valiationArr[] = array(
                                    'modelField' => $errorKey,
                                    'modelErrorMsg' => $errorVal[0],
                                );
                            }
                            echo '****FAILURE****' . json_encode($valiationArr);
                            exit;
                        }
                    } else {
                        DB::beginTransaction();
                        $loopCnt = 0;
                        $saveCnt = 0;
                        $id = (int) $formDataArr['id'];
                        $menu_id = $formDataArr['SubMenu']['menu_id'];
                        $sub_menu_name = trim($formDataArr['SubMenu']['sub_menu_name']);
                        $sub_menu_url = trim($formDataArr['SubMenu']['sub_menu_url']);
						$action = trim($formDataArr['SubMenu']['action']);
                        if (isset($formDataArr['SubMenu']['sub_menu_icon']) && $formDataArr['SubMenu']['sub_menu_icon'] != '') {
                            $sub_menu_icon = $formDataArr['SubMenu']['sub_menu_icon'];
                        } else {
                            $sub_menu_icon = '';
                        }
                        if (isset($id) && $id != 0) {
                            $dbobjCnt = DB::table('sub_menus')
                                ->where('sub_menus.menu_id', '=', $menu_id)
                                ->where('sub_menus.sub_menu_name', '=', "$sub_menu_name")
                                ->where('sub_menus.sub_menu_url', '=', "$sub_menu_url")
                                ->where('sub_menus.id', '!=', $id)
                                ->count();
                            if ($dbobjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formDataArr['SubMenu']['updated_at'] = date('Y-m-d h:i:s');
                                    DB::table('sub_menus')
                                        ->where('id', $id)
                                        ->update($formDataArr['SubMenu']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****SubMenu has been Updated successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                echo '****ERROR****This SubMenu is already exist.';
                            }
                        } else {
                            $dbobjCnt = DB::table('sub_menus')
                                ->where('sub_menus.menu_id', '=', $menu_id)
                                ->where('sub_menus.sub_menu_name', '=', "$sub_menu_name")
                                ->where('sub_menus.sub_menu_url', '=', "$sub_menu_url")
                                ->count();
                            if ($dbobjCnt == 0) {
                                try {
                                    $loopCnt++;
                                    $formDataArr['SubMenu']['created_at'] = date('Y-m-d h:i:s');
                                    $formDataArr['SubMenu']['updated_at'] = date('Y-m-d h:i:s');
                                    DB::table('sub_menus')->insert($formDataArr['SubMenu']);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    DB::rollback();
                                } catch (\Exception $e) {
                                    DB::rollback();
                                }
                                if ($loopCnt == $saveCnt) {
                                    DB::commit();
                                    echo '****SUCCESS****SubMenu has been saved successfully.';
                                } else {
                                    DB::rollback();
                                    echo '****ERROR****Unable to save data.';
                                }
                            } else {
                                echo '****ERROR****This SubMenu is already exist.';
                            }
                        }
                    }
                }
            }exit;
        } else {

            echo '****ERROR****please login to save data.';
        }exit;
    }

    public function submenuActive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formCDataArr['SubMenu']['is_active'] = "Y";
                $formCDataArr['SubMenu']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('sub_menus')
                    ->where('id', $id)
                    ->update($formCDataArr['SubMenu']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****Sub Menu has been Active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }

    public function submenuDeactive() {
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $loopCnt = 0;
            $saveCnt = 0;
            $inputData = Input::all();
            $id = $inputData['record_id'];
            DB::beginTransaction();
            try {
                $loopCnt++;
                $formDataArr['SubMenu']['is_active'] = "N";
                $formDataArr['SubMenu']['updated_at'] = date('Y-m-d h:i:s');
                DB::table('sub_menus')
                    ->where('id', $id)
                    ->update($formDataArr['SubMenu']);
                $saveCnt++;
            } catch (ValidationException $e) {
                DB::rollback();
            } catch (\Exception $e) {
                DB::rollback();
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "</pre>"; exit;
            if ($loopCnt == $saveCnt) {
                DB::commit();
                echo '****SUCCESS****Sub menu has been In-active successfully.';
            } else {
                DB::rollback();
                echo '****ERROR****Unable to delete record.';
            }
        } else {
            echo '****ERROR****please login to delete.';
            return Redirect::to('user/login');
        }exit;
    }

    public function addRoleMenu() {
        $layoutArr = [];
        $viewDataObj = [];
        $roleArr = Controller::getMasterList('roles', 'role_name');

        $layoutArr = array(
            'viewDataObj' => $viewDataObj,
            'roleArr' => $roleArr,
        );
        return view('master.add_role_menu', compact('layoutArr'));
    }

    public function rolewisemenu() {
        $menuSubMenuArr = array();
        $editMenuList = array();
        $editSubMenuList = array();
        $menuSubMenuArr = [];
        $role_id = (int) Input::get('role_id');
        if ($role_id != 0) {
            $editMenuListFind = DB::table('role_menus')
                ->where('role_menus.role_id', '=', $role_id)
                ->select(
                    array(
                        'role_menus.menu_id', 'role_menus.sub_menu_id',
                    )
                )
                ->get();
            if (is_object($editMenuListFind)) {
                foreach ($editMenuListFind as $editMenuListKey => $editMenuListVal) {
                    $editMenuList[] = $editMenuListVal->menu_id;
                    $editSubMenuList[] = $editMenuListVal->sub_menu_id;
                }
            }
        }
        $menuObj = DB::table('menus')
            ->where('menus.is_active', '=', 0)
            ->orderBy('menus.menu_order')
            ->get();
        if (is_object($menuObj)) {
            foreach ($menuObj as $menuKey => $menuData) {
                $subMenuObj = DB::table('sub_menus')
                    ->where('menu_id', '=', $menuData->id)
                    ->where('is_active', '=', "Y")
                    ->orderBy('sub_menu_order')
                    ->get();

                $menuSubMenuArr[$menuData->id] = $subMenuObj;
            }
        }
        $layoutArr = array(
            'menuSubMenuArr' => $menuSubMenuArr,
            'editMenuList' => $editMenuList,
            'editSubMenuList' => $editSubMenuList,
        );
        //echo'<pre>';print_r($layoutArr);echo'</pre>';exit;
        return view('master.role-wise-menu', compact('layoutArr'));
    }

    public function saveRoleMenu() {
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                parse_str($formData['formdata'], $formDataArr);
                $validator = Validator::make($formDataArr['RoleMenu'], RoleMenu::$rules, RoleMenu::$messages);
                if ($validator->fails()) {
                    $errorArr = $validator->getMessageBag()->toArray();
                    if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                        foreach ($errorArr as $errorKey => $errorVal) {
                            $valiationArr[] = array(
                                'modelField' => $errorKey,
                                'modelErrorMsg' => $errorVal[0],
                            );
                        }
                        echo '****FAILURE****' . json_encode($valiationArr);
                        exit;
                    }
                } else {
                    if ((isset($formDataArr['menuIdArr']) && is_array($formDataArr['menuIdArr']) && count($formDataArr['menuIdArr']) > 0) ||
                        (isset($formDataArr['subMenuIdArr']) && is_array($formDataArr['subMenuIdArr']) && count($formDataArr['subMenuIdArr']) > 0)
                    ) {
                        $loopCnt = 0;
                        $saveCnt = 0;
                        $role_id = $formDataArr['RoleMenu']['role_id'];
                        DB::beginTransaction();

                        if (DB::table('role_menus')->where('role_id', '=', $role_id)->count()) {
                            try {
                                $loopCnt++;
                                DB::table('role_menus')->where('role_id', '=', $role_id)->delete();
                                $saveCnt++;
                            } catch (ValidationException $e) {
                                
                            } catch (\Exception $e) {
                                
                            }
                        }
                        if (isset($formDataArr['menuIdArr']) && is_array($formDataArr['menuIdArr']) && count($formDataArr['menuIdArr']) > 0) {
                            foreach ($formDataArr['menuIdArr'] as $key => $val) {
                                $loopCnt++;
                                $dataArrInsert = array(
                                    'role_id' => $role_id,
                                    'menu_id' => $val,
                                    'sub_menu_id' => null,
                                    'is_active' => 0,
                                    'created_at' => date('Y-m-d h:i:s'),
                                    'updated_at' => date('Y-m-d h:i:s'),
                                );
                                try {
                                    DB::table('role_menus')->insert($dataArrInsert);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    
                                } catch (\Exception $e) {
                                    
                                }
                            }
                        }
                        if (isset($formDataArr['subMenuIdArr']) && is_array($formDataArr['subMenuIdArr']) && count($formDataArr['subMenuIdArr']) > 0) {
                            foreach ($formDataArr['subMenuIdArr'] as $key => $val) {
                                $loopCnt++;
                                $menu_id = Controller::getMasterID($val, 'sub_menus', 'menu_id');
                                $dataArrInsert = array(
                                    'role_id' => $role_id,
                                    'menu_id' => $menu_id,
                                    'sub_menu_id' => $val,
                                    'is_active' => 0,
                                    'created_at' => date('Y-m-d h:i:s'),
                                    'updated_at' => date('Y-m-d h:i:s'),
                                );
                                try {
                                    DB::table('role_menus')->insert($dataArrInsert);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    
                                } catch (\Exception $e) {
                                    
                                }
                            }
                        }
                        // echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>";  exit;
                        if ($loopCnt == $saveCnt) {
                            DB::commit();
                            echo '****SUCCESS****Role menu has been saved successfully.';
                        } else {
                            DB::rollback();
                            echo '****ERROR****Unable to save Role menu.';
                        }
                    } else {
                        echo '****ERROR****Please select at least one menu or sub menu.';
                    }exit;
                }
            }
        }
    }

    public function addFeatures($id = 0) {
        $layoutArr = [];
        $viewDataObj = [];
        $id = base64_decode(base64_decode($id));
        if ($id) {
            $viewDataObj = DB::table('t_features')
                ->where('t_features.id','=',$id)
                ->first();
        }
        $dbObj = DB::table('t_features')
            ->orderby('t_features.id', 'desc');
        $custompaginatorres = $dbObj->paginate('10');
        $layoutArr = array(
            'viewDataObj' => $viewDataObj,
            'sortFilterArr' => [],
            'custompaginatorres' => $custompaginatorres,
        );
        return View::make('master.add_features', ['layoutArr' => $layoutArr,'id'=>$id]);
    }
    
    public function roleWiseMenuList() {
        $menuSubMenuArr = array();
        $editMenuList = array();
        $editSubMenuList = array();
        $menuSubMenuArr = [];
        $menuObj = DB::table('menus')
            ->where('menus.is_active', '=', 0)
            ->orderBy('menus.menu_order')
            ->get();
        if (is_object($menuObj)) {
            foreach ($menuObj as $menuKey => $menuData) {
                $subMenuObj = DB::table('sub_menus')
                    ->where('menu_id', '=', $menuData->id)
                    ->where('is_active', '=', "Y")
                    ->orderBy('sub_menu_order')
                    ->get();

                $menuSubMenuArr[$menuData->id] = $subMenuObj;
            }
        }
        $layoutArr = array(
            'menuSubMenuArr' => $menuSubMenuArr,
            'editMenuList' => $editMenuList,
            'editSubMenuList' => $editSubMenuList,
        );
         return view('master.role_wise_menu_list', compact('layoutArr'));
    }
    
    public function roleWiseMenuListUpdate() {
        $menuSubMenuArr = array();
        $editMenuList = array();
        $editSubMenuList = array();
        $inputData = Input::all();
        $menuSubMenuArr = [];
        $id        = $inputData['id'];
        //echo'<pre>';print_r($id);echo'</pre>';exit;
        if(1){
            $editMenuListFind = DB::table('t_features_details')
                ->select(
                    array(
                        't_features_details.menu_id', 't_features_details.sub_menu_id',
                    )
                )
                ->where('t_features_details.t_features_id','=',$id)
                ->get();
            if (is_object($editMenuListFind)) {
                foreach ($editMenuListFind as $editMenuListKey => $editMenuListVal) {
                    $editMenuList[] = $editMenuListVal->menu_id;
                    $editSubMenuList[] = $editMenuListVal->sub_menu_id;
                }
            }
        }
        $menuObj = DB::table('menus')
            ->where('menus.is_active', '=', 0)
            ->orderBy('menus.menu_order')
            ->get();
        if (is_object($menuObj)) {
            foreach ($menuObj as $menuKey => $menuData) {
                $subMenuObj = DB::table('sub_menus')
                    ->where('menu_id', '=', $menuData->id)
                    ->where('is_active', '=', "Y")
                    ->orderBy('sub_menu_order')
                    ->get();

                $menuSubMenuArr[$menuData->id] = $subMenuObj;
            }
        }
        $layoutArr = array(
            'menuSubMenuArr' => $menuSubMenuArr,
            'editMenuList' => $editMenuList,
            'editSubMenuList' => $editSubMenuList,
        );
         return view('master.role_wise_menu_list', compact('layoutArr'));
    }
    
    public function saveFeaturesData() {
        $valiationArr = array();
        if (isset(Auth::user()->id) && Auth::user()->id) {
            $formData = Input::all();
            $formDataArr = array();
            if (isset($formData['formdata']) && $formData['formdata'] != '') {
                parse_str($formData['formdata'], $formDataArr);
                //echo'<pre>';print_r($formDataArr);echo'</pre>';exit;
                $validator = Validator::make($formDataArr['TFeatures'], TFeatures::$rules, TFeatures::$messages);
                if ($validator->fails()) {
                    $errorArr = $validator->getMessageBag()->toArray();
                    if (isset($errorArr) && is_array($errorArr) && count($errorArr) > 0) {
                        foreach ($errorArr as $errorKey => $errorVal) {
                            $valiationArr[] = array(
                                'modelField' => $errorKey,
                                'modelErrorMsg' => $errorVal[0],
                            );
                        }
                        echo '****FAILURE****' . json_encode($valiationArr);
                        exit;
                    }
                } else {
                    if ((isset($formDataArr['menuIdArr']) && is_array($formDataArr['menuIdArr']) && count($formDataArr['menuIdArr']) > 0) ||
                        (isset($formDataArr['subMenuIdArr']) && is_array($formDataArr['subMenuIdArr']) && count($formDataArr['subMenuIdArr']) > 0)
                    ) {
                        $loopCnt = 0;
                        $saveCnt = 0;
                        $feature_name = $formDataArr['TFeatures']['feature_name'];
                        $id           = $formDataArr['TFeatures']['id'];
                        //echo'<pre>';print_r($formDataArr);echo'</pre>';exit;
                        DB::beginTransaction();
                        if((isset($id) && $id == '')){
                            try {
                                $loopCnt++;
                                $formCDataArr['TFeatures']['feature_name']      = $feature_name;
                                $formCDataArr['TFeatures']['status']            = "Y";
                                $formCDataArr['TFeatures']['created_at']        = date('Y-m-d h:i:s');
                                $formCDataArr['TFeatures']['updated_at']        = date('Y-m-d h:i:s');
                                $t_features_id = DB::table('t_features')->insertGetId($formCDataArr['TFeatures']);
                                $saveCnt++;
                            } catch (ValidationException $e) {
                                DB::rollback();
                            } catch (\Exception $e) {
                                DB::rollback();
                            }
                        }else{
                           $t_features_id = $id;
                           try {
                                $loopCnt++;
                                $formCDataArr['TFeatures']['feature_name']      = $feature_name;
                                $formCDataArr['TFeatures']['status']            = "Y";
                                $formCDataArr['TFeatures']['updated_at'] = date('Y-m-d h:i:s');
                                DB::table('t_features')
                                    ->where('id', $t_features_id)
                                    ->update($formCDataArr['TFeatures']);
                                $saveCnt++;
                            } catch (ValidationException $e) {
                                DB::rollback();
                            } catch (\Exception $e) {
                                DB::rollback();
                            }
                            if (DB::table('t_features_details')
                                ->where('t_features_id','=',$t_features_id)
                                ->where('t_organizations_id','=',0)
                                ->count()) 
                            {
                                try {
                                    $loopCnt++;
                                    DB::table('t_features_details')->where('t_features_id', '=', $t_features_id)->delete();
                                    $saveCnt++;
                                } catch (ValidationException $e) {

                                } catch (\Exception $e) {

                                }
                            } 
                        }
                        if (isset($formDataArr['menuIdArr']) && is_array($formDataArr['menuIdArr']) && count($formDataArr['menuIdArr']) > 0) {
                            foreach ($formDataArr['menuIdArr'] as $key => $val) {
                                $loopCnt++;
                                $dataArrInsert = array(
                                    't_features_id'     =>  $t_features_id,
                                    'menu_id'           =>  $val,
                                    'sub_menu_id'       =>  0,
                                    'status'            =>  "Y",
                                    'created_at'        => date('Y-m-d h:i:s'),
                                    'updated_at'        => date('Y-m-d h:i:s'),
                                );
                                try {
                                    DB::table('t_features_details')->insert($dataArrInsert);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    
                                } catch (\Exception $e) {
                                    
                                }
                            }
                        }
                        if (isset($formDataArr['subMenuIdArr']) && is_array($formDataArr['subMenuIdArr']) && count($formDataArr['subMenuIdArr']) > 0) {
                            foreach ($formDataArr['subMenuIdArr'] as $key => $val) {
                                $loopCnt++;
                                $menu_id = Controller::getMasterID($val, 'sub_menus', 'menu_id');
                                $dataArrInsert = array(
                                    't_features_id' => $t_features_id,
                                    'menu_id'       => $menu_id,
                                    'sub_menu_id'   => $val,
                                    'status'        => "Y",
                                    'created_at'    => date('Y-m-d h:i:s'),
                                    'updated_at'    => date('Y-m-d h:i:s'),
                                );
                                try {
                                    DB::table('t_features_details')->insert($dataArrInsert);
                                    $saveCnt++;
                                } catch (ValidationException $e) {
                                    
                                } catch (\Exception $e) {
                                    
                                }
                            }
                        }
                        // echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>";  exit;
                        if ($loopCnt == $saveCnt) {
                            DB::commit();
                            echo '****SUCCESS****Features has been saved successfully.';
                        } else {
                            DB::rollback();
                            echo '****ERROR****Unable to save Features.';
                        }
                    } else {
                        echo '****ERROR****Please select at least one menu or sub menu.';
                    }exit;
                }
            }
        }
    }
    
    public function addOrganizationDetails(){
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $organization_name                                                      = '';
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
        return view('master.add_organization_details',['layoutArr' => $layoutArr]);
    }
    
    public function addOrganizationData($id=0){
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $viewDataObj1                                                           = "";
        $reqType                                                                = '';
        $organization_name                                                      = '';
        $id                                                                     = base64_decode(base64_decode($id));
        if($id != 0){
            $viewDataObj                                                        = DB::table('t_organizations')
                                                                                ->where('t_organizations.id', '=',$id)
                                                                                ->select(array('t_organizations.id',
                                                                                               't_organizations.organization_name',
                                                                                               't_organizations.mobile_number',
                                                                                               't_organizations.alter_mobile_number',
                                                                                               't_organizations.email_id',
                                                                                               't_organizations.logo',
                                                                                               't_organizations.status',
                                                                                               't_organizations.pan_number',
                                                                                               't_organizations.gst_number',
                                                                                               't_organizations.points_of_contact',
                                                                                               't_organizations.number_of_branch',
                                                                                               't_organizations.bank_name',
                                                                                               't_organizations.branch_name',
                                                                                               't_organizations.ifsc_code',
                                                                                               't_organizations.account_number',
                                                                                            )
                                                                                        )
                                                                                ->first();
            $viewDataObjs                                                       = DB::table('t_organizations')
                                                                                ->where('t_organizations.id', '=',$id)
                                                                                ->select(array('t_organizations.address'))
                                                                                ->first();
            $viewDataObj1                                                       = DB::table('t_features_details')
                                                                                ->where('t_features_details.t_organizations_id','=',$id)
                                                                                ->leftjoin('t_features','t_features_details.t_features_id','=','t_features.id')
                                                                                ->select(array('t_features.id','t_features.feature_name'))
                                                                                ->pluck('id')->toArray();
        }
        $packagesArr                                                            = Controller::getPackagesList();
        
        $layoutArr = [
                        'viewDataObj'           => $viewDataObj,
                        'viewDataObjs'          => $viewDataObjs,
                        'viewDataObj1'          => $viewDataObj1,
                        'packagesArr'           => $packagesArr,
                    ];
        return view('master.add_organization_data',['layoutArr' => $layoutArr,'id'=>$id]);
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
                if (isset($formData['TOrganizations']['alter_mobile_number']) && $formData['TOrganizations']['alter_mobile_number'] != '') {
                    $alter_mobile_number                                        = $formData['TOrganizations']['alter_mobile_number'];
                } else {
                    $alter_mobile_number                                        = '';
                }
                if (isset($formData['TOrganizations']['address']) && $formData['TOrganizations']['address'] != '') {
                    $address                                                    = $formData['TOrganizations']['address'];
                } else {
                    $address                                                    = '';
                }
                if (isset($formData['TOrganizations']['pan_number']) && $formData['TOrganizations']['pan_number'] != '') {
                    $pan_number                                                 = $formData['TOrganizations']['pan_number'];
                } else {
                    $pan_number                                                 = '';
                }
                if (isset($formData['TOrganizations']['gst_number']) && $formData['TOrganizations']['gst_number'] != '') {
                    $gst_number                                                 = $formData['TOrganizations']['gst_number'];
                } else {
                    $gst_number                                                 = '';
                }
                if (isset($formData['TOrganizations']['points_of_contact']) && $formData['TOrganizations']['points_of_contact'] != '') {
                    $points_of_contact                                          = $formData['TOrganizations']['points_of_contact'];
                } else {
                    $points_of_contact                                          = '';
                }
                if (isset($formData['TOrganizations']['number_of_branch']) && $formData['TOrganizations']['number_of_branch'] != '') {
                    $number_of_branch                                           = $formData['TOrganizations']['number_of_branch'];
                } else {
                    $number_of_branch                                           = '';
                }
                if (isset($formData['TOrganizations']['bank_name']) && $formData['TOrganizations']['bank_name'] != '') {
                    $bank_name                                                  = $formData['TOrganizations']['bank_name'];
                } else {
                    $bank_name                                                  = '';
                }
                if (isset($formData['TOrganizations']['branch_name']) && $formData['TOrganizations']['branch_name'] != '') {
                    $branch_name                                                = $formData['TOrganizations']['branch_name'];
                } else {
                    $branch_name                                                = '';
                }
                if (isset($formData['TOrganizations']['ifsc_code']) && $formData['TOrganizations']['ifsc_code'] != '') {
                    $ifsc_code                                                  = $formData['TOrganizations']['ifsc_code'];
                } else {
                    $ifsc_code                                                  = '';
                }
                if (isset($formData['TOrganizations']['account_number']) && $formData['TOrganizations']['account_number'] != '') {
                    $account_number                                             = $formData['TOrganizations']['account_number'];
                } else {
                    $account_number                                             = '';
                }
                if(isset($formData['t_features_id']) && is_array($formData['t_features_id']) && count($formData['t_features_id']) > 0){
                //echo'<pre>';print_r($formData);echo'</pre>';exit;
                
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
                            $formCDataArr['TOrganizations']['alter_mobile_number']   = $alter_mobile_number;
                            $formCDataArr['TOrganizations']['pan_number']            = $pan_number;
                            $formCDataArr['TOrganizations']['gst_number']            = $gst_number;
                            $formCDataArr['TOrganizations']['points_of_contact']     = $points_of_contact;
                            $formCDataArr['TOrganizations']['number_of_branch']      = $number_of_branch;
                            $formCDataArr['TOrganizations']['bank_name']             = $bank_name;
                            $formCDataArr['TOrganizations']['branch_name']           = $branch_name;
                            $formCDataArr['TOrganizations']['ifsc_code']             = $ifsc_code;
                            $formCDataArr['TOrganizations']['account_number']        = $account_number;
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
                        if (DB::table('t_features_details')
                            ->where('t_organizations_id','=',$id)
                            ->where('t_branch_details_id','=',0)
                            ->count()) 
                        {
                            try {
                                $loopCnt++;
                                DB::table('t_features_details')->where('t_organizations_id','=',$id)->delete();
                                $saveCnt++;
                            } catch (ValidationException $e) {

                            } catch (\Exception $e) {

                            }
                        }
                        foreach($formData['t_features_id'] as $key=>$val){
                            $tableFeaObjCnt    = DB::table('t_features_details')
                                                    ->where('t_features_details.t_organizations_id','=',0)
                                                    ->where('t_features_details.t_features_id','=',$val)
                                                    ->where('t_features_details.status', '=', 'Y')
                                                    ->get();
                            foreach($tableFeaObjCnt as $keys=>$vals){
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TFeaturesDetails']['t_organizations_id']    = $id;
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
                            return Redirect::to('/master/add_organization_data')->with('message', 'Data update successfully');
                        }else{
                            DB::rollback();
                            return Redirect::to('/master/add_organization_data')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/master/add_organization_data')->with('error', 'Data Already Exist');
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
                            $formCDataArr['TOrganizations']['alter_mobile_number']   = $alter_mobile_number;
                            $formCDataArr['TOrganizations']['pan_number']            = $pan_number;
                            $formCDataArr['TOrganizations']['gst_number']            = $gst_number;
                            $formCDataArr['TOrganizations']['points_of_contact']     = $points_of_contact;
                            $formCDataArr['TOrganizations']['number_of_branch']      = $number_of_branch;
                            $formCDataArr['TOrganizations']['bank_name']             = $bank_name;
                            $formCDataArr['TOrganizations']['branch_name']           = $branch_name;
                            $formCDataArr['TOrganizations']['ifsc_code']             = $ifsc_code;
                            $formCDataArr['TOrganizations']['account_number']        = $account_number;
                            $formCDataArr['TOrganizations']['address']               = $address;
                            $formCDataArr['TOrganizations']['logo']                  = $photoName;
                            $formCDataArr['TOrganizations']['status']                = "Y";
                            $formCDataArr['TOrganizations']['created_by']            = Auth::user()->id;
                            $formCDataArr['TOrganizations']['created_at']            = date('Y-m-d h:i:s');
                            $formCDataArr['TOrganizations']['updated_at']            = date('Y-m-d h:i:s');
                            $t_organizations_id = DB::table('t_organizations')->insertGetId($formCDataArr['TOrganizations']);
                            $saveCnt++;
                        } catch (ValidationException $e) {
                            DB::rollback();
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
                        foreach($formData['t_features_id'] as $key=>$val){
                            $tableFeaObjCnt    = DB::table('t_features_details')
                                                    ->where('t_features_details.t_organizations_id','=',0)
                                                    ->where('t_features_details.t_features_id','=',$val)
                                                    ->where('t_features_details.status', '=', 'Y')
                                                    ->get();
                            foreach($tableFeaObjCnt as $keys=>$vals){
                                try {
                                    $loopCnt++;
                                    $formCDataArr['TFeaturesDetails']['t_organizations_id']    = $t_organizations_id;
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
                            return Redirect::to('/master/add_organization_data')->with('message', 'Data saved successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/master/add_organization_data')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/master/add_organization_data')->with('error', 'Data Already Exist');
                    }
                }
                }else{
                    return Redirect::to('/master/add_organization_data')->with('error', 'Please Select One Package Details');
                }
            } else {
                return Redirect::to('/master/add_organization_data')->with('error', 'Invalid form submission');
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

    public function addMasterUser($id = 0) {
        $viewDataObj                                                            = "";
        $viewDataObjs                                                           = "";
        $reqType                                                                = '';
        $id                                                                     = base64_decode(base64_decode($id));
        $user_name = Input::get('search_user_name');
        if(Auth::user()->role_id == 1){
            $dbObj = DB::table('users')
             ->where('users.role_id','=',1)
             ->orWhere('users.role_id','=',2)   
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
        return view('master.add_master_user', ['layoutArr' => $layoutArr]);
    }
    
    public function addMasterUserData($id = 0) {
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
        return view('master.add_master_user_data', ['layoutArr' => $layoutArr]);
    }
    
    public function validateMasterUserDetails() {
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
    
    public function validateMasterUserDetailss() {
        $valiationArr = array();
        $formValArr = array();
        parse_str(Input::all()['formData'], $formValArr);
        //echo'<pre>';print_r($formValArr);echo'</pre>';exit; 
        if (is_array($formValArr) && count($formValArr) > 0) {
            if (isset($formValArr['User']) && is_array($formValArr['User']) && count($formValArr['User']) > 0) {
                $validator = Validator::make($formValArr['User'], User::$rules['masterupdate'], User::$messages);
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
    
    public function saveMasterUserDetails(Request $request) {
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
                            $formCDataArr['User']['t_branch_details_id']        = 0;
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
                            return Redirect::to('/master/add_master_user_data')->with('message', 'Data update successfully!');
                        } else {
                            DB::rollback();
                            return Redirect::to('/master/add_master_user_data')->with('error', 'Unable save Data');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('/master/add_master_user_data')->with('error', ' Data Already Exist');
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
                    //count points_of_contact value of organization & match with number of account created
                    $masterUserLimit    = DB::table('t_organizations')
                                                ->where('t_organizations.id','=',$t_organizations_id)
                                                ->where('status','=','Y')
                                                ->first();
                    if (isset($masterUserLimit->points_of_contact) && $masterUserLimit->points_of_contact != '') {
                        $points_of_contact = $masterUserLimit->points_of_contact;
                    }
                    $masterUserCnt  = DB::table('users')
                                        ->where('users.t_organizations_id','=',$t_organizations_id)
                                        ->where('users.t_branch_details_id','=',0)
                                        ->where('users.t_business_logistic_dtl_id','=',0)
                                        ->where('status','=',0)
                                        ->count();
                    //end
                    if($masterUserCnt < $points_of_contact){
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
                                $formCDataArr['User']['t_branch_details_id']        = 0;
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
                                return Redirect::to('/master/add_master_user_data')->with('message', 'Data saved successfully!');
                            } else {
                                DB::rollback();
                                return Redirect::to('/master/add_master_user_data')->with('error', 'Unable save Data');
                            }
                        } else {
                            DB::rollback();
                            return Redirect::to('/master/add_master_user_data')->with('error', 'User Data Already Exist');
                        }
                    }else{
                        return Redirect::to('/master/add_master_user_data')->with('error', 'Points Of Contacts(LIMIT) Exceed Contact to Super Admin'); 
                    }
                }
            } else {
                return Redirect::to('/master/add_master_user_data')->with('error', 'Invalid form submission');
            }
        } else {
            return Redirect::to('/user/login')->with('error', 'Please login to register');
        }exit;
    }

    public function masterUserDetailsActive() {
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

    public function masterUserDetailsDeactive() {
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

    
}
