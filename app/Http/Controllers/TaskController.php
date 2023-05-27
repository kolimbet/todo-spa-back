<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskTitleRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Log;

class TaskController extends Controller
{
  /**
   * Get a listing of the resource.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function list(Request $request)
  {
    $user = $request->user();
    $tasks = $user->tasks()->get();
    // $tasks = [];
    return response()->json($tasks, 200);
  }

  /**
   * Get resource counters by is_completed state: total, active and completed
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function counter(Request $request)
  {
    $user = $request->user();
    $tasks = $user->tasks()->get();

    $counter = [
      "total" => $tasks ? $tasks->count() : 0,
      "active" => $tasks ? $tasks->where('is_completed', 0)->count() : 0,
    ];
    $counter["completed"] = $counter["total"] - $counter["active"];

    return response()->json($counter, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param CreateTaskRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateTaskRequest $request)
  {
    // return response()->json(["error" => 'test error'], 500);
    $user = $request->user();
    $newTaskData = $request->only("title", "is_completed");
    $newTaskData['user_id'] = $user->id;
    $task = Task::create($newTaskData);

    if ($task) {
      Log::info("Create ToDo #{$task->id}", [$task]);
      return response()->json($task, 200);
    } else {
      return response()->json(["error" => "Failed to save a new task"], 500);
    }
  }

  /**
   * Mark the completion of the task with the end time
   *
   * @param Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function completing(Request $request, $id)
  {
    // return response()->json(["error" => 'test error'], 500);
    $user = $request->user();
    $task = $user->tasks()->where('id', $id)->first();
    if (!$task) return response()->json(["error" => "Record not found"], 404);

    if (!$request->has("is_completed")) return response()->json(["error" => "Completion status not received"], 500);
    $status = $request->boolean("is_completed");

    if ($status != $task->is_completed) {
      $task->is_completed = $status;
      $task->save();
      Log::info("Task #{$task->id} completed(" . json_encode($task->is_completed) . ")");
    }
    return response()->json($task, 200);
  }

  /**
   * Update Task title the specified resource in storage
   *
   * @param UpdateTaskTitleRequest $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function updatingTitle(UpdateTaskTitleRequest $request, $id)
  {
    $user = $request->user();
    $task = $user->tasks()->where('id', $id)->first();
    if (!$task) return response()->json(["error" => "Record not found"], 404);

    if (!$request->has("title")) return response()->json(["error" => "Title not received"], 500);
    $title = $request->string("title");

    if ($title != $task->title) {
      $task->title = $title;
      $task->save();
      Log::info("Task #{$task->id} updating title({$task->title})");
    }
    return response()->json($task, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {
    $user = $request->user();
    $deleteResult = $user->tasks()->where('id', $id)->delete();
    if ($deleteResult) {
      Log::info("Task #{$id} was deleted");
      return response()->json("Record #{$id} was deleted", 200);
    }
    else return response()->json(["error" => "Record not found"], 404);
  }
}