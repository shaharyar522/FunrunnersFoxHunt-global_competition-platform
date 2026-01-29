<div class="flex justify-between items-center mb-6">
    <button onclick="goBackToList()" class="flex items-center text-blue-600 hover:text-blue-800 font-medium transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Back to List
    </button>
    <div class="flex items-center space-x-4">
        <h2 class="text-2xl font-bold text-gray-900">{{ $voting->title }}</h2>
        @if($voting->status == 0)
            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700">Pending</span>
        @elseif($voting->status == 1)
            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">Open</span>
        @else
            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">Closed</span>
        @endif
    </div>
    <div class="flex items-center space-x-3">
        @if($voting->status == 2)
            <a href="{{ route('admin.voting.export', $voting->voting_id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export CSV
            </a>
            <form action="{{ route('admin.voting.destroyVotes', $voting->voting_id) }}" method="POST" onsubmit="return confirm('FINAL STEP: Are you sure you want to PERMANENTLY DELETE all votes for this round? This will clear the leaderboard for the next round.');">
                @csrf
                @method('DELETE')
          
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-600 transition flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Clean Votes
                </button>
            </form>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 text-sm text-gray-600">
    
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 italic">
        <strong>Voting Date:</strong> {{ \Carbon\Carbon::parse($voting->votingdate)->format('M d, Y') }}
    </div>
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
        <strong>Total Contestants:</strong> {{ $voting->votingContestants->count() }}
    </div>

</div>

<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4 font-medium border-b border-gray-100">S.No</th>
                <th class="px-6 py-4 font-medium border-b border-gray-100">Name</th>
                <th class="px-6 py-4 font-medium border-b border-gray-100 text-center">Live Votes</th>
                <th class="px-6 py-4 font-medium border-b border-gray-100">Status</th>
                <th class="px-6 py-4 font-medium border-b border-gray-100 text-right">Promote</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($voting->votingContestants as $index => $vc)
            <tr class="hover:bg-gray-50 transition-all">
                <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $vc->contestant->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600 text-center font-bold">{{ $vc->vote_count ?? 0 }}</td>
                <td class="px-6 py-4">
                    <button onclick="toggleContestantStatus({{ $vc->id }}, this)" 
                            class="status-badge cursor-pointer transition-all active:scale-90 focus:outline-none">
                        @if($vc->status == 1)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Active</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">Inactive</span>
                        @endif
                    </button>
                    <div class="status-loader hidden h-4 w-4 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end space-x-2">
                        <select id="target-round-{{ $vc->contestant->id }}" class="text-xs border border-gray-200 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500 outline-none">
                            <option value="">Select Round...</option>
                            @foreach($otherRounds as $round)
                                <option value="{{ $round->voting_id }}">{{ $round->title }}</option>
                            @endforeach
                        </select>
                        <button onclick="promoteContestant({{ $vc->contestant->id }})" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 transition-colors">
                            Move
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
