@extends('website.layouts.app')

@section('title', 'SHEV | Amazon AWS | Google Cloud')

@section('headercolor')
    <header class="alt-2">
    @stop

    @section('msgaboveheader')
        <!--  MESSAGES ABOVE HEADER IMAGE -->
            <div class="message">
                <div class="row">
                    <div class="small-12 columns">
                        <div class="message-intro">
                            <span class="message-line"></span>
                            <p>Amazon AWS | Google Cloud</p>
                            <span class="message-line"></span>
                        </div>
                        <h1>100% NETWORK AVAILABILITY</h1>
                    </div>
                </div>
            </div>
            <!--  END OF MESSAGES ABOVE HEADER IMAGE -->
    @stop

    @section('content')
        <!-- BUDGET SERVERS   -->
            <div class="features servers">
                <div class="row">
                    <div class="small-12 columns">
                        <h2>MANAGED BUDGET SERVERS</h2>
                        <p>Stumptown fanny pack ullamco Neutra, Banksy keytar deep v four loko cray proident chillwave. Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master cleanse.</p>
                    </div>
                </div>
            </div>

            <!--  PRICING BOXES  -->
            <div class="pricingboxes">
                <div class="row">
                    <div data-wow-delay="0.2s"  class="small-12 large-4 medium-4 columns wow fadeInLeft">
                        <div class="title">LEVEL 1</div>
                        <ul class="pricing-table">
                            <li class="description"><strong>Unlimited</strong> OS Reloads</li>
                            <li class="bullet-item">1GB storage</li>
                            <li class="bullet-item">3GB bandwidth</li>
                            <li class="bullet-item">Free Email Addresses</li>
                            <li class="bullet-item">24/7 security monitoring</li>
                            <li class="bullet-item">24/7 technical support</li>
                            <li class="price"><span>$109</span>MONTHLY</li>
                            <li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
                        </ul>
                    </div>

                    <div data-wow-delay="0.4s"  class="small-12 large-4 medium-4 columns wow fadeInUp">
                        <div class="title">LEVEL 2</div>
                        <ul class="pricing-table">
                            <li class="description">Remote <strong>Reboot</strong></li>
                            <li class="bullet-item">1GB storage</li>
                            <li class="bullet-item">3GB bandwidth</li>
                            <li class="bullet-item">Free Email Addresses</li>
                            <li class="bullet-item">24/7 security monitoring</li>
                            <li class="bullet-item">24/7 technical support</li>
                            <li class="price"><span>$139</span>MONTHLY</li>
                            <li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
                        </ul>
                    </div>

                    <div data-wow-delay="0.6s"  class="small-12 large-4 medium-4 columns wow fadeInRight">
                        <div class="title">LEVEL 3</div>
                        <ul class="pricing-table">
                            <li class="description"><strong>Root</strong> Access</li>
                            <li class="bullet-item">1GB storage</li>
                            <li class="bullet-item">3GB bandwidth</li>
                            <li class="bullet-item">Free Email Addresses</li>
                            <li class="bullet-item">24/7 security monitoring</li>
                            <li class="bullet-item">24/7 technical support</li>
                            <li class="price"><span>$169</span>MONTHLY</li>
                            <li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--  END OF PRCING BOXES  -->

            <!--  END OF BUDGET SERVERS  -->


            <!-- PREMIUM SERVERS - TABLES   -->
            <div class="features premium-servers">
                <div class="row">
                    <div class="small-12 columns">
                        <h2>MANAGED PREMIUM SERVERS</h2>
                        <p>Stumptown fanny pack ullamco Neutra, Banksy keytar deep v four loko cray proident chillwave. Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master cleanse.</p>

                        <table data-wow-delay="0.3s" class="flat-table flat-table-1 responsive wow fadeInUp tablesaw tablesaw-stack" data-tablesaw-mode="stack">
                            <thead>
                            <tr>
                                <th>SERVER</th>
                                <th>CPU</th>
                                <th>RAM</th>
                                <th>HDD</th>
                                <th>BANDWIDTH</th>
                                <th>COST</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Core i3-540</td>
                                <td>2×2.8GHz</td>
                                <td>4GB</td>
                                <td>2×500 GB 7.2K</td>
                                <td>10TB</td>
                                <td>$275/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Xeon E3-1270</td>
                                <td>4×2.13GHz</td>
                                <td>12GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$362/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Xeon E5-2640</td>
                                <td>2.0GHz</td>
                                <td>16GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$419/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Dual Xeon 5620</td>
                                <td>2.5GHz</td>
                                <td>16GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$421/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Dual Xeon E5-2650</td>
                                <td>2.6GHz</td>
                                <td>16GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$555/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Core i3-540</td>
                                <td>2×2.8GHz</td>
                                <td>4GB</td>
                                <td>2×500 GB 7.2K</td>
                                <td>10TB</td>
                                <td>$275/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Xeon E3-1270</td>
                                <td>4×2.13GHz</td>
                                <td>12GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$362/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Xeon E5-2640</td>
                                <td>2.0GHz</td>
                                <td>16GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$419/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Dual Xeon 5620</td>
                                <td>2.5GHz</td>
                                <td>16GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$421/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Dual Xeon E5-2650</td>
                                <td>2.6GHz</td>
                                <td>16GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$555/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Core i3-540</td>
                                <td>2×2.8GHz</td>
                                <td>4GB</td>
                                <td>2×500 GB 7.2K</td>
                                <td>10TB</td>
                                <td>$275/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Xeon E3-1270</td>
                                <td>4×2.13GHz</td>
                                <td>12GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$362/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Xeon E5-2640</td>
                                <td>2.0GHz</td>
                                <td>16GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$419/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Dual Xeon 5620</td>
                                <td>2.5GHz</td>
                                <td>16GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$421/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            <tr>
                                <td>Dual Xeon E5-2650</td>
                                <td>2.6GHz</td>
                                <td>16GB</td>
                                <td>2x1TB 7.2K</td>
                                <td>10TB</td>
                                <td>$555/mo</td>
                                <td><span><a href="">BUY NOW</a></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- END OF PREMIUM SERVERS - RESPONSIVE TABLES   -->

            <!-- DEDICATED SERVER FEATURES   -->
            <div class="dedicated-servers-features">
                <div class="row">
                    <div class="small-12 columns">
                        <h2>DEDICATED SERVERS THAT JUST WORK</h2>
                        <p>Stumptown fanny pack ullamco Neutra, Banksy keytar deep v four loko cray proident chillwave. Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master cleanse.</p>

                        <ul class="small-block-grid-1 large-block-grid-2 medium-block-grid-2">
                            <li  data-wow-delay="0.3s" class="wow fadeInLeft">
                                <div class="row">
                                    <div class="small-12 large-3 medium-3 columns">
                                        <img src="images/icons/server-features-1.png" alt=""/>
                                    </div>
                                    <div class="small-12 large-9 medium-9 columns">
                                        <h3>Quick Response Times</h3>
                                        <p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master.</p>
                                    </div>
                                </div>
                            </li>
                            <li  data-wow-delay="0.3s" class="wow fadeInRight">
                                <div class="row">
                                    <div class="small-12 large-3 medium-3 columns">
                                        <img src="images/icons/server-features-6.png" alt=""/>
                                    </div>
                                    <div class="small-12 large-9 medium-9 columns">
                                        <h3>Upscale or Downscale Instantly</h3>
                                        <p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master.</p>
                                    </div>
                                </div>
                            </li>
                            <li  data-wow-delay="0.6s" class="wow fadeInLeft">
                                <div class="row">
                                    <div class="small-12 large-3 medium-3 columns">
                                        <img src="images/icons/server-features-5.png" alt=""/>
                                    </div>
                                    <div class="small-12 large-9 medium-9 columns">
                                        <h3>Multiple Global Locations</h3>
                                        <p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master.</p>
                                    </div>
                                </div>
                            </li>
                            <li  data-wow-delay="0.6s" class="wow fadeInRight">
                                <div class="row">
                                    <div class="small-12 large-3 medium-3 columns">
                                        <img src="images/icons/server-features-4.png" alt=""/>
                                    </div>
                                    <div class="small-12 large-9 medium-9 columns">
                                        <h3>We Love What we do</h3>
                                        <p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master.</p>
                                    </div>
                                </div>
                            </li>
                            <li  data-wow-delay="0.9s" class="wow fadeInLeft">
                                <div class="row">
                                    <div class="small-12 large-3 medium-3 columns">
                                        <img src="images/icons/server-features-2.png" alt=""/>
                                    </div>
                                    <div class="small-12 large-9 medium-9 columns">
                                        <h3>99.99% Uptime Guarantee</h3>
                                        <p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master.</p>
                                    </div>
                                </div>
                            </li>
                            <li  data-wow-delay="0.9s" class="wow fadeInRight">
                                <div class="row">
                                    <div class="small-12 large-3 medium-3 columns">
                                        <img src="images/icons/server-features-3.png" alt=""/>
                                    </div>
                                    <div class="small-12 large-9 medium-9 columns">
                                        <h3>Full Control and Managed</h3>
                                        <p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <!-- DEDICATED SERVER FEATURES   -->
@stop
