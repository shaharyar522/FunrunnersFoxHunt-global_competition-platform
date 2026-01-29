@extends('layouts.admin')

@section('title', 'Manage Regions')
@section('page_title', 'Regions')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">Available Regions</h3>
        <a href="{{ route('admin.regions.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
            + Add New Region
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border-b border-green-100 text-green-700 text-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 bg-red-50 border-b border-red-100 text-red-700 text-sm">
        {{ session('error') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Region Name</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Contestants</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($regions as $region)
                <tr class="hover:bg-gray-50 transition-colors">

                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-gray-900">{{ $region->name }}</span>
                    </td>
                    
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $region->contestants_count }} contestants
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.regions.edit', $region) }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                        <form action="{{ route('admin.regions.destroy', $region) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-medium" onclick="return confirm('Are you sure you want to delete this region?')">
                                Delete
                            </button>
                        </form>
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-sm">
                        No regions found. Click "+ Add New Region" to create one.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
