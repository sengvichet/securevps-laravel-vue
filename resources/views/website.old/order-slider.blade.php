@extends('website.layouts.app')

@section('title', 'SHEV | Order Slider')

@section('headercolor')
<header class="alt-3 order-slider">
@stop

@section('msgaboveheader')
<!--  SLIDER ORDER -->
<div class="pricing-order-slider">
<div class="row">
<div class="small-12 columns">
<h1>SSD CLOUD VPS HOSTING. CHOOSE NOW.</h1>
<div class="vps-prices-container">
<div class="vps-prices-panel">
<div class="vps-prices-drag">
<div id="vps-slider"></div>
<div id="sliderlines"></div>
</div>

                        <div class="row">
           <div class="small-12 columns">

                          <div id="vps_name_option"><h3><span class="how_much"></span></h3></div>

                        <ul class="small-block-grid-2 medium-block-grid-4">

                         <li>
                            <div class="centralized"><div id="cpu_option"><h6>CPU</h6><span class="how_much"></span></div></div>
                          </li>

                          <li>
                           <div class="centralized"><div id="memory_option"><h6>RAM</h6><span class="how_much"></span></div></div>
                           </li>

                             <li>
                            <div class="centralized"><div id="disk_space_option"><h6>Disk Space</h6><span class="how_much"></span></div></div>
                            </li>

                           <li>
                            <div class="centralized"><div id="bandwidth_option"><h6>Bandwidth</h6><span class="how_much"></span></div></div>
                        </li>

</ul>

<div class="total_amount"><h3><span>$</span><span id="price_amount">39</span><span id="decimal">.00</span></h3></div>
                  <p class="text-center"><a class="button medium order-vps" href="#">ORDER VPS</a></p>

                </div>
                  </div>

            </div>
        </div>

</div>
</div>
</div>
<!--  END OF SLIDER ORDER -->
@stop

@section('content')
<!--  ORDER STEPS  -->
<div class="vps-order-steps">
<div class="row">
<div class="small-12 columns">
<h2>GETTING STARTED IS EASY.</h2>
<p>Stumptown fanny pack ullamco Neutra, Banksy keytar deep v four loko cray proident chillwave. Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master cleanse.</p>

<div class="spacing-top-50"></div>

    <div class="row">
        <div data-wow-delay="0.2s"  class="large-4 medium-4 columns text-center wow zoomIn hide-for-small-only">
            <img src="images/icons/vps_step_1.png" alt=""/>
        </div>
        <div data-wow-delay="0.4s" class="large-4 medium-4 columns text-center wow zoomIn hide-for-small-only">
            <img src="images/icons/vps_step_2.png" alt=""/>
        </div>
        <div data-wow-delay="0.6s" class="large-4 medium-4 columns text-center wow zoomIn hide-for-small-only">
            <img src="images/icons/vps_step_3.png" alt=""/>
        </div>
        <div class="large-12 columns hide-for-small-only">
            <div class="order-step">
                <div class="row collapse">
                    <div data-wow-delay="0.2s" class="order-circle large-4 medium-4 columns wow fadeInUp">
                        <div class="line left-side"></div>
                        <span class="left-side">1</span>
                    </div>
                    <div data-wow-delay="0.4s" class="order-circle large-4 medium-4 columns wow fadeInUp">
                        <div class="line"></div>
                        <span>2</span>
                    </div>
                    <div data-wow-delay="0.6s" class="order-circle large-4 medium-4 columns wow fadeInUp">
                        <div class="line right-side"></div>
                        <span class="right-side">3</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="large-4 medium-4 small-12 columns text-center">
            <img class="show-for-small-only" src="images/icons/vps_step_1.png" alt="" />
            <h3>Choose a Cloud VPS Plan</h3>
            <p>Typewriter lo-fi sartorial, church-key hella est pickled sustainable master cleanse.</p>
        </div>
        <div class="large-4 medium-4 small-12 columns text-center">
            <img class="show-for-small-only" src="images/icons/vps_step_2.png" alt=""/>
            <h3>Create Your Account</h3>
            <p>Typewriter lo-fi sartorial, church-key hella est pickled sustainable master cleanse.</p>
        </div>
        <div class="large-4 medium-4 small-12 columns text-center">
            <img class="show-for-small-only" src="images/icons/vps_step_3.png" alt=""/>
            <h3>Launch your VPS</h3>
            <p>Typewriter lo-fi sartorial, church-key hella est pickled sustainable master cleanse.</p>
        </div>
    </div>

