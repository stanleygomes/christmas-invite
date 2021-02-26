@extends('layouts.dashboard')

@section('page_title', 'Confirm presence')
@section('menu_confirm', 'active')

@section('styles')

<link rel="stylesheet" href="{{ env('APP_URL_PREFIX') }}css/christmas-lights.css?v={{ env('APP_VERSION') }}" type="text/css" />

@endsection

@section('content')

<style>
    body {
        background: #284d6a;
        /* background: #eee url('{{ env('APP_URL_PREFIX') }}img/vancouver-club-full.jpg') no-repeat center; */
        /* background-size: cover; */
    }

    #confirm .top-wall {
        height: 300px;
        background: #284d6a url('{{ env('APP_URL_PREFIX') }}uploads/events/{{ $event->id }}/{{ $event->id }}.png') no-repeat center bottom;
        background-size: contain;
    }

    #confirm .confirm-content {
        position: relative;
        /* margin-top: -50px; */
        margin-bottom: 100px;
        border-radius: 0 0 5px 5px !important;
    }

    #confirm .logo {
        max-width: 150px;
        margin: 15px 0;
    }

    #confirm .textarea {
        height: 200px;
    }

    #confirm .radio-button-confirm {
        min-width: 70px;
        padding: 5px;
        border-radius: 3px;
        font-size: 14px;
        display: inline-block;
        color: #888;
        font-weight: bold;
        background: #e5e5e5;
    }

    #confirm .radio-button-confirm-padding {
        padding: 15px 0;
    }

    #confirm .radio-button-confirm:hover {
        color: #555;
        background: #ccc;
    }

    #confirm .radio-huge {
        width: 20px;
        height: 20px;
    }

    @media(max-width:768px) {
        .xs-no-padding {
            padding: 0 !important
        }

        #confirm .top-wall {
            height: 200px;
            background-size: cover;
        }
    }

    .form-error {
        z-index: 10;
        position: fixed;
        top: 0;
        left: 0;
        padding: 15px;
        background: #fff;
        display: none;
    }

    .form-error .alert-icon {
        width: 50px;
    }

    .form-error .alert-message {
        margin-top: 15px;
    }

    .btn-min {
        margin-top: 15px;
        padding: 5px;
    }

    .waiver-option {
        padding: 10px;
        border-radius: 3px;
        border: 2px solid transparent;
    }

    .waiver-alert {
        color: #f00;
        padding: 10px;
        border-radius: 3px;
        border: 2px solid #f00;
    }

    #companion-data {
        display: none;
    }
</style>

<div id="form-error" class="full-width form-error text-center shadow-super">
    <div class="container">
        <div class="col-sm-12">
            <img src="{{ env('APP_URL_PREFIX') }}img/alert-icon.png" alt="" class="alert-icon" />
        </div>
        <div class="col-sm-12">
            <div id="form-error-message" class="alert-message"></div>
        </div>
        <!--
        <div class="col-sm-12">
            <div id="form-error-message-close" class="alert-close">
                <button class="btn btn-default btn-min">OK! Close.</button>
            </div>
        </div>
        -->
    </div>
</div>

