    <section id="login" class="cta">

        <div class="container">

            <h2 class="cta-title" data-aos="fade-up">Ready to Join?</h2>

            <p class="cta-subtitle" data-aos="fade-up" data-aos-delay="100">Sign up with your preferred social media
                account</p>
                
            <div class="social-login" data-aos="fade-up" data-aos-delay="200">

                <form action="{{ route('google-login') }}" method="get">
                    <button type="submit" class="social-btn google-btn">
                        <span class="icon">G</span>
                        <span class="text">Continue with Google</span>
                    </button>
                </form>

                <form action="{{ route('twitter.login') }}" method="get">
                    <button class="social-btn twitter-btn">
                        <span class="icon">𝕏</span>
                        <span class="text">Continue with X</span>
                    </button>
                </form>

                <form action="" method="get">
                    <button class="social-btn facebook-btn">
                        <span class="icon">f</span>
                        <span class="text">Continue with Facebook</span>
                    </button>
                </form>

            </div>

            <p class="cta-footer">No email or phone signup needed - just social login</p>

        </div>

    </section>
