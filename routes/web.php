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
Route::get('master/add_features/{id}','MasterController@addFeatures')->name('addFeatures');
Route::get('master/role_wise_menu_list','MasterController@roleWiseMenuList')->name('roleWiseMenuList');
Route::post('master/roleWiseMenuListUpdate','MasterController@roleWiseMenuListUpdate')->name('roleWiseMenuListUpdate');
Route::post('master/saveFeaturesData','MasterController@saveFeaturesData')->name('saveFeaturesData');
// end Features
//start Client Setup
Route::get('master/add_organization_details','MasterController@addOrganizationDetails')->name('addOrganizationDetails');
Route::get('master/add_organization_data','MasterController@addOrganizationData')->name('addOrganizationData');
Route::post('master/saveOrganizationDetails','MasterController@saveOrganizationDetails')->name('saveOrganizationDetails');
Route::post('master/validateOrganizationDetails','MasterController@validateOrganizationDetails')->name('validateOrganizationDetails');
Route::get('master/add_organization_data/{id}','MasterController@addOrganizationData')->name('addOrganizationData');
Route::post('master/organizationDetailsDeactive','MasterController@organizationDetailsDeactive')->name('organizationDetailsDeactive');
Route::post('master/organizationDetailsActive','MasterController@organizationDetailsActive')->name('organizationDetailsActive');
// end Client Setup
//start Client user
Route::get('master/add_master_user','MasterController@addMasterUser')->name('addMasterUser');
Route::get('master/add_master_user_data','MasterController@addMasterUserData')->name('addMasterUserData');
Route::post('master/saveMasterUserDetails','MasterController@saveMasterUserDetails')->name('saveMasterUserDetails');
Route::post('master/validateMasterUserDetails','MasterController@validateMasterUserDetails')->name('validateMasterUserDetails');
Route::post('master/validateMasterUserDetailss','MasterController@validateMasterUserDetailss')->name('validateMasterUserDetailss');
Route::get('master/add_master_user_data/{id}','MasterController@addMasterUserData')->name('addMasterUserData');
Route::post('master/masterUserDetailsDeactive','MasterController@masterUserDetailsDeactive')->name('masterUserDetailsDeactive');
Route::post('master/masterUserDetailsActive','MasterController@masterUserDetailsActive')->name('masterUserDetailsActive');
// end Client user
//start master Setup
Route::get('setting/add_department','SettingController@addDepartment')->name('addDepartment');
Route::get('setting/add_department_data','SettingController@addDepartmentData')->name('addDepartmentData');
Route::post('setting/saveDepartment','SettingController@saveDepartment')->name('saveDepartment');
Route::get('setting/add_department_data/{id}','SettingController@addDepartmentData')->name('addDepartmentData');
Route::post('setting/departmentDeactive','SettingController@departmentDeactive')->name('departmentDeactive');
Route::post('setting/departmentActive','SettingController@departmentActive')->name('departmentActive');

Route::get('setting/add_designation','SettingController@addDesignation')->name('addDesignation');
Route::get('setting/add_designation_data','SettingController@addDesignationData')->name('addDesignationData');
Route::post('setting/saveDesignation','SettingController@saveDesignation')->name('saveDesignation');
Route::get('setting/add_designation_data/{id}','SettingController@addDesignationData')->name('addDesignationData');
Route::post('setting/designationDeactive','SettingController@designationDeactive')->name('designationDeactive');
Route::post('setting/designationActive','SettingController@designationActive')->name('designationActive');

Route::get('setting/add_state','SettingController@addState')->name('addState');
Route::post('setting/saveState','SettingController@saveState')->name('saveState');
Route::get('setting/add_state_data','SettingController@addStateData')->name('addStateData');
Route::get('setting/add_state_data/{id}','SettingController@addStateData')->name('addStateData');
Route::post('setting/stateDeactive','SettingController@stateDeactive')->name('stateDeactive');
Route::post('setting/stateActive','SettingController@stateActive')->name('stateActive');

Route::get('setting/add_city','SettingController@addCity')->name('addCity');
Route::get('setting/add_city_data','SettingController@addCityData')->name('addCityData');
Route::post('setting/saveCity','SettingController@saveCity')->name('saveCity');
Route::get('setting/add_city_data/{id}','SettingController@addCityData')->name('addCityData');
Route::post('setting/cityDeactive','SettingController@cityDeactive')->name('cityDeactive');
Route::post('setting/cityActive','SettingController@cityActive')->name('cityActive');

Route::post('setting/citylist','SettingController@citylist')->name('citylist');

Route::get('setting/changepassword','SettingController@changepassword')->name('changepassword');
Route::post('setting/updatePassword','SettingController@updatePassword')->name('updatePassword');

