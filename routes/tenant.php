<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/


Route::group([
    'prefix' => '/{tenant}',
    'middleware' => [InitializeTenancyByPath::class, 'web', 'is.tenant'],
], function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', function () {
            $tenant = tenant();
            $title = array(
                'menu' => 'dashboard',
                'page' => 'Dashboard'
            );
            return view('tenants.dashboard', compact(
                'title',
                'tenant'
            ));
        });

        Route::get('staff/{id}/load-permissions-to-role', App\Actions\Users\LoadPermissionsToRole::class);
        Route::get('tasks/{id}/load-pipelines-to-project', App\Actions\Tasks\LoadPipelinesToProject::class);
        Route::post('toggle-status/{id}', App\Actions\StatusToggle::class);
        Route::post('add-attachments', App\Actions\AddAttachment::class);
        Route::delete('add-attachments', App\Actions\RemoveAttachment::class);

        Route::resource('modules', App\Http\Controllers\Tenants\ModuleController::class);
        Route::resource('user-roles', App\Http\Controllers\UserRoleController::class);
        Route::resource('staff', App\Http\Controllers\Tenants\StaffController::class, [
            'names' => [
                'index' => 'client-staff.index',
                'create' => 'client-staff.create',
                'store' => 'client-staff.store',
                'edit' => 'client-staff.edit',
                'update' => 'client-staff.update',
                'destroy' => 'client-staff.destroy'
            ]
        ]);
        Route::resource('suppliers', App\Http\Controllers\Tenants\SupplierController::class);
        Route::resource('categories', App\Http\Controllers\Tenants\CategoryController::class);
        Route::resource('opportunity-requests', App\Http\Controllers\Tenants\OpportunityRequestController::class);
        Route::resource('stakeholders', App\Http\Controllers\Tenants\CustomerController::class);
        Route::resource('customer-organizations', App\Http\Controllers\Tenants\CustomerOrganizationController::class);
        Route::resource('projects', App\Http\Controllers\Tenants\ProjectController::class);
        Route::resource('pipelines', App\Http\Controllers\Tenants\PipelineController::class);
        Route::resource('tasks', App\Http\Controllers\Tenants\TaskController::class);
        Route::resource('attachments', App\Http\Controllers\Tenants\AttachmentController::class);


        Route::get('create-module', function () {
            DB::table('modules')->insert([
                'name' => 'user roles',
                'type' => 'client_admin'
            ]);

            $user_role_permissions = array('view all user roles', 'create user role', 'edit user role', 'remove user role');

            foreach ($user_role_permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'module_id' => 1
                ]);
            }
        });
    });
});
require __DIR__.'/auth.php';
