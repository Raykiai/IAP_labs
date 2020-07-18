$(document).ready(function () {
    // Returns the number of minutes ahead or behind GMT
    let offset = new Date().getTimezoneOffset();

    //Return the number of milliseconds since 1970-01-01
    let timestamp = new Date().getTime();

    //Convert time to UTC
    let utc_timestamp = timestamp + (60000 * offset);

    $('#time_zone_offset').val(offset);
    $('#utc_timestamp').val(utc_timestamp);
})