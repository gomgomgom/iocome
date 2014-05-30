Dashboard Page

    <script type="text/javascript">
      // google.load("visualization", "1", {packages:["corechart"]});
      google.load("visualization", "1", {packages:["corechart"], "callback" : drawChart});
      // google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
	<div id="piechart" style="width: 450px; height: 250px;"></div>
	
	
	
	
	
	<script type="text/javascript">
      // google.load("visualization", "1", {packages:["corechart"]});
      google.load("visualization", "1", {packages:["corechart"], "callback" : drawChart});
      // google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

		// To create hard line
		var options = {
			title: 'Company Performance'
		};
		
		// To create soft line (curve)
		var options = {
			title: 'Company Performance',
			curveType: 'function',
			legend: { position: 'bottom' }
		};

        var chart = new google.visualization.LineChart(document.getElementById('line_chart_div'));
        chart.draw(data, options);
      }
    </script>
    <div id="line_chart_div" style="width: 100%; height: 500px;"></div>
	
	
	
	
	
	<script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart'], "callback" : drawMarkersMap});
     // google.setOnLoadCallback(drawMarkersMap);

      function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable([
        ['Country',   'Population', 'Area Percentage'],
        ['France',  65700000, 50],
        ['Germany', 81890000, 27],
        ['Poland',  38540000, 23],
      ]);

      var options = {
        sizeAxis: { minValue: 0, maxValue: 100 },
        // region: '155', // Western Europe
        region: '035', // Western Europe
        displayMode: 'markers',
        colorAxis: {colors: ['#e7711c', '#4374e0']} // orange to blue
      };

      var chart = new google.visualization.GeoChart(document.getElementById('map_chart_div'));
      chart.draw(data, options);
    };
    </script>
    <div id="map_chart_div" style="width: 900px; height: 500px;"></div>
	
	
	
	
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"], callback : drawChart});
      // google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('column_chart_div'));
        chart.draw(data, options);
      }
    </script>
    <div id="column_chart_div" style="width: 900px; height: 500px;"></div>
	
	
	
	
	
	
	<script type='text/javascript'>
      google.load('visualization', '1', {packages:['orgchart'], callback : drawChart});
      // google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');
        data.addRows([
          [{v:'Mike', f:'Mike<div style="color:red; font-style:italic">President</div>'}, '', 'The President'],
          [{v:'Jim', f:'Jim<div style="color:red; font-style:italic">Vice President</div>'}, 'Mike', 'VP'],
          ['Alice', 'Mike', ''],
          ['Bob', 'Jim', 'Bob Sponge'],
          ['Carol', 'Bob', '']
        ]);
        var chart = new google.visualization.OrgChart(document.getElementById('tree_chart_div'));
        chart.draw(data, {allowHtml:true});
      }
    </script>
    <div id='tree_chart_div'></div>
	
	
	
	
	<script type="text/javascript">
      google.load('visualization', '1', {packages:['timeline'], callback : drawChart});
	// google.setOnLoadCallback(drawChart);
	function drawChart() {
	  var container = document.getElementById('example2.2');
	  var chart = new google.visualization.Timeline(container);
	  var dataTable = new google.visualization.DataTable();
	  dataTable.addColumn({ type: 'string', id: 'Term' });
	  dataTable.addColumn({ type: 'string', id: 'Name' });
	  dataTable.addColumn({ type: 'date', id: 'Start' });
	  dataTable.addColumn({ type: 'date', id: 'End' });
	  dataTable.addRows([
		[ '1', 'George Washington', new Date(1789, 3, 29), new Date(1797, 2, 3) ],
		[ '2', 'John Adams',        new Date(1797, 2, 3),  new Date(1801, 2, 3) ],
		[ '3', 'Thomas Jefferson',  new Date(1801, 2, 3),  new Date(1809, 2, 3) ]]);

	  var options = {
		timeline: { showRowLabels: false }
	  };

	  chart.draw(dataTable, options);
	}
	</script>
	<div id="example2.2" style="width: 900px; height: 180px;"></div>
	
	
	
	
	<script type='text/javascript'>
      google.load('visualization', '1', {packages:['table'], callback : drawTable});
      // google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('number', 'Salary');
        data.addColumn('boolean', 'Full Time Employee');
        data.addRows([
          ['Mike',  {v: 10000, f: '$10,000'}, true],
          ['Jim',   {v:8000,   f: '$8,000'},  false],
          ['Alice', {v: 12500, f: '$12,500'}, true],
          ['Bob',   {v: 7000,  f: '$7,000'},  true]
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true});
      }
    </script>
    <div id='table_div'></div>
 
 
 
 