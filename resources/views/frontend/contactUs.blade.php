@extends('frontend.layouts.app')

@section('content')
    <main class="main">

        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
                    <span></span> Pages <span></span> Contact us
                </div>
            </div>
        </div>
        <section class="hero-2 bg-green">
            <div class="hero-content">
                <div class="container">
                    <div class="text-center">
                        <h4 class="text-brand mb-20">Multiple locations in Lahore</h4>
                        <h1 class="mb-20 wow fadeIn animated font-xxl fw-900">
                            We're Easy to Find<br><span class="text-style-1">Visit Today</span>
                        </h1>
                        <p class="w-50 m-auto mb-50 wow fadeIn animated">Visit our store for premium eyewear and get expert
                            guidance — your vision is our priority.</p>
                        <p class="wow fadeIn animated">
                            <a class="btn btn-brand btn-lg font-weight-bold text-white border-radius-5 btn-shadow-brand hover-up"
                                href="{{route('frontend.aboutUs')}}">About Us</a>
                            <a class="btn btn-outline btn-lg btn-brand-outline font-weight-bold text-brand bg-white text-hover-white ml-15 border-radius-5 btn-shadow-brand hover-up"
                                href="https://wa.me/923391339339?text=Hi%20Vision%20Plus%20Optical,%20I%20need%20assistance.">Support
                                Center</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-border pt-50 pb-50">
            <div class="container">

                <div class="map-responsive mb-sm-5">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3401.029079969172!2d74.34316767621588!3d31.523361246993158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391904f746e0124f%3A0xfcac2777dd471e32!2sVision%20Plus!5e0!3m2!1sen!2s!4v1745318156973!5m2!1sen!2s"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>


                <div class="row text-center ">
                    <div class="col-md-4 mb-4 mb-md-0 ">
                        <h4 class="mb-15 text-brand fw-900">Gulberg Branch | Head Office</h4>
                        Shop 6,7 sheraz plaza Hali Rd, Gulberg 2<br>
                        Lahore<br>
                        Phone: (042) 35753712<br>
                        Email: visionplus492@gmail.com<br>
                        <a class="btn btn-outline btn-sm btn-brand-outline font-weight-bold text-brand bg-white text-hover-white mt-20 border-radius-5 btn-shadow-brand hover-up "
                            href="https://maps.app.goo.gl/SDFzKEGWEg5LX5QA7" target="_blank"><i
                                class="fi-rs-marker mr-10"></i>View map</a>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0 ">
                        <h4 class="mb-15 text-brand fw-900">Iqbal Town Branch</h4>
                        Javed Centre, Allama Iqbal Rd, Kashmir Block, Allama Iqbal Town<br>
                        Lahore<br>
                        Phone: (042) 37808964<br>
                        Email: visionplus492@gmail.com<br>
                        <a class="btn btn-outline btn-sm btn-brand-outline font-weight-bold text-brand bg-white text-hover-white mt-20 border-radius-5 btn-shadow-brand hover-up"
                            href="https://g.co/kgs/1dJM7h9" target="_blank"><i class="fi-rs-marker mr-10"></i>View map</a>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0 ">
                        <h4 class="mb-15 text-brand fw-900">Township Branch</h4>
                        779D Maulana Shaukat Ali Rd, Sector B-1 Block 1<br>
                        Lahore<br>
                        Phone: 0334 4099993<br>
                        Email: visionplus492@gmail.com<br>
                        <a class="btn btn-outline btn-sm btn-brand-outline font-weight-bold text-brand bg-white text-hover-white mt-20 border-radius-5 btn-shadow-brand hover-up "
                            href=" https://g.co/kgs/ezonTS7" target="_blank"><i class="fi-rs-marker mr-10"></i>View map</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-50 pb-50">
            <div class="container">
                <div class="row">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="col-xl-8 col-lg-10 m-auto">
                        <div class="contact-from-area padding-20-row-col wow FadeInUp">
                            <h3 class="mb-10 text-center">Drop Us a Line</h3>
                            <form class="contact-form-style text-center" id="contact-form"
                                action="{{ route('frontend.contactUs.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="input-style mb-20">
                                            <input name="name" placeholder="First Name" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="input-style mb-20">
                                            <input name="email" placeholder="Your Email" type="email" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="input-style mb-20">
                                            <input name="telephone" placeholder="Your Phone" type="tel" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="input-style mb-20">
                                            <input name="subject" placeholder="Subject" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="textarea-style mb-30">
                                            <textarea name="message" placeholder="Message"></textarea>
                                        </div>
                                        <button class="submit submit-auto-width" type="submit">
                                            Send message
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <p class="form-messege"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection