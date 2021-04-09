<template>
    <admin-layout :status="status">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pedidos
            </h2>
        </template>
        <div class="py-12">
           <jet-nav-link :href="route('order.create')">
                <jet-button type="button">
                    Crear pedido
                </jet-button>
            </jet-nav-link>
            <jet-button type="button" @click.native="exportPDF">
                PDF
            </jet-button>
            <json-excel class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
            :data="options"
            :fields="json_fields"
            worksheet="Tabla"
            :name="`${document_name}.xls`">
                {{ btn_name_excel }}
            </json-excel>
            <div class="mt-8" v-if="options.length">
                <div class="col-span-3">
                    <label for="lenght">Paginar: </label>
                    <v-select
                    id="lenght"
                    class="w-20 bg-white"
                    v-model="lenght"
                    :options="pages"
                    @input="getPaginate"
                    :clearable="false"></v-select>
                </div>
                <table-responsive-component>
                    <template #title>
                        <tr>
                            <th-responsive-component 
                            v-for="(title, key) in titles"
                            :key="key">{{title}}</th-responsive-component>
                        </tr>
                    </template>
                    <template #content>
                        <tr v-for="(item, key) in options" :key="key">
                            <td-responsive-component>
                                {{item.id}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.client.details.name_company}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.client.name}}
                            </td-responsive-component>
                             <td-responsive-component>
                                {{item.client.details.type_pay}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.client.email}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.status}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.creator.name}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{moment(item.created_at).format('DD/MM/YYYY')}}
                            </td-responsive-component>
                            <td-responsive-component>
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <span  class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center  text-gray-900 hover:text-blue-400 focus:outline-none transition ease-in-out duration-150">
                                                <div class="bg-white border border-transparent hover:border-black shadow-sm p-2 rounded-lg">
                                                    <img src="/img/menu.svg">
                                                </div>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Opciones
                                        </div>

                                        <jet-dropdown-link v-for="(option,key) in actions"
                                        :key="key"
                                        :href="route(option.route, {order: item.id})" :as="option.as" method="option.method">
                                            {{option.name}}
                                        </jet-dropdown-link>

                                         <button type="button"
                                        v-if="item.status == 'cancelado' && $page.props.isAdmin"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="updateStatusOrder(item)">
                                            Activar
                                        </button>
                                        <button type="button"
                                        v-if="item.status == 'activo' && $page.props.isAdmin"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="openModalConsignment(item)">
                                            Agregar Consignación
                                        </button>
                                        <button type="button"
                                        v-if="!item.remissions.length && item.status != 'cancelado'"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="openModalDestroy(item)">
                                            Cancelar
                                        </button>
                                        <button type="button"
                                        v-if="$page.props.isAdmin"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="confirmNotification(item)">
                                            Notificar
                                        </button>

                                    </template>
                                </jet-dropdown>
                            </td-responsive-component>
                        </tr>
                    </template>
                </table-responsive-component>
                <paginate-component 
                :package="package"
                @updatingData="updateData"></paginate-component>
            </div>
            <div v-else>No hay datos</div>
            
            <!-- modal delete -->
            <vs-dialog width="300px" not-center v-model="modal">
                <template #header>
                  <h4 class="not-margin">
                    ¿Por qué se <b>cancelará</b> este pedido?
                  </h4>
                </template>
                <div class="grid grid-cols-3">
                  <textarea v-model="form.note" class="rounded-md col-span-3"></textarea>
                  <p v-if="error_note" v-for="error in error_note" class="text-sm text-red-500 mt-2 col-span-3">
                    {{error}}
                  </p>
                </div>
                <template #footer>
                  <div class="grid grid-cols-2">
                    <vs-button class="col-span-1" @click="destroyOrder" transparent>
                      Si,cancelar
                    </vs-button>
                    <vs-button class="col-span-1" @click="modal=false" dark transparent>
                      Cerrar
                    </vs-button>
                    
                  </div>
                </template>
            </vs-dialog>    
            <!-- end modal delete -->
            <!-- form consignment -->
             <vs-dialog auto-width not-center v-model="modalConsignment">
                <template #header>
                  <h4 class="mr-8">
                    Crea un consignación para este pedido con la información requerida.
                  </h4>
                </template>
                <form-consignment
                @closingModal="closeModal"
                :order_id="order_id"/>
                <template #footer>
                  <div class="grid grid-cols-2">
                    <vs-button class="col-span-2" @click="modalConsignment=false" dark transparent>
                      Cerrar
                    </vs-button>
                    
                  </div>
                </template>
             </vs-dialog>
            <!-- end form consignment -->
            <!-- confirm notification -->
            <vs-dialog width="550px" not-center v-model="modalNotify">
                <template #header>
                  <h4 class="not-margin">
                    Enviar notificación por correo a <b>{{dataNotify.name}}</b>
                  </h4>
                </template>


                <div class="con-content">
                  <p>
                    ¿Quieres enviar una notificación al usuario informandole que su pedido ha sido actualizado?. <br>
                    Enviar una notificación al usuario podrá causar que la operación tarde mas ¿Quieres enviarla?
                  </p>
                </div>

                <template #footer>
                  <div class="con-footer">
                    <vs-button @click="sendNotify(true)" transparent>
                      Si, enviar notificación
                    </vs-button>
                    <vs-button @click="sendNotify(false)" dark transparent>
                      No enviar notificación
                    </vs-button>
                  </div>
                </template>
            </vs-dialog>
            <!-- end confirm notification -->
        </div>
    </admin-layout>
