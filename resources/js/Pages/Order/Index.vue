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
                                {{item.note}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.creator.name}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.created_at}}
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
                                        v-if="!item.consignments.length && item.status != 'cancelado'"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="openModalDestroy(item)">
                                            Cancelar
                                        </button>
                                        <button type="button"
                                        v-if="item.status == 'activo' && $page.props.isAdmin"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="openModalConsignment(item)">
                                            Agregar Consignación
                                        </button>
                                        <button type="button"
                                        v-if="$page.props.isAdmin"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="sendEmail(item.id)">
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
                @updatingNotifications="updateNotifications"
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
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetButton from '@/Jetstream/Button'
    import TableResponsiveComponent from '@/Components/TableResponsive'
    import ThResponsiveComponent from '@/Components/THResponsive'
    import TdResponsiveComponent from '@/Components/TDResponsive'
    import PaginateComponent from '@/Components/Paginate'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import FormConsignment from './Modal/AddConsigment.vue'
    import vSelect from "vue-select"
    import 'vue-select/dist/vue-select.css'
    

    export default {
        components: {
            AdminLayout,
            JetNavLink,
            JetButton,
            TableResponsiveComponent,
            ThResponsiveComponent,
            TdResponsiveComponent,
            PaginateComponent,
            JetDropdown,
            JetDropdownLink,
            FormConsignment,
            vSelect
            
        },
        data () {
            return {
                status: {},
                loading: false,
                lenght: 5,
                page: this.lenght,
                pages:[
                    5,10,20
                ],
                titles: ['#','Cliente','Tipo','Email','Estado','Nota','Creador','Creado','Opciones'],
                options: [],
                package: [],
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
                order_id:false

            }
        },
        created(){
            this.getPaginate();
        },
        methods: {
            getPaginate(){
                 this.startLoading();
                var url = '/getAllOrders/order';
                var param = '?lenght='+this.lenght;
                var total_url = url + param;
                axios.get(total_url)
                .then(res => {
                    this.options = res.data.data;
                    this.package = res.data
                })
                .finally( () => this.endLoading());

            },
            updateData(data){
                this.options = data.data;
                this.package = data;
            },
            updateNotifications(data){
                this.modalConsignment = false;
                this.status = data;
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
                    delete_note: this.form.note
                })
                .then( res => {
                    this.modal = false;
                    this.status = {type: res.data.type ,text: res.data.text}
                    this.options.map(item => {
                        if(item.id == this.form.id){
                            item.status = 'cancelado';
                        }
                    })
                })
                .finally( () => this.endLoading())
                .catch( error => {
                    //error.response.data.errors
                    this.status = {type: 'error' ,text: 'Error, escribe el motivo para cancelar.'}  
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
                    this.status = {type: res.data.type, text: res.data.text}
                    this.loading.text = '¡Hecho!';
                }).finally( () => {
                    this.endLoading();
                });
            },
            startLoading(){
                
                this.loading = this.$vs.loading({
                    type: 'circles'
                });
                this.loading.text = "Procesando...";
            },
            endLoading(){
                this.loading.close();
            }
        }
    }
</script>
