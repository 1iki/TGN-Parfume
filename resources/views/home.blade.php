@extends('layouts.app')

@section('title', 'TGN Premium Parfume')

@section('content')
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center section-bg">
    <div class="container">
      <div class="row justify-content-between gy-5">
        <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
          <h2 data-aos="fade-up">Enjoy Your Fragrance<br>All Day</h2>
          <p data-aos="fade-up" data-aos-delay="100">Take a chance for satisfying results. every activity you do has a great influence on encouragement, such as using TGN perfume which will start every occasion with a very extraordinary</p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="#menu" class="btn-book-a-table">Order Now</a>
            <a href="https://www.youtube.com/embed/xfxe0wd4Q7Y?si=DoW3RZ3Yk2YdQYxQ" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
          </div>
        </div>
        <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
          <img src="{{ asset('assets/img/parfum.png') }}" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>
    </div>
  </section>
  <!-- End Hero Section -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>About Us</h2>
          <p>Learn More <span>About Us</span></p>
        </div>

        <div class="row gy-4">
          <div class="col-lg-7 position-relative about-img" style="background-image: url({{ asset('assets/img/about.jpg') }});" data-aos="fade-up" data-aos-delay="150">
            <div class="call-us position-absolute">
              <h4>Order Now</h4>
              <p>+62 8222999 1239</p>
            </div>
          </div>
          <div class="col-lg-5 d-flex align-items-end" data-aos="fade-up" data-aos-delay="300">
            <div class="content ps-0 ps-lg-5">
              <p class="fst-italic">
              TGN Parfume is a fragrant liquid typically made from essential oils extracted from flowers, spices, fruits, and other aromatic substances. It is mixed with a solvent, such as alcohol or water, to create a pleasant and long-lasting scent.
              </p>
              <ul>
                <li><i class="bi bi-check2-all"></i> The initial scents perceived immediately after applying the perfume. They are usually light and evaporate quickly. Examples include citrus, floral, and fruity notes.</li>
                <li><i class="bi bi-check2-all"></i> These scents emerge just before the top notes dissipate. They are often more rounded and contribute to the perfume's full body. Examples include floral, spicy, and herbal notes.</li>
                <li><i class="bi bi-check2-all"></i> The final and longest-lasting scents that appear once the perfume has dried. They provide depth and stability to the overall fragrance. Examples include woody, musky, and oriental notes.</li>
              </ul>
              <p>
              TGN Parfume are classified based on their concentration of aromatic compounds, which influences their strength and longevity.
              </p>

              <div class="position-relative mt-4">
                <img src="{{ asset('assets/img/about-1.jpg') }}" class="img-fluid" alt="">
                <a href="https://www.youtube.com/embed/xfxe0wd4Q7Y?si=DoW3RZ3Yk2YdQYxQ" class="glightbox play-btn"></a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us section-bg">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="why-box">
              <h3>Why Choose TGN ?</h3>
              <p>
              Choosing to wear perfume can be a personal preference, and people may have various reasons for using it. Here are some common reasons why individuals choose to wear perfume:
              </p>
            </div>
          </div><!-- End Why Box -->

          <div class="col-lg-8 d-flex align-items-center">
            <div class="row gy-4">

              <div class="col-xl-4" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-clipboard-data"></i>
                  <h4>Enhancing Personal Fragrance</h4>
                  <p>Cone of the primary reasons for wearing perfume is to enhance one's personal fragrance. Perfume can add a pleasant and appealing scent to an individual's natural body odor.</p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-gem"></i>
                  <h4>Boosting Confidence</h4>
                  <p>Wearing a fragrance that one enjoys can boost confidence and create a positive self-image. Feeling good about how one smells can contribute to overall self-esteem.</p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-inboxes"></i>
                  <h4>Expressing Individuality</h4>
                  <p>Perfume is a form of self-expression, and the choice of fragrance can convey aspects of an individual's personality, style, and preferences. It becomes a part of someone's personal identity.</p>
                </div>
              </div><!-- End Icon Box -->

            </div>
          </div>

        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= Menu Section ======= -->
    <section id="menu" class="menu">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Our Menu</h2>
          <p>Check Our <span>TGN Parfum Menu</span></p>
        </div>

        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">

          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#menu-male">
              <h4>Male</h4>
            </a>
          </li><!-- End tab nav item -->

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-female">
              <h4>Female</h4>
            </a>
          </li><!-- End tab nav item -->

        </ul>

        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">

          <div class="tab-pane fade active show" id="menu-male">
            <div class="tab-header text-center">
              <p>Menu</p>
              <h3>Male</h3>
            </div>

            <div class="row gy-5">
              @forelse($maleProducts as $fetch_product)
                <div class="col-lg-4 menu-item">
                  <a href="{{ url('/product.php?pid=' . ($fetch_product->_id ?? $fetch_product->legacy_id)) }}"><img src="{{ asset('uploaded_img/' . trim($fetch_product->image)) }}" class="menu-img img-fluid" alt=""></a>
                  <h4>{{ $fetch_product->name }}</h4>
                  <p class="ingredients">{{ $fetch_product->ingredient }}</p>
                  <p class="price">Rp {{ number_format($fetch_product->price, 0, ',', '.') }}</p>
                </div><!-- Menu Item -->
              @empty
                <p class="text-center">No data found</p>
              @endforelse
            </div>
          </div><!-- End Male Menu Content -->

          <div class="tab-pane fade" id="menu-female">
            <div class="tab-header text-center">
              <p>Menu</p>
              <h3>Female</h3>
            </div>

            <div class="row gy-5">
              @forelse($femaleProducts as $fetch_product)
                <div class="col-lg-4 menu-item">
                  <a href="{{ url('/product.php?pid=' . ($fetch_product->_id ?? $fetch_product->legacy_id)) }}"><img src="{{ asset('uploaded_img/' . trim($fetch_product->image)) }}" class="menu-img img-fluid" alt=""></a>
                  <h4>{{ $fetch_product->name }}</h4>
                  <p class="ingredients">{{ $fetch_product->ingredient }}</p>
                  <p class="price">Rp {{ number_format($fetch_product->price, 0, ',', '.') }}</p>
                </div><!-- Menu Item -->
              @empty
                <p class="text-center">No data found</p>
              @endforelse
            </div>
          </div><!-- End Female Menu Content -->

        </div>

      </div>
    </section><!-- End Menu Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Testimonials</h2>
          <p>What Are They <span>Saying About Us</span></p>
        </div>

        <div class="slides-1 swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row gy-4 justify-content-center">
                  <div class="col-lg-6">
                    <div class="testimonial-content">
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        This TGN perfume has incredible longevity! The scent remains noticeable all day without the need for reapplication.
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                      <h3>Prilly Latuconsina</h3>
                      <h4>Artis</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2 text-center">
                    <img src="{{ asset('assets/img/testimonials/testimonials-prilly.jpg') }}" class="img-fluid testimonial-img" alt="">
                  </div>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row gy-4 justify-content-center">
                  <div class="col-lg-6">
                    <div class="testimonial-content">
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        I wore this perfume on my wedding day, and every time I catch a whiff of its scent, it brings back beautiful memories.
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                      <h3>Gading Martin</h3>
                      <h4>Aktor &amp; Artis</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2 text-center">
                    <img src="{{ asset('assets/img/testimonials/testimonials-gading.jpg') }}" class="img-fluid testimonial-img" alt="">
                  </div>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row gy-4 justify-content-center">
                  <div class="col-lg-6">
                    <div class="testimonial-content">
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        My favorite celebrity always wears this perfume, so I decided to give it a try. Turns out, I love it!
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                      <h3>Boy Wiliam</h3>
                      <h4>Youtuber</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2 text-center">
                    <img src="{{ asset('assets/img/testimonials/testimonials-boy.jpg') }}" class="img-fluid testimonial-img" alt="">
                  </div>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row gy-4 justify-content-center">
                  <div class="col-lg-6">
                    <div class="testimonial-content">
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        The scent of TGN perfume is truly captivating, providing an extraordinary experience. I love how the fragrance is light yet long-lasting. A great choice!
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                      <h3>Rafi Ahmad</h3>
                      <h4>Artis &amp; Youtuber</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2 text-center">
                    <img src="{{ asset('assets/img/testimonials/testimonials-rafi.jpg') }}" class="img-fluid testimonial-img" alt="">
                  </div>
                </div>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Events Section ======= -->
    <section id="new" class="events">
      <div class="container-fluid" data-aos="fade-up">

        <div class="section-header">
          <h2 style="color: #333;">Exclusive Perfume Collection</h2>
          <p style="color: #666;">Discover <span>Your Signature Scent</span></p>
        </div>

        <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url({{ asset('assets/img/parfume-iklan.png') }})">
              <h3>Elegant Fragrance</h3>
              <div class="price align-self-start">
                <a href="#menu" style="color: white;">Special Offer</a>
              </div>
              <p class="description">
              Indulge in the captivating aroma of our elegant fragrance. Perfect for any occasion.
              </p>
            </div><!-- End Event item -->

            <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url({{ asset('assets/img/parfume-iklan1.png') }})">
              <h3>Luxurious Blend</h3>
              <div class="price align-self-start">
                <a href="#menu" style="color: white;">Exclusive Deal</a>
              </div>
              <p class="description">
              Immerse yourself in the luxurious blend of our signature perfume. Unleash your senses.
              </p>
            </div><!-- End Event item -->

            <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url({{ asset('assets/img/parfume-iklan2.png') }})">
              <h3>Celebrate Essence</h3>
              <div class="price align-self-start">
                <a href="#menu" style="color: white;">Limited Stock</a>
              </div>
              <p class="description">
              Celebrate your essence with our exclusive perfume. A scent that defines you.
              </p>
            </div><!-- End Event item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Events Section -->

    <!-- ======= Staff Section ======= -->
    <section id="staff" class="chefs section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Our</h2>
          <p><span>Professional</span> Staff</p>
        </div>

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="chef-member">
              <div class="member-img">
                <img src="{{ asset('assets/img/staff/putra-ai.jpg') }}" class="img-fluid" alt="">
                <div class="social">
                  <a href="#"><i class="bi bi-twitter"></i></a>
                  <a href="#"><i class="bi bi-facebook"></i></a>
                  <a href="#"><i class="bi bi-instagram"></i></a>
                  <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Putra Ardiansyah</h4>
                <span>STAFF PARFUM</span>
                <p>Passionate about crafting exquisite fragrances, Putra is our master perfumer with a keen sense of olfactory artistry. His expertise in blending unique scents ensures a delightful and memorable experience for every fragrance enthusiast.</p>
              </div>
            </div>
          </div><!-- End Staff Member -->

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="chef-member">
              <div class="member-img">
                <img src="{{ asset('assets/img/staff/fachri-ai.jpg') }}" class="img-fluid" alt="">
                <div class="social">
                  <a href="#"><i class="bi bi-twitter"></i></a>
                  <a href="#"><i class="bi bi-facebook"></i></a>
                  <a href="#"><i class="bi bi-instagram"></i></a>
                  <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Fachri Aditya Rizky</h4>
                <span>STAFF PARFUM</span>
                <p>our talented Perfume Telu Gusti Noir His olfactory creations weave stories that transport you to realms of elegance and allure. Immerse yourself in the symphony of scents meticulously crafted by this aromatic virtuoso.</p>
              </div>
            </div>
          </div><!-- End Staff Member -->

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="chef-member">
              <div class="member-img">
                <img src="{{ asset('assets/img/staff/krisna-ai.jpg') }}" class="img-fluid" alt="">
                <div class="social">
                  <a href="https://github.com/1iki"><i class="bi bi-twitter"></i></a>
                  <a href="https://github.com/1iki"><i class="bi bi-facebook"></i></a>
                  <a href="https://www.instagram.com/fachri.aer"><i class="bi bi-instagram"></i></a>
                  <a href="https://www.linkedin.com/in/fachriadityar/"><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Krisna Aprian Putra Wirawan</h4>
                <span>STAFF PARFUM</span>
                <p>Krisna our dedicated Perfume Specialist. With a refined sense of scent and a passion for helping customers find their signature fragrance, Krisna ensures a personalized and delightful experience for every visitor. Her expertise in the world of perfumery makes him an invaluable member of our team.</p>
              </div>
            </div>
          </div><!-- End Staff Member -->

        </div>

      </div>
    </section><!-- End Staff Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>gallery</h2>
          <p>Check <span>Our Gallery</span></p>
        </div>

        <div class="gallery-slider swiper">
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="{{ asset('assets/img/gallery/galery-parfum.png') }}"><img src="{{ asset('assets/img/gallery/galery-parfum.png') }}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="{{ asset('assets/img/gallery/galery-parfum1.png') }}"><img src="{{ asset('assets/img/gallery/galery-parfum1.png') }}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="{{ asset('assets/img/gallery/galery-parfum2.png') }}"><img src="{{ asset('assets/img/gallery/galery-parfum2.png') }}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="{{ asset('assets/img/gallery/galery-parfum3.png') }}"><img src="{{ asset('assets/img/gallery/galery-parfum3.png') }}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="{{ asset('assets/img/gallery/galery-parfum4.png') }}"><img src="{{ asset('assets/img/gallery/galery-parfum4.png') }}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="{{ asset('assets/img/gallery/galery-parfum5.png') }}"><img src="{{ asset('assets/img/gallery/galery-parfum5.png') }}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="{{ asset('assets/img/gallery/galery-parfum6.jpg') }}"><img src="{{ asset('assets/img/gallery/galery-parfum6.jpg') }}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="{{ asset('assets/img/gallery/galery-parfum7.png') }}"><img src="{{ asset('assets/img/gallery/galery-parfum7.png') }}" class="img-fluid" alt=""></a></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Gallery Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Contact</h2>
          <p>Need Help? <span>Contact Us</span></p>
        </div>

        <div class="row gy-4">

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center">
              <i class="icon bi bi-map flex-shrink-0"></i>
              <div>
                <h3>Our Address</h3>
                <p><a href="https://fachri-aer.vercel.app/">Jalan Warung Jati Barat No.98. RT.1/RW.7. Pejaten Barat. Daerah Khusus Ibukota Jakarta 12510. Indonesia.</a></p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center">
              <i class="icon bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>telugustinoir@gmail.com</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center">
              <i class="icon bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+62 822 9991 1239</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center">
              <i class="icon bi bi-share flex-shrink-0"></i>
              <div>
                <h3>Opening Hours</h3>
                <div><strong>Monday-Friday:</strong> 9AM - 5PM; </div>
                <div><strong>Saturday-Sunday:</strong> Closed</div>
              </div>
            </div>
          </div><!-- End Info Item -->

        </div>

        <form action="{{ route('contact.store') }}" method="post" class="p-3 p-md-4 mt-4">
          @csrf
          <div class="row">
            <div class="col-md-6 form-group mb-3">
              <label for="name">Name</label>
              <input id="name" type="text" name="name" class="form-control" placeholder="Your Name" required />
            </div>
            <div class="col-md-6 form-group mb-3">
              <label for="email">Email</label>
              <input id="email" type="email" name="email" class="form-control" placeholder="Your Email" required />
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="number">Phone Number</label>
            <input id="number" type="text" name="number" class="form-control" placeholder="Your Phone Number" required />
          </div>
          <div class="form-group mb-3">
            <label for="message">Message</label>
            <textarea id="message" class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
          </div>
          <div class="text-center">
            <button class="btn btn-danger px-4 py-2" type="submit">Send Message</button>
          </div>
        </form>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection

