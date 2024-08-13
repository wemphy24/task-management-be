<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function fetch (Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $description = $request->input('description');
        $status = $request->input('status');
        $limit = $request->input('limit', 8);

        $taskQuery = Task::with(['user']);

        // * /api/task?id=1 *
        if($id) {
            $task = $taskQuery->with(['user'])->find($id);

            if($task) {
                return ResponseFormatter::success($task);
            }

            return ResponseFormatter::error('Task Not Found', 404);
        }

        // get multiple data 
        $tasks = $taskQuery;

        if ($title) {
            $tasks->where('title', 'like', '%' . $title . '%');
        }

        if ($description) {
            $tasks->where('description', 'like', '%' . $description . '%');
        }

        if ($status) {
            $tasks->where('status', 'like', '%' . $status . '%');
        }

        return ResponseFormatter::success(
            $tasks->paginate($limit), 'Task Found'
        );
    }

    public function create(CreateTaskRequest $request)
    {
        try {
            // create task
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'assign_by' => $request->assign_by,
                'user_id' => $request->user_id,
                'status' => $request->status,
                'task_start' => $request->task_start,
                'task_complete' => $request->task_complete,
            ]);

            if(!$task) {
                throw new Exception('Task Not Created');
            }

            return ResponseFormatter::success($task, 'Task Created');
        } catch (Exception $e) {
            return ResponseFormatter::error('Failed Create Task', 500);
        }
    }

    public function edit($id)
    {
        try {
            $task = Task::find($id);

            if(!$task) {
                throw new Exception('Task Not Found');
            }

            
            return ResponseFormatter::success($task);
        } catch (Exception $e) {
            return ResponseFormatter::error('Cant Edit Task Data', 500);
        }
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        try {
            // find task id
            $task = Task::find($id);

            if(!$task) {
                throw new Exception('Task Not Found');
            }

            // update task
            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'assign_by' => $request->assign_by,
                'user_id' => $request->user_id,
                'status' => $request->status,
                // 'task_start' => $request->task_start,
                'task_start' => Carbon::now()->format('Y-m-d H:i:s'),
                'task_complete' => $request->task_complete,
            ]);

            return ResponseFormatter::success($task, 'Task Updated');
        } catch (Exception $e) {
            return ResponseFormatter::error('Failed Update Task', 500);
        }
    }

    public function destroy($id)
    {
        try {
            // get task
            $task = Task::find($id);

            if(!$task) {
                throw New Exception('Task Not Found');
            }

            // delete task
            $task->delete();

            return ResponseFormatter::success('Task Deleted');
        }
        catch (Exception $e) {
            return ResponseFormatter::error('Failed Delete Task', 500);
        }
    }
}
