@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
                    <span></span> Blog
                    <span></span> {{ $blog->title }}
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container custom">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="single-page pl-30">
                            <div class="single-header style-2">
                                <h1 class="mb-30">{{ $blog->title }}</h1>
                                <div class="single-header-meta">
                                    <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                                        <span class="post-on has-dot">{{ $blog->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="social-icons single-share">
                                        <ul class="text-grey-5 d-inline-block">
                                            <li><strong class="mr-10">Share this:</strong></li>
                                            <li class="social-facebook"><a
                                                    href="https://www.facebook.com/VisionPlusOpticianPK"
                                                    target="_blank"><img
                                                        src="../frontend/assets/imgs/theme/icons/icon-facebook.svg"
                                                        alt="facebook image" loading="lazy"></a></li>
                                            <li class="social-instagram"><a
                                                    href="https://www.instagram.com/visionplusopticianspk/"
                                                    target="_blank"><img
                                                        src="../frontend/assets/imgs/theme/icons/icon-instagram.svg"
                                                        alt="instagram image" loading="lazy"></a></li>
                                            <li class="social-yotube"><a href="https://www.youtube.com/@VisionPlusOptician"
                                                    target="_blank"><img
                                                        src="../frontend/assets/imgs/theme/icons/icon-youtube.svg"
                                                        alt="youtube image" loading="lazy"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <figure class="single-thumbnail">
                                <img src="{{ asset('uploads/blogs/' . $blog->image) }}" alt="blog thumnail "  loading="lazy" decoding="async">
                            </figure>
                            <div class="single-content">
                                {!! $blog->content !!}
                            </div>
                            <div class="entry-bottom mt-50 mb-30 wow fadeIn  animated"
                                style="visibility: visible; animation-name: fadeIn;">
                                <div class="social-icons single-share">
                                    <ul class="text-grey-5 d-inline-block">
                                        <li><strong class="mr-10">Share this:</strong></li>
                                        <li class="social-facebook"><a href="https://www.facebook.com/VisionPlusOpticianPK"
                                                target="_blank"><img
                                                    src="../frontend/assets/imgs/theme/icons/icon-facebook.svg" alt="facebook icon" loading="lazy" ></a>
                                        </li>
                                        <li class="social-instagram"><a
                                                href="https://www.instagram.com/visionplusopticianspk/" target="_blank"><img
                                                    src="../frontend/assets/imgs/theme/icons/icon-instagram.svg" alt="instagram icons" loading="lazy"></a>
                                        </li>
                                        <li class="social-yotube"><a href="https://www.youtube.com/@VisionPlusOptician"
                                                target="_blank"><img
                                                    src="../frontend/assets/imgs/theme/icons/icon-youtube.svg" alt="youtube icon" loading="lazy"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection