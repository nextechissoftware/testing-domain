<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shaheed RNS Education Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <!-- Bootstrap JS (v5) and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .mobile-menu.show {
            transform: translateX(0);
        }
        @media(max-width: 768px){
            .principal_message{
                margin-top: 100px;
            }
        }
    </style>
</head>
<body>
     <!------------------------------------ Header------------------------ -->
     <section class="bg-gray-900 text-white">
        <header class="container mx-auto px-4 md:px-40 py-4 flex items-center justify-between">
            <a href="#" class="flex items-center gap-2">
                 <div class="h-14 w-14 md:h-16 md:w-16 rounded-full overflow-hidden border-2 border-white flex-shrink-0">
                 <img src="assets/logo.jpeg" alt="Logo" class="w-full h-full object-cover" />
                  </div>

                <span class="text-2xl font-bold">Shaheed RNS Education Academy</span>
            </a>
            <nav class="flex md:hidden items-center gap-6">
                <button class="text-amber-500 hover:text-amber-400" id="menu-btn">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 12H20" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 18H20" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </nav>
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-amber-500 hover:text-amber-400">Home</a>
                <a href="events-gallery.php" class="hover:text-amber-400 transition">Gallery</a>
                <a href="mandatory-public-disclosure.html" class="hover:text-amber-400 transition">Certificates</a>
                <a href="magazine.pdf" class="hover:text-amber-400 transition">Magazine</a>
                <a href="#" class="hover:text-amber-400">Blog</a>
                <a href="#" class="hover:text-amber-400">Contact</a>
            </nav>
        </header>
    
        <!-- Mobile Menu -->
        <div class="mobile-menu fixed top-0 left-0 w-full h-full flex flex-col items-center justify-center space-y-6 text-white bg-gray-900 shadow-lg z-50" id="mobile-menu">
            <button id="close-menu" class="absolute top-5 right-6 text-3xl text-white hover:text-gray-400">
                &times;
            </button>
            <a href="#" class="text-xl font-semibold hover:text-amber-400 transition">Home</a>
            <a href="events-gallery.php" class="text-xl hover:text-amber-400 transition">Events Gallery</a>
            <a href="mandatory-public-disclosure.html" class="text-xl hover:text-amber-400 transition">Certificates</a>
             <a href="magazine.pdf"class="text-xl hover:text-amber-400 transition">Magazine</a>
            <a href="#" class="text-xl hover:text-amber-400 transition">Blog</a>
            <a href="#" class="text-xl hover:text-amber-400 transition">Contact</a>
        </div>
    
        <section class="relative min-h-[100vh] flex flex-col md:flex-row items-center text-center md:text-left px-4 md:px-40">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-black/85"></div>
                <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1600&q=80" alt="School building" class="w-full h-full object-cover" />
            </div>
            
            <div class="relative z-10 container mx-auto flex flex-col md:flex-row items-center">
                <div class="w-full md:w-1/2 space-y-6">
                    <h1 class="text-4xl md:text-7xl mt-10 font-bold">
                        Your Kids <br /> Deserve The <br /> <span class="text-blue-400">Best Education From RNS School</span>
                    </h1>
                    <p class="text-lg text-gray-300">Active Learning, Expert Teachers & Safe Environment</p>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLScKyroS4curaZ-CPWBVwRnpxbc-LHLPjHT060yNLX_Tu3asTQ/viewform?usp=preview" class="inline-block px-6 py-3 bg-amber-500 text-white font-semibold rounded-full hover:bg-amber-600 transition">
                        Admission Now
                    </a>
                </div>
                
                <div class="w-full md:w-1/2 mt-8 md:mt-0 flex justify-center">
                    <div class="relative w-96 h-96 md:w-144 md:h-144">
                        <img src="./assets/boy.png" alt="Student with backpack" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>
        </section>
        
        <script>
            const menuBtn = document.getElementById('menu-btn');
            const closeBtn = document.getElementById('close-menu');
            const mobileMenu = document.getElementById('mobile-menu');
    
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('show');
            });
    
            closeBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('show');
            });
    
            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !menuBtn.contains(e.target)) {
                    mobileMenu.classList.remove('show');
                }
            });
        </script>
     </section>
    <!------------------------------------ Section 2------------------------ -->
    <section class="bg-gray-900 text-white px-6 md:px-20 lg:px-40 py-0">
        <div class="container mx-auto px-4 py-16 fade-in">
            <div class="text-center mb-12">
                <p class="text-green-400 uppercase tracking-widest">Best Features</p>
                <h1 class="text-2xl md:text-4xl font-bold mt-2">Achieve Your Goals With Shaheed RNS Education Academy</h1>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                <div
                    class="bg-gray-800 p-6 rounded-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="text-red-500 text-4xl mb-4">
                        <i class="fas fa-chalkboard-teacher transition duration-300 hover:text-red-400"></i>
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold mb-2">Expert Teachers</h2>
                    <p class="text-gray-400">Our experienced faculty inspire minds and shape futures with passion and dedication.                    </p>
                </div>
                <div
                    class="bg-gray-800 p-6 rounded-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="text-blue-500 text-4xl mb-4">
                        <i class="fas fa-book transition duration-300 hover:text-blue-400"></i>
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold mb-2">Quality Education</h2>
                    <p class="text-gray-400">Empowering students with knowledge, skills, and confidence for tomorrow’s world.</p>
                </div>
                <div
                    class="bg-gray-800 p-6 rounded-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="text-yellow-500 text-4xl mb-4">
                        <i class="fas fa-life-ring transition duration-300 hover:text-yellow-400"></i>
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold mb-2">Life Time Support</h2>
                    <p class="text-gray-400">We guide our students beyond the classroom—through every step of their journey.</p>
                </div>
                <div
                    class="bg-gray-800 p-6 rounded-lg text-center transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="text-green-500 text-4xl mb-4">
                        <i class="fas fa-university transition duration-300 hover:text-green-400"></i>
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold mb-2">Best Scholarships</h2>
                    <p class="text-gray-400">Rewarding merit and potential with generous scholarships for a brighter future.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center fade-in">
                <div class="relative">
                    <!-- Image -->
                    <img alt="Group of happy students holding a sign that says 'We are happy to be here'"
                        class="rounded-lg transition duration-500 hover:shadow-2xl w-full h-auto" 
                        src="./assets/Sec_2_Childrens.jpg" />
                
                    <!-- Responsive Overlay -->
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-[90%] bg-gray-800 p-4 md:p-6 rounded-lg fade-in 
                                shadow-lg backdrop-blur-md bg-opacity-90 
                                text-center md:text-left md:left-40 md:w-auto md:transform-none">
                        <h3 class="text-sm md:text-xl font-semibold mb-2">Get an Appointment Today!</h3>
                        <p class="text-gray-400 mb-3 text-xs md:text-base">
                            Your child's journey to success starts with one call.
                        </p>
                        <p class="text-yellow-500 text-sm md:text-lg font-semibold flex items-center justify-center md:justify-start">
                            <i class="fas fa-phone-alt mr-2"></i> +91 9720476913
                        </p>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">We Are The Best Choice For Your Child</h2>
                    <p class="text-gray-400 mb-4">Building bright futures through caring guidance, academic excellence, and lifelong values.</p>
                    <ul class="list-disc list-inside text-gray-400 mb-4">
                        <li>Special Education</li>
                        <li>Access more than 100K online courses</li>
                        <li>Traditional Academies</li>
                    </ul>
                    <button
                        class="bg-yellow-500 text-gray-900 font-semibold py-2 px-6 rounded-lg hover:bg-yellow-600 transition duration-300 hover:shadow-lg">Apply
                        Now</button>
                </div>
            </div>
        </div>
    </section>



    <!------------------------------------ OUR CLASSES------------------------ -->

  <section class="bg-black text-white px-6 md:px-20 lg:px-40 py-0">
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <p class="text-green-400 uppercase tracking-widest">Best Courses</p>
            <h1 class="text-2xl md:text-4xl font-bold mt-2">Find The Right Course For You</h1>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <!-- Card 1 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:scale-105 transition-transform duration-300">
                <img alt="Children in an educational program" class="w-full h-48 object-cover" height="400"
                    src="./assets/sec_3_card_1.jpg" width="600" />
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-teal-500 text-xs text-white font-semibold px-2 py-1 rounded">
                             KG
                        </span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star"></i>
                            <span class="ml-1">4.5</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">A playful and nurturing start to lifelong learning.</h3>
                    <p class="text-gray-400 mb-4">
                        Alphabet & number recognition

