@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <a href="{{ route('member.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center mb-2 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900">{{ $voting->title }}</h1>
                <p class="mt-2 text-slate-600">Cast your vote carefully. You only get <span class="font-bold text-indigo-600">ONE vote</span> for this round.</p>
                <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-xs font-bold uppercase tracking-wider">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    Judges' decisions are final
                </div>
            </div>
            <div class="mt-4 sm:mt-0 bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200">
                <span class="text-sm text-slate-500">Voting Ends:</span>
                <span class="ml-2 font-bold text-slate-800">{{ $voting->votingdate }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($votedContestantId)
            <div class="mb-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-md shadow-sm">
                 <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-800">
                            You have already voted in this round. Thank you for participating!
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($voting->votingContestants as $votingContestant)
                @php $contestant = $votingContestant->contestant; @endphp
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 border border-slate-100 flex flex-col {{ $votedContestantId == $contestant->id ? 'ring-4 ring-green-400' : '' }}">
                    <div class="relative h-80 overflow-hidden bg-gray-200 group">
                        @if($contestant->image)
                            <img src="{{ $contestant->image }}" alt="{{ $contestant->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-90"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <h3 class="text-xl font-bold truncate">{{ $contestant->name }}</h3>
                            <p class="text-sm opacity-90 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $contestant->region->name ?? 'Unknown Region' }}
                                @if($contestant->age)
                                    <span class="mx-2">•</span> {{ $contestant->age }} years
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                             <p class="text-slate-600 text-sm line-clamp-2 mb-4">{{ $contestant->bio ?? 'No bio available.' }}</p>
                             
                             <!-- Q&A Section -->
                             <div class="mt-4 border-t border-slate-100 pt-4">
                                 <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Q&A with Members</h4>
                                 <div class="space-y-3 max-h-40 overflow-y-auto pr-2 custom-scrollbar">
                                     @forelse($contestant->questions as $q)
                                         <div class="text-xs">
                                             <p class="font-bold text-slate-800">Q: {{ $q->question }}</p>
                                             <p class="text-indigo-600 mt-1">A: {{ $q->answer }}</p>
                                         </div>
                                     @empty
                                         <p class="text-xs text-slate-400 italic">No questions answered yet.</p>
                                     @endforelse
                                 </div>
                                 
                                 <button onclick="toggleQuestionForm({{ $contestant->id }})" class="mt-3 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                                     + Ask her a question
                                 </button>
                                 
                                 <div id="q-form-{{ $contestant->id }}" class="hidden mt-3">
                                     <form action="{{ route('member.contestant.question.store', $contestant) }}" method="POST">
                                         @csrf
                                         <textarea name="question" rows="2" required
                                                   class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:ring-1 focus:ring-indigo-500 outline-none"
                                                   placeholder="What would you like to ask?"></textarea>
                                         <div class="mt-2 flex justify-end gap-2">
                                             <button type="button" onclick="toggleQuestionForm({{ $contestant->id }})" class="text-xs text-slate-400 hover:text-slate-600">Cancel</button>
                                             <button type="submit" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-md hover:bg-indigo-700 transition-colors">Submit</button>
                                         </div>
                                     </form>
                                 </div>
                             </div>
                        </div>

                        <form action="{{ route('member.vote.store', ['voting' => $voting->voting_id, 'contestant' => $contestant->id]) }}" method="POST" class="mt-6">
                            @csrf
                            <button type="submit" 
                                class="w-full py-3 px-4 rounded-xl font-bold shadow-lg transform active:scale-95 transition-all text-sm uppercase tracking-wide
                                {{ $votedContestantId == $contestant->id
                                    ? 'bg-green-600 text-white cursor-default shadow-none hover:shadow-none hover:bg-green-700'
                                    : ($votedContestantId ? 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none' : 'bg-gradient-to-r from-red-500 to-pink-600 text-white hover:from-red-600 hover:to-pink-700 hover:shadow-red-500/30') 
                                }}"
                                {{ $votedContestantId ? 'disabled' : '' }}>
                                {{ $votedContestantId == $contestant->id
                                    ? 'YOU VOTED FOR HER'
                                    : ($votedContestantId ? 'Voting Closed' : 'Vote For Her')
                                }}
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <p class="mt-2 text-lg font-medium text-slate-500">No contestants found for this round yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleQuestionForm(id) {
        const form = document.getElementById('q-form-' + id);
        form.classList.toggle('hidden');
    }
</script>
@endsection
