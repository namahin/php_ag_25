@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Leave Category</h2>

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('leave-categories.update', $leaveCategory) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Category Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $leaveCategory->name) }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('leave-categories.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
