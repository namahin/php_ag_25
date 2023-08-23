<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use App\Models\LeaveCategory;
use Illuminate\Http\Request;
use App\Notifications\NewLeaveRequest;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public function create()
    {
        return view('leave.create');
    }

    public function store(Request $request)
    {
        // Validate the input
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'leave_category_id' => 'required|exists:leave_categories,id',
            'reason' => 'required|string',
        ]);

        // Find the user with the 'manager' role
        $managerUser = User::whereHas('roles', function ($query) {
            $query->where('name', 'manager');
        })->first();

        if ($managerUser) {
            $managerRole = Role::findOrCreate('manager', 'web');

            DB::transaction(function () use ($managerUser, $managerRole, $request) {
                $managerUser->assignRole($managerRole);

                LeaveRequest::create([
                    'user_id' => auth()->user()->id,
                    'leave_category_id' => $request->input('leave_category_id'),
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
                    'reason' => $request->input('reason'),
                    'status' => 'pending',
                ]);
            });

            // Send notification to managers
            Notification::send($managerUser, new NewLeaveRequest());

            return redirect()->route('home')->with('success', 'Leave request submitted.');
        }

        // Handle the case where the manager user isn't found
        return redirect()->route('home')->with('error', 'Manager not found.');
    }
}