<div id="confirm" class="full-width">
    <div class="container xs-no-padding">
        <div class="col-sm-8 col-sm-offset-2 xs-no-padding">
            <div class="full-width top-wall">
                <!--
                    <ul class="lightrope">
                        <li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
                    </ul>
                    -->
            </div>
        </div>
    </div>
    <div class="container xs-no-padding">
        <div class="col-sm-8 col-sm-offset-2 xs-no-padding">
            <div class="full-width text-center confirm-content panel-shadow background-white border-radius-5 padding-v-30">
                <img src="{{ env('APP_URL_PREFIX') }}img/logo.png" class="logo" />
                @if ($lastHistory->status_id == 2)
                <h3><strong class="color-primary">{{ $lastHistory->name }}</strong>, will you join us?</h3>
                @else
                <h3><strong class="color-primary">{{ $lastHistory->name }}</strong>, thanks for your confirmation!</h3>
                <p>See you there!</p>
                <a href="https://www.google.com/calendar/render?action=TEMPLATE&text={{ utf8_encode($event->name) }}&dates={{ $event->date ? $event->date->format('Ymd') : '' }}T200000Z/{{ $event->date ? $event->date->addDays(1)->format('Ymd') : '' }}T010000Z&location={{ utf8_encode($event->place) }}&details=&sf=true&output=xml&ctz=America/Vancouver" target="_blank">
                    <button type="button" class="btn btn-primary btn-min">Add to google calendar</button>
                </a>
                <!-- https://outlook.live.com/owa/?path=/calendar/action/compose&rru=addevent&startdt=2018-05-24T12%3A00%3A00-05%3A00&enddt=2018-05-24T12%3A30%3A00-05%3A00&subject={{ utf8_encode($event->name) }}&body={{ utf8_encode($event->place) }} -->
                <a href="{{ env('APP_URL_PREFIX') }}uploads/hevvy-christimas.ics" data-toggle="tooltip" title="This will download a .ics file to create a event reminder in your calendar." download>
                    <button type="button" class="btn btn-primary btn-min">Add to outlook calendar</button>
                </a>
                @endif
                <hr class="full-width margin-top-15 margin-bottom-15" style="background:#ddd" />
                @if ($lastHistory->status_id == 2)
                <form id="form" class="full-width formulario formulary" method="post" action="">
                    {!! csrf_field() !!}
                    <strong class="full-width text-center title">PLEASE READ AND CONFIRM</strong>
                    <em>Will take only 2 min.</em>
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="full-width">
                            <textarea class="full-width txt pass margin-top-15 textarea" readonly name="waiver" autocomplete="off">{{ $waiver }}</textarea>
                        </div>
                    </div>
                    <p class="full-width margin-top-15">
                        <div class="full-width">
                            <label>Menu</label>
                            <p>please select your main course choice</p>
                        </div>
                        <div class="full-width">
                            <div class="col-sm-10 col-sm-offset-1">
                                @foreach($foodTypes as $key => $foodType)
                                <label for="guestfood{{ $key }}" class="full-width radio-button-confirm radio-button-confirm-padding">
                                    <div class="col-sm-2 margin-top-15">
                                        <input class="radio-huge" id="guestfood{{ $key }}" type="radio" name="guest_food" class="gestfood" value="{{ $foodType->id }}" />
                                    </div>
                                    <div class="col-sm-10 margin-top-15">
                                        <p style="text-align: justify">
                                            {!! str_replace(';', '<br />', $foodType->food_type) !!}
                                        </p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </p>
                    <p class="full-width margin-top-15">
                        <div class="full-width">
                            <label>Will you be bringing a guest?</label>
                        </div>
                        <div class="full-width">
                            <label for="companionyes" class="radio-button-confirm radio-button-confirm-green">
                                <input id="companionyes" type="radio" name="companion" value="1" /> YES
                            </label>
                            <label for="companionno" class="radio-button-confirm radio-button-confirm-red">
                                <input id="companionno" type="radio" name="companion" value="2" checked /> NO
                            </label>
                        </div>
                    </p>
                    <div id="companion-data">
                        <p class="full-width margin-top-15">
                            <div class="full-width">
                                <label>Guest's name</label>
                            </div>
                            <div class="full-width">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <input type="text" class="full-width text-center txt" name="companion_name" placeholder="Enter name here..." />
                                </div>
                            </div>
                        </p>
                        <p class="full-width margin-top-15">
                            <div class="full-width">
                                <label>Menu</label>
                                <p>please select your <strong>guest's</strong> main course choice</p>
                            </div>
                            <div class="full-width">
                                <div class="col-sm-10 col-sm-offset-1">
                                    @foreach($foodTypes as $key => $foodType)
                                    <label for="companionfood{{ $key }}" class="full-width radio-button-confirm radio-button-confirm-padding">
                                        <div class="col-sm-2 margin-top-15">
                                            <input class="radio-huge" id="companionfood{{ $key }}" type="radio" name="companion_food" class="companionfood" value="{{ $foodType->id }}" />
                                        </div>
                                        <div class="col-sm-10 margin-top-15">
                                            <p style="text-align: justify">
                                                {!! str_replace(';', '<br />', $foodType->food_type) !!}
                                            </p>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </p>
                    </div>
                    <p class="full-width margin-top-15">
                        <div class="full-width">
                            <label>Any allergies / dietary restrictions</label>
                            <p>Please describe in the space below</p>
                        </div>
                        <div class="full-width">
                            <div class="col-sm-10 col-sm-offset-1">
                                <input type="text" class="full-width text-center txt" name="allergies" placeholder="If apply, enter here" />
                            </div>
                        </div>
                    </p>
                    <div class="col-sm-10 col-sm-offset-1">
                        <p id="waiverconfirmbox" class="full-width margin-top-15 waiver-option">
                            <input id="waiverconfirm" type="checkbox" name="send" />
                            <label for="waiverconfirm">
                                <em>I agree with this waiver and confirm.</em>
                            </label>
                        </p>
                    </div>
                    <div class="full-width">
                        <button type="submit" id="button-confirm" class="btn btn-success showloading">CONFIRM</button>
                    </div>
                </form>
                <hr class="full-width margin-top-15 margin-bottom-15" style="background:#ddd" />
                @endif
                <div>
                    <div class="col-sm-12">
                        <p class="full-width"><strong>{{ $event->name }}</strong></p>
                        <div class=" full-width margin-top-15" style="font-size: 15px;">
                            <p><strong>Date:</strong> {{ $event->date ? $event->date->format('M d\n\d Y') : '' }}</p>
                            <p><strong>Start time:</strong> {{ $event->date && $event->date->format('H:i') != '00:00' ? (int)$event->date->format('h').':'.$event->date->format('ia') : '' }}</p>
                            <p><strong>Place:</strong> {{ $event->place }}</strong></p>
                            <p class="full-width" style="margin: 15px 0"><strong>Dress to impress</strong></p>
                            <div class="full-width" style="margin-bottom: 30px;">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ utf8_encode($event->place) }}" target="_blank">
                                    <button class="btn btn-primary btn-min">Click to get directions</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="map" class="full-width border-radius-2 border-2">
                            <div class="to" value=""></div>
                            <div class="marker" value="{{ $event->place }}"></div>
                            <div id="contentmap" class="full-width" style="height:300px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
