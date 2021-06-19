<?php

namespace App\Http\Controllers\Tenants;

use App\DataTables\Tenants\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\Categories\CategoryStoreRequest;
use App\Http\Requests\Tenants\Categories\CategoryUpdateRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryController extends Controller
{
    public function index(Request $request, CategoriesDataTable $categoriesDataTable)
    {
        if(auth()->user()->can('view all categories')) {
            $title = array(
                'menu' => 'categories',
                'page' => 'Categories'
            );

            if($request->ajax()) {
                return $categoriesDataTable->getAll();
            }

            return view('tenants.categories.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if(auth()->user()->can('create category')) {

            $title = array(
                'menu' => 'categories',
                'page' => 'Create Category'
            );

            return view('tenants.categories.create', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(CategoryStoreRequest $request)
    {
        DB::beginTransaction();

        try {

            tenant()->categories()->create($request->all());

            DB::commit();

            $url = route('categories.index', tenant()->id);

            return response()->json([
                'type' => 'success',
                'url' =>  $url
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ]);
        }
    }

    public function show($id)
    {
        return abort('404');
    }

    public function edit($id)
    {
        if(auth()->user()->can('edit category')) {

            $category = Category::findOrFail($id);

            $title = array(
                'menu' => 'categories',
                'page' => 'Edit Category'
            );

            return view('tenants.categories.edit', compact(
                'title',
                'category'
            ));
        } else {
            return abort('403');
        }
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        DB::beginTransaction();

        try {

            $category->update($request->all());

            DB::commit();

            return response()->json([
                'type' => 'success'
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ]);
        }
    }

    public function destroy($id)
    {
        if(auth()->user()->can('remove category')) {
            $category = Category::findOrFail($id);

            DB::beginTransaction();

            try {

                $category->delete();

                DB::commit();

                return response('', 200);
            } catch (Throwable $e) {
                DB::rollBack();

                return response()->json([
                    'type' => 'error',
                    'text' => 'unknown error occurred. please try again later',
                    'errorMsg' => $e
                ]);
            } catch (Exception $e) {
                DB::rollBack();

                return response()->json([
                    'type' => 'error',
                    'text' => 'unknown error occurred. please try again later',
                    'errorMsg' => $e
                ]);
            }
        } else {
            return abort('403');
        }
    }
}
