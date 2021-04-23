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
                                {{item.delivered}}
                                m3
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.order_detail.quantity}}
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
                <paginate-component 
                :package="package"
                @updatingData="updateData"></paginate-component>
            </div>
            <div v-else>No hay datos</div>
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
                titles: ['#','Pedido','Consignación','Producto','Entregado','Cantidad','Vehiculo','Firmado','Fecha','Opciones'],
                document_name: 'Listado pagina de remisiones',
                columns: ['#','Pedido','Consignación','Producto','Entregado','Cantidad','Vehiculo','Firmado','Fecha'],
                json_fields: {
                    '#' : 'id',
                    Pedido : 'order_detail.order_id',
                    'Consignación': {
                        field: 'order_detail.consignment_id',
                        callback: (value) => {
                            return  value ? value : 'Sin asignar'
                        }
                    },
                    Producto: 'order_detail.product.name',
                    Entregado: {
                        field: 'delivered',
                        callback: (value) => {
                            return `${value} m3`
                        }
                    },
                    Cantidad: {
                        field: 'order_detail.quantity',
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
