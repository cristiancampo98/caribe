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
                    Crear remission
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
                                No. {{item.order_detail.order_id}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.consignment 
                                    ? item.consignment.consignment_number
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
    import { loadingMixin} from '@/Mixins/loadingMixin'
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
        created() {
            this.getPaginate();
        },
        mixins: [loadingMixin],
        data () {
            return {
                status: {},
                lenght: 5,
                page: this.lenght,
                pages:[
                    5,10,20
                ],
                titles: ['#','Pedido','Consignación','Producto','Entregado','Cantidad','Vehiculo','Fecha','Opciones'],
                options: [],
                package: [],
                actions: [
                    {name: 'Ver', route:'remission.show'},
                ],
                moment: moment,
            }
        },
        methods: {
            getPaginate(){
                var url = '/getPaginateAllRemissions/remission',
                    param = '?lenght='+this.lenght,
                    total_url = url + param;

                this.startLoading();

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