</template>

<script>
    import { DataTableComponentMixin} from '@/Mixins/DataTableComponentMixin'
    import FormConsignment from './Modal/AddConsigment.vue'

    export default {
        mixins: [DataTableComponentMixin],
        components: {
            FormConsignment,
        },
        data () {
            return {
                titles: ['#','Empresa','Cliente','Tipo','Email','Estado','Creador','Fecha','Opciones'],
                document_name: 'Listado pagina pedidos',
                columns: ['#','Empresa','Cliente','Tipo','Email','Estado','Creador','Fecha'],
                json_fields: {
                    '#' : 'id',
                    Cliente : 'client.name',
                    Tipo: 'client.details.type_pay',
                    Email: 'client.email',
                    Estado: 'status',
                    Creador: 'creator.name',
                    Fecha: {
                        Fecha: 'created_at',
                        callback: (value) => {
                            return this.moment(value.created_at).format('DD/MM/YYYY');
                        },
                    }
                },
                actions: [
                    {name: 'Editar', route:'order.edit'},
                    {name: 'Ver', route:'order.show'},
                ],
                modal: false,
                modalConsignment:false,
                form:{
                    note:null,
                    id:null
                },
                modalNotify: false,
                dataNotify:{
                    id: null,
                    name: null,
                },
                order_id:false,
                error_note: null
            }
        },
        created(){
            this.url = '/getAllOrders/order';
        },
        methods: {
            closeModal(data){
                this.modalConsignment = data;
            },
            openModalConsignment(item){
                this.modalConsignment = true;
                this.order_id = item.id;
            },
            openModalDestroy(item){
                if (item.status == 'cancelado') {
                    this.status = {type: 'warning' ,text: 'Este pedido ya se encuentra cancelado'}
                }else{
                    this.form.id = item.id;
                    this.modal = true;
                }
            },
            destroyOrder(item){
                this.startLoading();
                axios.put('cancel/'+this.form.id+'/order',{
                    note: this.form.note
                })
                .then( res => {
                    this.modal = false;
                    this.setStatusFlash(res.data.type, res.data.text)
                    this.options.map(item => {
                        if(item.id == this.form.id){
                            item.status = 'cancelado';
                        }
                    });
                    this.error_note = null;
                })
                .finally( () => this.endLoading())
                .catch( error => {
                    this.error_note = error.response.data.errors;
                    this.setStatusFlash('error', 'Error, verifica los datos.')
                });
            },
            updateStatusOrder(item){
                this.startLoading();
                axios.put('updateStatusOrder/'+item.id+'/order')
                .then( res => {
                    if (res.data.order) {
                        item.status = res.data.order.status;
                    }
                    this.status = {type: res.data.type ,text: res.data.text}
                })
                .finally( () => this.endLoading() );
            },
            sendEmail(id){
               this.startLoading();
                axios.get('sendEmailUpdate/'+id+'/order')
                .then( res => {
                    this.setStatusFlash(res.data.type, res.data.text);
                    this.loader.text = '¡Hecho!';
                }).finally( () => {
                    this.endLoading();
                });
            },
            confirmNotification(item) {
                this.modalNotify = true
                this.dataNotify.id = item.id;
                this.dataNotify.name = item.client.name;

            },
            sendNotify(value) {

                this.modalNotify = false;
                if (value) {
                    this.sendEmail(this.dataNotify.id);    
                }
                this.dataNotify = {};
            }
        }
    }
</script>
