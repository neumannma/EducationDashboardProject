$(window).resize(function()
{
    var height = $('#wrapper').height() - $('#list-div').height();
    var width = $('#wrapper').width();
    $('#map').highcharts().setSize(width, height, doAnimation = false);
});

function load()
{
	// get value of data selection list
	var year = document.getElementById('list-year').value;
    var data = document.getElementById('list-data').value;
    var gender = document.getElementById('list-gender').value;
    var filter = document.getElementById('list-filter').value;
	$.getJSON('query.php?year=' + year + '&data=' + data + '&gender=' + gender + '&filter=' + filter, draw_map);
}

function draw_map(source)
{
    var text_subtitle = $('#list-year option:selected').text() + ' | ' + 
                        $('#list-data option:selected').text() + ' | ' + 
                        $('#list-gender option:selected').text() + ' | ' + 
                        $('#list-filter option:selected').text();
	var properties = 
	{
        title:
        {
            text: 'Region Averages'
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
            name: 'Region Averages',
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
            }
        }]
    }

	// Initiate the chart
    $('#map').highcharts('Map', properties);
}

$(function()
{
    load();
});
