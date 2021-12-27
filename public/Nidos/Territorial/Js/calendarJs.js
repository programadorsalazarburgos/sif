$(document).ready(function() {
	let startSelected;
	let endSelected;
	let allDaySelected;
	var selection = "";
	var i = 0;
	for(var i = 0; i < 23; i++)
	{
		var j = zeroFill(i, 2);
		selection += "<option value='"+ j +"00'>"+ j + ":00" + "</option>";
		selection += "<option value='"+ j +"30'>"+ j + ":30" + "</option>";
	}
	$("#select-hora-inicio").html(selection);
	$("#select-hora-fin").html(selection);
	function zeroFill( number, width )
	{
		width -= number.toString().length;
		if ( width > 0 )
		{
			return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
		}
		return number + "";
	}

	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();

	/*  className colors

		className: default(transparent), important(red), chill(pink), success(green), info(blue)

		*/


	/* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events div.external-event').each(function() {

		// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
		// it doesn't need to have a start or end
		var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};

		// store the Event Object in the DOM element so we can get to it later
		$(this).data('eventObject', eventObject);

		// make the event draggable using jQuery UI
		$(this).draggable({
			zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

	});


	/* initialize the calendar
	-----------------------------------------------------------------*/

	var calendar =  $('#calendar').fullCalendar({
		header: {
			left: 'title',
			//center: 'agendaDay,agendaWeek,month',
			right: 'prev,next today'
		},
		editable: true,
			firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
			selectable: true,
			defaultView: 'month',

			axisFormat: 'h:mm',
			columnFormat: {
                month: 'ddd',    // Mon
                week: 'ddd d', // Mon 7
                day: 'dddd M/d',  // Monday 9/7
                agendaDay: 'dddd d'
            },
            timeFormat: {
            	'': '( h:mm tt) [- h:mm tt ]',
            },
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
            },
            allDaySlot: false,
            selectHelper: true,
            select: function(start, end, allDay) {
            	startSelected = start;
            	endSelected = end;
            	allDaySelected = allDay;
            	$("#info-event").modal("show");
            },
			droppable: true, // this allows things to be dropped onto the calendar !!!
			drop: function(date, allDay) { // this function is called when something is dropped

			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');

			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);

			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;

			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}

		},

		events: [
		{
			title: 'All Day Event',
			start: new Date(y, m, 1)
		},
		{
			id: 999,
			title: 'Repeating Event',
			start: new Date(y, m, d-3, 16, 0),
			allDay: false,
			className: 'info'
		},
		{
			id: 999,
			title: 'Repeating Event',
			start: new Date(y, m, d+4, 16, 0),
			allDay: false,
			className: 'info'
		},
		{
			title: 'Meeting',
			start: new Date(y, m, d, 10, 30),
			allDay: false,
			className: 'important'
		},
		{
			title: 'Lunch',
			start: new Date(y, m, d, 12, 0),
			allDay: false,
			className: 'important',
			styles: "background: red !important;"
		},
		{
			title: 'Birthday Party',
			start: new Date(y, m, 15),
			styles: "background: red !important;"
		},
		{
			title: 'Click for Google',
			start: new Date(y, m, 28),
			url: 'https://ccp.cloudaccess.net/aff.php?aff=5188',
			className: 'success'
		}
		],
	});
	$('#guardar-cambios').on('click', function(e){
		e.preventDefault();
		let horaInicio = $('#select-hora-inicio').val();
		let horaFin = $('#select-hora-fin').val();
		if ($('#input-texto').val() != "") {
			calendar.fullCalendar('renderEvent',
			{
				title: $('#input-texto').val(),
				start: moment(startSelected).add(horaInicio.substring(0,2), 'h').add(horaInicio.substring(2,4), 'm').toDate(),
				end: moment(startSelected).add(horaFin.substring(0,2), 'h').add(horaFin.substring(2,4), 'm').toDate(),
				allDay: false,
				styles: "background: "+$('#input-color').val()+" !important;"
			},
			true
			);
			$("#info-event").modal("hide");
		}
		else{
			swal(
				'',
				'Debe digitar alguna descripcion del evento',
				'error'
				);
		}
		calendar.fullCalendar('unselect');
	});



});
