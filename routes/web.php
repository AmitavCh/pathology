<?php
// user module start
Route::get('/','UserController@login')->name('login');
Route::get('dashboard/dashboard','DashboardController@dashboard')->name('dashboard');

Route::post('user/signup','UserController@signup')->name('signup');
Route::get('user/logout','UserController@logout');

Route::get('user/add_user','UserController@addUser')->name('addUser');
Route::post('user/saveMasterUser','UserController@saveMasterUser')->name('saveMasterUser');
Route::get('user/add_user/{id}','UserController@addUser')->name('addUser');
Route::post('user/userDeactive','UserController@userDeactive')->name('userDeactive');
Route::post('user/userActive','UserController@userActive')->name('userActive');
Route::post('user/validateMasterUser','UserController@validateMasterUser')->name('validateMasterUser');
Route::post('user/validateMasterUsers','UserController@validateMasterUsers')->name('validateMasterUsers');

Route::get('user/changepassword','UserController@changepassword')->name('changepassword');
Route::post('user/updatePassword','UserController@updatePassword')->name('updatePassword');

Route::get('user/userprofile','UserController@Profile')->name('Profile');
Route::post('user/updateProfile','UserController@updateProfile')->name('updateProfile');
//user module end
// add user role
Route::get('master/add_role','MasterController@addRole')->name('addRole');
Route::get('master/add_role_data','MasterController@addRoleData')->name('addRoleData');
Route::post('master/saveRole','MasterController@saveRole')->name('saveRole');
Route::get('master/add_role_data/{id}','MasterController@addRoleData')->name('addRoleData');
Route::post('master/roleDeactive','MasterController@roleDeactive')->name('roleDeactive');
Route::post('master/roleActive','MasterController@roleActive')->name('roleActive');
// end user role
// add menu
Route::get('master/add_menu','MasterController@addMenu')->name('addMenu');
Route::get('master/add_menu_data','MasterController@addMenuData')->name('addMenuData');
Route::post('master/saveMenu','MasterController@savemenu')->name('saveMenu');
Route::get('master/add_menu_data/{id}','MasterController@addMenuData')->name('addMenuData');
Route::post('master/menuDeactive','MasterController@menuDeactive')->name('menuDeactive');
Route::post('master/menuActive','MasterController@menuActive')->name('menuActive');
// end menu
// start sub menu
Route::get('master/add_sub_menu','MasterController@addSubMenu')->name('addSubMenu');
Route::get('master/add_sub_menu_data','MasterController@addSubMenuData')->name('addSubMenuData');
Route::post('master/saveSubMenu','MasterController@savesubmenu')->name('saveSubMenu');
Route::get('master/add_sub_menu_data/{id}','MasterController@addSubMenuData')->name('addSubMenuData');
Route::post('master/submenuDeactive','MasterController@submenuDeactive')->name('submenuDeactive');
Route::post('master/submenuActive','MasterController@submenuActive')->name('submenuActive');
// end sub menu
// start role assign
Route::get('master/add_role_menu','MasterController@addRoleMenu')->name('addRoleMenu');
Route::get('master/role-wise-menu','MasterController@roleWiseMenu')->name('rolewisemenu');
Route::post('master/saveRoleMenu','MasterController@saveRoleMenu')->name('saveRoleMenu');
// end user role
// start Features
Route::get('master/add_features','MasterController@addFeatures')->name('addFeatures');
Route::get('master/role_wise_menu_list','MasterController@roleWiseMenuList')->name('roleWiseMenuList');
Route::post('master/saveFeatures','MasterController@saveFeatures')->name('saveFeatures');
// end Features
//start master Setup
Route::get('setting/add_organization_details','SettingController@addOrganizationDetails')->name('addOrganizationDetails');
Route::post('setting/saveOrganizationDetails','SettingController@saveOrganizationDetails')->name('saveOrganizationDetails');
Route::post('setting/validateOrganizationDetails','SettingController@validateOrganizationDetails')->name('validateOrganizationDetails');
Route::get('setting/add_organization_details/{id}','SettingController@addOrganizationDetails')->name('addOrganizationDetails');
Route::post('setting/organizationDetailsDeactive','SettingController@organizationDetailsDeactive')->name('organizationDetailsDeactive');
Route::post('setting/organizationDetailsActive','SettingController@organizationDetailsActive')->name('organizationDetailsActive');

Route::get('setting/add_department','SettingController@addDepartment')->name('addDepartment');
Route::post('setting/saveDepartment','SettingController@saveDepartment')->name('saveDepartment');
Route::get('setting/add_department/{id}','SettingController@addDepartment')->name('addDepartment');
Route::post('setting/departmentDeactive','SettingController@departmentDeactive')->name('departmentDeactive');
Route::post('setting/departmentActive','SettingController@departmentActive')->name('departmentActive');

Route::get('setting/add_designation','SettingController@addDesignation')->name('addDesignation');
Route::post('setting/saveDesignation','SettingController@saveDesignation')->name('saveDesignation');
Route::get('setting/add_designation/{id}','SettingController@addDesignation')->name('addDesignation');
Route::post('setting/designationDeactive','SettingController@designationDeactive')->name('designationDeactive');
Route::post('setting/designationActive','SettingController@designationActive')->name('designationActive');

Route::get('setting/add_state','SettingController@addState')->name('addState');
Route::post('setting/saveState','SettingController@saveState')->name('saveState');
Route::get('setting/add_state/{id}','SettingController@addState')->name('addState');
Route::post('setting/stateDeactive','SettingController@stateDeactive')->name('stateDeactive');
Route::post('setting/stateActive','SettingController@stateActive')->name('stateActive');

Route::get('setting/add_city','SettingController@addCity')->name('addCity');
Route::post('setting/saveCity','SettingController@saveCity')->name('saveCity');
Route::get('setting/add_city/{id}','SettingController@addCity')->name('addCity');
Route::post('setting/cityDeactive','SettingController@cityDeactive')->name('cityDeactive');
Route::post('setting/cityActive','SettingController@cityActive')->name('cityActive');

Route::post('setting/citylist','SettingController@citylist')->name('citylist');

Route::get('setting/add_regional_branch','SettingController@addRegionalBranch')->name('addRegionalBranch');
Route::post('setting/saveRegionalBranch','SettingController@saveRegionalBranch')->name('saveRegionalBranch');
Route::post('setting/validateRegionalBranch','SettingController@validateRegionalBranch')->name('validateRegionalBranch');
Route::get('setting/add_regional_branch/{id}','SettingController@addRegionalBranch')->name('addRegionalBranch');
Route::post('setting/regionalBranchDeactive','SettingController@regionalBranchDeactive')->name('regionalBranchDeactive');
Route::post('setting/regionalBranchActive','SettingController@regionalBranchActive')->name('regionalBranchActive');

Route::get('setting/add_business_logistics','SettingController@addBusinessLogistics')->name('addBusinessLogistics');
Route::post('setting/saveBusinessLogistics','SettingController@saveBusinessLogistics')->name('saveBusinessLogistics');
Route::post('setting/validateBusinessLogistics','SettingController@validateBusinessLogistics')->name('validateBusinessLogistics');
Route::get('setting/add_business_logistics/{id}','SettingController@addBusinessLogistics')->name('addBusinessLogistics');
Route::post('setting/businessBusinessDeactive','SettingController@businessBusinessDeactive')->name('businessBusinessDeactive');
Route::post('setting/businessBusinessActive','SettingController@businessBusinessActive')->name('businessBusinessActive');

//end master Setup