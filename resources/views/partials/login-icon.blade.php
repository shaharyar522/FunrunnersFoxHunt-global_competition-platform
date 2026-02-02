    <section id="login" class="cta">

        <div class="container">

            <h2 class="cta-title" data-aos="fade-up">Ready to Join?</h2>

            <p class="cta-subtitle" data-aos="fade-up" data-aos-delay="100">Sign up with your preferred social media
                account</p>
                
            <div id="role-selector" class="mb-10 text-center" data-aos="fade-up" data-aos-delay="150">
                <style>
                    .role-btn { transition: all 0.3s ease; cursor: pointer; }
                    .role-btn.active { background: #d4af37 !important; color: #0a0e27 !important; border-color: #d4af37 !important; transform: scale(1.05); box-shadow: 0 0 20px rgba(212, 175, 55, 0.4); }
                </style>
                <p class="text-sm mb-4 text-slate-400">Step 1: Choose your role</p>
                <div class="flex justify-center gap-4">
                    <button type="button" onclick="updateLoginRole('contestant')" id="btn-contestant" class="role-btn active px-8 py-3 bg-transparent border-2 border-primary-gold rounded-full text-sm font-bold text-primary-gold uppercase">Contestant</button>
                    <button type="button" onclick="updateLoginRole('member')" id="btn-member" class="role-btn px-8 py-3 bg-transparent border-2 border-primary-gold rounded-full text-sm font-bold text-primary-gold uppercase">Member</button>
                </div>
            </div>

            <div class="social-login" data-aos="fade-up" data-aos-delay="200">

                <form action="{{ route('google-login') }}" method="get">
                    <input type="hidden" name="role" value="contestant" class="role-input">
                    <button type="submit" class="social-btn google-btn">
                        <span class="icon">G</span>
                        <span class="text">Continue with Google</span>
                    </button>
                </form>

                <form action="{{ route('twitter.login') }}" method="get">
                    <input type="hidden" name="role" value="contestant" class="role-input">
                    <button type="submit" class="social-btn twitter-btn">
                        <span class="icon">𝕏</span>
                        <span class="text">Continue with X</span>
                    </button>
                </form>

                <form action="{{ route('facebook-login') }}" method="get">
                    <input type="hidden" name="role" value="contestant" class="role-input">
                    <button type="submit" class="social-btn facebook-btn">
                        <span class="icon">f</span>
                        <span class="text">Continue with Facebook</span>
                    </button>
                </form>

            </div>

            <div class="mt-12 max-w-md mx-auto" data-aos="fade-up" data-aos-delay="250">
                <div class="relative flex items-center justify-center mb-8">
                    <div class="flex-grow border-t border-slate-700"></div>
                    <span class="flex-shrink mx-4 text-slate-500 text-sm font-medium uppercase tracking-wider">Or login with email</span>
                    <div class="flex-grow border-t border-slate-700"></div>
                </div>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-4 text-left">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Email Address</label>
                        <input type="email" name="email" required 
                            class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-5 py-4 text-white focus:outline-none focus:border-primary-gold transition-all"
                            placeholder="Enter your email">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Password</label>
                        <input type="password" name="password" required 
                            class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-5 py-4 text-white focus:outline-none focus:border-primary-gold transition-all"
                            placeholder="••••••••">
                    </div>
                    <button type="submit" 
                        class="w-full py-4 bg-primary-gold text-slate-900 font-black rounded-xl hover:bg-yellow-500 transition-all transform active:scale-95 shadow-lg shadow-yellow-600/20">
                        LOG IN NOW
                    </button>
                </form>
            </div>

            <p class="cta-footer mt-8">Register via Social and set your password in Profile to login here.</p>

        </div>

    </section>
