<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                	<jet-nav-link :href="route('role.create')" class="m-8">
                		<jet-button type="button">
                			Crear rol
                		</jet-button>
                	</jet-nav-link>
                    <div class="mx-8 my-8">

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-20 mt-8">
                            <div v-for="(item, index) in roles"
                            class="border-2 border-gray hover:border-blue-500 hover:bg-blue-50 rounded-md text-black pb-16">
                                <h3 class="mx-2 my-2 text-xl">{{item.name}}
                                    <span class="float-right">
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
                                                :href="route(option.route, {role: item.id})" :as="option.as" method="option.method">
                                                    {{option.name}}
                                                </jet-dropdown-link>

                                            </template>
                                        </jet-dropdown>
                                        
                                    </span>
                                </h3>
                                <p class="mx-2 my-2 text-justify text-black text-opacity-50 hover:text-opacity-100 truncate ">{{item.description}}</p>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetButton from '@/Jetstream/Button'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'

    export default {
        components: {
            AdminLayout,
            JetNavLink,
            JetButton,
            JetDropdown,
            JetDropdownLink
        },
        props: {
            roles: {
                Object
            }
        },
        data () {
            return {
                options: [
                    {name: 'Editar', route:'role.edit', method: 'get' , as: ""},
                    {name: 'Asignar permisos', route:'security.assignPermission', method: 'get' , as: ""},
                    {name: 'Eliminar', route:'role.destroy', method: 'delete' , as: "button"},
                ]
            }
        }
    }
</script>
