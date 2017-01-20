$(window).resize(function()
{
    var height = $('#wrapper').height() - $('#input').height();
    var width = $('#wrapper').width();
    $('#map').highcharts().setSize(width, height, doAnimation = false);
});

function load(make_log_entry)
{
    if (make_log_entry === undefined)
        make_log_entry = true;
	// get value of data selection list
	var year = document.getElementById('list-year').value;
    var data = document.getElementById('list-data').value;
    var gender = document.getElementById('list-gender').value;
    var ownership = document.getElementById('list-ownership').value;
    var filter = document.getElementById('list-filter').value;

    var link = 'query.php?make_log_entry=' + make_log_entry
                                        + '&year=' + year
                                        + '&data=' + data
                                        + '&gender='+ gender
                                        + '&ownership=' + ownership
                                        + '&filter=' + filter;
    console.log(link);
	$.getJSON(link, draw_map);
}

function draw_map(source)
{
    // Display title as: CSEE <year> <dataset>
    var text_title = "CSEE " + $('#list-year option:selected').text() + " " + $('#list-data option:selected').text();
    // Display subtitle as: Gender: <gender> | Filter: <filter>
    var text_subtitle = "Gender: " + $('#list-gender option:selected').text()
                                + ' | Ownership: ' + $('#list-ownership option:selected').text()
                                + ' | Filter: ' + $('#list-filter option:selected').text();

	var properties = 
	{
        title:
        {
            text: text_title
        },

        subtitle:
        {
            text: text_subtitle
        },

        mapNavigation:
        {
            enabled: true,
            buttonOptions:
            {
                verticalAlign: 'middle'
            }
        },
		
        colorAxis: 
        {
            min: source.min,
            max: source.max
        },

        series: 
        [{
            data: source.data,
            mapData: Highcharts.maps['countries/tz/tz-all'],
            joinBy: 'hc-key',
            name: $('#list-data option:selected').text(),
            states:
            {
                hover:
                {
                    color: '#36B35B'
                }
            },
            dataLabels:
            {
                enabled: true,
                format: '{point.name}'
            },
            tooltip:
            {
                pointFormat: '{point.name}: {point.value:.1f}%'
            }
        }]
    }

	// Initiate the chart
    $('#map').highcharts('Map', properties);
}

$(function()
{
    load(make_log_entry = false);
});
