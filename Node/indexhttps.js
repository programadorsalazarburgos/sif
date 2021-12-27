var express = require('express');  
var timer = require('timers');
const util = require('util');
var fs = require('fs');
var http = require('http');
var https = require('https');
var sslOptions = {
  key: fs.readFileSync('sif_idartes_gov_co.key'),
  cert: fs.readFileSync('sif_idartes_gov_co.crt'),
  ca: fs.readFileSync('sif_idartes_gov_co.ca-bundle'),
};
var app = express();  
var server = https.Server(sslOptions,app);   
var io = require('socket.io')(server);  

///////////////////////////////////////////////////////////////////////////

// se dispara cuando se conecta un cliente
io.on('connection', function(socket){
	console.log("new COnnection: "+socket.id);
	
	/* 	se dispara cuando un cliente realiza un emit con el parametro token
	* 	esto sirve para suscribirlo a un "rom" y asi identificarlo al realizar
	*	un emit especifico
	*/
	socket.on('token',function(info){
		console.log("conectado usuario: "+info.userId+" en el room: "+info.room);
		socket.join('user'+info.userId);
		socket.join('general');
		socket.join(info.room);
	});

	/* 	se dispara cuando desde el cliete se realiza un emit con el parametro sendNotificationUser
	*	con el fin de enviar una notificacion a un usuario especifico
	*/
	socket.on('sendNotificationUser',function(notificacion){ 
		var d = new Date();
		var s = d.getSeconds();
		var m = d.getMinutes();
		var h = d.getHours();
		io.to('user'+notificacion.userId).emit('notificacion',notificacion);
		console.log('EMIT: '+ h+":"+m+":"+s+" to: user"+notificacion.userId);
		// io.to('general').emit('notificacion',"enviado general de servidor");
	});

	/* 	se dispara cuando desde el cliete se realiza un emit con el parametro sendNotificationUser
	*	con el fin de enviar una notificacion a un usuario especifico
	*/
	socket.on('sendNotificationRole',function(notificacion){ 
		var d = new Date();
		var s = d.getSeconds();
		var m = d.getMinutes();
		var h = d.getHours();
		io.to(notificacion.room).emit('notificacion',notificacion);
		console.log('EMIT: '+notificacion.room+' - '+ h+":"+m+":"+s);
		console.log('EMIT Date: '+notificacion.DT_Fecha);
		// io.to('general').emit('notificacion',"enviado general de servidor");
	});


	/* 	Se dispara cuando un cliente se desconecta el servidor
	*	esto se da cuando realiza F5, cierra el navegador 
	*	en general cualquier accion que lo separe de io.connect
	*/
	socket.on('disconnect',function(){
		console.log('Cliente Desconectado');
	});

});
server.listen(55000,function(){
	console.log('open');
});
