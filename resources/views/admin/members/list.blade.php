@extends('layouts.admin')

@section('title', 'Members List')
@section('page_title', 'Member Management')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">All Members (Voters)</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-8 py-4 font-medium">S.No</th>
                    <th class="px-8 py-4 font-medium">Name</th>
                    <th class="px-8 py-4 font-medium">Email</th>
                    <th class="px-8 py-4 font-medium">Payment Status</th>
                    <th class="px-8 py-4 font-medium">Created At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($members as $index => $member)
                <tr class="hover:bg-gray-50 transition-all">
                    <td class="px-8 py-5 text-sm text-gray-600">{{ $index + 1 }}</td>
                    <td class="px-8 py-5 text-sm font-medium text-gray-900">{{ $member->name }}</td>
                    <td class="px-8 py-5 text-sm text-gray-600">{{ $member->email }}</td>
                    <td class="px-8 py-5">
    @if($member->subscription_ends_at && now()->lte($member->subscription_ends_at))
        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
            Paid until {{ \Carbon\Carbon::parse($member->subscription_ends_at)->format('Y-m-d') }}
        </span>
    @else
        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
            Expired
        </span>
    @endif
</td>

                    <td class="px-8 py-5 text-sm text-gray-600">{{ $member->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
