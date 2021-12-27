<template>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header text-muted">
                <h2 class="m-0">Ficha CREA - Administracion</h2>
            </div>

            <div class="card-body text-center">
                <p>Hola</p>
                <p>Hola</p>
            </div>
                
        </div>
    </div>
</template>


<script>
    require( 'jszip' );
	require( 'datatables.net-dt' );
	require( 'datatables.net-buttons-dt' );
	require( 'datatables.net-buttons/js/buttons.html5.js' );
	require( 'datatables.net-responsive-dt' );

    import Multiselect from "vue-multiselect";
    import DataTables from "datatables.net";
    import Sweetalert2 from 'sweetalert2';
    import { forEach } from 'jszip';
    
    export default {
        components: { 
            Multiselect
        },
        data () {
            return {

            }
        },
        mounted() {
            
        },
        methods: {
          
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>