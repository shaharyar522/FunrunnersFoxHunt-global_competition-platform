@extends('layouts.app')

@section('content')


    <style>
        /* Force select options to be visible and have dark text */
        select option {
            color: #0f172a !important;
            /* slate-900 */
            background-color: #ffffff !important;
            padding: 10px !important;
        }

        select:invalid,
        select option[value=""] {
            color: #94a3b8 !important;
            /* slate-400 */
        }
    </style>

    <div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-slate-100">
                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-700 px-10 py-12 text-white text-center">
                    <!-- Logout Button -->
                    <div class="absolute top-4 right-6">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl text-sm font-bold border border-white/20 transition-all active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>

                    <h1 class="text-3xl font-bold">Complete Your Profile</h1>
                    <p class="mt-2 text-indigo-100 opacity-80">This information will be visible to voters worldwide.</p>
                </div>

                @if (session('success'))
                    <div class="mx-10 mt-6 bg-green-50 border-l-4 border-green-400 p-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mx-10 mt-6 bg-red-50 border-l-4 border-red-400 p-4 text-red-700">
                        <p class="font-bold">Please fix the following errors:</p>
                        <ul class="list-disc ml-5 mt-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="profileForm" action="{{ route('contestant.storeProfile') }}" method="POST" enctype="multipart/form-data"
                    class="px-10 py-10 space-y-8">

                    @csrf

                    <!-- Profile Image -->
                    <div class="space-y-4">
                        <label class="block text-lg font-bold text-slate-800">Your Photo</label>
                        <div class="flex items-center justify-center w-full">
                            <label
                                class="flex flex-col items-center justify-center w-full h-72 border-2 border-indigo-200 border-dashed rounded-3xl cursor-pointer bg-indigo-50/30 hover:bg-indigo-50 hover:border-indigo-400 transition-all duration-300 group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                    <div
                                        class="bg-indigo-100 p-4 rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="mb-2 text-base text-slate-700 font-semibold">Click to upload your best photo
                                    </p>
                                    <p class="text-sm text-slate-500">Selected image will be visible in voting</p>
                                    <p
                                        class="mt-2 px-3 py-1 bg-white rounded-full text-xs font-bold text-indigo-600 shadow-sm border border-indigo-100">
                                        PNG, JPG or JPEG</p>
                                </div>
                                <input type="file" name="image" id="profile_image" class="hidden" required
                                    onchange="previewImage(this)" />
                            </label>
                        </div>
                    </div>

                    <!-- Fields Stacked -->
                    <div class="space-y-6">


                        <!-- Contestant Name -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Contestant Name</label>
                            <input type="text" name="name"
                                value="{{ old('name', $contestant?->name ?? auth()->user()->name) }}"
                                class="w-full px-5 py-4 rounded-xl border-2 @error('name') border-red-300 @else border-slate-100 @enderror bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-slate-800 font-medium"
                                placeholder="Enter contestant display name" required>
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob', $contestant?->dob) }}"
                                class="w-full px-5 py-4 rounded-xl border-2 @error('dob') border-red-300 @else border-slate-100 @enderror bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-slate-800 font-medium"
                                required>
                            @error('dob')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Contact --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Your Contact</label>
                            <input type="text" name="contact" value="{{ old('contact', $contestant?->contact) }}"
                                class="w-full px-5 py-4 rounded-xl border-2 @error('contact') border-red-300 @else border-slate-100 @enderror bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-slate-800 font-medium"
                                placeholder="Phone number or WhatsApp" required>
                            <p class="mt-2 text-xs text-slate-400">Example: +1 234 567 8900</p>
                            @error('contact')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Region -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Region</label>
                            <div class="relative">
                                <select name="region"
                                    class="w-full px-5 py-4 rounded-xl border-2 @error('region') border-red-300 @else border-slate-100 @enderror bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-slate-800 font-medium appearance-none cursor-pointer"
                                    >
                                    <option value="" class="text-slate-400">Select your region</option>

                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}"
                                            {{ old('region', $contestant?->region_id) == $region->id ? 'selected' : '' }}
                                            class="text-slate-900 bg-white py-2">
                                            {{ $region->name }}
                                        </option>
                                    @endforeach

                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('region')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Bio -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Your Story (Bio)</label>
                            <textarea name="bio" rows="4"
                                class="w-full px-5 py-4 rounded-xl border-2 @error('bio') border-red-300 @else border-slate-100 @enderror bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-slate-800 font-medium"
                                placeholder="Tell the world why you should be the foxiest woman on earth..." required>{{ old('bio', $contestant?->bio) }}</textarea>
                            <p class="mt-2 text-xs text-slate-400">Minimum 20 characters</p>
                            @error('bio')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>

                    <div class="pt-8">
                        <button type="submit" id="submitBtn"
                            class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-lg font-black rounded-2xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 shadow-xl hover:shadow-indigo-500/25 active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3 btn-icon transition-all">
                                <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-100 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            <span id="btnText">SUBMIT PROFILE</span>
                            <span id="btnLoader" class="hidden ml-3">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                        <p class="mt-4 text-center text-xs text-slate-400">By submitting, you agree to follow the community
                            guidelines.</p>
                    </div>
                </form>

                <script>
                    function previewImage(input) {
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const label = input.parentElement;
                                label.style.backgroundImage = `url('${e.target.result}')`;
                                label.style.backgroundSize = 'cover';
                                label.style.backgroundPosition = 'center';
                                label.querySelector('div').style.display = 'none';
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    document.getElementById('profileForm').addEventListener('submit', function() {
                        const btn = document.getElementById('submitBtn');
                        const text = document.getElementById('btnText');
                        const loader = document.getElementById('btnLoader');
                        const icon = document.querySelector('.btn-icon');

                        btn.disabled = true;
                        text.innerText = 'PROCESSING...';
                        loader.classList.remove('hidden');
                        if (icon) icon.classList.add('opacity-0');
                    });
                </script>
            </div>
        </div>
    </div>


@endsection
