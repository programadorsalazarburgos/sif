<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prueba Vue</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div id="app" class="container mt-5">
        <h1>@{{ titulo }}</h1>
        <input type="text" class="form-control my-3" v-model='nuevaTarea' @keyup.enter="agregarTarea">
        <button class="btn btn-primary" @click="agregarTarea">Agregar</button>

        <div class="mt-3" v-for="(tarea,index) of tareas">
            <div class="alert" role="alert" :class="[{'alert-success': tarea.estado}, {'alert-secondary':!tarea.estado}]">
            <div class="d-flex justify-content-between align-items-center">
                <div>@{{ index }} - @{{ tarea.nombre }} - @{{ tarea.estado }}</div>
                <div>
                    <button class="btn btn-success btn-sm" @click="tarea.estado = true">OK</button>
                    <button class="btn btn-danger btn-sm" @click="tarea.estado = false">X</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="node_modules/vue/dist/vue.js"></script>
<script src="resources/js/pruebavue.js"></script>
</html>