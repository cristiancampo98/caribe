<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-nav-link :href="route('user.create')" class="my-8">
                    <jet-button type="button">
                        Crear usuario
                    </jet-button>
                </jet-nav-link>
                    <table-responsive-component v-if="showTable">
                    <template #title>
                        <tr>
                            <th-responsive-component 
                            v-for="(title, key) in titles"
                            :key="key">{{title}}</th-responsive-component>
                            <th-responsive-component>Opciones</th-responsive-component>
                        </tr>
                    </template>
                    <template #content>
                        <tr v-for="(item, key) in users" :key="key">
                            <td-responsive-component>{{item.id}}</td-responsive-component>
                            <td-responsive-component>{{item.name}}</td-responsive-component>
                            <td-responsive-component>
                                {{item.details.number_identification}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.details.street_address}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.details.city}}
                            </td-responsive-component>
                            <td-responsive-component>
                                <div class="center">
							      <vs-tooltip>
							        <vs-button flat>
							          Ver roles
							        </vs-button>
							        <template #tooltip>
							          <ul>
							          	<li v-for="(rol, key) in item.roles">{{rol.name}}</li>
							          </ul>
							        </template>
							      </vs-tooltip>
							    </div>
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.email}}
                            </td-responsive-component>
                            <td-responsive-component>
                                <span :class="item.classStatus">{{item.status}}</span>
                                
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
                                        :href="route(option.route, {user: item.id})" :as="option.as" method="option.method">
                                            {{option.name}}
                                        </jet-dropdown-link>
                                        <button type="button"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="updateStatusUser(item)">
                                            {{item.status == 'Activo' ? 'Inactivar' : 'Activar'}}
                                        </button>

                                    </template>
                                </jet-dropdown>
                            </td-responsive-component>

                        </tr>
                    </template>
                </table-responsive-component>
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

        },
        mounted(){
            this.getPaginateAllUsers();
            
        },
        data() {
            return {
                titles: ['#','Nombre','No. Documento','Dirección','Ciudad','Correo','Roles','Estado'],
                showTable: false,
                options: [
                    {name: 'Editar', route:'user.edit'},
                    {name: 'Ver', route:'user.show'},
                ],
                showTable: false,
                users: {
	                type: [Object, Array],
	                required: true
	            }

            }
        },
        methods: {
            getPaginateAllUsers(){
            	axios.get('getPaginateAllUsers/users')
            	.then(res => {
            		this.users = res.data.users;

            		for (var i = 0; i < this.users.length; i++) {

	                    if (this.users[i].details) {

	                        this.users[i].details.number_identification  = this.users[i].details.number_identification 
	                        ? this.users[i].details.number_identification 
	                        : 'N/A';

	                        this.users[i].details.street_address  = this.users[i].details.street_address 
	                        ? this.users[i].details.street_address 
	                        : 'N/A';

	                        this.users[i].details.city  = this.users[i].details.city 
	                        ? this.users[i].details.city 
	                        : 'N/A';
	                          
	                    }else{
	                        this.users[i].details = {
	                            number_identification : 'N/A',
	                            street_address : 'N/A',
	                            city : 'N/A',
	                            email : 'N/A'
	                        }
	                    }
	                    this.users[i].status = this.users[i].status
	                    ? 'Activo'
	                    : 'Inactivo';

	                    this.users[i].classStatus = this.users[i].status == 'Activo' 
	                    ? 'text-white bg-green-500 p-1 rounded-md'
	                    : 'text-white bg-red-500 p-1 rounded-md';
	                }
	                this.showTable = true;
            	});
                
            },
            updateStatusUser(item){
                axios.put('/updateStatus/'+item.id+'/user')
                .then(res => {
                    item.status = res.data.user.status ? 'Activo' : 'Inactivo';
                    item.classStatus = res.data.user.status 
                    ? 'text-white bg-green-500 p-1 rounded-md'
                    : 'text-white bg-red-500 p-1 rounded-md';
                })
            }
        }
    }
</script>