<ul class="lightrope">
    <li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
</ul>
-->

@endsection

@section('scripts')

<script src="{{ env('APP_URL_PREFIX') }}js/snow.js?v={{ env('APP_VERSION') }}"></script>
<script src="{{ env('APP_URL_PREFIX') }}js/gmap3.js?v={{ env('APP_VERSION') }}"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyD8JUHkBGbsHg52zzjxxq0SSEUMV4z2eUE&sensor=false&amp;language=en"></script>

<script>
    var KMAPpointer = $("#map").find(".pointer").attr("url"),
        KMAPmarker = $("#map").find(".marker").attr("value"),
        KMAPto = $("#map").find(".to").attr("value");

    //marker
    $("#contentmap").gmap3({
            map: {
                options: {
                    maxZoom: 16
                }
            },
            marker: {
                address: KMAPmarker
            }
        },
        "autofit");

    $(window).load(function() {
        if ($("#contentmap").length > 0) {
            $("#contentmap").gmap3({
                marker: {
                    address: KMAPmarker
                },
                map: {
                    options: {
                        zoom: 16,
                        scrollwheel: false
                    }
                }
            });
        }
    })

    // form validation
    const errorMessages = {
        menuChoiseInvalid: 'Please, enter enter your menu choice.',
        companionNameInvalid: 'Please, enter your guest\'s name.',
        menuChoiseCompanionFoodInvalid: 'Please, enter your guest\'s menu choise.',
        agreedInvalid: 'Please, read the waiver and check agree option above.'
    }

    const getCompanionName = () => {
        return $('input[name="companion_name"]').val()
    }

    const getCompanionFood = () => {
        return $('input[name="companion_food"]:checked').val()
    }

    const getCompanion = () => {
        return $('input[name="companion"]:checked').val()
    }

    const getGuestFood = () => {
        return $('input[name="guest_food"]:checked').val()
    }

    const getAgreed = () => {
        return $('input[name="send"]:checked').val()
    }

    const setFormErrorMessage = (message) => {
        $('#form-error-message').text(message)
    }

    const formErrorShow = (message) => {
        if (message != null) {
            $('#form-error').fadeIn('fast')
            setFormErrorMessage(message)
            formErrorHideAutomatic()
        } else {
            $('#form-error').fadeOut('fast')
            setFormErrorMessage('')
        }
    }

    const formErrorHideAutomatic = () => {
        setTimeout(() => {
            formErrorShow()
        }, 4000)
    }

    const validateForm = () => {
        const guestFood = getGuestFood()
        const companion = getCompanion()
        const companionName = getCompanionName()
        const companionFood = getCompanionFood()
        const agreed = getAgreed()

        if (guestFood == null) {
            formErrorShow(errorMessages.menuChoiseInvalid)
            return false
        }

        // only a 'yes' is capable of validate
        if (companion == 1) {
            if (companionName == null) {
                formErrorShow(errorMessages.companionNameInvalid)
                return false
            }

            if (companionFood == null) {
                formErrorShow(errorMessages.menuChoiseCompanionFoodInvalid)
                return false
            }
        }

        if (agreed != 'on') {
            formErrorShow(errorMessages.agreedInvalid)
            $('#waiverconfirmbox').addClass('waiver-alert')
            return false
        }

        $('#button-confirm').text('Please, wait...')

        return true
    }

    const companionDataShow = () => {
        const companion = getCompanion()

        if (companion == 1) {
            // yes
            $('#companion-data').fadeIn('fast')
        } else if (companion == 2) {
            // no
            $('#companion-data').fadeOut('fast')
        }
    }

    const submit = () => {
        return validateForm()
    }

    $('#form-error-message-close').click(() => {
        formErrorShow()
    })

    $('form#form').submit((event) => {
        const status = submit()

        if (status == false) {
            event.preventDefault();
        }
    })

    $('input[name="companion"]').change(() => {
        companionDataShow()
    })

    $('#waiverconfirm').change(() => {
        var agreed = getAgreed()

        if (agreed == 'on') {
            $('#waiverconfirmbox').removeClass('waiver-alert')
        } else if (agreed != 'on') {
            $('#waiverconfirmbox').addClass('waiver-alert')
        }
    })
</script>

@endsection