Rhymes and storytelling

Basic motor skills & social development
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold"></span>
                        <a class="text-teal-500 hover:underline" href="#">Know Details</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:scale-105 transition-transform duration-300">
                <img alt="Children meditating in a class" class="w-full h-48 object-cover" height="400"
                    src="./assets/sec_3_card_2.jpg" width="600" />
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-yellow-500 text-xs text-white font-semibold px-2 py-1 rounded">
                            UKG
                        </span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star"></i>
                            <span class="ml-1">4.3</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Best  Classes</h3>
                    <p class="text-gray-400 mb-4">
                        Help your child stay calm and focused with guided meditation and breathing exercises.
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold"></span>
                        <a class="text-teal-500 hover:underline" href="#">Know Details</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:scale-105 transition-transform duration-300">
                <img alt="Children playing games in a program" class="w-full h-48 object-cover" height="400"
                    src="./assets/sec_3_card_3.jpg" width="600" />
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-blue-500 text-xs text-white font-semibold px-2 py-1 rounded">
                            CLASS 1
                        </span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star"></i>
                            <span class="ml-1">4.2</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">The foundation for structured learning begins.</h3>
                    <p class="text-gray-400 mb-4">
                       Basic reading and writing

Simple arithmetic

Moral stories and creativity


                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold"></span>
                        <a class="text-teal-500 hover:underline" href="#">Know Details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Browse More Button -->
        <div class="text-center mt-12">
            <a  href="courses.html"   class="bg-yellow-500 text-gray-900 font-semibold py-2 px-6 rounded-full hover:bg-yellow-600 transition-all duration-300 transform hover:scale-105 inline-block" >
                Browse more courses
            </a>
        </div>
    </div>
