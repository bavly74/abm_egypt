<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index() {
        return response()->json([
           'tasks'=>Task::all()
        ]);
    }

    public function store(StoreTaskRequest $request) {
        try{
            $task = Task::create([
                'title'=>$request->title ,
                'status'=>'pending' ,
                'user_id'=>Auth::id()
            ]);
            return response()->json([
                'task'=>$task ,
                'message'=>'task created'
            ],200);
        }catch (\Exception $e){
            return response()->json([
                'message'=>'task creation failed',
                'error'=>$e->getMessage()
            ]);
        }
    }

    public function update(UpdateTaskRequest $request, Task $task ) {
        \Log::info('Task user_id: ' . $task->user_id);
        \Log::info('Auth user_id: ' . Auth::id());
        \Log::info('Authenticated user: ', [Auth::user()]);
        if ($task->user_id == Auth::id()) {
            $task->update([
                'title'=>$request->title ,
                'status'=>$request->status
            ]);
            return response()->json([
                'message'=>'task updated',
                'task'=>$task
            ],200);
        }else{
            return response()->json([
                'message'=>'task creation failed',
                'error'=>'You are not authorized'
            ],403);
        }
    }

    public function destroy(Task $task) {
        $task->where('user_id', Auth::id())->delete();
        return response()->json([
            'message'=>'task deleted'
        ],200);
    }

}
