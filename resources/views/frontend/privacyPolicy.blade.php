@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
                    <span></span> Pages
                    <span></span> Privacy policy
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single-page pr-30">
                            <div class="single-header style-2">
                                <h2>Privacy Policy</h2>
                                <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                                    <span class="post-by">By <a href="#">VisionPlus</a></span>
                                    <!-- <span class="post-on has-dot">9 April 2020</span>
                                        <span class="time-reading has-dot">8 mins read</span>
                                        <span class="hit-count has-dot">69k Views</span> -->
                                </div>
                            </div>
                            <div class="single-content">
                                <h3>Privacy Policy for Vision Plus</h3>

                                <p>At Vision Plus, we are committed to protecting your personal information and your right
                                    to privacy.</p>
                                <p> This Privacy Policy outlines the types of information we may collect from you, how we
                                    use it, and what rights you have in relation to it.</p>
                                <p> Please read this policy carefully to understand our views and practices regarding your
                                    personal data.</p>

                                <h3>1. Information We Collect</h3>
                                <p>We collect both personal and non-personal information when you use our website or
                                    services. This may include:</p>
                                <ul>
                                    <li><strong>Personal Identification Information:</strong> Name, email address, phone
                                        number, postal address, and payment details when you make a purchase.</li>
                                    <li><strong>Prescription Data:</strong> Information you provide when ordering
                                        prescription lenses or using virtual try-on features.</li>
                                    <li><strong>Technical Data:</strong> IP address, browser type, device type, operating
                                        system, referring URLs, and usage data collected via cookies and similar
                                        technologies.</li>
                                    <li><strong>Account Information:</strong> If you register, we collect login credentials
                                        and user preferences.</li>
                                </ul>

                                <h4>2. How We Use Your Information</h4>
                                <p>Your information helps us to:</p>
                                <ul>
                                    <li>Fulfill orders and provide customer service</li>
                                    <li>Process payments securely</li>
                                    <li>Send transactional emails and updates</li>
                                    <li>Improve our products, website, and user experience</li>
                                    <li>Customize content and provide relevant advertisements</li>
                                    <li>Ensure compliance with legal obligations</li>
                                </ul>

                                <h4>3. Sharing and Disclosure of Information</h4>
                                <p>We do not sell or rent your personal data to third parties. However, we may share your
                                    information with trusted third parties under the following conditions:</p>
                                <ul>
                                    <li>Service providers who support our operations (e.g., payment processors, shipping
                                        partners, IT service providers)</li>
                                    <li>Legal authorities if required to comply with a legal obligation or to protect our
                                        rights</li>
                                    <li>In the event of a business transfer, merger, or acquisition</li>
                                </ul>

                                <h4>4. Cookies and Tracking Technologies</h4>
                                <p>We use cookies and similar tracking technologies to enhance your experience on our
                                    website. Cookies help us understand user behavior, personalize content, and improve
                                    functionality.</p>
                                <p>You can manage your cookie preferences through your browser settings. However, disabling
                                    cookies may affect the usability of our website.</p>

                                <h4>5. Data Retention</h4>
                                <p>We retain your personal data only for as long as necessary to fulfill the purposes for
                                    which it was collected, including satisfying legal, accounting, or reporting
                                    requirements.</p>

                                <h4>6. Data Security</h4>
                                <p>We implement appropriate technical and organizational measures to protect your personal
                                    data from unauthorized access, disclosure, alteration, or destruction. However, no
                                    internet transmission is ever completely secure, and we cannot guarantee absolute
                                    security.</p>

                                <h4>7. Your Rights</h4>
                                <p>You have the right to:</p>
                                <ul>
                                    <li>Access, correct, or delete your personal data</li>
                                    <li>Withdraw consent at any time</li>
                                    <li>Object to the processing of your data</li>
                                    <li>Lodge a complaint with a data protection authority</li>
                                </ul>
                                <p>To exercise these rights, please contact us at <a
                                        href="mailto:support@visionplus.com">support@visionplus.com</a></p>

                                <h4>8. Third-Party Links</h4>
                                <p>Our website may contain links to third-party websites.</P>
                                <P> We are not responsible for the privacy practices or the content of these websites.</P>
                                <P> Please review their privacy policies before providing them with any personal
                                    information.</p>

                                <h4>9. Children's Privacy</h4>
                                <p>Our services are not intended for individuals under the age of 13. We do not knowingly
                                    collect personal information from children. If we learn that a child has provided us
                                    with personal data, we will take steps to delete such information promptly.</p>

                                <h4>10. Changes to This Privacy Policy</h4>
                                <p>We may update this Privacy Policy from time to time to reflect changes in our practices,
                                    technologies, legal requirements, or for other reasons. Any updates will be posted on
                                    this page with the effective date noted at the top.</p>

                                <h4>11. Contact Us</h4>
                                <p>If you have any questions about this Privacy Policy or how we handle your data, please
                                    contact us at:</p>
                                <p>
                                    Vision Plus<br>
                                    Email: <a href="mailto:support@visionplus.com">support@visionplus.com</a><br>
                                    Phone: +923228717170<br>
                                    Address: 1 Hali Rd, Block A Gulberg 2, Lahore <br>
                                    Address: 779D Maulana Shaukat Ali Rd, Sector B-1 Block 1 Sector B 1 Lahore, 54600<br>
                                    Address: Javed Centre, Kashmir Block Allama Iqbal Town, Lahore, 54570 </p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
