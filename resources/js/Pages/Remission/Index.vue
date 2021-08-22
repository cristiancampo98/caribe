<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Remisiones
            </h2>
        </template>
        <div class="py-12">
            <jet-nav-link :href="route('remission.create')">
                <jet-button type="button">
                    Crear remisión
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
                        <label for="lenght">Empresa o cliente: </label>
                        <input type="text"
                        @blur="getPaginate"
                        class="w-20 w-max bg-white rounded-md h-9 border-gray-400"
                        v-model="valueParams.name">
                    </div>
                    <div>
                        <label for="lenght">Pedido: </label>
                        <input type="number"
                        @blur="getPaginate"
                        class="w-20 w-max bg-white rounded-md h-9 border-gray-400"
                        v-model="valueParams.order_id">
                    </div>
                    <div>
                        <label for="lenght">Firmado: </label>
                        <v-select
                        id="lenght"
                        class="w-max bg-white"
                        v-model="valueParams.isSigned"
                        :options="params.isSigned"
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
                                {{item.order_detail.order.client.details.name_company}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.order_detail.order.client.name}}
                            </td-responsive-component>
                            <td-responsive-component>
                                No. {{item.order_detail.order_id}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.order_detail.consignment
                                    ? item.order_detail.consignment.consignment_number
                                    : 'Pendiente '}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.order_detail.product.name}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.order_detail.quantity | formatNumber}}
                                m3
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.delivered | formatNumber}}
                                m3
                            </td-responsive-component>
                            <td-responsive-component>
                                <ul>
                                    <li >Placa: 
                                        <span class="uppercase">{{item.carrier.vehicle.license_plate}}</span>
                                    </li>
                                    <li >Conductor: 
                                        <span class="capitalize">{{item.carrier.carrier}}</span>
                                    </li>
                                </ul>
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.isSigned ? 'Si' : 'No'}}
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
                                       
                                    </template>
                                </jet-dropdown>
                            </td-responsive-component>
                        </tr>
                    </template>
                </table-responsive-component>
                <div v-else>No hay datos</div>
                <paginate-component 
                v-if="options.length"
                :package="package"
                @updatingData="updateData"></paginate-component>
            </div>
            
        </div>
    </admin-layout>
</template>

<script>
    import { DataTableComponentMixin} from '@/Mixins/DataTableComponentMixin'
    
    export default {
        mixins: [DataTableComponentMixin],
        created() {
            this.url = '/getPaginateAllRemissions/remission';
        },
        data () {
            return {
                titles: ['#','Empresa','Cliente','Pedido','Consignación','Producto','Cantidad','Entregado','Vehiculo','Firmado','Fecha','Opciones'],
                document_name: 'Listado pagina de remisiones',
                columns: ['#','Empresa','Cliente','Pedido','Consignación','Producto','Cantidad','Entregado','Vehiculo','Firmado','Fecha'],
                json_fields: {
                    '#' : 'id',
                    Empresa : 'order_detail.order.client.details.name_company',
                    Cliente : 'order_detail.order.client.name',
                    Pedido : 'order_detail.order_id',
                    'Consignación': {
                        field: 'order_detail.consignment_id',
                        callback: (value) => {
                            return  value ? value : 'Sin asignar'
                        }
                    },
                    Producto: 'order_detail.product.name',
                    Cantidad: {
                        field: 'order_detail.quantity',
                        callback: (value) => {
                            return `${value} m3`
                        }
                    },
                    Entregado: {
                        field: 'delivered',
                        callback: (value) => {
                            return `${value} m3`
                        }
                    },
                    Vehiculo: {
                        callback: (value) => {
                            return `Placa: ${value.carrier.vehicle.license_plate} / Conductor: ${value.carrier.carrier}`
                        }
                    },
                    Firma: {
                        field: 'isSigned',
                        callback: (value) => {
                            return value ? 'Si' : 'No'
                        }
                    },
                    Fecha: {
                        field: 'created_at',
                        callback: (value) => {
                            return this.moment(value).format('DD/MM/YYYY');
                        }
                    }
                },
                actions: [
                    {name: 'Ver', route:'remission.show'},
                    {name: 'Editar', route:'remission.edit'},
                ],
                params: {
                    isSigned: [
                        {label:'Si',value: 1},
                        {label:'No',value: 0},
                    ]
                },
            }
        },
        methods: {
            updaStatus(id){
                this.startLoading();

                axios.put(`updateStatus/${id}/product`)
                .then( res => {
                    this.status = {
                        type : res.data.type,
                        text : res.data.text,
                    }
                })
                .finally( () => {
                    this.endLoading();
                });
            },
        }
    }
</script>
