<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-nav-link :href="route('client.create')" class="my-8">
                    <jet-button type="button">
                        Crear Cliente
                    </jet-button>
                </jet-nav-link>
                <div v-if="Object.keys(clients).length">
                    <table-responsive-component v-if="showTable">
                        <template #title>
                            <tr>
                                <th-responsive-component 
                                v-for="(title, key) in titles"
                                :key="key">{{title}}</th-responsive-component>
                                <th-responsive-component></th-responsive-component>
                            </tr>
                        </template>
                        <template #content>
                            <tr v-for="(item, key) in clients" :key="key">
                                <td-responsive-component>{{item.user_id}}</td-responsive-component>
                                <td-responsive-component>{{item.users.name}}</td-responsive-component>
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
                                    <span :class="item.users.classStatus">{{item.users.status}}</span>
                                    
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

                                            <jet-dropdown-link v-for="(option,key) in options"
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
                    
                </div>
            </div>
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
            JetDropdown,
            JetDropdownLink
        },
        props: {
            clients: {
                type: [Object, Array],
                required: true
            }

        },
        mounted(){
            this.validateDataClients();
            
        },
        data() {
            return {
                titles: ['#','Nombre','Empresa','Dirección','Ciudad','Correo','Estado'],
                showTable: false,
                options: [
                    {name: 'Editar', route:'client.edit'},
                    {name: 'Ver', route:'client.show'},
                ]
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
                    ? 'text-white bg-green-500 p-1 rounded-md'
                    : 'text-white bg-red-500 p-1 rounded-md';
                }
                this.showTable = true;
            },
            updateStatusUser(item){
                axios.put('/updateStatus/'+item.id+'/user')
                .then(res => {
                    item.users.status = res.data.user.status ? 'Activo' : 'Inactivo';
                    item.users.classStatus = res.data.user.status 
                    ? 'text-white bg-green-500 p-1 rounded-md'
                    : 'text-white bg-red-500 p-1 rounded-md';
                })
            }
        }
    }
</script>
