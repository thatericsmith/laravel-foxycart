/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function() {
    "use strict";

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    $(".box-header, .nav-tabs").css("cursor","move");
    //jQuery UI sortable for the todo list
    $(".todo-list").sortable({
        placeholder: "sort-highlight",
        handle: ".handle",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();;

    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();

    $('.daterange').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            },
    function(start, end) {
        alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

    /* jQueryKnob */
    $(".knob").knob();


    var sparkvalues;
    $('.sparkline-bar').each(function(){
        sparkvalues = $(this).attr('data-values').split(',');
        $(this).sparkline(sparkvalues, {
            type: 'bar',
            barColor: '#00a65a',
            colorMap:['#00e65a','#00d65a','#00c65a','#00b65a','#00a65a'],
            height: '20px'
        });
    });
    
    // data tables
    $(".table-data").dataTable();

    /* Morris.js Charts */ 
    // Articles / Topics chart
    if($('#revenue-chart').length){
        var area = new Morris.Area({
            element: 'revenue-chart',
            resize: true,
            data: [
                {y: 'Monday', a: 2666, t: 2666},
                {y: 'Tuesday', a: 2778, t: 2294},
                {y: 'Wednesday', a: 4912, t: 1969},
                {y: 'Thursday', a: 3767, t: 3597},
                {y: 'Friday', a: 6810, t: 1914},
                {y: 'Saturday', a: 5670, t: 4293},
                {y: 'Sunday', a: 4820, t: 3795}
            ],
            xkey: 'y',
            ykeys: ['a', 't'],
            labels: ['Articles', 'Topics'],
            lineColors: ['#a0d0e0', '#3c8dbc'],
            hideHover: 'auto'
        });

        //Fix for charts under tabs
        $('.box ul.nav a').on('shown.bs.tab', function(e) {
            area.redraw();
        });
    }

    if($('#add-topic-input').length){
        // let's create a typeahead here with values from this weeks topics
     
        $( "#add-topic-input" ).autocomplete({
          minLength: 0,
          source: '/api/topic/autocomplete',
          focus: function( event, ui ) {
            $( "#add-topic-input" ).val( ui.item.label );
            return false;
          },
          select: function( event, ui ) {
            $( "#add-topic-input" ).val( ui.item.label );
            $( "#add-topic-input-id" ).val( ui.item.value );
     
            return false;
          }
        })
        .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .append( "<a>" + item.label + "</a>" )
            .appendTo( ul );
        };
    }

    $('select.admin-grader').change(function(){
        var $select = $(this);
        var grade = $select.val();
        var qty = $select.attr('data-qty');
        var article = $select.attr('data-article');

        if(grade !== '' && confirm('Add '+qty+' '+grade+' grades to this article?')){
            $.post('/admin/grade','grade='+grade+'&article='+article+'&qty='+qty,function(data){
                //console.log(data);
                location.reload();
            });
        }
    });


});