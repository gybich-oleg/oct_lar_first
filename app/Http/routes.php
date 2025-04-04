<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use \Illuminate\Http\Request;
use \App\Models\Task;
use \Illuminate\Support\Facades\Validator;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/task', function () {
    $tasks = Task::orderBy('created_at', 'desc')->get();
    return view('task.index', [
        'tasks' => $tasks,
    ]);
})->name('task.index');

Route::get('/task/create', function () {
    return view('task.create');
})->name('task.create');

Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:10|unique:task,name',
    ]);

    if ($validator->fails()) {
        return redirect(route('task.create'))
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task();
    $task->name = $request->input('name');
    $task->save();

    return redirect(route('task.index'))->with('success', 'Завдання додано!');

    })->name('task.store');

Route::delete('/task/{id}', function ($id) {
    $task = Task::findOrFail($id);
    $task->delete();
    return redirect(route('task.index'))->with('success', 'Завдання видалено!');
    })->name('task.destroy');

Route::get('/task/{id}/edit', function ($id) {
    $task = Task::findOrFail($id);
    return view('task.edit', ['task' => $task]);
})->name('task.edit');

Route::put('/task/{id}', function (Request $request, $id) {
    $task = Task::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|max:10|unique:task,name,' . $id,
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $task->name = $request->input('name');
    $task->save();

    return redirect(route('task.index'))->with('success', 'Завдання оновлено!');
})->name('task.update');

Route::get('/view-tasks', function () {
    $tasks = Task::all();
    return view('tasks', ['tasks' => $tasks]);
})->name('tasks.view');
