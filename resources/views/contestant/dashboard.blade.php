@extends('layouts.contestant')

@section('title', 'Contestant Dashboard')
@section('page_title', 'My Competition Rounds')

@section('content')

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h2 class="text-md font-bold text-gray-700 uppercase tracking-tight">Active & Past Rounds</h2>
                {{-- <a href="{{ route('contestant.profile') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-blue-700 transition">Edit Profile</a> --}}
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-bold border-b">Title</th>
                            <th class="px-6 py-4 font-bold border-b text-center">Date</th>
                            <th class="px-6 py-4 font-bold border-b text-center">Status</th>
                            <th class="px-6 py-4 font-bold border-b text-center">Applied Contestants_lists</th>
                            <th class="px-6 py-4 font-bold border-b text-center">Applyins</th>
                            <th class="px-6 py-4 font-bold border-b text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse($rounds as $round)
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-5 text-sm font-medium text-gray-900">
                                    {{  $round->title }}
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-600 text-center">
                                    {{  $round->creationdate ?? ($current_date ?? now()->toDateString()) }}
                                </td>

                                <td class="px-6 py-5 text-center">
                                    @if ($round->status == 0)
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">Pending</span>
                                    @elseif($round->status == 1)
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Open</span>
                                    @elseif($round->status == 2)
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">Closed</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">Pending</span>
                                    @endif
                                </td>


                                <td class="px-6 py-5">
                                    <div class="flex justify-center items-center">
                                        <button
                                            onclick="openContestantModal({{ $round->voting_id }}, '{{ $round->title }}')"
                                            class="group flex -space-x-2 cursor-pointer hover:scale-110 transition-transform duration-300">

                                            @php
                                                // Just show a few placeholders or real images if you have them
                                                $images = [
                                                    'https://i.pravatar.cc/100?u=1',
                                                    'https://i.pravatar.cc/100?u=2',
                                                    'https://i.pravatar.cc/100?u=3'
                                                ];
                                            @endphp
                                            
                                            @foreach($images as $img)
                                                <img src="{{ $img }}"
                                                    class="w-8 h-8 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-100">
                                            @endforeach

                                            <div
                                                class="w-8 h-8 rounded-full border-2 border-white shadow-sm bg-indigo-50 flex items-center justify-center text-[10px] font-bold text-indigo-600 ring-1 ring-indigo-100">
                                                +{{ $round->applied_count }}
                                            </div>
                                        </button>
                                    </div>
                                </td>


                                <td class="px-6 py-5 text-center">
                                    <div class="flex flex-col items-center space-y-1">
                                        @if($round->already_applied)
                                            <span class="text-[10px] bg-green-100 text-green-700 px-3 py-1.5 rounded-lg font-black uppercase tracking-widest border border-green-200">
                                                Applied
                                            </span>
                                        @elseif($round->status == 1)
                                            <button onclick="applyToRound({{ $round->voting_id }})"
                                                class="mt-2 text-[10px] bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-3 py-1.5 rounded-lg font-black hover:from-blue-700 hover:to-indigo-700 transition shadow-lg shadow-indigo-100 uppercase tracking-widest">
                                                Apply
                                            </button>
                                        @else
                                             <span class="text-[10px] text-gray-400 font-bold uppercase">Closed</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-right">
                                    <a href="#"
                                        class="text-xs bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg font-bold hover:bg-gray-200 transition">
                                        View
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">
                                    No competition rounds found matching your criteria.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Contestant List Modal -->


    <div id="contestantModal"
        class="fixed inset-0 z-[100] hidden overflow-hidden bg-slate-900/60 backdrop-blur-sm flex justify-center items-center transition-all duration-500">
        <div id="modalContainer"
            class="bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all scale-95 opacity-0 duration-300">
            <!-- Modal Header -->
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 id="modalTitle" class="text-xl font-black text-gray-800 tracking-tight">Contestants List</h3>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Global Competition</p>
                </div>
                <button onclick="closeModal()"
                    class="bg-white p-2 rounded-xl shadow-sm border border-gray-100 text-gray-400 hover:text-red-500 hover:border-red-100 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="px-8 py-8 max-h-[400px] overflow-y-auto custom-scrollbar">
                <div id="contestantList" class="space-y-4">
                    <!-- Dummy data injected here -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-8 bg-gray-50/50 border-t border-gray-100 flex flex-col space-y-3">
                <button onclick="applyToRoundFromModal()"
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 rounded-2xl font-black text-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-xl shadow-indigo-100 active:scale-95">
                    APPLY FOR THIS ROUND
                </button>
                <p class="text-center text-[10px] text-gray-400 font-bold uppercase tracking-widest">Limited Slots Available
                </p>
            </div>
        </div>
    </div>



    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #ccc;
        }
    </style>



    <script>
        let activeRoundId = null;
        const baseUrl = "{{ url('/') }}";

        async function openContestantModal(roundId, roundTitle) {
            activeRoundId = roundId;
            const modal = document.getElementById('contestantModal');
            const container = document.getElementById('modalContainer');
            const list = document.getElementById('contestantList');
            const title = document.getElementById('modalTitle');

            title.innerText = roundTitle;
            list.innerHTML = `<div class="flex justify-center py-10 items-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
            </div>`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                container.classList.remove('scale-95', 'opacity-0');
                container.classList.add('scale-100', 'opacity-100');
            }, 10);

            try {
                const response = await fetch(`${baseUrl}/onboarding/round/${roundId}/contestants`);
                const data = await response.json();
                
                if (data.success) {
                    if (!data.contestants || data.contestants.length === 0) {
                        list.innerHTML = `
                            <div class="text-center py-10">
                                <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">No contestants applied yet</p>
                            </div>`;
                    } else {
                        list.innerHTML = data.contestants.map(c => `
                            <div class="flex items-center space-x-4 p-4 bg-white border border-gray-100 rounded-2xl hover:shadow-lg hover:border-indigo-100 transition-all duration-300 group">
                                <div class="relative">
                                    <img src="${c.image}" class="w-12 h-12 rounded-full border-2 border-indigo-50 group-hover:border-indigo-200 transition-all" />
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-black text-gray-800 text-sm tracking-tight">${c.name}</h4>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">${c.region}</p>
                                </div>
                                <div class="bg-indigo-50 px-3 py-1 rounded-full">
                                    <span class="text-[10px] text-indigo-600 font-black uppercase">Verified</span>
                                </div>
                            </div>
                        `).join('');
                    }
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                list.innerHTML = `<p class="text-center text-red-500 text-xs font-bold">Failed to load contestants.</p>`;
            }
        }

        function closeModal() {
            const modal = document.getElementById('contestantModal');
            const container = document.getElementById('modalContainer');

            container.classList.remove('scale-100', 'opacity-100');
            container.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Close modal on click outside
        window.onclick = function(event) {
            const modal = document.getElementById('contestantModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        async function applyToRound(roundId) {
            if (!confirm('Are you sure you want to apply for this round? This will use one of your entry payments.')) return;

            try {
                const response = await fetch(`${baseUrl}/onboarding/apply-round/${roundId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    if (data.needs_payment) {
                        if (confirm(data.message + '\n\nWould you like to go to the payment page?')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('contestant.paymentProcess') }}";
                            const csrf = document.createElement('input');
                            csrf.type = 'hidden';
                            csrf.name = '_token';
                            csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            form.appendChild(csrf);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    } else {
                        alert(data.message);
                    }
                }
            } catch (error) {
                console.error('Apply Error:', error);
                alert('An error occurred while submitting your application.');
            }
        }

        function applyToRoundFromModal() {
            if (activeRoundId) {
                applyToRound(activeRoundId);
            }
        }
    </script>
@endsection
