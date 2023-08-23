<?php

namespace App\Http\Controllers;

use App\Models\LeaveCategory;
use Illuminate\Http\Request;

class LeaveCategoryController extends Controller
{
    public function index()
    {
        $categories = LeaveCategory::all();
        return view('leave-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('leave-categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:leave_categories'
        ]);

        LeaveCategory::create($request->all());

        return redirect()->route('leave-categories.index')->with('success', 'Leave category created.');
    }

    public function edit(LeaveCategory $leaveCategory)
    {
        return view('leave-categories.edit', compact('leaveCategory'));
    }

    public function update(Request $request, LeaveCategory $leaveCategory)
    {
        $this->validate($request, [
            'name' => 'required|unique:leave_categories,name,' . $leaveCategory->id
        ]);

        $leaveCategory->update($request->all());

        return redirect()->route('leave-categories.index')->with('success', 'Leave category updated.');
    }

    public function destroy(LeaveCategory $leaveCategory)
    {
        $leaveCategory->delete();
        return redirect()->route('leave-categories.index')->with('success', 'Leave category deleted.');
    }
}
