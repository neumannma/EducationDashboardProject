// for triggering vscode type acquisition
// remove if this causes problems
function require(str) {}
require('jquery');
require('highcharts');

var state = {
    year: '2016',
    data: 'pass',
    gender: 'all',
    ownership: 'all',
    candidates: 'none'
};

function isMobile() {
    return window.matchMedia("only screen and (max-aspect-ratio: 1/1)").matches;
}

function getUrlParams() {
    var result = {};

    var url = window.location.href;     // get the whole URL
    url = url.split('?')[1];            // separate params from URL
    if (!url)
        return null;                    // return null if there are no params
    url = url.split('#')[0];            // separate params from heading navigation
    var paramArray = url.split('&');    // tokenize individual param=value pairs

    // store each param=value pair in 'result'
    paramArray.forEach(function(elt) {
        var temp = elt.split('=');
        temp[0] = temp[0].toLowerCase();
        temp[1] = temp[1].toLowerCase();
        result[temp[0]] = temp[1];
    });
    
    return result;
}

// Colorize the submit buttons when changes are made to the inputs
function highlightSubmit() {
    $('#edp_desktop_submit').addClass('highlight');
}

function submit() {
    $('#edp_desktop_submit').removeClass('highlight');
    $('#edp_mobile_menu').hide();
    loadMap();
}

function loadMap(make_log_entry) {
    if (make_log_entry === undefined)
        make_log_entry = true;

    var link = 'query.php?make_log_entry=' + make_log_entry
                                        + '&year=' + state.year
                                        + '&data=' + state.data
                                        + '&gender='+ state.gender
                                        + '&ownership=' + state.ownership
                                        + '&filter=' + state.candidates;
    console.log(link);
	$.getJSON(link, drawMap);
}

function drawMap(source) {
    // Display title as: CSEE <year> <dataset>
    var text_title = "CSEE " + $('#edp_mobile_year option:selected').text() + " " + $('#edp_mobile_data option:selected').text();
    // Display subtitle as: Gender: <gender> | Filter: <filter>
    var text_subtitle = "Gender: " + $('#edp_mobile_gender option:selected').text()
                                + ' | Ownership: ' + $('#edp_mobile_ownership option:selected').text()
                                + ' | Candidates: ' + $('#edp_mobile_filter option:selected').text();

	var properties = {
        title: {
            text: text_title
        },

        subtitle: {
            text: text_subtitle
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'middle'
            }
        },
		
        colorAxis: {
            min: source.min,
            max: source.max
        },

        series: [{
            data: source.data,
            mapData: Highcharts.maps['countries/tz/tz-all'],
            joinBy: 'hc-key',
            name: $('#edp_mobile_data option:selected').text(),
            states: {
                hover: {
                    color: '#36B35B'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            },
            tooltip: {
                pointFormat: '{point.name}: {point.value:.1f}%'
            }
        }]
    }

	// Initiate the chart
    $('#edp_map').highcharts('Map', properties);
}

// -- EVENT HANDLERS --

    // MOBILE

        // show menu button: click
        $('#edp_mobile_show').click(function() {
            $('#edp_mobile_menu').show();
        });

        // hide menu button: click
        $('#edp_mobile_hide').click(function() {
            $('#edp_mobile_menu').hide();
        });

        // year select: change
        $('#edp_mobile_year').change(function() {
            state.year = $(this).val();
            $('#edp_desktop_year').val(state.year);
            highlightSubmit();
        });

        // data select: change
        $('#edp_mobile_data').change(function() {
            state.data = $(this).val();
            $('#edp_desktop_data').val(state.data);
            highlightSubmit();
        });

        // gender select: change
        $('#edp_mobile_gender').change(function() {
            state.gender = $(this).val();
            $('input[name="edp_desktop_gender"][value="' + state.gender + '"]').prop("checked",true);
            highlightSubmit();
        });

        // ownership select: change
        $('#edp_mobile_ownership').change(function() {
            state.ownership = $(this).val();
            $('input[name="edp_desktop_ownership"][value="' + state.ownership + '"]').prop("checked",true);
            highlightSubmit();
        });

        // candidates select: change
        $('#edp_mobile_filter').change(function() {
            state.candidates = $(this).val();
            $('input[name="edp_desktop_filter"][value="' + state.candidates + '"]').prop("checked",true);
            highlightSubmit();
        });

        // submit button: click
        $('#edp_mobile_submit').click(function() {
            submit();
        });
    
    // DESKTOP

        // year select: change
        $('#edp_desktop_year').change(function() {
            state.year = $(this).val();
            $('#edp_mobile_year').val(state.year);
            highlightSubmit();
        });

        // data select: change
        $('#edp_desktop_data').change(function() {
            state.data = $(this).val();
            $('#edp_mobile_data').val(state.data);
            highlightSubmit();
        });

        // gender radio: change
        $('input[name="edp_desktop_gender"]').change(function() {
            state.gender = $('input[name="edp_desktop_gender"]:checked').val();
            $('#edp_mobile_gender').val(state.gender);
            highlightSubmit();
        });

        // ownership radio: change
        $('input[name="edp_desktop_ownership"]').change(function() {
            state.ownership = $('input[name="edp_desktop_ownership"]:checked').val();
            $('#edp_mobile_ownership').val(state.ownership);
            highlightSubmit();
        });

        // candidates radio: change
        $('input[name="edp_desktop_filter"]').change(function() {
            state.candidates = $('input[name="edp_desktop_filter"]:checked').val();
            $('#edp_mobile_filter').val(state.candidates);
            highlightSubmit();
        });

        // submit button: click
        $('#edp_desktop_submit').click(function() {
            submit();
        });

// -- EVENT HANDLERS --

$(window).resize(function() {
    var width;
    var height;
    var wrapper = $('#EducationDashboardProject');
    if (isMobile()) {
        height = $(window).height() - $('#edp_mobile').height();
        width = wrapper.width();
    }
    else {
        height = $(window).height();
        width = $(window).width() - $('#edp_desktop').width();
    }
    $('#edp_map').highcharts().setSize(width, height, doAnimation = false);
});

$(function() {
    // get starting state values
    var params = getUrlParams();
    if (params) {
        if (params.year) state.year = params.year;
        if (params.data) state.data = params.data;
        if (params.gender) state.gender = params.gender;
        if (params.ownership) state.ownership = params.ownership;
        if (params.candidates) state.candidates = params.candidates;
    }

    // get list of years
    $.getJSON('fetch-years.php', function(data) {
        data.forEach(function(year) {
            var option = $('<option value="' + year + '">' + year + '</option>');
            $('#edp_desktop_year').append('<option value=' + year + '>' + year + '</option>');
            $('#edp_mobile_year').append('<option value=' + year + '>' + year + '</option>');
        });

        $('#edp_desktop_year').val(state.year);
        $('#edp_desktop_data').val(state.data);
        $('input[name="edp_desktop_gender"][value="' + state.gender + '"]').prop("checked",true);
        $('input[name="edp_desktop_ownership"][value="' + state.ownership + '"]').prop("checked",true);
        $('input[name="edp_desktop_filter"][value="' + state.candidates + '"]').prop("checked",true);

        $('#edp_mobile_year').val(state.year);
        $('#edp_mobile_data').val(state.data);
        $('#edp_mobile_gender').val(state.gender);
        $('#edp_mobile_ownership').val(state.ownership);
        $('#edp_mobile_filter').val(state.candidates);

        loadMap(false);
    });
});