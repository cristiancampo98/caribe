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
            <div class="mt-8" >
                <div class="grid grid-flow-row lg:grid-flow-col gap-4 auto-cols-min items-end">
                    <div>
                        <label for="lenght">Paginar: </label>
                        <v-select
                        id="lenght"
                        class="w-20 bg-white"
                        v-model="lenght"
                        :options="pages"
                        @input="getPaginate"
                        :clearable="false"></v-select>
                    </div>
                    <div>
                        <label for="lenght">Cliente o empresa: </label>
                       <input type="text"
                        @blur="getPaginate"
                        class="w-20 w-max bg-white rounded-md h-9 border-gray-400"
                        v-model="valueParams.name">
                    </div>
                    <div>
                        <label for="lenght">Consignación: </label>
                       <input type="text"
                        @blur="getPaginate"
                        class="w-20 w-max bg-white rounded-md h-9 border-gray-400"
                        v-model="valueParams.consignment_number">
                    </div>
                    <div>
                        <label for="lenght">Tipo: </label>
                        <v-select
                        id="lenght"
                        class="w-20 w-max bg-white"
                        v-model="valueParams.fully_apply"
                        :options="params.fully_apply"
                        :reduce="label => label.value"
                        @input="getPaginate"
                        :clearable="false"></v-select>
                    </div>
                    <div>
                        <label for="lenght">Fecha inicio: </label>
                        <input type="date" 
                        class="w-44 bg-white rounded-md h-9 border-gray-400"
                        v-model="valueParams.start_date"
                        @change="getPaginate">
                    </div>
                    <div>
                        <label for="lenght">Fecha fin: </label>
                        <input type="date" 
                        class="w-44 bg-white rounded-md h-9 border-gray-400"
                        v-model="valueParams.end_date"
                        @change="getPaginate">
                    </div>
                    <div>
                        <button type="button" class="bg-red-500 text-white py-1 px-2 rounded-md" @click="clean">
                            Limpiar
                        </button>
                    </div>
                </div>
                <table-responsive-component v-if="options.length">
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
                                {{item.order.client.details.name_company}}
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
                                <div v-if="item.fully_apply">
                                    C. Total
                                </div>
                                <div v-else>
                                    C. Parcial 
                                </div>
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
                <div v-else>No hay datos</div>
                <paginate-component 
                :package="package"
                v-if="options.length"
                @updatingData="updateData"></paginate-component>
            </div>
            
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
               
                titles: ['#','Empresa','Cliente','# Pedido','# Consignación','Tipo','Fecha','Opciones'],
                document_name: 'Listado pagina consignación',
                columns: ['#','Empresa','Cliente','# Pedido','# Consignación','Tipo','Fecha'],
                json_fields: {
                    '#' : 'id',
                    'Número de consignación': 'consignment_number',
                    Empresa: 'order.client.details.name_company',
                    Cliente: 'order.client.name',
                    'Número de pedido': 'order.id',
                    Tipo: {
                        field: 'fully_apply',
                        callback: (value) => {
                            return value ? 'C. Total' : 'C. Parcial'
                        }
                    },
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
                params: {
                    fully_apply: [
                        {label:'Total',value:1},
                        {label:'Parcial',value:0}
                    ]
                },
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
                    this.setStatusFlash(res.data.type, res.data.text);
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
