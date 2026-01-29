<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="FunrunnersFoxHunt - The Global Beauty Competition Platform. Join a premium members-only voting experience.">
    <title>FunrunnersFoxHunt — Looking for the Foxiest Woman on Earth</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
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
                <a href="#login" class="nav-link">Login</a>
            </div>
            <button class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero"
        style="
         background-image: linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.25)), url('{{ asset('images/hero_bg.png') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
    ">
        <div class="animated-background">
            <div class="particle" style="--i:1"></div>
            <div class="particle" style="--i:2"></div>
            <div class="particle" style="--i:3"></div>
            <div class="particle" style="--i:4"></div>
            <div class="particle" style="--i:5"></div>
        </div>

        <div class="hero-content">
            <h1 class="hero-title" data-aos="fade-up">
                Looking for the Foxiest Woman on Earth
            </h1>
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200" style="color: white">
                Global Members-Only Voting Competition
            </p>

            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="400">
                <button class="btn btn-primary">Join as Contestant</button>
                <button class="btn btn-secondary">Join as Member</button>
            </div>
        </div>

        <div class="hero-footer">
            <p>Already a member? <a href="#login" class="scroll-link">Sign in now</a></p>
        </div>

    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">How It Works</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Three simple steps to join the global
                competition</p>

            <div class="steps-grid">
                <div class="step-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-icon">👩</div>
                    <h3>Women Join</h3>
                    <p>Contestants pay a one-time <span class="highlight">$5 fee</span> to prove they are real and join
                        the competition</p>
                    <div class="step-number">01</div>
                    php artisan make:controller indexController -r
                </div>

                <div class="step-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-icon">👨</div>
                    <h3>Men Vote</h3>
                    <p>Members get monthly voting access for a <span class="highlight">subscription</span>. Vote once
                        per round for any contestant worldwide</p>
                    <div class="step-number">02</div>
                </div>

                <div class="step-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-icon">🏆</div>
                    <h3>Winners Advance</h3>
                    <p>Regional rounds converge, <span class="highlight">judges select finalists</span>, and a global
                        winner emerges</p>
                    <div class="step-number">03</div>
                </div>
            </div>
        </div>
    </section>







    <!-- Regions Section -->
    <section id="regions" class="regions">

        {{-- regions image is here in this . --}}

    </section>





    <!-- Rules & Legal -->
    <section id="rules" class="rules">

        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Rules & Competition Guidelines</h2>

            <div class="rules-grid">
                <div class="rule-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="rule-check">✔</div>
                    <h3>One Vote Per Round</h3>
                    <p>Each member gets exactly one vote per voting round, regardless of region</p>
                </div>

                <div class="rule-card" data-aos="fade-up" data-aos-delay="150">
                    <div class="rule-check">✔</div>
                    <h3>Transparent Voting</h3>
                    <p>All votes are publicly visible while voting is open and active</p>
                </div>

                <div class="rule-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="rule-check">✔</div>
                    <h3>Vote Deletion</h3>
                    <p>All votes are permanently deleted after each round ends</p>
                </div>

                <div class="rule-card" data-aos="fade-up" data-aos-delay="250">
                    <div class="rule-check">✔</div>
                    <h3>Global Reach</h3>
                    <p>Members can vote for any contestant from any region worldwide</p>
                </div>

                <div class="rule-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="rule-check">✔</div>
                    <h3>Synchronized Timing</h3>
                    <p>All regional voting ends at the same date and time globally</p>
                </div>

                <div class="rule-card" data-aos="fade-up" data-aos-delay="350">
                    <div class="rule-check">✔</div>
                    <h3>Final Authority</h3>
                    <p>Judges' decisions are final and binding in all matters</p>
                </div>
            </div>

            <div class="read-more" data-aos="fade-up" data-aos-delay="400">
                <button class="btn btn-outline">Read Full Rules & Terms</button>
            </div>
        </div>

    </section>

    <!-- Call to Action -->
    <section id="login" class="cta">
        <div class="container">
            <h2 class="cta-title" data-aos="fade-up">Ready to Join?</h2>
            <p class="cta-subtitle" data-aos="fade-up" data-aos-delay="100">Sign up with your preferred social media
                account</p>
            <div class="social-login" data-aos="fade-up" data-aos-delay="200">
                <button class="social-btn google-btn">
                    <span class="icon">G</span>
                    <span class="text">Continue with Google</span>
                </button>
                <button class="social-btn facebook-btn">
                    <span class="icon">f</span>
                    <span class="text">Continue with Facebook</span>
                </button>
                <button class="social-btn twitter-btn">
                    <span class="icon">𝕏</span>
                    <span class="text">Continue with X</span>
                </button>
            </div>

            <p class="cta-footer">No email or phone signup needed - just social login</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>FunrunnersFoxHunt</h4>
                    <p>Looking for the Foxiest Woman on Earth</p>
                </div>

                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#hero">Home</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#regions">Regions</a></li>
                        <li><a href="#rules">Rules</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-icons">
                        <a href="#" class="social-icon" title="Facebook">f</a>
                        <a href="#" class="social-icon" title="Twitter">𝕏</a>
                        <a href="#" class="social-icon" title="Instagram">📷</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 FunrunnersFoxHunt.com. All rights reserved. | Looking for the Foxiest Woman on Earth</p>
            </div>
        </div>
    </footer>

    <!-- Loading AOS (Animate On Scroll) -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="{{ asset('js/landing.js') }}"></script>
</body>

</html>
