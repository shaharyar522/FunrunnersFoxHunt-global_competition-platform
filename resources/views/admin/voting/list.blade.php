@extends('layouts.admin')

@section('title', 'Voting List')
@section('page_title', 'Voting Management')

@section('content')
    <div id="voting-list-view">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4">
                <h2 class="text-lg font-semibold text-gray-800">Voting Rounds</h2>
                <div class="flex items-center gap-4">
                    {{-- <button onclick="openSyncModal()"
                        class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-all border border-indigo-200">
                        🔄 Sync Regional End Times
                    </button> --}}
                    <button onclick="openModal()"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-all shadow-sm">
                        + Add New Voting
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">

                        <tr>

                            <th class="px-8 py-4 font-medium">S.No</th>
                            <th class="px-8 py-4 font-medium">Title</th>
                            <th class="px-8 py-4 font-medium">Voting Date</th>
                            <th class="px-8 py-4 font-medium">Status</th>
                            <th class="px-8 py-4 font-medium">Action</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach ($votings as $index => $voting)
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-8 py-5 text-sm text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-8 py-5 text-sm font-medium text-gray-900">{{ $voting->title }}</td>
                                <td class="px-8 py-5 text-sm text-gray-600">{{ $voting->creationdate }}</td>
                                <td class="px-8 py-5">
                                    <form action="{{ route('admin.voting.status', $voting->voting_id) }}" method="POST">
                                        @csrf

                                        <button type="submit" class="focus:outline-none">

                                            @if ($voting->status == 0)
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                                            @elseif($voting->status == 1)
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Open</span>
                                            @else
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Closed</span>
                                            @endif

                                        </button>

                                    </form>  

                                </td>
                                <td class="px-8 py-5 flex items-center space-x-4">

                               <a href="javascript:void(0);" onclick="openVotingDetail({{ $voting->voting_id }})"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View Details
                                    </a>


                                    {{--  reset voting right now..!! --}}
                                    {{-- <form action="{{ route('admin.voting.destroyVotes', $voting->voting_id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to PERMANENTLY DELETE current votes for this round? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center"
                                            title="Delete all votes for this round">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Reset Votes
                                        </button>

                                    </form> --}}


                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div id="voting-detail-view" class="hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div id="voting-detail-content">
                <div class="text-center py-10">
                    <p class="text-gray-500 text-lg">Loading details...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Voting Modal -->
    <div id="addVotingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">
            <button onclick="closeModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 font-bold text-lg">&times;</button>
            <h2 class="text-xl font-semibold mb-4">Add Voting Round</h2>

            <form id="addVotingForm" action="{{ route('admin.votings.store') }}" method="POST">
                @csrf
                <div class="mb-4">

                    <label class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Voting Date</label>
                    <input type="date" name="creationdate" value="{{ old('creationdate') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Voting End Time (Global Sync)</label>
                <input type="datetime-local" name="closed_at" value="{{ old('closed_at') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Voting will automatically close at this time.</p>
            </div> --}}


                {{-- after this i am adding this  --}}

                {{-- <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Region (Automatic Addition)</label>
                    <select name="region_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- No Region (Manual) --</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Approved contestants from this region will be added instantly.</p>
                </div> --}}

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="0">Pending</option>
                        <option value="1">Open</option>
                        <option value="2">Closed</option>
                    </select>
                </div>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all font-medium">
                    Add Voting Round
                </button>
            </form>

        </div>
    </div>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '<ul class="text-left">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                showConfirmButton: true
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                showConfirmButton: true
            });
        </script>
    @endif

    <!-- Sync Modal -->
    <div id="syncModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeSyncModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 font-bold text-lg">&times;</button>
            <h2 class="text-xl font-semibold mb-2">Sync End Times</h2>
            <p class="text-sm text-gray-500 mb-6">This will update <span class="font-bold text-indigo-600">ALL currently
                    OPEN</span> regional rounds to end at the same time.</p>


        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addVotingModal').classList.remove('hidden');
            document.getElementById('addVotingModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('addVotingModal').classList.remove('flex');
            document.getElementById('addVotingModal').classList.add('hidden');
        }

        function openSyncModal() {
            document.getElementById('syncModal').classList.remove('hidden');
            document.getElementById('syncModal').classList.add('flex');
        }

        function closeSyncModal() {
            document.getElementById('syncModal').classList.remove('flex');
            document.getElementById('syncModal').classList.add('hidden');
        }

        function openVotingDetail(votingId) {
            const listView = document.getElementById('voting-list-view');
            const detailView = document.getElementById('voting-detail-view');
            const detailContent = document.getElementById('voting-detail-content');

            listView.classList.add('hidden');
            detailView.classList.remove('hidden');
            detailContent.innerHTML =
                '<div class="text-center py-10"><p class="text-gray-500 text-lg">Loading details...</p></div>';

            fetch(`/admin/voting/detail/${votingId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(data => {
                    detailContent.innerHTML = data;
                })
                .catch(err => {
                    detailContent.innerHTML =
                        '<p class="text-red-500 p-8">Failed to load data. <button onclick="goBackToList()" class="underline text-blue-600">Go back</button></p>';
                });
        }

        function goBackToList() {
            document.getElementById('voting-list-view').classList.remove('hidden');
            document.getElementById('voting-detail-view').classList.add('hidden');
        }

        function toggleContestantStatus(id, btn) {
            const badge = btn.querySelector('span');
            const loader = btn.nextElementSibling;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            btn.classList.add('hidden');
            loader.classList.remove('hidden');

            fetch(`/admin/voting-contestant/toggle/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    loader.classList.add('hidden');
                    btn.classList.remove('hidden');
                    if (data.success) {
                        if (data.status == 1) {
                            badge.className =
                                'px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200';
                            badge.innerText = 'Active';
                        } else {
                            badge.className =
                                'px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200';
                            badge.innerText = 'Inactive';
                        }
                    }
                })
                .catch(err => {
                    console.error('Toggle error:', err);
                    loader.classList.add('hidden');
                    btn.classList.remove('hidden');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update status.'
                    });
                });
        }

        function promoteContestant(contestantId) {
            const targetRoundId = document.getElementById('target-round-' + contestantId).value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!targetRoundId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Wait',
                    text: 'Please select a round to move her to.'
                });
                return;
            }

            Swal.fire({
                title: 'Move Contestant?',
                text: "She will be added to the selected round.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, move her!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/voting/promote`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                contestant_id: contestantId,
                                target_voting_id: targetRoundId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success!', data.message, 'success');
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(err => {
                            console.error('Promotion error:', err);
                            Swal.fire('Error', 'Something went wrong.', 'error');
                        });
                }
            });
        }
    </script>
@endsection
