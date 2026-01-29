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

         <h1 class="hero-title" data-aos="fade-up" style="color: white">

             Looking for the Foxiest Woman on Earth

         </h1>

         <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200" style="color: white">
             Global Members-Only Voting Competition
         </p>

         <div class="hero-buttons" data-aos="fade-up" data-aos-delay="400">   

             <a href="{{ route('google-login', ['role' => 'contestant']) }}" style="text-decoration: none;">
                 <button class="btn btn-primary">Join as Contestant</button>
             </a>

             <a href="{{ route('google-login', ['role' => 'member']) }}" style="text-decoration: none;">

                 <button class="btn btn-secondary">Join as Member</button>
                 
             </a>
             
         </div>

     </div>

     <div class="hero-footer">
         <p>Already a member? <a href="#login" class="scroll-link">Sign in now</a></p>
     </div>

 </section>
