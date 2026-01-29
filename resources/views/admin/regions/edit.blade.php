@extends('layouts.admin')

@section('title', 'Edit Region')
@section('page_title', 'Edit Region')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Edit Region: {{ $region->name }}</h3>
            <p class="text-sm text-gray-500 mt-1">Update the name of this geographical region.</p>
        </div>

        <form action="{{ route('admin.regions.update', $region) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Region Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $region->name) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('name') border-red-500 @enderror"
                       placeholder="e.g. North America, Europe, Asia">
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.regions.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    Update Region
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
