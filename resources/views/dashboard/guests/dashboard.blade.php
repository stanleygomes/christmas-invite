
<div id="dashboard" class="full-width">
    <div class="full-width">
        <div id="chart_div" class="panel-shadow background-white border-radius-5"></div>
    </div>
</div>

@section('scriptschart')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
         ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average', 'Average2'],
         ['2004/05',  165,      938,         522,             998,           450,      614.6, 569.6],
         ['2005/06',  135,      1120,        599,             1268,          288,      682, 614.6],
         ['2006/07',  157,      1167,        587,             807,           397,      623, 614.6],
         ['2007/08',  139,      1110,        615,             968,           215,      609.4, 614.6],
         ['2008/09',  136,      691,         629,             1026,          366,      569.6, 614.6]
      ]);

    var options = {
      titles: 'Monthly Coffee Production by Country',
      height: 200,
      vAxis: {title: 'Cups'},
      hAxis: {title: 'Month'},
      seriesType: 'bars',
      series: {
          5: {type: 'line'}
            ,
            6: {type: 'line'}
        }
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }



    //   // Load the Visualization API and the corechart package.
    //   google.charts.load('current', {'packages':['corechart']});

    //   // Set a callback to run when the Google Visualization API is loaded.
    //   google.charts.setOnLoadCallback(drawChart);

    //   // Callback that creates and populates a data table,
    //   // instantiates the pie chart, passes in the data and
    //   // draws it.
    //   function drawChart() {

    //     // Create the data table.
    //     var data = new google.visualization.DataTable();
    //     data.addColumn('string', 'Topping');
    //     data.addColumn('number', 'Slices');
    //     data.addRows([
    //       ['Mushrooms', 3],
    //       ['Onions', 1],
    //       ['Olives', 1],
    //       ['Zucchini', 1],
    //       ['Pepperoni', 2]
    //     ]);

    //     // Set chart options
    //     var options = {'title':'How Much Pizza I Ate Last Night',
    //                    'width':800,
    //                    'height':600};

    //     // Instantiate and draw our chart, passing in some options.
    //     var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    //     chart.draw(data, options);
    //   }
    </script>

@endsection