</section>

    <!------------------------------------ Section 4------------------------ -->
    <section class="bg-gray-900 text-white px-6 md:px-20 lg:px-40 py-0">
        <div class="container mx-auto px-4 py-16">
            <div class="text-center mb-12">
                <p class="text-green-400 uppercase tracking-widest">WHY CHOOSE US</p>
                <h1 class="text-2xl md:text-4xl font-bold mt-2">Tools For Teachers And Learners</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="relative transform transition duration-300 hover:scale-105">
                    <img alt="Teacher in a classroom with students raising hands"
                        class="w-full h-full object-cover rounded-lg" height="400"
                        src="./assets/sec4_card_1.jpg"
                        width="600" />
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-lg fade-in">
                        <span class="text-xl font-bold text-white">Expert Teachers</span>
                    </div>
                </div>
                <div class="relative transform transition duration-300 hover:scale-105">
                    <img alt="Students in a safe learning environment" class="w-full h-full object-cover rounded-lg"
                        height="400"
                        src="./assets/sec4_card_2.jpg"
                        width="600" />
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-lg fade-in">
                        <span class="text-xl font-bold text-white">Safe Environment</span>
                    </div>
                </div>
            </div>
            <div class="text-center mb-12 fade-in">
                <p class="text-green-400 uppercase tracking-widest">OUR STATISTICS</p>
                <h1 class="text-2xl md:text-4xl font-bold mt-2">We are Proud to Share with You</h1>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="transition duration-300 hover:scale-110">
                    <i class="fas fa-users text-4xl text-pink-500 mb-2"></i>
                    <h3 class="text-xl md:text-2xl font-bold">36,076</h3>
                    <p class="text-gray-400">Students Enrolled</p>
                </div>
                <div class="transition duration-300 hover:scale-110">
                    <i class="fas fa-building text-4xl text-green-500 mb-2"></i>
                    <h3 class="text-xl md:text-2xl font-bold">786</h3>
                    <p class="text-gray-400">Our Branches</p>
                </div>
                <div class="transition duration-300 hover:scale-110">
                    <i class="fas fa-book text-4xl text-red-500 mb-2"></i>
                    <h3 class="text-xl md:text-2xl font-bold">3,630</h3>
                    <p class="text-gray-400">Total Courses</p>
                </div>
                <div class="transition duration-300 hover:scale-110">
                    <i class="fas fa-award text-4xl text-blue-500 mb-2"></i>
                    <h3 class="text-xl md:text-2xl font-bold">6,300</h3>
                    <p class="text-gray-400">Awards Won</p>
                </div>
            </div>
        </div>
    </section>
 <!------------------------------------ Director Message Review------------------------ -->
