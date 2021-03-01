<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </template>
        <div class="py-12">
            <jet-nav-link :href="route('client.create')">
                <jet-button type="button">
                    Crear Cliente
                </jet-button>
            </jet-nav-link>
            <div class="mt-8" v-if="clients.length">
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
                <table-responsive-component v-if="showTable">
                    <template #title>
                        <tr>
                            <th-responsive-component 
                            v-for="(title, key) in titles"
                            :key="key">{{title}}</th-responsive-component>
                        </tr>
                    </template>
                    <template #content>
                        <tr v-for="(item, key) in clients" :key="key">
                            <td-responsive-component>{{item.user_id}}</td-responsive-component>
                            <td-responsive-component>{{item.users.name}}</td-responsive-component>
                            <td-responsive-component>{{item.users.details.type_pay}}</td-responsive-component>
                            <td-responsive-component>
                                {{item.users.details.name_company}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.users.details.street_address}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.users.details.city}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.users.email}}
                            </td-responsive-component>
                            <td-responsive-component>
                                <span class="text-white p-1 rounded-md" :class="item.users.classStatus">{{item.users.status}}</span>
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
                                        :href="route(option.route, {client: item.id})" :as="option.as" method="option.method">
                                            {{option.name}}
                                        </jet-dropdown-link>
                                        <button type="button"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="updateStatusUser(item)">
                                            {{item.users.status == 'Activo' ? 'Inactivar' : 'Activar'}}
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
    import vSelect from "vue-select"
    import 'vue-select/dist/vue-select.css'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'

    export default {
        components: {
            AdminLayout,
            JetNavLink,
            JetButton,
            TableResponsiveComponent,
            ThResponsiveComponent,
            TdResponsiveComponent,
            vSelect,
            PaginateComponent,
            JetDropdown,
            JetDropdownLink
        },
        mounted(){
            this.getPaginate();
        },
        data() {
            return {
                status: {},
                titles: ['#','Nombre','Tipo','Empresa','Dirección','Ciudad','Correo','Estado','Opciones'],
                showTable: false,
                lenght: 5,
                page: this.lenght,
                pages:[
                    5,10,20
                ],
                actions: [
                    {name: 'Editar', route:'client.edit'},
                    {name: 'Ver', route:'client.show'},
                ],
                clients: []
            }
        },
        methods: {
            validateDataClients(){
                
                for (var i = 0; i < this.clients.length; i++) {

                    if (this.clients[i].users.details) {
                        this.clients[i].users.details.name_company  = this.clients[i].users.details.name_company 
                        ? this.clients[i].users.details.name_company 
                        : 'N/A';

                        this.clients[i].users.details.street_address  = this.clients[i].users.details.street_address 
                        ? this.clients[i].users.details.street_address 
                        : 'N/A';

                        this.clients[i].users.details.city  = this.clients[i].users.details.city 
                        ? this.clients[i].users.details.city 
                        : 'N/A';
                          
                    }else{

                        this.clients[i].users.details = {
                            name_company : 'N/A',
                            street_address : 'N/A',
                            city : 'N/A',
                            email : 'N/A'
                        }
                    }
                    this.clients[i].users.status = this.clients[i].users.status
                    ? 'Activo'
                    : 'Inactivo';

                    this.clients[i].users.classStatus = this.clients[i].users.status == 'Activo' 
                    ? 'bg-green-500'
                    : 'bg-red-500';
                }
                this.showTable = true;
            },
            updateStatusUser(item){
                this.startLoading();
                axios.put('/updateStatus/'+item.id+'/user')
                .then(res => {
                    item.users.status = res.data.user.status ? 'Activo' : 'Inactivo';
                    item.users.classStatus = res.data.user.status 
                    ? 'bg-green-500'
                    : 'bg-red-500';
                    this.setStatusFlash(res.data.type,res.data.text);
                })
                .finally( () =>  this.endLoading())
            },
            getPaginate(){
                this.startLoading();
                var url = '/getClientsPaginate/client';
                var param = '?lenght='+this.lenght;
                var total_url = url + param;
                axios.get(total_url)
                .then(res => {
                    this.clients = res.data.data;
                    this.package = res.data
                })
                .finally( () => {
                    this.validateDataClients();
                    this.endLoading();
                });

            },
            updateData(data){
                this.options = data.data;
                this.package = data;
            },
        }
    }
</script>
