<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Consignaciones
            </h2>
        </template>
        <div class="py-12">
           <jet-nav-link :href="route('consignment.create')" class="m-8">
                <jet-button type="button">
                    Crear consignación
                </jet-button>
            </jet-nav-link>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-3">
                    <label for="lenght">Paginar: </label>
                    <v-select
                    id="lenght"
                    class="w-20 bg-white"
                    v-model="lenght"
                    :options="pages"
                    @input="getPaginateOrders"
                    :clearable="false"></v-select>
                </div>
            </div>
            
                
            <table-responsive-component v-if="loading">
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
                            {{item.pse_url}}
                        </td-responsive-component>
                        <td-responsive-component>
                            {{item.pse_number}}
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
                                    :href="route(option.route, {id: item.id})" :as="option.as" method="option.method">
                                        {{option.name}}
                                    </jet-dropdown-link>
                                    <!-- <button type="button"
                                    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                    @click="updateStatusUser(item)">
                                        {{item.users.status == 'Activo' ? 'Inactivar' : 'Activar'}}
                                    </button> -->

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
                loading: false,
                lenght: 5,
                page: this.lenght,
                pages:[
                    5,10,20
                ],
                titles: ['#','Cliente','# Pedido','# Consignación','Url','# PSE','Fecha','Opciones'],
                options: [],
                package: [],
                actions: [
                    {name: 'Editar', route:'consignment.edit'},
                    {name: 'Ver', route:'consignment.show'},
                ]
            }
        },
        mounted(){
            this.getPaginateOrders();
        },
        methods: {
            getPaginateOrders(){
                var url = '/getAllConsignments/consignments';
                var param = '?lenght='+this.lenght;
                var total_url = url + param;
                axios.get(total_url)
                .then(res => {
                    this.options = res.data.data;
                    this.package = res.data
                })
                .finally( () => this.loading = true);

            },
            updateData(data){
                this.options = data.data;
                this.package = data;
            }
        }
    }
</script>