<section class="bg-black text-white px-6 md:px-20 lg:px-40 py-12 md:py-20 relative overflow-hidden">

  <!-- Message Wrapper 1: Director -->
  <div class="message-slide">
    <div class="flex flex-col md:flex-row items-center md:items-start md:gap-x-12 py-10">
      <!-- Director Picture Left -->
      <div class="w-48 h-48 md:w-56 md:h-56 flex-shrink-0 text-center">
        <img
          src="assets/Director.jpeg"
          alt="Director"
          class="w-full h-full object-cover rounded-full border-4 border-gray-300"
        />
        <div class="mt-3">
          <h3 class="text-xl md:text-2xl font-bold text-sky-300">KAUSHLENDRA SINGH</h3>
          <p class="text-base text-gray-400">Director</p>
        </div>
      </div>

      <!-- Director Message Right -->
      <div class="principal_message md:mt-0 md:flex-1 md:ml-8">
        <div class="bg-gray-800 shadow-lg rounded-2xl p-8 md:p-10 border border-gray-200 text-lg">
          <h2 class="text-sky-400 text-2xl font-semibold mb-4">Message from the Director</h2>
          <p class="leading-relaxed mb-4">
            "Education is not just about textbooks and exams; it is about shaping responsible, compassionate, and confident individuals who are ready to face the world with courage and kindness."
          
        </div>
      </div>
    </div>
  </div>

  <!-- Message Wrapper 2: Principal (Initially Hidden) -->
  <div class="message-slide hidden">
    <div class="flex flex-col md:flex-row items-center md:items-start md:gap-x-12 py-10">
      <!-- Principal Message Left -->
      <div class="principal_message md:flex-1 order-2 md:order-1 md:mt-0 md:mr-8">
        <div class="bg-gray-800 shadow-lg rounded-2xl p-8 md:p-10 border border-gray-200 text-lg">
          <h2 class="text-sky-400 text-2xl font-semibold mb-4">Message from the Principal</h2>
          <p class="leading-relaxed mb-4">
           "Education is the key that unlocks the door to endless possibilities. Our mission is to ignite curiosity, foster creativity, and empower every student to become a confident thinker and a lifelong learner who can make a positive impact."
          </p>
          
        </div>
      </div>

      <!-- Principal Picture Right -->
      <div class="w-48 h-48 md:w-56 md:h-56 flex-shrink-0 order-1 md:order-2 text-center">
        <img
          src="assets/Principle.jpeg"
          alt="Principle"
          class="w-full h-full object-cover rounded-full border-4 border-gray-300"
        />
        <div class="mt-3">
          <h3 class="text-xl md:text-2xl font-bold text-sky-300">CHITRANKA CHAUHAN</h3>
          <p class="text-base text-gray-400">Principal</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Arrow Buttons -->
  <button id="prevMessage"
    class="absolute top-1/2 left-2 transform -translate-y-1/2 text-sky-400 bg-sky-400 bg-opacity-10 hover:bg-opacity-30 rounded-full p-2 text-2xl transition">
    ←
  </button>
  <button id="nextMessage"
    class="absolute top-1/2 right-2 transform -translate-y-1/2 text-sky-400 bg-sky-400 bg-opacity-10 hover:bg-opacity-30 rounded-full p-2 text-2xl transition">
    →
  </button>



</section>

  <script>    // Director Message Slider
    (function() {
        const slides = document.querySelectorAll(".message-slide");
        const prevMessageBtn = document.getElementById("prevMessage");
        const nextMessageBtn = document.getElementById("nextMessage");

        let messageIndex = 0;
        let slideInterval;
        let delayTimeout;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle("hidden", i !== index);
            });
        }

        function startAutoSlide(interval = 2000) {
            clearInterval(slideInterval);
            slideInterval = setInterval(() => {
                messageIndex = (messageIndex + 1) % slides.length;
                showSlide(messageIndex);
            }, interval);
        }

        function resetWithDelay() {
            clearInterval(slideInterval);
            clearTimeout(delayTimeout);
            delayTimeout = setTimeout(() => {
                startAutoSlide(2000); // Resume auto-slide after 10s
            }, 10000);
        }

        if (prevMessageBtn && nextMessageBtn) {
            prevMessageBtn.addEventListener("click", () => {
                messageIndex = (messageIndex - 1 + slides.length) % slides.length;
                showSlide(messageIndex);
                resetWithDelay();
            });

            nextMessageBtn.addEventListener("click", () => {
                messageIndex = (messageIndex + 1) % slides.length;
                showSlide(messageIndex);
                resetWithDelay();
            });
        }

        if (slides.length > 0) {
            showSlide(messageIndex);
            startAutoSlide();
        }
    })();
