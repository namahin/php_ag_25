@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('leave.store') }}">
            @csrf
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="leave_category_id">Leave Category</label>
                <select name="leave_category_id" class="form-control">
                    <option value="" disabled selected>Select a category</option>
                    {{--@foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach--}}
                </select>
            </div>
            <div class="form-group">
                <label for="reason">Reason</label>
                <textarea name="reason" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
