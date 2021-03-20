<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Role;
use App\Models\RoleMenu;
use App\User;
use DB;
use View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Redirect;
use Validator;

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

    public function addFeatures() {
        $layoutArr = [];
        $viewDataObj = [];
        $roleArr = Controller::getMasterList('roles', 'role_name');

        $layoutArr = array(
            'viewDataObj' => $viewDataObj,
            'roleArr' => $roleArr,
        );
        return view('master.add_features', compact('layoutArr'));
    }
    public function roleWiseMenuList() {
        $menuSubMenuArr = array();
        $editMenuList = array();
        $editSubMenuList = array();
        $menuSubMenuArr = [];
        if (1) {
            $editMenuListFind = DB::table('role_menus')
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
         return view('master.role_wise_menu_list', compact('layoutArr'));
    }
}
