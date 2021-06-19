<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'is.tenant'])->group(function () {
    Route::get('/', [App\Http\Controllers\Master\DashboardController::class, 'index'])->name('dashboard');

    Route::get('staff/{id}/load-permissions-to-role', App\Actions\Users\LoadPermissionsToRole::class);
    Route::post('toggle-status/{id}', App\Actions\StatusToggle::class);
    Route::post('add-client-admin-from-contact/{tenant}', App\Actions\SaveOrUpdateClientAdminFromContact::class);
    Route::post('add-or-update-client-guest-from-contact/{tenant}', App\Actions\SaveOrUpdateClientGuestFromContact::class);
    Route::get('clients/{tenant}/invoice', [App\Http\Controllers\Master\ContactController::class, 'invoice']);

    Route::resource('staff', App\Http\Controllers\Master\StaffController::class);
    Route::resource('user-roles', App\Http\Controllers\UserRoleController::class);
    Route::resource('plans', App\Http\Controllers\Master\PlanController::class);
    Route::resource('clients', App\Http\Controllers\Master\ClientController::class);

    Route::resource('app-modules', App\Http\Controllers\Master\ModuleController::class);

    Route::get('invoices', [App\Http\Controllers\Master\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{invoice}', [App\Http\Controllers\Master\InvoiceController::class, 'show'])->name('invoices.show');

    Route::get('client-contacts/{tenant}', [App\Http\Controllers\Master\ContactController::class, 'index'])->name('contacts.index');
    Route::get('client-contacts/create/{tenant}', [App\Http\Controllers\Master\ContactController::class, 'create'])->name('contacts.create');
    Route::post('client-contacts/{tenant}', [App\Http\Controllers\Master\ContactController::class, 'store'])->name('contacts.store');
    Route::get('client-contacts/{tenant}/{contact}/edit', [App\Http\Controllers\Master\ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('client-contacts/{tenant}/{contact}', [App\Http\Controllers\Master\ContactController::class, 'update'])->name('contacts.update');
    Route::delete('client-contacts/{contact}', [App\Http\Controllers\Master\ContactController::class, 'destroy'])->name('contacts.destroy');
});

Route::get('/admin', function () {
    if (Auth::check()) {
        return redirect()->back();
    } else {
        return redirect('/admin/login');
    }
});

Route::get('/client', function () {
    if (Auth::check()) {
        return redirect()->back();
    } else {
        return redirect('/client/login');
    }
});

Route::get('tenant-modules-5-23', function () {
    $supplier = DB::table('modules')->insertGetId(['name' => 'suppliers','type' => 'client']);
    $category = DB::table('modules')->insertGetId(['name' => 'categories','type' => 'client']);
    $stakeholder = DB::table('modules')->insertGetId(['name' => 'stakeholders','type' => 'client']);
    $opportunityRequest = DB::table('modules')->insertGetId(['name' => 'opportunity requests','type' => 'client']);
    $project = DB::table('modules')->insertGetId(['name' => 'projects','type' => 'client']);
    $pipeline = DB::table('modules')->insertGetId(['name' => 'pipelines','type' => 'client']);
    $task = DB::table('modules')->insertGetId(['name' => 'tasks','type' => 'client']);

    $supplier_permissions = array('view all suppliers', 'create supplier', 'edit supplier', 'remove supplier');

    foreach ($supplier_permissions as $permission) {
        Permission::create([
            'name' => $permission,
            'module_id' => $supplier
        ]);
    }

    $category_permissions = array('view all categories', 'create category', 'edit category', 'remove category');

    foreach ($category_permissions as $permission) {
        Permission::create([
            'name' => $permission,
            'module_id' => $category
        ]);
    }

    $stakeholder_permissions = array('view all stakeholders', 'create stakeholder', 'edit stakeholder', 'remove stakeholder');

    foreach ($stakeholder_permissions as $permission) {
        Permission::create([
            'name' => $permission,
            'module_id' => $stakeholder
        ]);
    }

    $or_permissions = array('view all opportunity requests', 'create opportunity request', 'edit opportunity request', 'remove opportunity request');

    foreach ($or_permissions as $permission) {
        Permission::create([
            'name' => $permission,
            'module_id' => $opportunityRequest
        ]);
    }

    $project_permissions = array('view all projects', 'create project', 'edit project', 'remove project');

    foreach ($project_permissions as $permission) {
        Permission::create([
            'name' => $permission,
            'module_id' => $project
        ]);
    }

    $pipeline_permissions = array('view all pipelines', 'create pipeline', 'edit pipeline', 'remove pipeline');

    foreach ($pipeline_permissions as $permission) {
        Permission::create([
            'name' => $permission,
            'module_id' => $pipeline
        ]);
    }

    $task_permissions = array('view all tasks', 'create task', 'edit task', 'remove task');

    foreach ($task_permissions as $permission) {
        Permission::create([
            'name' => $permission,
            'module_id' => $task
        ]);
    }
});

Route::get('assign-customer-role-permissions', function () {
    $role = App\Models\Role::find(3);
    $role->syncPermissions([
        'view all opportunity requests',
        'create opportunity request',
        'edit opportunity request',
        'view all stakeholders'
    ]);

    dd('done');
});

require __DIR__.'/admin_auth.php';
