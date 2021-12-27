const app = new Vue({
    el: '#app',
    data: {
        titulo: 'GYM',
        tareas: [{nombre:'Limpiar', estado:false}, {nombre:'Cocinar', estado:false}],
        nuevaTarea : ''
    },
    methods: {
        agregarTarea(){
            this.tareas.push(
                {
                    nombre:this.nuevaTarea,
                    estado:false
                });
        }
    }
});