@extends('layouts.contestant')

@section('title', 'Contestant Dashboard')
@section('page_title', 'Overview Statistics')

@section('content')

<div class="space-y-6">

    <!-- Simple Summary Table -->

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h2 class="text-md font-bold text-gray-700 uppercase tracking-tight">Competition Summary</h2>
            <a href="{{ route('contestant.profile') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold shadow hover:bg-blue-700 transition">Edit Profile</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-bold border-b">Title (Round)</th>
                        <th class="px-6 py-4 font-bold border-b">Date</th>
                        <th class="px-6 py-4 font-bold border-b">Status</th>
                        <th class="px-6 py-4 font-bold border-b">My Region</th>
                        <th class="px-6 py-4 font-bold border-b text-center">Contestants in My Round</th>
                        <th class="px-6 py-4 font-bold border-b text-center">Applying Contestants</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-5 text-sm font-medium text-gray-900 text-blue-600">
                            {{ $voting_data?->voting?->title ?? 'Waiting for Round Assignment' }}
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-600">
                            {{ $current_date }}
                        </td>
                        <td class="px-6 py-5">
                            @if($contestant->status == 1)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Official Approved</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">Pending Review</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-900 font-bold">
                            {{ $contestant->region->name ?? 'Not Assigned' }}
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-900 font-bold text-center">
                            <span class="text-lg">{{ $total_contestants }}</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-900 font-bold text-center">
                            <span class="text-lg">{{ $applying_contestants }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


   

</div>

@endsection
