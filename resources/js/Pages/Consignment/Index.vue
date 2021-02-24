<template>
    <admin-layout :status="status">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Consignaciones
            </h2>
        </template>
        <div class="py-12">
           <jet-nav-link :href="route('consignment.create')">
                <jet-button type="button">
                    Crear consignación
                </jet-button>
            </jet-nav-link>
            <div class="mt-8" v-if="options.length">
                <div class="grid grid-cols-6 gap-6">
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
                                {{item.order.client.name}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.order.id}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.consignment_number}}
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
                                        :href="route(option.route, {id: item.id})" :as="option.as" method="option.method">
                                            {{option.name}}
                                        </jet-dropdown-link>
                                        <button type="button"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="confirmDestroy(item, key)">
                                            Eliminar
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
            <vs-dialog width="550px" not-center v-model="modalDestroy">
                <template #header>
                  <h4 class="not-margin">
                    Confirma la <b>eliminación</b>
                  </h4>
                </template>

                <div class="con-content">
                  <p>
                    ¿Esta seguro que desea eliminar esta consignación? <b>Consecutivo #{{consecutive}}</b>
                  </p>
                </div>

                <template #footer>
                  <div class="con-footer">
                    <vs-button @click="destroyConsignment()" transparent>
                      Si, confirmar
                    </vs-button>
                    <vs-button @click="modalDestroy=false" dark transparent>
                      Cancelar
                    </vs-button>
                  </div>
                </template>
            </vs-dialog>
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
    import vSelect from "vue-select"
    import 'vue-select/dist/vue-select.css'
    import moment from 'moment';
    moment.locale('es')
    

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
            vSelect
            
        },
        data () {
            return {
                status:{},
                loading: false,
                lenght: 5,
                page: this.lenght,
                pages:[
                    5,10,20
                ],
                titles: ['#','Cliente','# Pedido','# Consignación','Fecha','Opciones'],
                options: [],
                package: [],
                actions: [
                    {name: 'Editar', route:'consignment.edit'},
                    {name: 'Ver', route:'consignment.show'},
                ],
                consecutive: null,
                modalDestroy: false,
                key: null,
                moment: moment,
            }
        },
        created(){
            if (this.info) {
                this.status = {type: 'info', text: this.info};
            }
            if (this.error) {
                this.status = {type: 'error', text: this.error};
            }
        },
        mounted(){
            this.getPaginate();
        },
        methods: {
            getPaginate(){
                this.startLoading();
                var url = '/getAllConsignments/consignments';
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
            confirmDestroy(item, key){
                this.consecutive = item.id;
                this.modalDestroy = true;
                this.key = key
            },
            destroyConsignment(){
                this.startLoading();
                axios.delete(`/consignment/${this.consecutive}`)
                .then( res => {
                    this.options.splice(this.key, 1);
                    this.modalDestroy = false;
                    this.status = {
                        type: res.data.type,
                        text: res.data.text,
                    }
                })
                .finally( () => {
                    this.endLoading();
                    this.consecutive = null;
                    this.key = null;
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
