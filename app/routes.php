<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/login', function () {
    $view = View::make('login');
    return $view;
});

Route::get('/home', 'HomeController@showWelcome');

Route::get('/', 'LakesController@nurturingProcess');

Route::get('/nurturing-process', 'LakesController@nurturingProcess');

Route::get('/nurturing-process-admin', 'LakesController@nurturingProcessAdmin');

Route::get('/add-user', 'UsersController@addUser');

Route::post('/add-user-action', 'UsersController@addUserAction');

Route::post('/login-action', 'UserAuthController@loginAction');

Route::get('/logout', 'UserAuthController@logout');

Route::get('/edit-user', 'UsersController@editUser');

Route::post('/edit-user-action', 'UsersController@editUserAction');

Route::get('/users-manager', 'UsersController@usersManager');

Route::get('/profile', 'UsersController@profile');

Route::post('/edit-profile-action', 'UsersController@editProfileAction');

Route::get('/form-add-lake', 'LakesController@formAddLake');

Route::post('/add-lake-action', 'LakesController@addLakeAction');

Route::get('/nurturing-process', 'LakesController@nurturingProcess');

Route::get('/add-eat-to-lake', 'LakesController@addEatToLake');

Route::get('/update-eat-to-lake', 'LakesController@updateEatToLake');

Route::get('/environment-index', 'EnvironmentController@environmentIndex');

Route::get('/input-environment-index', 'EnvironmentController@inputEnvironmentIndex');

Route::get('/shrimp-index', 'ShrimpIndexController@shrimpIndex');

Route::get('/basic-building', 'BuildingCostController@basicBuilding');

Route::get('/lakes', 'LakesController@lakes');

Route::get('/edit-lake', 'LakesController@editLake');

Route::post('/edit-lake-action', 'LakesController@editLakeAction');

Route::get('/add-note', 'LakesController@addNote');

Route::get('/nha-process', 'NhaController@nhaProcess');

Route::post('/upload-image', 'UploadController@uploadImage');

Route::get('/update-nha-process', 'NhaController@updateNhaProcess');

Route::post('/update-nha-image', 'UploadController@updateNhaImage');

Route::get('/update-shrimp-index', 'ShrimpIndexController@updateShrimpIndex');

Route::get('/form-catalog', 'CatalogController@formCatalog');

Route::post('/add-catalog-action', 'CatalogController@addCatalogAction');

Route::get('/input-inventory', 'CatalogController@inputInventory');

Route::get('/input-inventory-action', 'CatalogController@inputInventoryAction');

Route::get('/delete-catalog', 'CatalogController@delCatalog');

Route::get('/form-fee-catalog', 'FeeCatalogController@formFeeCatalog');

Route::post('/add-fee-catalog-action', 'FeeCatalogController@addFeeCatalogAction');

Route::get('/input-fee', 'FeeCatalogController@inputFee');

Route::get('/input-fee-action', 'FeeCatalogController@inputFeeAction');

Route::get('/histories-nurturing-process', 'HistoriesController@showNurturingProcess');

Route::get('/histories-nha-process', 'HistoriesController@showNhaProcess');

Route::get('/drug-process', 'DrugController@drugProcess');

Route::get('/add-drug-to-lake', 'DrugController@addDrugToLake');

Route::get('/update-drug-to-lake', 'DrugController@updateDrugToLake');

Route::get('/histories-drug-process', 'HistoriesController@showDrugProcess');

Route::get('/shrimp_harvesting', 'ShrimpHarvestingController@shrimpHarvesting');

Route::get('/histories-environment-index', 'HistoriesController@showEnvironmentIndex');

Route::post('/add-harvesting-action', 'ShrimpHarvestingController@addHarvestingAction');

Route::post('/stop-drug-process', 'DrugController@stopDrugProcess');

Route::get('/histories-fees', 'HistoriesController@showFees');

Route::get('/food-analytic', 'AnalyticsController@foodAnalytic');

Route::get('/food-details', 'AnalyticsController@foodDetails');

Route::get('/drug-analytic', 'AnalyticsController@drugAnalytic');

Route::get('/drug-details', 'AnalyticsController@drugDetails');

Route::get('/fee-analytic', 'AnalyticsController@feeAnalytic');

Route::get('/fee-details', 'AnalyticsController@feeDetails');

Route::get('/statement', 'StatementController@statementForm');

Route::post('/settlement-action', 'StatementController@settlementAction');

/*********Danh mục thuốc*********/
Route::get('/form-drug-item','CategoriesController@formDrugItem');

Route::post('/add-drug-item-action','CategoriesController@addDrugItemAction');

/******Danh mục giờ cho ăn**********/
Route::get('/form-eat-time-item','CategoriesController@formEatTimeItem');

Route::post('/add-eat-time-item-action','CategoriesController@addEatTimeItemAction');

/******Danh mục loại thức ăn**********/
Route::get('/form-food-type-item','CategoriesController@formFoodTypeItem');

Route::post('/add-food-type-item-action','CategoriesController@addFoodTypeItemAction');

Route::get('/get-food-type','CategoriesController@getFoodType');

/**************API******************/
Route::post('/rest/v1/user/login', 'UsersAPIController@login');

Route::get('/rest/v1/lake/getAll', 'LakesAPIController@getLakes');

Route::get('/rest/v1/lake/getFoodType', 'LakesAPIController@getFoodType');

Route::get('/rest/v1/lake/setFoodToLake', 'LakesAPIController@setFoodToLake');