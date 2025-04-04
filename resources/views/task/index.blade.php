@extends('templates.default')

@section('content')
    <h1>Tasks</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped task-table">
                <thead>
                <th>Task</th>
                <th>&nbsp;</th>
                </thead>
                <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td class="table-text">
                            <div>{{ $task->name }}</div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('task.edit', $task->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('task.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Task</a>
@endsection