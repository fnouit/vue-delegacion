<template>
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Edición de Regiones</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Regiones
                        <button type="button" class="btn btn-secondary float-right ml-1" @click="abrirModal(0)">
                            <i class="icon-plus"></i>&nbsp;Nueva
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <select class="form-control col-md-4" v-model="filtro">
                                        <option value="nombre">Nombre</option>
                                        <option selected value="sede">Sede</option>
                                        <option value="coordinador">Coordinador</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarRegiones(1,buscar, filtro)" class="form-control" placeholder="...">
                                    <button type="submit" @click="listarRegiones(1, buscar, filtro)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Sede</th>
                                <th>Coordinador</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="region in arrayRegiones" :key="region.id">
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" @click="abrirModal(1, region)">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarRegion(region.id)">
                                        <i class="icon-trash"></i>
                                    </button>
                                </td>
                                <td v-text="region.nombre"></td>
                                <td v-text="region.sede"></td>
                                <td v-text="region.coordinador"></td>
                            </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, filtro)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, filtro)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, filtro)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>

            <!-- Zona de Modales o ventanas del CRUD -->
            <!-- Modal agregar regiones -->
            <vue-window-modal :active="mostrarMR" width="600px" height="300px" :title="tituloVentana"  v-on:clickClose="mostrarMR=false">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre"  class="form-control" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Sede</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="sede" class="form-control" placeholder="Sede">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Coordinador</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="coordinador" class="form-control" placeholder="Coordinador">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-right">
                            <button type="button" v-if="accion===0" class="btn btn-success" @click="registrarRegion">Guardar</button>
                            <button type="button" v-if="accion===1" class="btn btn-success" @click="actualizarRegion">Actualizar</button>
                        </div>
                    </div>
                </div>
            </vue-window-modal>
        </div>
    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    export default {
        data() {
            return {
                mostrarMR: false,
                accion: 0,
                tituloVentana: '',
                arrayRegiones:[],
                id: 0,
                nombre: '',
                sede: '',
                coordinador: '',
                estado: '',
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                filtro: "nombre",
                buscar: ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            abrirModal(accion, data=[]) {
                switch(accion){
                    case 0:
                    {
                        this.tituloVentana = 'Nueva region';
                        this.nombre = '';
                        this.sede = '';
                        this.coordinador = '';
                        this.mostrarMR = true;
                        this.accion = 0;
                        break;
                    }
                    case 1:
                    {
                        this.tituloVentana = 'Actualizar región';
                        this.nombre = data['nombre'];
                        this.sede = data['sede'];
                        this.coordinador = data['coordinador'];
                        this.id = data['id'];
                        this.mostrarMR = true;
                        this.accion = 1;
                        break;

                                /* this.modal=1;
                                this.tituloModal='Actualizar categoría';
                                this.tipoAccion=2;
                                this.categoria_id=data['id'];
                                this.nombre = data['nombre'];
                                this.descripcion= data['descripcion'];
                                break; */
                    }
                }
            },
            listarRegiones(page, buscar, filtro){
                let me = this;
                let url = '/region?page=' + page + '&buscar=' + buscar + '&filtro=' + filtro;
                axios.get(url).then(function (response) {                    
                    let respuesta = response.data;
                    me.arrayRegiones = respuesta.regiones.data;
                    me.pagination = respuesta.pagination;
                }).catch(function (error) {
                    console.log(error);
                })
            },
            cambiarPagina(page, buscar, filtro){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarRegiones(page, buscar, filtro);
            },
            registrarRegion(){
                let me = this;
                axios.post('/region/registrar',{
                    'nombre': this.nombre,
                    'sede': this.sede,
                    'coordinador': this.coordinador
                }).then(function (response) {
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Región agregada con exito!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    me.mostrarMR = false;
                    me.listarRegiones(1,'','nombre');
                }).catch(function (error) {
                    Swal.fire({
                        position: 'top-end',
                        type: 'warning',
                        title: 'Error (' + error.status + '): ' + error
                    });
                });
            },
            actualizarRegion(){
                let me = this;
                axios.put('/region/actualizar',{
                    'nombre': this.nombre,
                    'sede': this.sede,
                    'coordinador': this.coordinador,
                    'id': this.id
                }).then(function (response) {
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Región actualizada con exito!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    me.mostrarMR = false;
                    me.listarRegiones(1,'','nombre');
                }).catch(function (error) {
                    Swal.fire({
                        position: 'top-end',
                        type: 'warning',
                        title: 'Error (' + error.status + '): ' + error
                    });
                })
            },
            desactivarRegion(id){
                Swal.fire({
                    title: 'Esta seguro de eliminar esta Categoria?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.put('/region/desactivar',{
                            'id': id
                        }).then(function (response) {
                            me.listarRegiones(1,'','nombre');
                            Swal.fire({
                                title:'Desactivado!',
                                text:'El registro ha sido borrado con éxito.',
                                type:'success',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                });
            },
            activarRegion(id){
                Swal.fire({
                    title: 'Esta seguro de recuperar esta Categoria?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.put('/categoria/activar',{
                            'id': id
                        }).then(function (response) {
                            me.listarRegiones(1,'','nombre');
                            Swal.fire({
                                title:'Recuperado!',
                                text:'El registro ha sido recuperado con éxito.',
                                type:'success',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                });
            }
        },
        mounted() {
            this.listarRegiones(1, this.buscar, this.filtro);
        }
    }
</script>
<style>
    form{
        margin-top: 15px;
    }
</style>
