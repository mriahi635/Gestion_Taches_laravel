@extends('layouts.app')
@section('title')
    {{ $project->name }} Edit Project
@endsection
@section('content')
    <div class="container" style="background-color: white; padding-top: 30px;">
        <h2 class="mb-4" style="background-color: white; color: black; padding: 20px; font-size: 24px; font-weight: bold; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 5px;">
            Edit Project
        </h2>
        <div class="card border-0 shadow-sm m-auto" style="max-width: 600px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <form action="{{ route('projects.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label" style="font-size: 16px; color: #333;">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $project->name }}" required style="border-radius: 5px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">
                        @error('name')
                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label" style="font-size: 16px; color: #333;">Description</label>
                        <textarea name="description" id="description" class="form-control" style="border-radius: 5px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">{{ $project->description }}</textarea>
                        @error('description')
                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label" style="font-size: 16px; color: #333;">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') }}" style="border-radius: 5px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">
                        @error('start_date')
                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label" style="font-size: 16px; color: #333;">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') }}" style="border-radius: 5px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">
                        @error('end_date')
                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label" style="font-size: 16px; color: #333;">Status</label>
                        <select name="status" id="status" class="form-select" required style="border-radius: 5px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">
                            <option value="not_started" {{ $project->status == 'not_started' ? 'selected' : '' }}>Not Started</option>
                            <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label" style="font-size: 16px; color: #333;">Budget</label>
                        <input type="number" name="budget" id="budget" class="form-control" step="0.01" value="{{ $project->budget }}" style="border-radius: 5px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">
                        @error('budget')
                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn" style="background-color: black; color: white; border: none; border-radius: 5px; padding: 10px 15px; transition: background-color 0.3s ease;">
                        Update Project
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
