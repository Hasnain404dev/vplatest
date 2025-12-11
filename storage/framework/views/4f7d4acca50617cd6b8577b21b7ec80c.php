<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="eyeframe-section">
            <div class="eyeframe-details">
                <img id="eyeframeImage" class="eyeframe-image" src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>"
                    alt="Eyeframe" />
                <div class="eyeframe-name"><?php echo e($product->name); ?></div>
                <div class="eyeframe-price">
                    <?php if($product->discountprice): ?>
                        <span>Rs. <?php echo e($product->discountprice); ?></span>
                        <span class="old-price text-decoration-line-through text-muted">Rs. <?php echo e($product->price); ?></span>
                    <?php else: ?>
                        <span>Rs. <?php echo e($product->price); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="pre-section">
            <div class="progress-container" id="progress-container">
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
                <div class="progress-step">
                    <div class="step-number active" id="step-1">1</div>
                    <div class="step-label active">Lens Type</div>
                </div>
                <div class="progress-step">
                    <div class="step-number" id="step-2">2</div>
                    <div class="step-label" id="step-2-label">Prescription</div>
                </div>
                <div class="progress-step">
                    <div class="step-number" id="step-3">3</div>
                    <div class="step-label" id="step-3-label">Lens Features</div>
                </div>
                <div class="progress-step" id="step-4-progress">
                    <div class="step-number" id="step-4">4</div>
                    <div class="step-label">Lens Options</div>
                </div>
                <div class="progress-step" id="step-5-progress">
                    <div class="step-number" id="step-5">5</div>
                    <div class="step-label">Review</div>
                </div>
            </div>
            <div class="step active" id="step1">
                <div class="audio-container">
                    <button class="audio-button" onclick="playAudio('step1')">
                        Play Audio Guidance
                    </button>
                </div>
                <h2>Choose Your Lens Type</h2>
                <div class="cardT-container">
                    <div class="cardT" data-lensType="distance" onclick="selectcardT(this, 'lensType')">
                        <img class="cardT-image" src="../frontend/assets/images/single-vision-distance.jpg"
                            alt="Distance Glasses Icon" />
                        <div class="details">
                            <div class="cardT-title">Single Vision (Distance)</div>
                            <div class="cardT-desc">
                                Single vision distance lenses provide clear, focused vision
                                for seeing objects at a distance.
                            </div>
                        </div>
                    </div>
                    <div class="cardT" data-lensType="reading" onclick="selectcardT(this, 'lensType')">
                        <img class="cardT-image" src="../frontend/assets/images/Reading-1-2.jpg"
                            alt="Reading Glasses Icon" />
                        <div class="details">
                            <div class="cardT-title">Reading</div>
                            <div class="cardT-desc">
                                Reading lenses provide sharp, close-up vision, perfect for
                                reading and other near-distance tasks.
                            </div>
                        </div>
                    </div>
                    <div class="cardT" data-lensType="bifocal" onclick="selectcardT(this, 'lensType')">
                        <img class="cardT-image" src="../frontend/assets/images/Distance-near-01-1.jpg"
                            alt="Bifocal Glasses Icon" />
                        <div class="details">
                            <div class="cardT-title">Bifocal</div>
                            <div class="cardT-desc">
                                Bifocal lenses provide clear vision at both near and far
                                distances, with a distinct separation between the two viewing
                                areas.
                            </div>
                        </div>
                    </div>
                    <div class="cardT" data-lensType="progressive" onclick="selectcardT(this, 'lensType')">
                        <img class="cardT-image" src="../frontend/assets/images/pro-lense.jpg"
                            alt="Progressive Glasses Icon" />
                        <div class="details">
                            <div class="cardT-title">Progressive</div>
                            <div class="cardT-desc">
                                Progressive lenses offer seamless, multi-distance vision
                                correction, allowing clear sight at near, intermediate, and
                                far distances without visible lines.
                            </div>
                        </div>
                    </div>
                    <div class="cardT" data-lensType="non-prescription" onclick="selectcardT(this, 'lensType')">
                        <img class="cardT-image" src="../frontend/assets/images/single-vision-distance.jpg"
                            alt="Non-Prescription Glasses Icon" />
                        <div class="details">
                            <div class="cardT-title">Non-Prescription</div>
                            <div class="cardT-desc">
                                Non-prescription lenses offer clear, protective vision without
                                vision correction, ideal for style or eye protection.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-group">
                    <div></div>
                    <button class="button" onclick="nextStep()">Next</button>
                </div>
            </div>
            <!-- Modified Step 2: Prescription Section with Custom Combobox -->
            <div class="step" id="step2">
                <div class="audio-container">
                    <button class="audio-button" onclick="playAudio('step2')">
                        Play Audio Guidance
                    </button>
                </div>
                <h2 id="step2-title">Enter Your Prescription</h2>
                <div class="prescription-type" id="prescription-type">
                    <button class="prescription-type-btn selected" onclick="selectPrescriptionType('manual')">
                        Enter Manually
                    </button>
                    <button class="prescription-type-btn" onclick="selectPrescriptionType('upload')">
                        Upload Image
                    </button>
                </div>
                <div class="prescription-section active" id="manualPrescription">
                    <!-- Right Eye (OD) -->
                    <div class="prescription-eye">
                        <div class="prescription-eye-title">
                            <span class="eye-label">Right Eye (OD)</span>
                        </div>
                        <div class="prescription-grid">
                            <div class="prescription-field">
                                <label>SPH</label>
                                <div class="combobox">
                                    <input name="od_sph" placeholder="0.00" step="0.25" type="number"
                                        min="-20" max="20" required />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="-20.00">-20.00</li>
                                            <li data-value="-19.75">-19.75</li>
                                            <li data-value="-19.50">-19.50</li>
                                            <li data-value="-19.25">-19.25</li>
                                            <li data-value="-19.00">-19.00</li>
                                            <li data-value="-18.75">-18.75</li>
                                            <li data-value="-18.50">-18.50</li>
                                            <li data-value="-18.25">-18.25</li>
                                            <li data-value="-18.00">-18.00</li>
                                            <li data-value="-17.75">-17.75</li>
                                            <li data-value="-17.50">-17.50</li>
                                            <li data-value="-17.25">-17.25</li>
                                            <li data-value="-17.00">-17.00</li>
                                            <li data-value="-16.75">-16.75</li>
                                            <li data-value="-16.50">-16.50</li>
                                            <li data-value="-16.25">-16.25</li>
                                            <li data-value="-16.00">-16.00</li>
                                            <li data-value="-15.75">-15.75</li>
                                            <li data-value="-15.50">-15.50</li>
                                            <li data-value="-15.25">-15.25</li>
                                            <li data-value="-15.00">-15.00</li>

                                            <li data-value="-14.75">-14.75</li>
                                            <li data-value="-14.50">-14.50</li>
                                            <li data-value="-14.25">-14.25</li>
                                            <li data-value="-14.00">-14.00</li>
                                            <li data-value="-13.75">-13.75</li>
                                            <li data-value="-13.50">-13.50</li>
                                            <li data-value="-13.25">-13.25</li>

                                            <li data-value="-13.00">-13.00</li>
                                            <li data-value="-12.75">-12.75</li>
                                            <li data-value="-12.50">-12.50</li>
                                            <li data-value="-12.25">-12.25</li>
                                            <li data-value="-12.00">-12.00</li>
                                            <li data-value="-11.75">-11.75</li>
                                            <li data-value="-11.50">-11.50</li>
                                            <li data-value="-11.25">-11.25</li>
                                            <li data-value="-11.00">-11.00</li>
                                            <li data-value="-10.75">-10.75</li>
                                            <li data-value="-10.50">-10.50</li>
                                            <li data-value="-10.25">-10.25</li>
                                            <li data-value="-10.00">-10.00</li>
                                            <li data-value="-9.75">-9.75</li>
                                            <li data-value="-9.50">-9.50</li>
                                            <li data-value="-9.25">-9.25</li>
                                            <li data-value="-9.00">-9.00</li>
                                            <li data-value="-8.75">-8.75</li>
                                            <li data-value="-8.50">-8.50</li>
                                            <li data-value="-8.25">-8.25</li>
                                            <li data-value="-8.00">-8.00</li>
                                            <li data-value="-7.75">-7.75</li>
                                            <li data-value="-7.50">-7.50</li>
                                            <li data-value="-7.25">-7.25</li>
                                            <li data-value="-7.00">-7.00</li>
                                            <li data-value="-6.75">-6.75</li>
                                            <li data-value="-6.50">-6.50</li>
                                            <li data-value="-6.25">-6.25</li>
                                            <li data-value="-6.00">-6.00</li>
                                            <li data-value="-5.75">-5.75</li>
                                            <li data-value="-5.50">-5.50</li>
                                            <li data-value="-5.25">-5.25</li>
                                            <li data-value="-5.00">-5.00</li>
                                            <li data-value="-4.75">-4.75</li>
                                            <li data-value="-4.50">-4.50</li>
                                            <li data-value="-4.25">-4.25</li>
                                            <li data-value="-4.00">-4.00</li>
                                            <li data-value="-3.75">-3.75</li>
                                            <li data-value="-3.50">-3.50</li>
                                            <li data-value="-3.25">-3.25</li>
                                            <li data-value="-3.00">-3.00</li>
                                            <li data-value="-2.75">-2.75</li>
                                            <li data-value="-2.50">-2.50</li>
                                            <li data-value="-2.25">-2.25</li>
                                            <li data-value="-2.00">-2.00</li>
                                            <li data-value="-1.75">-1.75</li>
                                            <li data-value="-1.50">-1.50</li>
                                            <li data-value="-1.25">-1.25</li>
                                            <li data-value="-1.00">-1.00</li>
                                            <li data-value="-0.75">-0.75</li>
                                            <li data-value="-0.50">-0.50</li>
                                            <li data-value="-0.25">-0.25</li>
                                            <li data-value="0.00">0.00</li>
                                            <li data-value="0.25">+0.25</li>
                                            <li data-value="0.50">+0.50</li>
                                            <li data-value="0.75">+0.75</li>
                                            <li data-value="1.00">+1.00</li>
                                            <li data-value="1.25">+1.25</li>
                                            <li data-value="1.50">+1.50</li>
                                            <li data-value="1.75">+1.75</li>
                                            <li data-value="2.00">+2.00</li>
                                            <li data-value="2.25">+2.25</li>
                                            <li data-value="2.50">+2.50</li>
                                            <li data-value="2.75">+2.75</li>
                                            <li data-value="3.00">+3.00</li>
                                            <li data-value="3.25">+3.25</li>
                                            <li data-value="3.50">+3.50</li>
                                            <li data-value="3.75">+3.75</li>
                                            <li data-value="4.00">+4.00</li>
                                            <li data-value="4.25">+4.25</li>
                                            <li data-value="4.50">+4.50</li>
                                            <li data-value="4.75">+4.75</li>
                                            <li data-value="5.00">+5.00</li>
                                            <li data-value="5.25">+5.25</li>
                                            <li data-value="5.50">+5.50</li>
                                            <li data-value="5.75">+5.75</li>
                                            <li data-value="6.00">+6.00</li>
                                            <li data-value="6.25">+6.25</li>
                                            <li data-value="6.50">+6.50</li>
                                            <li data-value="6.75">+6.75</li>
                                            <li data-value="7.00">+7.00</li>
                                            <li data-value="7.25">+7.25</li>
                                            <li data-value="7.50">+7.50</li>
                                            <li data-value="7.75">+7.75</li>
                                            <li data-value="8.00">+8.00</li>
                                            <li data-value="8.25">+8.25</li>
                                            <li data-value="8.50">+8.50</li>
                                            <li data-value="8.75">+8.75</li>
                                            <li data-value="9.00">+9.00</li>
                                            <li data-value="9.25">+9.25</li>
                                            <li data-value="9.50">+9.50</li>
                                            <li data-value="9.75">+9.75</li>
                                            <li data-value="10.00">+10.00</li>
                                            <li data-value="10.25">+10.25</li>
                                            <li data-value="10.50">+10.50</li>
                                            <li data-value="10.75">+10.75</li>
                                            <li data-value="11.00">+11.00</li>
                                            <li data-value="11.25">+11.25</li>
                                            <li data-value="11.50">+11.50</li>
                                            <li data-value="11.75">+11.75</li>
                                            <li data-value="12.00">+12.00</li>
                                            <li data-value="12.25">+12.25</li>
                                            <li data-value="12.50">+12.50</li>
                                            <li data-value="12.75">+12.75</li>
                                            <li data-value="13.00">+13.00</li>
                                            <li data-value="13.25">+13.25</li>
                                            <li data-value="13.50">+13.50</li>
                                            <li data-value="13.75">+13.75</li>
                                            <li data-value="14.00">+14.00</li>
                                            <li data-value="14.25">+14.25</li>
                                            <li data-value="14.50">+14.50</li>
                                            <li data-value="14.75">+14.75</li>
                                            <li data-value="15.00">+15.00</li>
                                            <li data-value="15.25">+15.25</li>
                                            <li data-value="15.50">+15.50</li>
                                            <li data-value="15.75">+15.75</li>
                                            <li data-value="16.00">+16.00</li>
                                            <li data-value="16.25">+16.25</li>
                                            <li data-value="16.50">+16.50</li>
                                            <li data-value="16.75">+16.75</li>
                                            <li data-value="17.00">+17.00</li>
                                            <li data-value="17.25">+17.25</li>
                                            <li data-value="17.50">+17.50</li>
                                            <li data-value="17.75">+17.75</li>
                                            <li data-value="18.00">+18.00</li>
                                            <li data-value="18.25">+18.25</li>
                                            <li data-value="18.50">+18.50</li>
                                            <li data-value="18.75">+18.75</li>
                                            <li data-value="19.00">+19.00</li>
                                            <li data-value="19.25">+19.25</li>
                                            <li data-value="19.50">+19.50</li>
                                            <li data-value="19.75">+19.75</li>
                                            <li data-value="20.00">+20.00</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="prescription-field">
                                <label>CYL</label>
                                <div class="combobox">
                                    <input name="od_cyl" placeholder="0.00" step="0.25" type="number"
                                        min="-6" max="6" />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="-6.00">-6.00</li>
                                            <li data-value="-5.75">-5.75</li>
                                            <li data-value="-5.50">-5.50</li>
                                            <li data-value="-5.25">-5.25</li>
                                            <li data-value="-5.00">-5.00</li>
                                            <li data-value="-4.75">-4.75</li>
                                            <li data-value="-4.50">-4.50</li>
                                            <li data-value="-4.25">-4.25</li>
                                            <li data-value="-4.00">-4.00</li>
                                            <li data-value="-3.75">-3.75</li>
                                            <li data-value="-3.50">-3.50</li>
                                            <li data-value="-3.25">-3.25</li>
                                            <li data-value="-3.00">-3.00</li>
                                            <li data-value="-2.75">-2.75</li>
                                            <li data-value="-2.50">-2.50</li>
                                            <li data-value="-2.25">-2.25</li>
                                            <li data-value="-2.00">-2.00</li>
                                            <li data-value="-1.75">-1.75</li>
                                            <li data-value="-1.50">-1.50</li>
                                            <li data-value="-1.25">-1.25</li>
                                            <li data-value="-1.00">-1.00</li>
                                            <li data-value="-0.75">-0.75</li>
                                            <li data-value="-0.50">-0.50</li>
                                            <li data-value="-0.25">-0.25</li>
                                            <li data-value="0.00">0.00</li>
                                            <li data-value="0.25">+0.25</li>
                                            <li data-value="0.50">+0.50</li>
                                            <li data-value="0.75">+0.75</li>
                                            <li data-value="1.00">+1.00</li>
                                            <li data-value="1.25">+1.25</li>
                                            <li data-value="1.50">+1.50</li>
                                            <li data-value="1.75">+1.75</li>
                                            <li data-value="2.00">+2.00</li>
                                            <li data-value="2.25">+2.25</li>
                                            <li data-value="2.50">+2.50</li>
                                            <li data-value="2.75">+2.75</li>
                                            <li data-value="3.00">+3.00</li>
                                            <li data-value="3.25">+3.25</li>
                                            <li data-value="3.50">+3.50</li>
                                            <li data-value="3.75">+3.75</li>
                                            <li data-value="4.00">+4.00</li>
                                            <li data-value="4.25">+4.25</li>
                                            <li data-value="4.50">+4.50</li>
                                            <li data-value="4.75">+4.75</li>
                                            <li data-value="5.00">+5.00</li>
                                            <li data-value="5.25">+5.25</li>
                                            <li data-value="5.50">+5.50</li>
                                            <li data-value="5.75">+5.75</li>
                                            <li data-value="6.00">+6.00</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="prescription-field">
                                <label>Axis</label>
                                <div class="combobox">
                                    <input name="od_axis" placeholder="0" type="number" min="0"
                                        max="180" />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="0">0</li>
                                            <li data-value="1">1</li>
                                            <li data-value="2">2</li>
                                            <li data-value="3">3</li>
                                            <li data-value="4">4</li>
                                            <li data-value="5">5</li>
                                            <li data-value="6">6</li>
                                            <li data-value="7">7</li>
                                            <li data-value="8">8</li>
                                            <li data-value="9">9</li>
                                            <li data-value="10">10</li>
                                            <li data-value="11">11</li>
                                            <li data-value="12">12</li>
                                            <li data-value="13">13</li>
                                            <li data-value="14">14</li>
                                            <li data-value="15">15</li>
                                            <li data-value="16">16</li>
                                            <li data-value="17">17</li>
                                            <li data-value="18">18</li>
                                            <li data-value="19">19</li>
                                            <li data-value="20">20</li>
                                            <li data-value="21">21</li>
                                            <li data-value="22">22</li>
                                            <li data-value="23">23</li>
                                            <li data-value="24">24</li>
                                            <li data-value="25">25</li>
                                            <li data-value="26">26</li>
                                            <li data-value="27">27</li>
                                            <li data-value="28">28</li>
                                            <li data-value="29">29</li>
                                            <li data-value="30">30</li>
                                            <li data-value="31">31</li>
                                            <li data-value="32">32</li>
                                            <li data-value="33">33</li>
                                            <li data-value="34">34</li>
                                            <li data-value="35">35</li>
                                            <li data-value="36">36</li>
                                            <li data-value="37">37</li>
                                            <li data-value="38">38</li>
                                            <li data-value="39">39</li>
                                            <li data-value="40">40</li>
                                            <li data-value="41">41</li>
                                            <li data-value="42">42</li>
                                            <li data-value="43">43</li>
                                            <li data-value="44">44</li>
                                            <li data-value="45">45</li>
                                            <li data-value="46">46</li>
                                            <li data-value="47">47</li>
                                            <li data-value="48">48</li>
                                            <li data-value="49">49</li>
                                            <li data-value="50">50</li>
                                            <li data-value="51">51</li>
                                            <li data-value="52">52</li>
                                            <li data-value="53">53</li>
                                            <li data-value="54">54</li>
                                            <li data-value="55">55</li>
                                            <li data-value="56">56</li>
                                            <li data-value="57">57</li>
                                            <li data-value="58">58</li>
                                            <li data-value="59">59</li>
                                            <li data-value="60">60</li>
                                            <li data-value="61">61</li>
                                            <li data-value="62">62</li>
                                            <li data-value="63">63</li>
                                            <li data-value="64">64</li>
                                            <li data-value="65">65</li>
                                            <li data-value="66">66</li>
                                            <li data-value="67">67</li>
                                            <li data-value="68">68</li>
                                            <li data-value="69">69</li>
                                            <li data-value="70">70</li>
                                            <li data-value="71">71</li>
                                            <li data-value="72">72</li>
                                            <li data-value="73">73</li>
                                            <li data-value="74">74</li>
                                            <li data-value="75">75</li>
                                            <li data-value="76">76</li>
                                            <li data-value="77">77</li>
                                            <li data-value="78">78</li>
                                            <li data-value="79">79</li>
                                            <li data-value="80">80</li>
                                            <li data-value="81">81</li>
                                            <li data-value="82">82</li>
                                            <li data-value="83">83</li>
                                            <li data-value="84">84</li>
                                            <li data-value="85">85</li>
                                            <li data-value="86">86</li>
                                            <li data-value="87">87</li>
                                            <li data-value="88">88</li>
                                            <li data-value="89">89</li>
                                            <li data-value="90">90</li>
                                            <li data-value="91">91</li>
                                            <li data-value="92">92</li>
                                            <li data-value="93">93</li>
                                            <li data-value="94">94</li>
                                            <li data-value="95">95</li>
                                            <li data-value="96">96</li>
                                            <li data-value="97">97</li>
                                            <li data-value="98">98</li>
                                            <li data-value="99">99</li>
                                            <li data-value="100">100</li>
                                            <li data-value="101">101</li>
                                            <li data-value="102">102</li>
                                            <li data-value="103">103</li>
                                            <li data-value="104">104</li>
                                            <li data-value="105">105</li>
                                            <li data-value="106">106</li>
                                            <li data-value="107">107</li>
                                            <li data-value="108">108</li>
                                            <li data-value="109">109</li>
                                            <li data-value="110">110</li>
                                            <li data-value="111">111</li>
                                            <li data-value="112">112</li>
                                            <li data-value="113">113</li>
                                            <li data-value="114">114</li>
                                            <li data-value="115">115</li>
                                            <li data-value="116">116</li>
                                            <li data-value="117">117</li>
                                            <li data-value="118">118</li>
                                            <li data-value="119">119</li>
                                            <li data-value="120">120</li>
                                            <li data-value="121">121</li>
                                            <li data-value="122">122</li>
                                            <li data-value="123">123</li>
                                            <li data-value="124">124</li>
                                            <li data-value="125">125</li>
                                            <li data-value="126">126</li>
                                            <li data-value="127">127</li>
                                            <li data-value="128">128</li>
                                            <li data-value="129">129</li>
                                            <li data-value="130">130</li>
                                            <li data-value="131">131</li>
                                            <li data-value="132">132</li>
                                            <li data-value="133">133</li>
                                            <li data-value="134">134</li>
                                            <li data-value="135">135</li>
                                            <li data-value="136">136</li>
                                            <li data-value="137">137</li>
                                            <li data-value="138">138</li>
                                            <li data-value="139">139</li>
                                            <li data-value="140">140</li>
                                            <li data-value="141">141</li>
                                            <li data-value="142">142</li>
                                            <li data-value="143">143</li>
                                            <li data-value="144">144</li>
                                            <li data-value="145">145</li>
                                            <li data-value="146">146</li>
                                            <li data-value="147">147</li>
                                            <li data-value="148">148</li>
                                            <li data-value="149">149</li>
                                            <li data-value="150">150</li>
                                            <li data-value="151">151</li>
                                            <li data-value="152">152</li>
                                            <li data-value="153">153</li>
                                            <li data-value="154">154</li>
                                            <li data-value="155">155</li>
                                            <li data-value="156">156</li>
                                            <li data-value="157">157</li>
                                            <li data-value="158">158</li>
                                            <li data-value="159">159</li>
                                            <li data-value="160">160</li>
                                            <li data-value="161">161</li>
                                            <li data-value="162">162</li>
                                            <li data-value="163">163</li>
                                            <li data-value="164">164</li>
                                            <li data-value="165">165</li>
                                            <li data-value="166">166</li>
                                            <li data-value="167">167</li>
                                            <li data-value="168">168</li>
                                            <li data-value="169">169</li>
                                            <li data-value="170">170</li>
                                            <li data-value="171">171</li>
                                            <li data-value="172">172</li>
                                            <li data-value="173">173</li>
                                            <li data-value="174">174</li>
                                            <li data-value="175">175</li>
                                            <li data-value="176">176</li>
                                            <li data-value="177">177</li>
                                            <li data-value="178">178</li>
                                            <li data-value="179">179</li>
                                            <li data-value="180">180</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="prescription-field add-field hidden" data-lens-type="bifocal progressive">
                                <label>ADD</label>
                                <div class="combobox">
                                    <input name="od_add" placeholder="0.00" step="0.25" type="number"
                                        min="0.25" max="4" />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="0.25">+0.25</li>
                                            <li data-value="0.50">+0.50</li>
                                            <li data-value="0.75">+0.75</li>
                                            <li data-value="1.00">+1.00</li>
                                            <li data-value="1.25">+1.25</li>
                                            <li data-value="1.50">+1.50</li>
                                            <li data-value="1.75">+1.75</li>
                                            <li data-value="2.00">+2.00</li>
                                            <li data-value="2.25">+2.25</li>
                                            <li data-value="2.50">+2.50</li>
                                            <li data-value="2.75">+2.75</li>
                                            <li data-value="3.00">+3.00</li>
                                            <li data-value="3.25">+3.25</li>
                                            <li data-value="3.50">+3.50</li>
                                            <li data-value="3.75">+3.75</li>
                                            <li data-value="4.00">+4.00</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Left Eye (OS) -->
                    <div class="prescription-eye">
                        <div class="prescription-eye-title">
                            <span class="eye-label">Left Eye (OS)</span>
                        </div>
                        <div class="prescription-grid">
                            <div class="prescription-field">
                                <label>SPH</label>
                                <div class="combobox">
                                    <input name="os_sph" placeholder="0.00" step="0.25" type="number"
                                        min="-20" max="20" required />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="-20.00">-20.00</li>
                                            <li data-value="-19.75">-19.75</li>
                                            <li data-value="-19.50">-19.50</li>
                                            <li data-value="-19.25">-19.25</li>
                                            <li data-value="-19.00">-19.00</li>
                                            <li data-value="-18.75">-18.75</li>
                                            <li data-value="-18.50">-18.50</li>
                                            <li data-value="-18.25">-18.25</li>
                                            <li data-value="-18.00">-18.00</li>
                                            <li data-value="-17.75">-17.75</li>
                                            <li data-value="-17.50">-17.50</li>
                                            <li data-value="-17.25">-17.25</li>
                                            <li data-value="-17.00">-17.00</li>
                                            <li data-value="-16.75">-16.75</li>
                                            <li data-value="-16.50">-16.50</li>
                                            <li data-value="-16.25">-16.25</li>
                                            <li data-value="-16.00">-16.00</li>
                                            <li data-value="-15.75">-15.75</li>
                                            <li data-value="-15.50">-15.50</li>
                                            <li data-value="-15.25">-15.25</li>
                                            <li data-value="-15.00">-15.00</li>

                                            <li data-value="-14.75">-14.75</li>
                                            <li data-value="-14.50">-14.50</li>
                                            <li data-value="-14.25">-14.25</li>
                                            <li data-value="-14.00">-14.00</li>
                                            <li data-value="-13.75">-13.75</li>
                                            <li data-value="-13.50">-13.50</li>
                                            <li data-value="-13.25">-13.25</li>

                                            <li data-value="-13.00">-13.00</li>
                                            <li data-value="-12.75">-12.75</li>
                                            <li data-value="-12.50">-12.50</li>
                                            <li data-value="-12.25">-12.25</li>
                                            <li data-value="-12.00">-12.00</li>
                                            <li data-value="-11.75">-11.75</li>
                                            <li data-value="-11.50">-11.50</li>
                                            <li data-value="-11.25">-11.25</li>
                                            <li data-value="-11.00">-11.00</li>
                                            <li data-value="-10.75">-10.75</li>
                                            <li data-value="-10.50">-10.50</li>
                                            <li data-value="-10.25">-10.25</li>
                                            <li data-value="-10.00">-10.00</li>
                                            <li data-value="-9.75">-9.75</li>
                                            <li data-value="-9.50">-9.50</li>
                                            <li data-value="-9.25">-9.25</li>
                                            <li data-value="-9.00">-9.00</li>
                                            <li data-value="-8.75">-8.75</li>
                                            <li data-value="-8.50">-8.50</li>
                                            <li data-value="-8.25">-8.25</li>
                                            <li data-value="-8.00">-8.00</li>
                                            <li data-value="-7.75">-7.75</li>
                                            <li data-value="-7.50">-7.50</li>
                                            <li data-value="-7.25">-7.25</li>
                                            <li data-value="-7.00">-7.00</li>
                                            <li data-value="-6.75">-6.75</li>
                                            <li data-value="-6.50">-6.50</li>
                                            <li data-value="-6.25">-6.25</li>
                                            <li data-value="-6.00">-6.00</li>
                                            <li data-value="-5.75">-5.75</li>
                                            <li data-value="-5.50">-5.50</li>
                                            <li data-value="-5.25">-5.25</li>
                                            <li data-value="-5.00">-5.00</li>
                                            <li data-value="-4.75">-4.75</li>
                                            <li data-value="-4.50">-4.50</li>
                                            <li data-value="-4.25">-4.25</li>
                                            <li data-value="-4.00">-4.00</li>
                                            <li data-value="-3.75">-3.75</li>
                                            <li data-value="-3.50">-3.50</li>
                                            <li data-value="-3.25">-3.25</li>
                                            <li data-value="-3.00">-3.00</li>
                                            <li data-value="-2.75">-2.75</li>
                                            <li data-value="-2.50">-2.50</li>
                                            <li data-value="-2.25">-2.25</li>
                                            <li data-value="-2.00">-2.00</li>
                                            <li data-value="-1.75">-1.75</li>
                                            <li data-value="-1.50">-1.50</li>
                                            <li data-value="-1.25">-1.25</li>
                                            <li data-value="-1.00">-1.00</li>
                                            <li data-value="-0.75">-0.75</li>
                                            <li data-value="-0.50">-0.50</li>
                                            <li data-value="-0.25">-0.25</li>
                                            <li data-value="0.00">0.00</li>
                                            <li data-value="0.25">+0.25</li>
                                            <li data-value="0.50">+0.50</li>
                                            <li data-value="0.75">+0.75</li>
                                            <li data-value="1.00">+1.00</li>
                                            <li data-value="1.25">+1.25</li>
                                            <li data-value="1.50">+1.50</li>
                                            <li data-value="1.75">+1.75</li>
                                            <li data-value="2.00">+2.00</li>
                                            <li data-value="2.25">+2.25</li>
                                            <li data-value="2.50">+2.50</li>
                                            <li data-value="2.75">+2.75</li>
                                            <li data-value="3.00">+3.00</li>
                                            <li data-value="3.25">+3.25</li>
                                            <li data-value="3.50">+3.50</li>
                                            <li data-value="3.75">+3.75</li>
                                            <li data-value="4.00">+4.00</li>
                                            <li data-value="4.25">+4.25</li>
                                            <li data-value="4.50">+4.50</li>
                                            <li data-value="4.75">+4.75</li>
                                            <li data-value="5.00">+5.00</li>
                                            <li data-value="5.25">+5.25</li>
                                            <li data-value="5.50">+5.50</li>
                                            <li data-value="5.75">+5.75</li>
                                            <li data-value="6.00">+6.00</li>
                                            <li data-value="6.25">+6.25</li>
                                            <li data-value="6.50">+6.50</li>
                                            <li data-value="6.75">+6.75</li>
                                            <li data-value="7.00">+7.00</li>
                                            <li data-value="7.25">+7.25</li>
                                            <li data-value="7.50">+7.50</li>
                                            <li data-value="7.75">+7.75</li>
                                            <li data-value="8.00">+8.00</li>
                                            <li data-value="8.25">+8.25</li>
                                            <li data-value="8.50">+8.50</li>
                                            <li data-value="8.75">+8.75</li>
                                            <li data-value="9.00">+9.00</li>
                                            <li data-value="9.25">+9.25</li>
                                            <li data-value="9.50">+9.50</li>
                                            <li data-value="9.75">+9.75</li>
                                            <li data-value="10.00">+10.00</li>
                                            <li data-value="10.25">+10.25</li>
                                            <li data-value="10.50">+10.50</li>
                                            <li data-value="10.75">+10.75</li>
                                            <li data-value="11.00">+11.00</li>
                                            <li data-value="11.25">+11.25</li>
                                            <li data-value="11.50">+11.50</li>
                                            <li data-value="11.75">+11.75</li>
                                            <li data-value="12.00">+12.00</li>
                                            <li data-value="12.25">+12.25</li>
                                            <li data-value="12.50">+12.50</li>
                                            <li data-value="12.75">+12.75</li>
                                            <li data-value="13.00">+13.00</li>
                                            <li data-value="13.25">+13.25</li>
                                            <li data-value="13.50">+13.50</li>
                                            <li data-value="13.75">+13.75</li>
                                            <li data-value="14.00">+14.00</li>
                                            <li data-value="14.25">+14.25</li>
                                            <li data-value="14.50">+14.50</li>
                                            <li data-value="14.75">+14.75</li>
                                            <li data-value="15.00">+15.00</li>
                                            <li data-value="15.25">+15.25</li>
                                            <li data-value="15.50">+15.50</li>
                                            <li data-value="15.75">+15.75</li>
                                            <li data-value="16.00">+16.00</li>
                                            <li data-value="16.25">+16.25</li>
                                            <li data-value="16.50">+16.50</li>
                                            <li data-value="16.75">+16.75</li>
                                            <li data-value="17.00">+17.00</li>
                                            <li data-value="17.25">+17.25</li>
                                            <li data-value="17.50">+17.50</li>
                                            <li data-value="17.75">+17.75</li>
                                            <li data-value="18.00">+18.00</li>
                                            <li data-value="18.25">+18.25</li>
                                            <li data-value="18.50">+18.50</li>
                                            <li data-value="18.75">+18.75</li>
                                            <li data-value="19.00">+19.00</li>
                                            <li data-value="19.25">+19.25</li>
                                            <li data-value="19.50">+19.50</li>
                                            <li data-value="19.75">+19.75</li>
                                            <li data-value="20.00">+20.00</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="prescription-field">
                                <label>CYL</label>
                                <div class="combobox">
                                    <input name="os_cyl" placeholder="0.00" step="0.25" type="number"
                                        min="-6" max="6" />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="-6.00">-6.00</li>
                                            <li data-value="-5.75">-5.75</li>
                                            <li data-value="-5.50">-5.50</li>
                                            <li data-value="-5.25">-5.25</li>
                                            <li data-value="-5.00">-5.00</li>
                                            <li data-value="-4.75">-4.75</li>
                                            <li data-value="-4.50">-4.50</li>
                                            <li data-value="-4.25">-4.25</li>
                                            <li data-value="-4.00">-4.00</li>
                                            <li data-value="-3.75">-3.75</li>
                                            <li data-value="-3.50">-3.50</li>
                                            <li data-value="-3.25">-3.25</li>
                                            <li data-value="-3.00">-3.00</li>
                                            <li data-value="-2.75">-2.75</li>
                                            <li data-value="-2.50">-2.50</li>
                                            <li data-value="-2.25">-2.25</li>
                                            <li data-value="-2.00">-2.00</li>
                                            <li data-value="-1.75">-1.75</li>
                                            <li data-value="-1.50">-1.50</li>
                                            <li data-value="-1.25">-1.25</li>
                                            <li data-value="-1.00">-1.00</li>
                                            <li data-value="-0.75">-0.75</li>
                                            <li data-value="-0.50">-0.50</li>
                                            <li data-value="-0.25">-0.25</li>
                                            <li data-value="0.00">0.00</li>
                                            <li data-value="0.25">+0.25</li>
                                            <li data-value="0.50">+0.50</li>
                                            <li data-value="0.75">+0.75</li>
                                            <li data-value="1.00">+1.00</li>
                                            <li data-value="1.25">+1.25</li>
                                            <li data-value="1.50">+1.50</li>
                                            <li data-value="1.75">+1.75</li>
                                            <li data-value="2.00">+2.00</li>
                                            <li data-value="2.25">+2.25</li>
                                            <li data-value="2.50">+2.50</li>
                                            <li data-value="2.75">+2.75</li>
                                            <li data-value="3.00">+3.00</li>
                                            <li data-value="3.25">+3.25</li>
                                            <li data-value="3.50">+3.50</li>
                                            <li data-value="3.75">+3.75</li>
                                            <li data-value="4.00">+4.00</li>
                                            <li data-value="4.25">+4.25</li>
                                            <li data-value="4.50">+4.50</li>
                                            <li data-value="4.75">+4.75</li>
                                            <li data-value="5.00">+5.00</li>
                                            <li data-value="5.25">+5.25</li>
                                            <li data-value="5.50">+5.50</li>
                                            <li data-value="5.75">+5.75</li>
                                            <li data-value="6.00">+6.00</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="prescription-field">
                                <label>Axis</label>
                                <div class="combobox">
                                    <input name="os_axis" placeholder="0" type="number" min="0"
                                        max="180" />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="0">0</li>
                                            <li data-value="1">1</li>
                                            <li data-value="2">2</li>
                                            <li data-value="3">3</li>
                                            <li data-value="4">4</li>
                                            <li data-value="5">5</li>
                                            <li data-value="6">6</li>
                                            <li data-value="7">7</li>
                                            <li data-value="8">8</li>
                                            <li data-value="9">9</li>
                                            <li data-value="10">10</li>
                                            <li data-value="11">11</li>
                                            <li data-value="12">12</li>
                                            <li data-value="13">13</li>
                                            <li data-value="14">14</li>
                                            <li data-value="15">15</li>
                                            <li data-value="16">16</li>
                                            <li data-value="17">17</li>
                                            <li data-value="18">18</li>
                                            <li data-value="19">19</li>
                                            <li data-value="20">20</li>
                                            <li data-value="21">21</li>
                                            <li data-value="22">22</li>
                                            <li data-value="23">23</li>
                                            <li data-value="24">24</li>
                                            <li data-value="25">25</li>
                                            <li data-value="26">26</li>
                                            <li data-value="27">27</li>
                                            <li data-value="28">28</li>
                                            <li data-value="29">29</li>
                                            <li data-value="30">30</li>
                                            <li data-value="31">31</li>
                                            <li data-value="32">32</li>
                                            <li data-value="33">33</li>
                                            <li data-value="34">34</li>
                                            <li data-value="35">35</li>
                                            <li data-value="36">36</li>
                                            <li data-value="37">37</li>
                                            <li data-value="38">38</li>
                                            <li data-value="39">39</li>
                                            <li data-value="40">40</li>
                                            <li data-value="41">41</li>
                                            <li data-value="42">42</li>
                                            <li data-value="43">43</li>
                                            <li data-value="44">44</li>
                                            <li data-value="45">45</li>
                                            <li data-value="46">46</li>
                                            <li data-value="47">47</li>
                                            <li data-value="48">48</li>
                                            <li data-value="49">49</li>
                                            <li data-value="50">50</li>
                                            <li data-value="51">51</li>
                                            <li data-value="52">52</li>
                                            <li data-value="53">53</li>
                                            <li data-value="54">54</li>
                                            <li data-value="55">55</li>
                                            <li data-value="56">56</li>
                                            <li data-value="57">57</li>
                                            <li data-value="58">58</li>
                                            <li data-value="59">59</li>
                                            <li data-value="60">60</li>
                                            <li data-value="61">61</li>
                                            <li data-value="62">62</li>
                                            <li data-value="63">63</li>
                                            <li data-value="64">64</li>
                                            <li data-value="65">65</li>
                                            <li data-value="66">66</li>
                                            <li data-value="67">67</li>
                                            <li data-value="68">68</li>
                                            <li data-value="69">69</li>
                                            <li data-value="70">70</li>
                                            <li data-value="71">71</li>
                                            <li data-value="72">72</li>
                                            <li data-value="73">73</li>
                                            <li data-value="74">74</li>
                                            <li data-value="75">75</li>
                                            <li data-value="76">76</li>
                                            <li data-value="77">77</li>
                                            <li data-value="78">78</li>
                                            <li data-value="79">79</li>
                                            <li data-value="80">80</li>
                                            <li data-value="81">81</li>
                                            <li data-value="82">82</li>
                                            <li data-value="83">83</li>
                                            <li data-value="84">84</li>
                                            <li data-value="85">85</li>
                                            <li data-value="86">86</li>
                                            <li data-value="87">87</li>
                                            <li data-value="88">88</li>
                                            <li data-value="89">89</li>
                                            <li data-value="90">90</li>
                                            <li data-value="91">91</li>
                                            <li data-value="92">92</li>
                                            <li data-value="93">93</li>
                                            <li data-value="94">94</li>
                                            <li data-value="95">95</li>
                                            <li data-value="96">96</li>
                                            <li data-value="97">97</li>
                                            <li data-value="98">98</li>
                                            <li data-value="99">99</li>
                                            <li data-value="100">100</li>
                                            <li data-value="101">101</li>
                                            <li data-value="102">102</li>
                                            <li data-value="103">103</li>
                                            <li data-value="104">104</li>
                                            <li data-value="105">105</li>
                                            <li data-value="106">106</li>
                                            <li data-value="107">107</li>
                                            <li data-value="108">108</li>
                                            <li data-value="109">109</li>
                                            <li data-value="110">110</li>
                                            <li data-value="111">111</li>
                                            <li data-value="112">112</li>
                                            <li data-value="113">113</li>
                                            <li data-value="114">114</li>
                                            <li data-value="115">115</li>
                                            <li data-value="116">116</li>
                                            <li data-value="117">117</li>
                                            <li data-value="118">118</li>
                                            <li data-value="119">119</li>
                                            <li data-value="120">120</li>
                                            <li data-value="121">121</li>
                                            <li data-value="122">122</li>
                                            <li data-value="123">123</li>
                                            <li data-value="124">124</li>
                                            <li data-value="125">125</li>
                                            <li data-value="126">126</li>
                                            <li data-value="127">127</li>
                                            <li data-value="128">128</li>
                                            <li data-value="129">129</li>
                                            <li data-value="130">130</li>
                                            <li data-value="131">131</li>
                                            <li data-value="132">132</li>
                                            <li data-value="133">133</li>
                                            <li data-value="134">134</li>
                                            <li data-value="135">135</li>
                                            <li data-value="136">136</li>
                                            <li data-value="137">137</li>
                                            <li data-value="138">138</li>
                                            <li data-value="139">139</li>
                                            <li data-value="140">140</li>
                                            <li data-value="141">141</li>
                                            <li data-value="142">142</li>
                                            <li data-value="143">143</li>
                                            <li data-value="144">144</li>
                                            <li data-value="145">145</li>
                                            <li data-value="146">146</li>
                                            <li data-value="147">147</li>
                                            <li data-value="148">148</li>
                                            <li data-value="149">149</li>
                                            <li data-value="150">150</li>
                                            <li data-value="151">151</li>
                                            <li data-value="152">152</li>
                                            <li data-value="153">153</li>
                                            <li data-value="154">154</li>
                                            <li data-value="155">155</li>
                                            <li data-value="156">156</li>
                                            <li data-value="157">157</li>
                                            <li data-value="158">158</li>
                                            <li data-value="159">159</li>
                                            <li data-value="160">160</li>
                                            <li data-value="161">161</li>
                                            <li data-value="162">162</li>
                                            <li data-value="163">163</li>
                                            <li data-value="164">164</li>
                                            <li data-value="165">165</li>
                                            <li data-value="166">166</li>
                                            <li data-value="167">167</li>
                                            <li data-value="168">168</li>
                                            <li data-value="169">169</li>
                                            <li data-value="170">170</li>
                                            <li data-value="171">171</li>
                                            <li data-value="172">172</li>
                                            <li data-value="173">173</li>
                                            <li data-value="174">174</li>
                                            <li data-value="175">175</li>
                                            <li data-value="176">176</li>
                                            <li data-value="177">177</li>
                                            <li data-value="178">178</li>
                                            <li data-value="179">179</li>
                                            <li data-value="180">180</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="prescription-field add-field hidden" data-lens-type="bifocal progressive">
                                <label>ADD</label>
                                <div class="combobox">
                                    <input name="os_add" placeholder="0.00" step="0.25" type="number"
                                        min="0.25" max="4" />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="0.25">+0.25</li>
                                            <li data-value="0.50">+0.50</li>
                                            <li data-value="0.75">+0.75</li>
                                            <li data-value="1.00">+1.00</li>
                                            <li data-value="1.25">+1.25</li>
                                            <li data-value="1.50">+1.50</li>
                                            <li data-value="1.75">+1.75</li>
                                            <li data-value="2.00">+2.00</li>
                                            <li data-value="2.25">+2.25</li>
                                            <li data-value="2.50">+2.50</li>
                                            <li data-value="2.75">+2.75</li>
                                            <li data-value="3.00">+3.00</li>
                                            <li data-value="3.25">+3.25</li>
                                            <li data-value="3.50">+3.50</li>
                                            <li data-value="3.75">+3.75</li>
                                            <li data-value="4.00">+4.00</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pupillary Distance (PD) -->
                    <div class="pd-section">
                        <h3>Pupillary Distance (PD)</h3>
                        <a href="https://pdtest.visionplus.pk/" target="_blank" 
   style="display: inline-block; padding: 10px 20px; background-color: #4696ec; color: white; text-decoration: none; font-weight: bold; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: background-color 0.3s;"
   onmouseover="this.style.backgroundColor='#0056b3';"
   onmouseout="this.style.backgroundColor='#007bff';">
   Measure PD
</a>
                        <div class="prescription-field">
                            <label>PD (mm)</label>
                            <div class="combobox">
                                <input id="pd" placeholder="63" type="number" min="40"
                                    max="80"/>
                                <div class="combobox-dropdown pd-width">
                                    <ul>
                                        <li data-value="40">40</li>
                                        <li data-value="41">41</li>
                                        <li data-value="42">42</li>
                                        <li data-value="43">43</li>
                                        <li data-value="44">44</li>
                                        <li data-value="45">45</li>
                                        <li data-value="46">46</li>
                                        <li data-value="47">47</li>
                                        <li data-value="48">48</li>
                                        <li data-value="49">49</li>
                                        <li data-value="50">50</li>
                                        <li data-value="51">51</li>
                                        <li data-value="52">52</li>
                                        <li data-value="53">53</li>
                                        <li data-value="54">54</li>
                                        <li data-value="55">55</li>
                                        <li data-value="56">56</li>
                                        <li data-value="57">57</li>
                                        <li data-value="58">58</li>
                                        <li data-value="59">59</li>
                                        <li data-value="60">60</li>
                                        <li data-value="61">61</li>
                                        <li data-value="62">62</li>
                                        <li data-value="63">63</li>
                                        <li data-value="64">64</li>
                                        <li data-value="65">65</li>
                                        <li data-value="66">66</li>
                                        <li data-value="67">67</li>
                                        <li data-value="68">68</li>
                                        <li data-value="69">69</li>
                                        <li data-value="70">70</li>
                                        <li data-value="71">71</li>
                                        <li data-value="72">72</li>
                                        <li data-value="73">73</li>
                                        <li data-value="74">74</li>
                                        <li data-value="75">75</li>
                                        <li data-value="76">76</li>
                                        <li data-value="77">77</li>
                                        <li data-value="78">78</li>
                                        <li data-value="79">79</li>
                                        <li data-value="80">80</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="checkbox-container">
                            <input id="dualPd" onchange="toggleDualPd()" type="checkbox" />
                            <label for="dualPd">I have two PD numbers (Right and Left)</label>
                        </div>
                        <div class="dual-pd-fields" id="dualPdFields">
                            <div class="prescription-field">
                                <label>Right PD</label>
                                <div class="combobox">
                                    <input id="pdRight" placeholder="31.5" type="number" step="0.5"
                                        min="20" max="40" />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="20.0">20.0</li>
                                            <li data-value="20.5">20.5</li>
                                            <li data-value="21.0">21.0</li>
                                            <li data-value="21.5">21.5</li>
                                            <li data-value="22.0">22.0</li>
                                            <li data-value="22.5">22.5</li>
                                            <li data-value="23.0">23.0</li>
                                            <li data-value="23.5">23.5</li>
                                            <li data-value="24.0">24.0</li>
                                            <li data-value="24.5">24.5</li>
                                            <li data-value="25.0">25.0</li>
                                            <li data-value="25.5">25.5</li>
                                            <li data-value="26.0">26.0</li>
                                            <li data-value="26.5">26.5</li>
                                            <li data-value="27.0">27.0</li>
                                            <li data-value="27.5">27.5</li>
                                            <li data-value="28.0">28.0</li>
                                            <li data-value="28.5">28.5</li>
                                            <li data-value="29.0">29.0</li>
                                            <li data-value="29.5">29.5</li>
                                            <li data-value="30.0">30.0</li>
                                            <li data-value="30.5">30.5</li>
                                            <li data-value="31.0">31.0</li>
                                            <li data-value="31.5">31.5</li>
                                            <li data-value="32.0">32.0</li>
                                            <li data-value="32.5">32.5</li>
                                            <li data-value="33.0">33.0</li>
                                            <li data-value="33.5">33.5</li>
                                            <li data-value="34.0">34.0</li>
                                            <li data-value="34.5">34.5</li>
                                            <li data-value="35.0">35.0</li>
                                            <li data-value="35.5">35.5</li>
                                            <li data-value="36.0">36.0</li>
                                            <li data-value="36.5">36.5</li>
                                            <li data-value="37.0">37.0</li>
                                            <li data-value="37.5">37.5</li>
                                            <li data-value="38.0">38.0</li>
                                            <li data-value="38.5">38.5</li>
                                            <li data-value="39.0">39.0</li>
                                            <li data-value="39.5">39.5</li>
                                            <li data-value="40.0">40.0</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="prescription-field">
                                <label>Left PD</label>
                                <div class="combobox">
                                    <input id="pdLeft" placeholder="31.5" type="number" step="0.5"
                                        min="20" max="40" />
                                    <div class="combobox-dropdown">
                                        <ul>
                                            <li data-value="20.0">20.0</li>
                                            <li data-value="20.5">20.5</li>
                                            <li data-value="21.0">21.0</li>
                                            <li data-value="21.5">21.5</li>
                                            <li data-value="22.0">22.0</li>
                                            <li data-value="22.5">22.5</li>
                                            <li data-value="23.0">23.0</li>
                                            <li data-value="23.5">23.5</li>
                                            <li data-value="24.0">24.0</li>
                                            <li data-value="24.5">24.5</li>
                                            <li data-value="25.0">25.0</li>
                                            <li data-value="25.5">25.5</li>
                                            <li data-value="26.0">26.0</li>
                                            <li data-value="26.5">26.5</li>
                                            <li data-value="27.0">27.0</li>
                                            <li data-value="27.5">27.5</li>
                                            <li data-value="28.0">28.0</li>
                                            <li data-value="28.5">28.5</li>
                                            <li data-value="29.0">29.0</li>
                                            <li data-value="29.5">29.5</li>
                                            <li data-value="30.0">30.0</li>
                                            <li data-value="30.5">30.5</li>
                                            <li data-value="31.0">31.0</li>
                                            <li data-value="31.5">31.5</li>
                                            <li data-value="32.0">32.0</li>
                                            <li data-value="32.5">32.5</li>
                                            <li data-value="33.0">33.0</li>
                                            <li data-value="33.5">33.5</li>
                                            <li data-value="34.0">34.0</li>
                                            <li data-value="34.5">34.5</li>
                                            <li data-value="35.0">35.0</li>
                                            <li data-value="35.5">35.5</li>
                                            <li data-value="36.0">36.0</li>
                                            <li data-value="36.5">36.5</li>
                                            <li data-value="37.0">37.0</li>
                                            <li data-value="37.5">37.5</li>
                                            <li data-value="38.0">38.0</li>
                                            <li data-value="38.5">38.5</li>
                                            <li data-value="39.0">39.0</li>
                                            <li data-value="39.5">39.5</li>
                                            <li data-value="40.0">40.0</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error" id="prescriptionError">
                        Please fill in all required fields correctly.
                    </div>
                </div>

                <div class="prescription-section" id="readingMagnification">
                    <h3>Select a Magnification Strength</h3>
                    <p>Please note that it is compulsory to select!</p>
                    <div class="magnification-grid" id="magnificationGrid"></div>
                    <div class="error" id="magnificationError">
                        Please select a magnification strength
                    </div>
                </div>
                <div class="prescription-section" id="uploadPrescription">
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">📁</div>
                        <div class="upload-text">
                            <h3>Click here to upload Prescription</h3>
                            <p>JPEG,jpg or PNG, max 5MB</p>
                              <p style="color: #d9534f; font-weight: 500; font-size:12px;">
                 If your image doesn't upload on first attempt, please try again.
              </p>
                        </div>
                        <input accept=".jpg,.jpeg,.png,image/jpeg,image/png,image/jpg" id="imageUpload" style="display: none" type="file"/>
                        <img class="image-preview" id="imagePreview" />
                    </div>
                    <div class="error" id="uploadError">
                        Please upload a prescription image
                    </div>
                    <div class="success-message" id="uploadSuccess">
                        Prescription uploaded successfully
                    </div>
                </div>
                <div class="prescription-section" id="nonPrescriptionFeatures">
                    <div class="cardT-container" id="nonPrescriptionFeatureContainer"></div>
                </div>
                <div class="button-group">
                    <button class="button button-outline" onclick="prevStep()">
                        Back
                    </button>
                    <button class="button" onclick="nextStep()">Next</button>
                </div>
            </div>

            <div class="step" id="step3">
                <div class="audio-container">
                    <button class="audio-button" onclick="playAudio('step3')">
                        Play Audio Guidance
                    </button>
                </div>
                <h2>Select Lens Features</h2>
                <div class="cardT-container" id="lensFeatureContainer"></div>
                <div class="button-group">
                    <button class="button button-outline" onclick="prevStep()">
                        Back
                    </button>
                    <button class="button" onclick="nextStep()">Next</button>
                </div>
            </div>
            <div class="step" id="step4">
                <div class="audio-container">
                    <button class="audio-button" onclick="playAudio('step4')">
                        Play Audio Guidance
                    </button>
                </div>
                <h2>Select Your Lens Options</h2>
                <div class="step4-variant" id="step4-distance">
                    <h3>Choose your lens option: <span style="color:#d9534f; font-size:13px;">
  ⚠ High Prescription Alert: Above ±4.00? Avoid basic lenses choose Super Thin 1.67 OR Ultra Thin 1.74 Index from below for thinner look.