</div>
</div>
</div>

<!--  END OF ORDER STEPS  -->

<!--  PRICING BOXES  -->
<div class="pricingboxes">
<div class="row">
<div data-wow-delay="0.2s"  class="small-12 large-3 medium-3 columns wow fadeInUp">
<div class="title">VPS 1</div>
<ul class="pricing-table">
<li class="description"><strong>RAID-10 SSD</strong>  space</li>
<li class="bullet-item">1GB storage</li>
<li class="bullet-item">3GB bandwidth</li>
<li class="bullet-item">Free Email Addresses</li>
<li class="bullet-item">24/7 security monitoring</li>
<li class="bullet-item">24/7 technical support</li>
<li class="price"><span>$79</span>MONTHLY</li>
<li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
</ul>
</div>

<div data-wow-delay="0.4s"  class="small-12 large-3 medium-3 columns wow fadeInUp">
<div class="title">VPS 2</div>
<ul class="pricing-table">
<li class="description">Route-Optimized <strong>Bandwidth</strong></li>
<li class="bullet-item">1GB storage</li>
<li class="bullet-item">3GB bandwidth</li>
<li class="bullet-item">Free Email Addresses</li>
<li class="bullet-item">24/7 security monitoring</li>
<li class="bullet-item">24/7 technical support</li>
<li class="price"><span>$99</span>MONTHLY</li>
<li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
</ul>
</div>

<div data-wow-delay="0.6s"  class="small-12 large-3 medium-3 columns wow fadeInUp">
<div class="title">VPS 3</div>
<ul class="pricing-table">
<li class="description">CDP <strong>Backups</strong></li>
<li class="bullet-item">1GB storage</li>
<li class="bullet-item">3GB bandwidth</li>
<li class="bullet-item">Free Email Addresses</li>
<li class="bullet-item">24/7 security monitoring</li>
<li class="bullet-item">24/7 technical support</li>
<li class="price"><span>$119</span>MONTHLY</li>
<li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
</ul>
</div>

<div data-wow-delay="0.8s"  class="small-12 large-3 medium-3 columns wow fadeInUp">
<div class="title">VPS 4</div>
<ul class="pricing-table">
<li class="description">cPanel / WHM <strong>included</strong></li>
<li class="bullet-item">1GB storage</li>
<li class="bullet-item">3GB bandwidth</li>
<li class="bullet-item">Free Email Addresses</li>
<li class="bullet-item">24/7 security monitoring</li>
<li class="bullet-item">24/7 technical support</li>
<li class="price"><span>$139</span>MONTHLY</li>
<li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
</ul>
</div>


