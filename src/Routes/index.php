<?php

namespace App\Routes;

use App\Controllers\CartController;
use App\Routes\Router;
use App\Controllers\EmployeeLoginController;
use App\Controllers\EmployeeRegisterController;
use App\Controllers\InventoryController;
use App\Controllers\ProductController;
use App\Controllers\ReportsController;
use App\Controllers\AccountManagementController;
use App\Controllers\DesignerDashboardController;
use App\Controllers\NotificationController;
use App\Controllers\PendingController;
use App\Controllers\UserLoginController;
use App\Controllers\GalleryController;
use App\Controllers\HomeController;
use App\Controllers\UserRegisterController;
use App\Controllers\ProfileController;
use App\Controllers\OrderController;
use App\Middleware\AuthenticateAdmin;
use App\Middleware\AuthenticateDesigner;
use App\Middleware\RedirectIfAuthenticated;
use App\Middleware\JwtAuth;
use App\Config\database;

$db = new database();

$router = new Router($db);

//employee routes
$router->get('/employee/login', EmployeeLoginController::class, 'login', RedirectIfAuthenticated::class);
$router->get('/employee/register', EmployeeRegisterController::class, 'register', RedirectIfAuthenticated::class);
$router->post('/employee/login', EmployeeLoginController::class, 'employeeLogin');
$router->post('/employee/register', EmployeeRegisterController::class, 'employeeRegister');
$router->post('/employee/logout', EmployeeLoginController::class, 'logout');
$router->get('/employee/pending-request', PendingController::class, 'getPendingPage');

//admin routes
$router->get('/admin/inventory', InventoryController::class, 'inventory', AuthenticateAdmin::class);
$router->get('/admin/inventory/refresh', InventoryController::class, 'getFirstProduct', AuthenticateAdmin::class);
$router->get('/admin/inventory/products', ProductController::class, 'productCard', AuthenticateAdmin::class);
$router->post('/admin/inventory/products', ProductController::class, 'createProduct');
$router->post('/admin/inventory/item-details', InventoryController::class, 'getProductDetails');
$router->post('/admin/inventory/edit/item', InventoryController::class, 'getProductDetails');
$router->post('/admin/inventory/edit/update-item', InventoryController::class, 'updateProductDetails');
$router->post('/admin/inventory/delete', InventoryController::class, 'deleteProduct');

//admin routes
$router->get('/admin/manage-account', AccountManagementController::class, 'getAccountManagement', AuthenticateAdmin::class);
$router->post('/admin/manage-account/delete-account', AccountManagementController::class, 'deleteAccount');
$router->post('/admin/manage-account/edit-status/activate', AccountManagementController::class, 'activateAccount');
$router->post('/admin/manage-account/edit-status/deactivate', AccountManagementController::class, 'deactivateAccount');
$router->post('/admin/manage-account/edit-status/update', AccountManagementController::class, 'getStatus');

//admin routes
$router->get('/admin/reports', ReportsController::class, 'getReports', AuthenticateAdmin::class);

//designer routes
$router->get('/designer/dashboard', DesignerDashboardController::class, 'getDashboard', AuthenticateDesigner::class);
$router->get('/designer/dashboard/complete', DesignerDashboardController::class, 'fetchCompleteOrders', AuthenticateDesigner::class);
$router->get('/designer/notification', NotificationController::class, 'getNotification', AuthenticateDesigner::class);

$router->post('/designer/dashboard/update', DesignerDashboardController::class, 'updatePendingOrderStatus', AuthenticateDesigner::class);

//user routes
$router->post('/api/user-login', UserLoginController::class, 'userLogin');
$router->post('/api/user-register', UserRegisterController::class, 'userRegister');

$router->get('/api/gallery', GalleryController::class, 'getBouquets', JwtAuth::class);
$router->get('/api/home', HomeController::class, 'getBouquets', JwtAuth::class);
$router->post('/api/cart/add', CartController::class, 'addProductToCart', JwtAuth::class);
$router->post('/api/cart/delete', CartController::class, 'deleteCartById', JwtAuth::class);
$router->get('/api/cart', CartController::class, 'getProductsFromCart', JwtAuth::class);
$router->get('/api/cart/total-price', CartController::class, 'getTotalPrice', JwtAuth::class);
$router->post('/api/cart/update-quantity', CartController::class, 'updateItemQuantity', JwtAuth::class);
$router->post('/api/cart/status', CartController::class, 'updateCartStatus', JwtAuth::class);
$router->get('/api/profile', ProfileController::class, 'getUserDetails', JwtAuth::class);
$router->post('/api/profile/edit', ProfileController::class, 'editProfile', JwtAuth::class);

$router->get('/api/order', OrderController::class, 'fetchItemsToCheckOut', JwtAuth::class);
$router->post('/api/order', OrderController::class, 'addOrderDetails', JwtAuth::class);

$router->get('/api/order/details', OrderController::class, 'fetchOrderDetails', JwtAuth::class);
$router->post('/api/order/status', OrderController::class, 'updatePickedUpOrderStatus', JwtAuth::class);

$router->dispatch();
