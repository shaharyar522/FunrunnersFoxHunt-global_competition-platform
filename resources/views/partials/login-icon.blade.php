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

            <p class="cta-footer mt-8">Register via Social and set your password in Profile to login here.</p>

        </div>

    </section>
