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
                                    <!-- Ye button missing tha -->
                                    <a href="javascript:void(0);" onclick="openVotingDetail({{ $voting->voting_id }})"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View Details
                                    </a>
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

                <!-- {{-- <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Voting End Time (Global Sync)</label>
                <input type="datetime-local" name="closed_at" value="{{ old('closed_at') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Voting will automatically close at this time.</p>
            </div> --}} -->


               

               <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Region (Automatic Addition)</label>
                    <select name="region_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- No Region (Manual) --</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Approved contestants from this region will be added instantly.</p>
                </div>

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
    // System Config
    const APP_URL = "{{ url('/') }}";

    function openModal() {
        document.getElementById('addVotingModal').classList.replace('hidden', 'flex');
    }

    function closeModal() {
        document.getElementById('addVotingModal').classList.replace('flex', 'hidden');
    }

    function openSyncModal() {
        document.getElementById('syncModal').classList.replace('hidden', 'flex');
    }

    function closeSyncModal() {
        document.getElementById('syncModal').classList.replace('flex', 'hidden');
    }

    function openVotingDetail(votingId) {
        const modal = document.getElementById('viewDetailModal');
        const listContainer = document.getElementById('modalContestantList');
        const titleElement = document.getElementById('modalVotingTitle');

        listContainer.innerHTML = '<div class="text-center py-10"><p>Loading contestants...</p></div>';
        modal.classList.replace('hidden', 'flex');

        fetch(`${APP_URL}/admin/voting/detail-modal/${votingId}`)
            .then(res => res.json())
            .then(data => {
                titleElement.innerText = data.title;
                let html = '<table class="w-full text-left"><tbody class="divide-y">';
                data.contestants.forEach(item => {
                    const isBlocked = item.status == 0;
                    html += `
                        <tr>
                            <td class="py-4 flex items-center space-x-3 text-sm">
                                <img src="${item.image}" class="w-10 h-10 rounded-full border">
                                <span class="font-bold">${item.name}</span>
                            </td>
                            <td class="py-4 text-center">
                                <span id="badge-${item.id}" class="px-2 py-1 rounded-full text-[10px] font-bold uppercase ${isBlocked ? 'bg-gray-100 text-gray-500' : 'bg-green-100 text-green-700'}">
                                    ${isBlocked ? 'Blocked' : 'Active'}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <button onclick="toggleBlock(${item.id}, this)"
                                    class="px-4 py-2 rounded-lg text-[10px] font-bold uppercase transition-all ${isBlocked ? 'bg-green-600 text-white' : 'bg-red-50 text-red-600 shadow-sm'}">
                                    ${isBlocked ? 'Unblock' : 'Block'}
                                </button>
                            </td>
                        </tr>`;
                });
                listContainer.innerHTML = html + '</tbody></table>';
            });
    }

    function toggleBlock(vcId, btn) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const badge = document.getElementById(`badge-${vcId}`);

        btn.disabled = true;
        btn.innerText = 'Updating...';

        fetch(`${APP_URL}/admin/voting/contestant/toggle/${vcId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            if(data.success) {
                if(data.new_status == 1) { // User is now Active
                    btn.innerText = 'Block';
                    btn.className = 'px-4 py-2 rounded-lg text-[10px] font-bold uppercase bg-red-50 text-red-600 shadow-sm transition-all';
                    badge.innerText = 'Active';
                    badge.className = 'px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-green-100 text-green-700';
                } else { // User is now Blocked
                    btn.innerText = 'Unblock';
                    btn.className = 'px-4 py-2 rounded-lg text-[10px] font-bold uppercase bg-green-600 text-white transition-all';
                    badge.innerText = 'Blocked';
                    badge.className = 'px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-gray-100 text-gray-500';
                }
            } else {
                alert('Error: Could not update status');
                btn.innerText = 'Try Again';
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerText = 'Error';
            alert('Something went wrong. Please check your internet or permissions.');
        });
    }

    function closeDetailModal() {
        document.getElementById('viewDetailModal').classList.replace('flex', 'hidden');
    }

</script>

    <!-- Contestant Detail Modal -->

    <div id="viewDetailModal"
        class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-[100] backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all mx-4">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <h2 id="modalVotingTitle" class="text-xl font-bold text-gray-800">Voting Contestants</h2>
                <button onclick="closeDetailModal()"
                    class="text-gray-400 hover:text-gray-600 p-1 hover:bg-gray-100 rounded-lg transition-all text-2xl">&times;</button>
            </div>
            <div class="p-6 max-h-[70vh] overflow-y-auto" id="modalContestantList">
                <!-- Data yahan JavaScript se load hoga -->
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-right">
                <button onclick="closeDetailModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-all">Close</button>
            </div>
        </div>
    </div>

@endsection
