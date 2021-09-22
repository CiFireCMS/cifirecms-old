<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols cols-full">
    <div class="colleft">
        <div class="box">
            <div class="page-contact">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <h3>CONTACT INFORMATION</h3>
                        <div class="contact-information">
                            <div><?=htmlspecialchars_decode($this->settings->website('address'))?></div>
                            <hr>
                            <ul class="list-infomation">
                                <li>
                                    <p><i class="fa fa-envelope"></i> <?=$this->settings->website('web_email')?></p>
                                </li>
                                <li>
                                    <p><i class="fa fa-phone"></i> <?=$this->settings->website('tlpn')?></p>
                                </li>
                                <li>
                                    <p><i class="fa fa-fax"></i> <?=$this->settings->website('fax')?></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <?php
                            $this->alert->show('contact');
                            echo form_open('','autocomplete="on"');
                        ?>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="field-item">
                                        <input type="text" name="name_contact" placeholder="Name" />
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="field-item">
                                        <input type="email" name="email_contact" placeholder="Email" />
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="field-item">
                                        <input type="text" name="subject_contact" placeholder="Subject" />
                                    </div>
                                </div>
                            </div>
                            <div class="field-item">
                                <textarea name="message_contact" placeholder="Text here..."></textarea>
                            </div>
                            <div class="field-item">
                                <div class="g-recaptcha pull-right" data-sitekey="<?=$this->settings->website('recaptcha_site_key')?>" style="margin-bottom:5px;"></div>
                                <button class="my-btn pull-left"><i class="fa fa-send"> </i> SEND</button>
                            </div>
                        <?=form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4aoOIudqSItjwJmznfbFFjMiieOTRFv8"></script>
    <script src="<?//$this->CI->theme_asset('js/map.js');?>"></script>
<script>
    (function ($) {
        "use strict";
        function initialize() {
            var _location = new google.maps.LatLng(1.447399,124.8308443);
            var _mapOption = {
                zoom: 16,
                center: _location,
                styles: [
                    { "featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{ "color": "#444444" }] },
                    { "featureType": "landscape", "elementType": "all", "stylers": [{ "color": "#f2f2f2" }] },
                    { "featureType": "poi", "elementType": "all", "stylers": [{ "visibility": "on" }] },
                    { "featureType": "poi", "elementType": "geometry.fill", "stylers": [{ "saturation": "-100" }, { "lightness": "57" }] },
                    { "featureType": "poi", "elementType": "geometry.stroke", "stylers": [{ "lightness": "1" }] },
                    { "featureType": "poi", "elementType": "labels", "stylers": [{ "visibility": "off" }] },
                    { "featureType": "road", "elementType": "all", "stylers": [{ "saturation": -100 }, { "lightness": 45 }] },
                    { "featureType": "road.highway", "elementType": "all", "stylers": [{ "visibility": "simplified" }] },
                    { "featureType": "road.arterial", "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] },
                    { "featureType": "transit", "elementType": "all", "stylers": [{ "visibility": "off" }] },
                    { "featureType": "transit.station.bus", "elementType": "all", "stylers": [{ "visibility": "on" }] },
                    {
                    "featureType": "transit.station.bus", "elementType": "labels.text.fill", "stylers": [{ "saturation": "0" },
                    { "lightness": "0" },
                    { "gamma": "1.00" },
                    { "weight": "1" },
                    { "color": "#7b7b7b" }]
                    },
                    { "featureType": "transit.station.bus", "elementType": "labels.icon", "stylers": [{ "saturation": "-100" }, { "weight": "1" }, { "lightness": "0" }] },
                    { "featureType": "transit.station.rail", "elementType": "all", "stylers": [{ "visibility": "on" }] },
                    { "featureType": "transit.station.rail", "elementType": "labels.text.fill", "stylers": [{ "gamma": "1" }, { "lightness": "40" }] },
                    { "featureType": "transit.station.rail", "elementType": "labels.icon", "stylers": [{ "saturation": "-100" }, { "lightness": "30" }] },
                    { "featureType": "water", "elementType": "all", "stylers": [{ "color": "#d2d2d2" }, { "visibility": "on" }] }
                ]
            };

            // var contentString = "";
            // var infowindow = new google.maps.InfoWindow({
            //     content: contentString
            // });
            var _map = new google.maps.Map(document.getElementById('map'), _mapOption);

            var marker = new google.maps.Marker({
                position: _location,
                map: _map,
                // title: '',
                // icon: image
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    })(jQuery);
</script>
<?php $this->CI->render_view('footer'); ?>