</span> </h3>
                    <div class="cardT-container" id="distance-tier-options"></div>
                </div>
                <div class="step4-variant hidden" id="step4-reading">
                    <h3>Choose your lens option: <span style="color:#d9534f; font-size:13px;">
  ⚠ High Prescription Alert: Above ±4.00? Avoid basic lenses choose Super Thin 1.67 OR Ultra Thin 1.74 Index from below for thinner look.
</span></h3>
                    <div class="cardT-container" id="reading-tier-options"></div>
                </div>
                <div class="step4-variant hidden" id="step4-bifocal">
                    <h3>Choose your lens option: <span style="color:#d9534f; font-size:13px;">
  ⚠ High Prescription Alert: Above ±4.00? Avoid basic lenses choose Super Thin 1.67 OR Ultra Thin 1.74 Index from below for thinner look.
</span></h3>
                    <div class="cardT-container" id="bifocal-tier-options"></div>
                </div>
                <div class="step4-variant hidden" id="step4-progressive">
                    <h3>Choose your lens option: <span style="color:#d9534f; font-size:13px;">
  ⚠ High Prescription Alert: Above ±4.00? Avoid basic lenses choose Super Thin 1.67 OR Ultra Thin 1.74 Index from below for thinner look.
</span></h3>
                    <div class="cardT-container" id="progressive-tier-options"></div>
                </div>
                <div class="button-group">
                    <button class="button button-outline" onclick="prevStep()">
                        Back
                    </button>
                    <button class="button" onclick="nextStep()">Next</button>
                </div>
            </div>
            <div class="step" id="step5">
                <div class="audio-container">
                    <button class="audio-button" onclick="playAudio('step5')">
                        Play Audio Guidance
                    </button>
                </div>
                <h2>Review Your Order</h2>
                <div id="framePreview" class="frame-preview"></div>
                <table class="summary-table">
                    <tr>
                        <th>Frame Price</th>
                        <td id="summary-framePrice" style="font-weight: 600; color: var(--text-main)"></td>
                    </tr>
                    <tr>
                        <th>Lens Type</th>
                        <td id="summary-lensType"></td>
                    </tr>
                    <tr>
                        <th>Lens Feature</th>
                        <td id="summary-features"></td>
                    </tr>
                    <tr>
                        <th>Lens Option</th>
                        <td id="summary-lensOption"></td>
                    </tr>
                    <tr>
                        <th>Lens Price</th>
                        <td id="summary-lensPrice" style="font-weight: 600; color: var(--text-main)"></td>
                    </tr>
                    <tr>
                        <th>Total Price</th>
                        <td id="summary-totalPrice" style="font-weight: 600; color: var(--text-main)"></td>
                    </tr>
                </table>
                <div id="summary-prescription"></div>
                <div class="hidden" id="summary-imageContainer">
                    <h3>Uploaded Prescription</h3>
                    <img class="image-preview" id="summary-image" />
                </div>
                <div class="button-group">
                    <button class="button button-outline" onclick="prevStep()">
                        Back
                    </button>
                    <button class="button" onclick="submitOrder()">Submit Order</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store product ID in URL params for the loadFrameData function
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.has('productId') && <?php echo e($product->id); ?>) {
                urlParams.set('productId', '<?php echo e($product->id); ?>');
                const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
                window.history.replaceState({}, '', newUrl);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.prescriptionApp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\frontend\prescription.blade.php ENDPATH**/ ?>