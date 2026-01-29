
 <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            
            <div class="nav-logo">
                {{-- <span class="fox-icon">🦊</span> --}}
                <span class="logo-text">FunrunnersFoxHunt</span>
            </div>

            <div class="nav-menu">
                <a href="#hero" class="nav-link">Home</a>
                <a href="#how-it-works" class="nav-link">How It Works</a>
                <a href="#regions" class="nav-link">Regions</a>
                <a href="#rules" class="nav-link">Rules</a>
                <a href="{{ route('public.results.index') }}" class="nav-link font-bold text-indigo-400">Live Results</a>
                <a href="#login" class="nav-link">Login</a>
            </div>
            <button class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
