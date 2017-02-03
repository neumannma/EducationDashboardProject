function is_mobile()
{
    var mq = window.matchMedia("only screen and (max-width: 768px)");
    return mq.matches;
}


// Ensure that the map responds properly when the window is resized
$(window).resize(function()
{
    var witdh;
    var height;
    if (is_mobile())    // mobile
    {
        var height = $('#wrapper').height() - $('#input').height();
        var width = $('#wrapper').width();
    }
    else                // desktop
    {
        var height = $('#wrapper').height();
        var width = $('#wrapper').width() - $('#input').width();
    }
    $('#map').highcharts().setSize(width, height, doAnimation = false);
});


// Link the values of the corresponding inputs for the desktop and mobile page layouts
function link_inputs()
{
    function get_button(id)
    {
        var elts = document.getElementById(id).children;
        for (var i = 0; i < elts.length; i++)
            if (elts[i].checked)
                return elts.item(i).value;
    }

    function set_button(id, val)
    {
        var elts = document.getElementById(id).children;
        for (var i = 0; i < elts.length; i++)
            if (elts[i].value == val)
            {
                elts[i].checked = true;
                break;
            }
    }

    if (is_mobile())
    {
        set_button('radio-gender', document.getElementById('list-gender').value);
        set_button('radio-ownership', document.getElementById('list-ownership').value);
        set_button('radio-filter', document.getElementById('list-filter').value);
    }
    else
    {
        document.getElementById('list-gender').value = get_button('radio-gender');
        document.getElementById('list-ownership').value = get_button('radio-ownership');
        document.getElementById('list-filter').value = get_button('radio-filter');
    }
}


// Execute AJAX request to fetch map data
// Runs when the page loads or when the submit button is pressed
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


// Invoke HighCharts to render the map
function draw_map(source)
{
    // Display title as: CSEE <year> <dataset>
    var text_title = "CSEE " + $('#list-year option:selected').text() + " " + $('#list-data option:selected').text();
    // Display subtitle as: Gender: <gender> | Filter: <filter>
    var text_subtitle = "Gender: " + $('#list-gender option:selected').text()
                                + ' | Ownership: ' + $('#list-ownership option:selected').text()
                                + ' | Candidates: ' + $('#list-filter option:selected').text();

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