</script>


    <!------------------------------------ Section parents Review------------------------ -->
  <section class="bg-blue-500 flex items-center justify-center h-[300px] relative overflow-hidden">
  <!-- Background Image -->
  <img alt="Background image of children and a teacher in a classroom"
    class="absolute inset-0 w-full h-full object-cover opacity-50 animate-fadeIn"
    src="./assets/sec5_bg.jpg" />

  <!-- Arrow Buttons Outside -->
  <button id="prevBtn"
    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 text-blue-500 rounded-full p-3 shadow-lg z-10">
    &#8592;
  </button>

  <button id="nextBtn"
    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 text-blue-500 rounded-full p-3 shadow-lg z-10">
    &#8594;
  </button>

  <!-- Broader Testimonials Container -->
  <div class="relative w-full max-w-3xl text-center text-white px-4">
    <div id="testimonial-wrapper" class="relative">
      <!-- Testimonial 1 -->
      <div class="testimonial relative p-6 bg-blue-500 bg-opacity-75 rounded-lg shadow-lg transition duration-300" data-index="0">
        <img src="./assets/sec5_person_logo.jpg" alt="Portrait of Petey Cru" class="w-20 h-20 rounded-full mx-auto mb-4 shadow-md" />
        <p class="text-lg italic mb-4 drop-shadow-md">
          "We couldn't be happier with the growth we've seen in our child since joining this school. The teachers are not only qualified but genuinely care about every child. The focus on both academics and values is commendable."
        </p>
        <p class="font-bold text-xl drop-shadow-lg">- VED SHARMA </p>
      </div>

      <!-- Testimonial 2 -->
      <div class="testimonial hidden relative p-6 bg-blue-500 bg-opacity-75 rounded-lg shadow-lg transition duration-300" data-index="1">
        <img src="./assets/sec5_person_logo.jpg" alt="Portrait of Petey Cru" class="w-20 h-20 rounded-full mx-auto mb-4 shadow-md" />
        <p class="text-lg italic mb-4 drop-shadow-md">
          "My daughter looks forward to school every day! The environment is warm and nurturing, and the activities are well thought out. We've noticed huge improvements in her confidence and communication."
        </p>
        <p class="font-bold text-xl drop-shadow-lg">- SHALINI SINGH</p>
      </div>

      <!-- Testimonial 3 -->
      <div class="testimonial hidden relative p-6 bg-blue-500 bg-opacity-75 rounded-lg shadow-lg transition duration-300" data-index="2">
        <img src="./assets/sec5_person_logo.jpg" alt="Portrait of Petey Cru" class="w-20 h-20 rounded-full mx-auto mb-4 shadow-md" />
        <p class="text-lg italic mb-4 drop-shadow-md">
          "As new parents to the school, we were nervous about the transition. But the staff made us feel welcomed from day one. Clear communication, organized events, and personalized attention really make a difference"
        </p>
        <p class="font-bold text-xl drop-shadow-lg">- SATYAM PANDEY</p>
      </div>
    </div>
  </div>
</section>
   <!-- user form -->
<!-- ===================== Admission Enquiry Form ===================== -->
<section class="bg-gray-900 text-white px-6 md:px-20 lg:px-40 py-16">
  <div class="container mx-auto">

    <!-- Heading -->
    <div class="text-center mb-10">
      <p class="text-green-400 uppercase tracking-widest text-sm">
        Admission Enquiry
      </p>
      <h2 class="text-2xl md:text-3xl font-bold mt-2">
        We’d Love to Hear From You
      </h2>
      <p class="text-gray-400 mt-3 max-w-2xl mx-auto">
        Fill in the details below and our team will contact you shortly regarding admissions.
      </p>
    </div>

    <!-- Form Wrapper -->
    <div class="max-w-4xl mx-auto bg-gray-800 rounded-2xl shadow-lg p-8 md:p-10
         transition-all duration-300 ease-out
         hover:-translate-y-2 hover:shadow-2xl
         focus-within:-translate-y-2 focus-within:shadow-2xl
         focus-within:ring-2 focus-within:ring-yellow-500/40">
      <form method="post" action="admin/submit-form.php" class="space-y-6">

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Name -->
          <div>
            <label class="block text-sm font-semibold mb-2 text-green-400">
              Full Name
            </label>
            <div class="relative group">
              <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-green-400 group-focus-within:text-yellow-500 transition"></i>
              <input
                type="text"
                name="name"
                required
                placeholder="Enter your name"
                class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white
                       focus:outline-none focus:ring-2 focus:ring-yellow-500"
              />
            </div>
          </div>

          <!-- Phone -->
          <div>
            <label class="block text-sm font-semibold mb-2 text-green-400">
              Phone Number
            </label>
            <div class="relative group">
              <i class="fas fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-green-400 group-focus-within:text-yellow-500 transition"></i>
              <input
                type="text"
                name="phone"
                required
                placeholder="Enter phone number"
                class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white
                       focus:outline-none focus:ring-2 focus:ring-yellow-500"
              />
            </div>
          </div>

        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm font-semibold mb-2 text-green-400">
            Email Address
          </label>
          <div class="relative group">
            <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-green-400 group-focus-within:text-yellow-500 transition"></i>
            <input
              type="email"
              name="email"
              required
              placeholder="Enter your email"
              class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white
                     focus:outline-none focus:ring-2 focus:ring-yellow-500"
            />
          </div>
        </div>

        <!-- Message -->
        <div>
          <label class="block text-sm font-semibold mb-2 text-green-400">
            Message
          </label>
          <textarea
            name="message"
            rows="4"
            placeholder="Write your message here..."
            class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white
                   focus:outline-none focus:ring-2 focus:ring-yellow-500"
          ></textarea>
        </div>

        <!-- Button -->
        <div class="text-center pt-4">
          <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 bg-yellow-500 text-gray-900 font-semibold
                   px-10 py-3 rounded-full hover:bg-yellow-600 transition duration-300 shadow-lg hover:scale-105"
          >
            <i class="fas fa-paper-plane"></i>
            Submit Enquiry
          </button>
        </div>

      </form>
    </div>

  </div>
</section>
<!-- ===================== End Form ===================== -->

<script>
  $(document).ready(function () {
    const testimonialsAuto = $('.testimonial');
    let currentTestimonialIndex = 0;
    let autoSlideInterval;

    function showTestimonialAuto(index) {
      testimonialsAuto.addClass('hidden');
      testimonialsAuto.eq(index).removeClass('hidden');
    }

    function nextTestimonialAuto() {
      currentTestimonialIndex = (currentTestimonialIndex + 1) % testimonialsAuto.length;
      showTestimonialAuto(currentTestimonialIndex);
    }

    function prevTestimonialAuto() {
      currentTestimonialIndex = (currentTestimonialIndex - 1 + testimonialsAuto.length) % testimonialsAuto.length;
      showTestimonialAuto(currentTestimonialIndex);
    }

    $('#nextBtn').click(function () {
      nextTestimonialAuto();
      resetAutoPlayTimer();
    });

    $('#prevBtn').click(function () {
      prevTestimonialAuto();
      resetAutoPlayTimer();
    });

    function startAutoPlayTestimonials() {
      autoSlideInterval = setInterval(nextTestimonialAuto, 5000); // change every 5 seconds
    }

    function resetAutoPlayTimer() {
      clearInterval(autoSlideInterval);
      startAutoPlayTestimonials();
    }

    // Initialize
    showTestimonialAuto(currentTestimonialIndex);
    startAutoPlayTestimonials();
  });
</script>


    <!------------------------------------ Section 6------------------------ -->

    <section class="bg-gray-900 text-white px-6 md:px-20 lg:px-40 py-0">
        <div class="container mx-auto py-12">

            <div class="text-center mb-12">
                <p class="text-green-400 uppercase tracking-widest">OUR NEWS</p>
                <h1 class="text-2xl md:text-4xl font-bold mt-2">Latest Blog Posts</h1>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Blog Post 1 -->
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105">
                    <img alt="Children in a classroom participating in educational activities" class="w-full h-48 object-cover" src="./assets/sec6_blog1_main.jpg"/>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Education Programs...</h3>
                        <p class="text-gray-400 mb-4">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...</p>
                        <div class="flex items-center">
                            <img alt="Profile picture of Betsy Cruz" class="w-8 h-8 rounded-full mr-2" src="./assets/sec6_blog1_logo.jpg"/>
                            <div class="text-sm">
                                <p class="text-gray-400">Betsy Cruz</p>
                                <p class="text-gray-500"><i class="fas fa-calendar-alt"></i> Jan 08, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Post 2 -->
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105">
                    <img alt="Child playing with toys on a green mat" class="w-full h-48 object-cover" src="./assets/sec6_blog2_main.jpg"/>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Games Programs...</h3>
                        <p class="text-gray-400 mb-4">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...</p>
                        <div class="flex items-center">
                            <img alt="Profile picture of Melvin Joe" class="w-8 h-8 rounded-full mr-2" src="./assets/sec6_blog2_logo.jpg"/>
                            <div class="text-sm">
                                <p class="text-gray-400">Melvin Joe</p>
                                <p class="text-gray-500"><i class="fas fa-calendar-alt"></i> Jan 20, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Post 3 -->
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105">
                    <img alt="Two children holding alphabet letters" class="w-full h-48 object-cover" src="./assets/sec6_blog3_main.jpg"/>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Articles Programs...</h3>
                        <p class="text-gray-400 mb-4">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...</p>
                        <div class="flex items-center">
                            <img alt="Profile picture of Tunnie Leo" class="w-8 h-8 rounded-full mr-2" src="./assets/sec6_blog3_logo.jpg"/>
                            <div class="text-sm">
                                <p class="text-gray-400">Tunnie Leo</p>
                                <p class="text-gray-500"><i class="fas fa-calendar-alt"></i> Feb 12, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <button class="bg-yellow-500 text-gray-900 font-semibold py-2 px-6 rounded-full hover:bg-yellow-600 transition duration-300">Read More Blogs</button>
            </div>
        </div>
    </section>
    
    <!------------------------------------ Section 7------------------------ -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 md:px-20 lg:px-40 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center p-4 md:p-6 bg-opacity-90 rounded-lg shadow-lg">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <h1 class="text-lg md:text-xl font-bold">CALL TO ENROLL YOUR CHILD</h1>
                <p class="text-sm text-gray-200">Begin the change today!</p>
            </div>
            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-6">
                <div class="flex items-center space-x-2 text-lg">
                    <i class="fas fa-phone-alt"></i>
                    <span class="font-semibold tracking-wide">+91 9720476913</span>
                </div>
                <a href="tel:+91 9720476913" class="bg-black text-white font-semibold py-2 px-5 rounded-full hover:bg-gray-800 transition duration-300">
                    Call Now
                </a>
            </div>
        </div>
    </section>

    <!------------------------------------ Footer------------------------ -->
    <footer class="bg-gray-900 text-white px-6 md:px-20 lg:px-40 py-8">
        <section class="py-10">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Contact Info -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Contact Info</h2>
                        <p>Shaheed R.N.S Education Academy, Jirauli, Bichhwan, Mainpuri</p>
                        <p>Uttar Pradesh - 205267</p>
                        <p>📞 +91 9720476913</p>
                        <p>📧 shaheedrns31@gmail.com</p>
                    </div>
                    <!-- Quick Links -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Quick Links</h2>
                        <ul>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">About Us</a></li>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">Courses</a></li>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">Become a Teacher</a></li>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">Contact Us</a></li>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">Career</a></li>
                        </ul>
                    </div>
                    <!-- Explore -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Explore</h2>
                        <ul>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">Blog Posts</a></li>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">Privacy Policy</a></li>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">Contact Us</a></li>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">License & Uses</a></li>
                            <li class="mb-2"><a href="#" class="hover:text-blue-400 transition">Tutorials</a></li>
                        </ul>
                    </div>
                    <!-- Subscribe -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Subscribe</h2>
                        <form class="flex">
                            <input type="email" placeholder="Email Address" class="w-full px-4 py-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-900">
                            <button type="submit" class="bg-blue-500 px-4 py-2 rounded-r-md hover:bg-blue-600 transition">
                                <i class="fas fa-paper-plane text-white"></i>
                            </button>
                        </form>
                        <!-- <p class="mt-4 text-gray-400">Subscribe for the latest updates directly in your inbox.</p> -->
                    </div>
                </div>
                <!-- Footer Bottom -->
                <div class="text-center mt-10 border-t border-gray-700 pt-6">
                    <p class="text-gray-400">© 2025 Shaheed RNS Education Academy. All rights reserved. Designed by <a href="https://www.nextechis.in/" target="_blank" class="text-blue-500 hover:underline">Nextechis Software Solutions</a></p>
                </div>
            </div>
        </section>
    </footer>
    
    <script>
        document.getElementById('menuBtn').addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>

</body>

</html>
