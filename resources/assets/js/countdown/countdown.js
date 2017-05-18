import jQuery from 'jquery';

window.jQuery = window.$ = jQuery;

jQuery.extend( jQuery.easing,
    {
        easeInOutQuad: function (t) { return t<.5 ? 2*t*t : -1+(4-2*t)*t },
        easeOutQuad: function (t) { return t*(2-t) },
    });

// Start date
const targetDate = new Date("2017/06/05 10:00:00");

// Other date related constiables
let days;
let hrs;
let min;
let sec;

$(function() {
    // Calculate time until launch date
    timeToLaunch();
    // Transition the current countdown from 0
    numberTransition('#days .number', days, 1000, 'easeOutQuad');
    numberTransition('#hours .number', hrs, 1000, 'easeOutQuad');
    numberTransition('#minutes .number', min, 1000, 'easeOutQuad');
    numberTransition('#seconds .number', sec, 1000, 'easeOutQuad');
    // Begin Countdown
    setTimeout(countDownTimer,1001);
});

function timeToLaunch(){
    // Get the current date
    const currentDate = new Date();

    // Find the difference between dates
    let diff = (currentDate - targetDate)/1000;
    diff = Math.abs(Math.floor(diff));

    // Check number of days until target
    days = Math.floor(diff/(24*60*60));
    sec = diff - days * 24*60*60;

    // Check number of hours until target
    hrs = Math.floor(sec/(60*60));
    sec = sec - hrs * 60*60;

    // Check number of minutes until target
    min = Math.floor(sec/(60));
    sec = sec - min * 60;
}

function countDownTimer(){

    // Figure out the time to launch
    timeToLaunch();

    // Write to countdown component
    $( "#days .number" ).text(days);
    $( "#hours .number" ).text(hrs);
    $( "#minutes .number" ).text(min);
    $( "#seconds .number" ).text(sec);

    // Repeat the check every second
    setTimeout(countDownTimer,1000);
}

function numberTransition(id, endPoint, transitionDuration, transitionEase){
    // Transition numbers from 0 to the final number
    $({numberCount: $(id).text()}).animate({numberCount: endPoint}, {
        duration: transitionDuration,
        easing:transitionEase,
        step: function() {
            $(id).text(Math.floor(this.numberCount));
        },
        complete: function() {
            $(id).text(this.numberCount);
        }
    });
};
