<template>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="/sif/framework/centro-de-monitoreo" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  General
                  <span class="right badge badge-danger">Totales</span>
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview" v-for="(proyecto,i) in proyectos" :key="i">
              <a href="#" class="nav-link" v-if="proyecto.nombre">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  {{ proyecto.nombre }}
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" v-for="(tipoindicador,i) in tipo_indicadores" :key="i">
                  <a v-if="proyecto.nombre === tipoindicador.programa" v-bind:href="'/sif/framework/centro-de-monitoreo/indicadores/'+tipoindicador.seccion+'/'+tipoindicador.id_tipo_indicador" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ tipoindicador.tipo_indicador }}</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Google Analytics
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/sif/framework/centro-de-monitoreo/analytics/navegadores" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Navegadores</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/sif/framework/centro-de-monitoreo/analytics/paginas" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Páginas Vistas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/sif/framework/centro-de-monitoreo/analytics/sesiones" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sesiones Día</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/sif/framework/centro-de-monitoreo/analytics/ciudades" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ciudades</p>
                  </a>
                </li>
                <!--<li class="nav-item">
                  <a href="{{ url('centro-de-monitoreo/analytics/activos') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Activos</p>
                  </a>
                </li>!-->
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
</template>
<script>
export default {
        data () {
            return {
                proyectos:[],
                tipo_indicadores: [],
                tipo_indicador : null,
            }
        },
        mounted() {
            this.listarTipoIndicadores();
            this.getProyectos();
        },
        methods: {
        getProyectos(){
            axios
                .post("/sif/framework/administracion/proyectos/getAll", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
                .then(response => {
                    this.proyectos = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        listarTipoIndicadores() {
            axios
                .post(
                    "/sif/framework/centro-de-monitoreo/getListadoTipoIndicadores",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    }
                )
                .then(response => {
                    for (let index = 0; index < response.data.length; index++) {
                            this.tipo_indicadores.push({
                                programa:
                                    response.data[index]["PROGRAMA"],
                                tipo_indicador:
                                    response.data[index]["TIPO_INDICADOR"],
                                id_tipo_indicador:
                                    response.data[index]["ID_TIPO_INDICADOR"],
                                seccion: response.data[index]["SECCION"],
                            });
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
    }
}
</script>