</div>
</div>
<!--  END OF PRCING BOXES  -->

  <script>
    (
        function($, undefined) {
            $.ui.slider.prototype.options =
                $.extend({},
                    $.ui.slider.prototype.options, {
                        paddingMin: 0,
                        paddingMax: 0
                    }
                );

            $.ui.slider.prototype._refreshValue =
                function() {
                    var
                        oRange = this.options.range,
                        o = this.options,
                        self = this,
                        animate = (!this._animateOff) ? o.animate : false,
                        valPercent,
                        _set = {},
                        elementWidth,
                        elementHeight,
                        paddingMinPercent,
                        paddingMaxPercent,
                        paddedBarPercent,
                        lastValPercent,
                        value,
                        valueMin,
                        valueMax;

                    if (self.orientation === "horizontal") {
                        elementWidth = this.element.outerWidth();
                        paddingMinPercent = o.paddingMin * 100 / elementWidth;
                        paddedBarPercent = (elementWidth - (o.paddingMin + o.paddingMax)) * 100 / elementWidth;
                    } else {
                        elementHeight = this.element.outerHeight();
                        paddingMinPercent = o.paddingMin * 100 / elementHeight;
                        paddedBarPercent = (elementHeight - (o.paddingMin + o.paddingMax)) * 100 / elementHeight;
                    }

                    if (this.options.values && this.options.values.length) {
                        this.handles.each(function(i, j) {
                            valPercent = ((self.values(i) - self._valueMin()) / (self._valueMax() - self._valueMin()) * 100) * paddedBarPercent / 100 + paddingMinPercent;
                            valPercent = ( self.options.isRTL ? 100 - valPercent : valPercent ); // RTL
                            _set[self.orientation === "horizontal" ? "right" : "bottom"] = valPercent + "%";
                            $(this).stop(1, 1)[animate ? "animate" : "css"](_set, o.animate);
                            if (self.options.range === true) {
                                if (self.orientation === "horizontal") {
                                    if (i === 0) {
                                        self.range.stop(1, 1)[animate ? "animate" : "css"](
                                        {
                                            left: valPercent + "%"
                                        }, o.animate);
                                    }
                                    if (i === 1) {
                                        self.range[animate ? "animate" : "css"]({
                                            width: (valPercent - lastValPercent) + "%"
                                        }, {
                                            queue: false,
                                            duration: o.animate
                                        });
                                    }
                                } else {
                                    if (i === 0) {
                                        self.range.stop(1, 1)[animate ? "animate" : "css"]({
                                            bottom: (valPercent) + "%"
                                        }, o.animate);
                                    }
                                    if (i === 1) {
                                        self.range[animate ? "animate" : "css"]({
                                            height: (valPercent - lastValPercent) + "%"
                                        }, {
                                            queue: false,
                                            duration: o.animate
                                        });
                                    }
                                }
                            }
                            lastValPercent = valPercent;
                        });
                    } else {
                        value = this.value();
                        valueMin = this._valueMin();
                        valueMax = this._valueMax();
                        valPercent = ((valueMax !== valueMin) ? (value - valueMin) / (valueMax - valueMin) * 100 : 0) * paddedBarPercent / 100 + paddingMinPercent;
                        valPercent = ( self.options.isRTL ? 100 - valPercent : valPercent ); // RTL
                        _set[self.orientation === "horizontal" ? "right" : "bottom"] = valPercent + "%";

                        this.handle.stop(1, 1)[animate ? "animate" : "css"](_set, o.animate);

                        if (oRange === "min" && this.orientation === "horizontal") {
                            this.range.stop(1, 1)[animate ? "animate" : "css"]({
                                width: valPercent + "%"
                            }, o.animate);
                        }
                        if (oRange === "max" && this.orientation === "horizontal") {
                            this.range[animate ? "animate" : "css"]({
                                width: (100 - valPercent) + "%"
                            }, {
                                queue: false,
                                duration: o.animate
                            });
                        }
                        if (oRange === "min" && this.orientation === "vertical") {
                            this.range.stop(1, 1)[animate ? "animate" : "css"]({
                                height: valPercent + "%"
                            }, o.animate);
                        }
                        if (oRange === "max" && this.orientation === "vertical") {
                            this.range[animate ? "animate" : "css"]({
                                height: (100 - valPercent) + "%"
                            }, {
                                queue: false,
                                duration: o.animate
                            });
                        }
                    }
                };

            $.ui.slider.prototype._normValueFromMouse =
                function(position) {
                    var
                        o = this.options,
                        pixelTotal,
                        pixelMouse,
                        percentMouse,
                        valueTotal,
                        valueMouse;

                    if (this.orientation === "horizontal") {
                        pixelTotal = this.elementSize.width - (o.paddingMin + o.paddingMax);
                        pixelMouse = position.x - this.elementOffset.left - o.paddingMin - (this._clickOffset ? this._clickOffset.left : 0);
                    } else {
                        pixelTotal = this.elementSize.height - (o.paddingMin + o.paddingMax);
                        pixelMouse = position.y - this.elementOffset.top - o.paddingMin - (this._clickOffset ? this._clickOffset.top : 0);
                    }

                    percentMouse = (pixelMouse / pixelTotal);
                    if (percentMouse > 1) {
                        percentMouse = 1;
                    }
                    if (percentMouse < 0) {
                        percentMouse = 0;
                    }
                    if (this.orientation === "vertical") {
                        percentMouse = 1 - percentMouse;
                    }

                    valueTotal = this._valueMax() - this._valueMin();
                    valueMouse = this._valueMin() + percentMouse * valueTotal;

                    return this._trimAlignValue(valueMouse);
                };
        }
    )(jQuery);
    var vpsnameval = new Array('VPS8', 'VPS7', 'VPS6', 'VPS5', 'VPS4', 'VPS3', 'VPS2', 'VPS1'); //VPS plan names
    var memoryval = new Array('8GB', '7GB', '6GB', '5GB', '4GB', '3GB', '2GB', '1GB'); //Memory array per plan
    var cpuval = new Array('8 CPU Core', '7 CPU Cores', '6 CPU Cores', '5 CPU Cores', '4 CPU Cores', '3 CPU Cores', '2 CPU Cores', '1 CPU Cores'); //CPU array per plan
    var diskspaceval = new Array('800GB', '700GB', '600GB', '500GB','400GB', '300GB', '200GB', '100GB'); //Disk Space array per plan
    var bandwidthval = new Array('8000GB', '7000GB', '6000GB', '5000GB','4000GB', '3000GB', '2000GB', '1000GB'); //Bandwidth array per plan
    var decimalval = new Array('.00', '.00', '.00', '.00', '.00', '.00', '.00', '.00'); //Decimal array per plan

    var priceval = new Array('249', '219', '189', '159','129', '99', '69', '39'); //Price array per plan
    var urlval = new Array('8', '7', '6', '5','4', '3', '2', '1'); //WHMCS pid array per plan

    var finalurl = 'http://domain.com/cart.php?a=add&pid='; //Update "domain.com" with your WHMCS installation URL

    var starting_point = 7; //Where the slider stops on first page load. Ideal to sign a plan as popular.

   $(document).ready(function() {

        $("#vps-slider").slider({
            isRTL: true,
            range: 'min',
            animate: true,
            min: 1,
            max: 8, //Update this if you less or more plans
            paddingMin: 0,
            paddingMax: 0,
            slide: function(event, ui) {
                $('.vps-prices-container #vps_name_option span.how_much').html(vpsnameval[ui.value - 1]);
                $('.vps-prices-container #disk_space_option span.how_much').html(diskspaceval[ui.value - 1]);
                $('.vps-prices-container #memory_option span.how_much').html(memoryval[ui.value - 1]);
                $('.vps-prices-container #cpu_option span.how_much').html(cpuval[ui.value - 1]);
                $('.vps-prices-container #bandwidth_option span.how_much').html(bandwidthval[ui.value - 1]);
                $('.vps-prices-container #price_amount').html(priceval[ui.value - 1]);
                $('.vps-prices-container a.order-vps').attr('href', finalurl + urlval[ui.value - 1]);

                $('.vps-prices-container #decimal').html(decimalval[ui.value - 1]);

            },
            change: function(event, ui) {
                $('.vps-prices-container #vps_name_option span.how_much').html(vpsnameval[ui.value - 1]);
                $('.vps-prices-container #disk_space_option span.how_much').html(diskspaceval[ui.value - 1]);
                $('.vps-prices-container #memory_option span.how_much').html(memoryval[ui.value - 1]);
                $('.vps-prices-container #cpu_option span.how_much').html(cpuval[ui.value - 1]);
                $('.vps-prices-container #bandwidth_option span.how_much').html(bandwidthval[ui.value - 1]);
                $('.vps-prices-container #price_amount').html(priceval[ui.value - 1]);
                $('.vps-prices-container a.order-vps').attr('href', finalurl + urlval[ui.value - 1]);
                $('.vps-prices-container #decimal').html(decimalval[ui.value - 1]);
            }

           });


        $("#amount").val("$" + $("#vps-slider").slider("value"));
        $('#vps-slider').slider('value', starting_point);
        $('.vps-plan').click(function() {
            tt_amount = parseInt(this.id.slice(5)) + 1;
            $('#vps-slider').slider('how_much', tt_amount);
        });
    });
    </script>

@stop
