'use strict';


          // Load Charts and the corechart package.
          google.charts.load('current', {'packages':['corechart']});
           // Draw the bubble chart when Charts is loaded.
        
          google.charts.setOnLoadCallback(`Chart_${counter}`);
          var Chart=`Chart_${counter}`;
          function Chart() {

            // Create the data table.
            var data = new google.visualization.arrayToDataTable([
           
            ['Company','Magnitude of Impact', 'Likelihood', 'Time horizons',],
           
            for (var figure of chartData){
            ['{{$risk->Identifier}}',{{$risk->$numMagnitude}} ,{{$risk->$numLikelihood}},{{$risk->getTime()}},],
            }
          ]);
        
          var options = {
            title: 'CDP回答分析：C2.3a: {{$risk->companies->name}}',
            hAxis: {title: 'Magnitude of Impact',minValue:0, maxValue:7,minorGridlines:{count:0},
            ticks: [{v:1, f:'Unknown'}, {v:2, f:'Low'},{v:3, f:'Mid-Low'},{v:4, f:'Midium'},{v:5, f:'Mid-high'},{v:6, f:'High'},{v:7, f:''}],},
            vAxis: {title: 'Likelihood',
            ticks: [{v:1, f:'Unknown'},{v:2, f:'0-1%'}, {v:3, f:'0-10%'},{v:4, f:'0-33%'},{v:5, f:'33-66%'},
            {v:6, f:'50-100%'},{v:7, f:'66-100%'},{v:8, f:'90-100%'},{v:9, f:'99-100%'},{v:10, f:''}] ,
            minorGridlines:{count:0},minValue:0, maxValue:10,},
            colorAxis: {minValue:1,maxValue:5,colors: ['yellow', 'red']},
           // series:{'Current':{color:'#ff0000'},'Short-term':{color:'#FF3300'},'Medium-term':{color:'FF9900'},'Long-term':{color:'#e6ffe6'}},
            bubble: { textStyle:{fontName:'Meiryo UI', fontSize: 11,auraColor: 'none'},ignoreBounds:true,},
            legend:{position:'none',alignment:'center'},
            tooltip: {isHtml: true,ignoreBounds:false},
            sizeSize:{maxValue:1},
            fontName:'Meiryo UI',
            };
          
            // Instantiate and draw the chart.
            var chart = new google.visualization.BubbleChart(document.getElementById('riskChart{{$loop->index}}'));
            chart.draw(data, options);
          }
        


    
 
 

