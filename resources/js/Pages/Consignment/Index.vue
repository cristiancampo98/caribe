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
    import { DataTableComponentMixin} from '@/Mixins/DataTableComponentMixin'
    
    export default {
        mixins: [DataTableComponentMixin],
        data () {
            return {
               
                titles: ['#','Cliente','# Pedido','# Consignación','Fecha','Opciones'],
                document_name: 'Listado pagina consignación',
                columns: ['#','Cliente','# Pedido','# Consignación','Fecha'],
                json_fields: {
                    '#' : 'users.id',
                    Cliente : 'order.client.name',
                    'Número de pedido': 'order.id',
                    'Número de consignación': 'consignment_number',
                    Fecha: {
                        Fecha: 'created_at',
                        callback: (value) => {
                            return this.moment(value.created_at).format('DD/MM/YYYY');
                        },
                    }
                },
                actions: [
                    {name: 'Editar', route:'consignment.edit'},
                    {name: 'Ver', route:'consignment.show'},
                ],
                consecutive: null,
                modalDestroy: false,
                key: null,
            }
        },
        created(){
            this.url = '/getAllConsignments/consignments';
        },
        methods: {
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
        }
    }
</script>