Route::get('setting/userprofile','SettingController@userProfile')->name('userProfile');
Route::post('setting/updateProfile','SettingController@updateProfile')->name('updateProfile');
//end master Setup
// start branch Setup
Route::get('branch/add_regional_branch','BranchController@addRegionalBranch')->name('addRegionalBranch');
Route::post('branch/saveRegionalBranch','BranchController@saveRegionalBranch')->name('saveRegionalBranch');
Route::post('branch/validateRegionalBranch','BranchController@validateRegionalBranch')->name('validateRegionalBranch');
Route::get('branch/add_regional_branch_data','BranchController@addRegionalBranchData')->name('addRegionalBranchData');
Route::get('branch/add_regional_branch_data/{id}','BranchController@addRegionalBranchData')->name('addRegionalBranchData');
Route::post('branch/regionalBranchDeactive','BranchController@regionalBranchDeactive')->name('regionalBranchDeactive');
Route::post('branch/regionalBranchActive','BranchController@regionalBranchActive')->name('regionalBranchActive');

Route::get('branch/add_business_logistics','SettingController@addBusinessLogistics')->name('addBusinessLogistics');
Route::post('branch/saveBusinessLogistics','SettingController@saveBusinessLogistics')->name('saveBusinessLogistics');
Route::post('branch/validateBusinessLogistics','SettingController@validateBusinessLogistics')->name('validateBusinessLogistics');
Route::get('branch/add_business_logistics/{id}','SettingController@addBusinessLogistics')->name('addBusinessLogistics');
Route::post('branch/businessBusinessDeactive','SettingController@businessBusinessDeactive')->name('businessBusinessDeactive');
Route::post('branch/businessBusinessActive','SettingController@businessBusinessActive')->name('businessBusinessActive');

Route::get('branch/create_organization_user','BranchController@createOrganizationUser')->name('createOrganizationUser');
Route::get('branch/create_organization_user_data','BranchController@createOrganizationUserData')->name('createOrganizationUserData');
Route::get('branch/create_organization_user_data/{id}','BranchController@createOrganizationUserData')->name('createOrganizationUserData');

Route::get('branch/create_branch_user','BranchController@createBranchUser')->name('createBranchUser');
Route::get('branch/create_branch_user_data','BranchController@createBranchUserData')->name('createBranchUserData');
Route::post('branch/saveBranchUserDetails','BranchController@saveBranchUserDetails')->name('saveBranchUserDetails');
Route::post('branch/validateBranchUserDetails','BranchController@validateBranchUserDetails')->name('validateBranchUserDetails');
Route::post('branch/validateBranchUserDetailss','BranchController@validateBranchUserDetailss')->name('validateBranchUserDetailss');
Route::get('branch/create_branch_user_data/{id}','BranchController@createBranchUserData')->name('createBranchUserData');
Route::post('branch/branchUserDetailsDeactive','BranchController@branchUserDetailsDeactive')->name('branchUserDetailsDeactive');
Route::post('branch/branchUserDetailsActive','BranchController@branchUserDetailsActive')->name('branchUserDetailsActive');

Route::get('branch/add_lab_collection_center','BranchController@addLabCollectionCenter')->name('addLabCollectionCenter');
Route::get('branch/add_lab_collection_center_data','BranchController@addLabCollectionCenterData')->name('addLabCollectionCenterData');
Route::post('branch/saveLabCollectionCenter','BranchController@saveLabCollectionCenter')->name('saveLabCollectionCenter');
Route::post('branch/validateLabCollectionCenter','BranchController@validateLabCollectionCenter')->name('validateLabCollectionCenter');
Route::get('branch/add_lab_collection_center_data/{id}','BranchController@addLabCollectionCenterData')->name('addLabCollectionCenterData');
Route::post('branch/labCollectionCenterDeactive','BranchController@labCollectionCenterDeactive')->name('labCollectionCenterDeactive');
Route::post('branch/labCollectionCenterActive','BranchController@labCollectionCenterActive')->name('labCollectionCenterActive');

Route::get('branch/add_lab_collection_center_user','BranchController@addLabCollectionCenterUser')->name('addLabCollectionCenterUser');
Route::get('branch/add_lab_collection_center_user_data','BranchController@addLabCollectionCenterUserData')->name('addLabCollectionCenterUserData');
Route::post('branch/saveLabCollectionCenterUserDetails','BranchController@saveLabCollectionCenterUserDetails')->name('saveLabCollectionCenterUserDetails');
Route::post('branch/validateLabCollectionCenterUserDetails','BranchController@validateLabCollectionCenterUserDetails')->name('validateLabCollectionCenterUserDetails');
Route::post('branch/validateLabCollectionCenterUserDetailss','BranchController@validateLabCollectionCenterUserDetailss')->name('validateLabCollectionCenterUserDetailss');
Route::get('branch/add_lab_collection_center_user_data/{id}','BranchController@addLabCollectionCenterUserData')->name('addLabCollectionCenterUserData');
Route::post('branch/labCollectionCenterUserDetailsDeactive','BranchController@labCollectionCenterUserDetailsDeactive')->name('labCollectionCenterUserDetailsDeactive');
Route::post('branch/labCollectionCenterUserDetailsActive','BranchController@labCollectionCenterUserDetailsActive')->name('labCollectionCenterUserDetailsActive');
//end branch Setup