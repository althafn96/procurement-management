<?php
namespace App\DataTables\Tenants;

use App\Models\Category;
use DataTables;

class CategoriesDataTable {

    public function getAll()
    {
        $categories = Category::latest()->get();

        return DataTables::of($categories)
                ->addColumn('action', function($supplier) {

                })
                ->make('true');
    }

}
