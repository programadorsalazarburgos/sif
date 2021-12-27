var cargado=true;
$(document).ready(function(e){


	$.getScript( "../bower_components/codemirror/lib/codemirror.js" )
	  .done(function( script, textStatus ) {
	    
		cargarDependencias(); 	    
	  })
	  .fail(function( jqxhr, settings, exception ) {
	  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/lib/codemirror.js" );
	  	cargado=false;
	});


	function cargarDependencias(){
		$.getScript( "../bower_components/codemirror/addon/search/searchcursor.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/search/searchcursor.js" );
		  	cargado=false;
		});

		$.getScript( "../bower_components/codemirror/addon/search/search.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/search/search.js" );
		  	cargado=false;
		});

		$.getScript( "../bower_components/codemirror/addon/dialog/dialog.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/dialog/dialog.js" );
		  	cargado=false;
		});

		$.getScript( "../bower_components/codemirror/addon/edit/matchbrackets.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/edit/matchbrackets.js" );
		  	cargado=false;
		});	 

		$.getScript( "../bower_components/codemirror/addon/edit/closebrackets.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/edit/closebrackets.js" );
		  	cargado=false;
		});	

		$.getScript( "../bower_components/codemirror/addon/comment/comment.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/comment/comment.js" );
		  	cargado=false;
		});		 

		$.getScript( "../bower_components/codemirror/addon/wrap/hardwrap.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/wrap/hardwrap.js" );
		  	cargado=false;
		});	

		$.getScript( "../bower_components/codemirror/addon/fold/foldcode.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/fold/foldcode.js" );
		  	cargado=false;
		});				 

		$.getScript( "../bower_components/codemirror/addon/fold/brace-fold.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/fold/brace-fold.js" );
		  	cargado=false;
		});

		$.getScript( "../bower_components/codemirror/addon/hint/show-hint.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/hint/show-hint.js" );
		  	cargado=false;
		});

		$.getScript( "../bower_components/codemirror/addon/hint/anyword-hint.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/hint/anyword-hint.js" );
		  	cargado=false;
		});					

		$.getScript( "../bower_components/codemirror/addon/hint/sql-hint.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/hint/sql-hint.js" );
		  	cargado=false;
		});	

		$.getScript( "../bower_components/codemirror/addon/display/autorefresh.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/display/autorefresh.js" );
		  	cargado=false;
		});		  

		$.getScript( "../bower_components/codemirror/addon/display/fullscreen.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/display/fullscreen.js" );
		  	cargado=false;
		});	

		$.getScript( "../bower_components/codemirror/addon/scroll/simplescrollbars.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/addon/scroll/simplescrollbars.js" );
		  	cargado=false;
		});	

		$.getScript( "../bower_components/codemirror/keymap/sublime.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/keymap/sublime.js" );
		  	cargado=false;
		});   

		$.getScript( "../bower_components/codemirror/mode/sql/sql.js" )
		  .done(function( script, textStatus ) {
		    
		  })
		  .fail(function( jqxhr, settings, exception ) {
		  	console.log( "no se pudo cargar el script: ../bower_components/codemirror/mode/sql/sql.js" );
		  	cargado=false;
		}); 	 	
	 }
			 
});