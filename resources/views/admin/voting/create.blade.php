@extends('layouts.admin')

@section('title', 'Add Voting Round')
@section('page_title', 'Add Voting Round')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 max-w-lg">
    <form action="{{ route('admin.voting.store') }}" method="POST">

        @csrf 

        <!-- Title -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <!-- Voting Date -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Voting Date</label>
            <input type="date" name="votingdate" value="{{ old('votingdate') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <!-- Region (For Automatic Addition) -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Region (Automatic Addition)</label>
            <select name="region_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- No Region (Manual / Global) --</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                        {{ $region->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">If selected, all approved contestants from this region will be added automatically.</p>
        </div>

        <!-- Status -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Open</option>
                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all font-medium">
            Add Voting Round
        </button>
    </form>
</div>

@endsection
