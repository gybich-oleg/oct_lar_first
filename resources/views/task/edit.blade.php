@extends('templates.default')

@section('content')
    <h1>Edit task</h1>
    <div class="panel-body">
        @include('common.errors')
        <form action="{{ route('task.update', $task->id) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            {{ method_field('PUT') }} <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Task</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="task-name" class="form-control" value="{{ old('name', $task->name) }}">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-pencil"></i> Save Changes
                    </button>
                    <a href="{{ route('task.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection