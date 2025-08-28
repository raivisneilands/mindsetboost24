@extends('layouts.app')

@section('title', 'About Page | Mindset Boost 24')
@section('meta_description', 'Discover the story behind Mindset Boost 24. Learn why we created tools to help you build discipline, focus, and lasting success in life.')

@section('content')

<style>
  html, body {
    margin: 0;
    padding: 0;
    background-color: #6EE7B7; /* emerald-300 fallback */
  }

  section {
    height: 100vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin: 0;
    padding: 0;
  }

  .parallax {
    will-change: background-position;
  }

  .overlay {
    background-color: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(6px);
    padding: 2.5rem;
    border-radius: 1.5rem;
    color: white;
    max-width: 800px;
    margin: auto;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
  }
</style>

{{-- Section 1 --}}
<section
  id="section1"
  class="parallax flex items-center justify-center px-6"
  style="background-image: url('{{ asset('images/mission.jpg') }}');"
>
  <div class="overlay text-center" data-aos="fade-up">
    <h2 class="text-4xl font-bold mb-4">Our Mission</h2>
    <p class="text-lg leading-relaxed">
      We’re building a space where anyone can access digital resources that spark action and drive clarity.
      From habit trackers to growth journals, every product is crafted with care and intention.
    </p>
  </div>
</section>

{{-- Section 2 --}}
<section
  id="section2"
  class="parallax flex items-center justify-center px-6"
  style="background-image: url('{{ asset('images/growth.jpg') }}');"
>
  <div class="overlay text-center" data-aos="fade-up">
    <h2 class="text-4xl font-bold mb-4">Growth With Every File</h2>
    <p class="text-lg leading-relaxed">
      Each product is more than just a file — it's a step forward. Our expanding library evolves with your needs,
      staying focused on helping you build structure, improve mindset, and take ownership of your journey.
    </p>
  </div>
</section>

{{-- Section 3 --}}
<section
  id="section3"
  class="parallax flex items-center justify-center px-6"
  style="background-image: url('{{ asset('images/impact.jpg') }}');"
>
  <div class="overlay text-center" data-aos="fade-up">
    <h2 class="text-4xl font-bold mb-4">Why We Exist</h2>
    <p class="text-lg leading-relaxed">
      We believe digital products should be functional, beautiful, and motivating. This isn’t just about downloads —
      it’s about impact. We’re here to make tools that give you momentum, not noise.
    </p>
  </div>
</section>

<script>
  // Simple parallax effect
  const parallaxSections = document.querySelectorAll('.parallax');

  window.addEventListener('scroll', () => {
    parallaxSections.forEach(section => {
      const speed = 0.12;
      const offset = window.scrollY;
      section.style.backgroundPositionY = `${-offset * speed}px`;
    });
  });
</script>

@endsection
