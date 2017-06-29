// for triggering vscode type acquisition
// remove if this causes problems
function require(str) {}
require('jquery');
require('highcharts');

var description = {
    normal:     'Total number of students',
    percent:    'Percentage of students'
}

var dictionary = {
    'I':            'Division I',
    'DISTINCTION':  'Division I',
    'II':           'Division II',
    'MERIT':        'Division II',
    'III':          'Division III',
    'PASS':         'Division III',
    'IV':           'Division IV',
    'CREDIT':       'Division IV',
    '0':            'Failed',
    'FLD':          'Failed',
    'FAIL':         'Failed',
    '-':            'Failed',
    'ABS':          'Absent',
    '*E':           '*E',
    '*R':           '*R',
    '*W':           '*W'
};

// HighCharts object
var chart;

// UI state
var state = {
    // server
    necta: 's0101',
    gender: 'all',

    // client
    yAxis: 'normal'    // one of: 'normal', 'percent'
};

var properties = {
        chart: {
            type: 'column'
        },

        title: {
            text: 'Stacked column chart'
        },

        // xAxis: {
        //     categories: []
        // },

        yAxis: {
            min: 0,
            title: {
                text: state.yAxis == 'normal' ? 'Total number of students' : 'Percentage of students'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },

        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: false,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },

        tooltip: {
            shared: false,
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>'
        },

        plotOptions: {
            column: {
                stacking: state.yAxis,
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
            }
        },

        // series: []
};

// UI EVENT HANDLERS

    // show menu button: click
    $('#barchart_menu_show').click(function() {
        $('#barchart_menu').show();
    });

    // hide menu button: click
    $('#barchart_menu_hide').click(function() {
        $('#barchart_menu').hide();
    });

    // toggle display type from total to percentage
    $('input[name="barchart_menu_display"]').change(function() {
        state.yAxis = $('input[name="barchart_menu_display"]:checked').val();
        chart.update({
            yAxis: {
                title: {
                    text: state.yAxis == 'normal' ? 'Total number of students' : 'Percentage of students'
                }
            },
            plotOptions: {
                column: {
                    stacking: state.yAxis
                }
            }
        });
    });

    $('#barchart_menu_necta').change(function() { state.necta = $(this).val(); });
    $('#barchart_menu_gender').change(function() { state.gender = $(this).val(); });
    $('#barchart_menu_submit').click( loadChart );

// END UI EVENT HANDLERS

/**
 * Redraw the graph to fill all available space when the window size changes.
 */
$(window).resize(function() {
    var width;
    var height;
    var wrapper = $('#EDPBarchart');
    height = $(window).height() - $('#barchart_ui').height();
    width = wrapper.width();
    chart.setSize(width, height, doAnimation = false);
});

/**
 * Takes the JSON object returned by query.php and adapt it
 * for use by HighCharts.
 * @param {Object} data
 */
function parseData(data) {

    var result = {
        xAxis: [],
        series: []
    };

    var numYears = Object.keys(data).length;
    var zeros = [];
    while (zeros.push(0) < numYears);

    var divisions = {
        'Division I': zeros.slice(),
        'Division II': zeros.slice(),
        'Division III': zeros.slice(),
        'Division IV': zeros.slice(),
        'Failed': zeros.slice(),
        'Absent': zeros.slice(),
        '*E': zeros.slice(),
        '*R': zeros.slice(),
        '*W': zeros.slice()
    };

    // parse the data for each year
    var i = 0;
    for (var year in data) {

        // include this year in the x axis
        result.xAxis.push(year);

        // place each division data element in the proper array
        for (var elt in data[year]) {
            divisions[ dictionary[data[year][elt]['division']] ][i] = parseInt(data[year][elt]['value']);
        }
        i++;
    }

    // format the data as a HighCharts series
    for (var div in divisions) {
        result.series.push({name: div, data: divisions[div]});
    }

    console.log(JSON.stringify(data, null, 2));
    console.log(JSON.stringify(result, null, 2));
    for (var year in result.series) {
        console.log(result.series[year].data.length);
    }

    return result;
}

/**
 * Issues an AJAX request to query.php, hands the resulting
 * object in a callback to drawChart().
 * @param {boolean} log
 */
function loadChart(log) {
    var necta = 's0101';
    var gender = 'all';
    var start = '2003';
    var end = '2016';

    var link = 'query.php?necta=' + state.necta
                                + '&gender=' + state.gender
                                + '&start=' + start
                                + '&end=' + end;
    console.log(link);
    $.getJSON(link, drawChart);
}

/**
 * Redraws the HighCharts object using the data returned by query.php.
 * @param {Object} data
 */
function drawChart(data) {

    // format the data
    data = parseData(data);

    // create the HighCharts properties objects containing data & rendering options
    properties.xAxis = {categories: data.xAxis};
    properties.yAxis.text = state.yAxis == 'normal' ? description.normal : description.percent;
    properties.series = data.series;
    properties.plotOptions.column.stacking = state.yAxis;

    chart = Highcharts.chart('barchart', properties);
}

$(function() {
    chart = Highcharts.chart('barchart', properties);
    loadChart(null);
});