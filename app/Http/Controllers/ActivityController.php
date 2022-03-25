<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $activities = Activity::where('user_id', $user->id);

        return response()->json($activities->get());
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'activity_name' => 'required'
        ]);

        $activity = new Activity();
        $activity->user_id = $user->id;
        $activity->activity_name = $request->activity_name;
        $activity->status = 0;
        if (!$activity->save()) {
            return response()->json(['code'=>400, 'message'=> 'Ops! we are facing issue while adding activity.']);
        }
        return response()->json(['code'=>200, 'message'=> 'Activity Added Successfully.']);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'status' => 'required|boolean'
        ]);

        $activity = Activity::find($request->id);
        if ($activity) {
            $activity->update([
                'status' => $request->status
            ]);
    
            return response()->json(['code'=>200, 'message'=> 'Activity Updated Successfully.']);    
        } else {
            return response()->json(['code'=>400, 'message'=> 'Ops! we are facing issue while updating activity.']);
        }
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        $activity = Activity::find($request->id);
        if ($activity) {
            $activity->delete();

            return response()->json(['code'=>200, 'message'=> 'Activity Deleted Successfully.']);
        } else {
            return response()->json(['code'=>400, 'message'=> 'Ops! we are facing issue while deleting activity.']);
        }
    }
}
