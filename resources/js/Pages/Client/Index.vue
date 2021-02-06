<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <jet-nav-link :href="route('client.create')" class="m-8">
                        <jet-button type="button">
                            Crear Cliente
                        </jet-button>
                    </jet-nav-link>

                    <div class="m-8" v-if="Object.keys(clients).length">
                        <table-responsive-component>
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
                                    <td-responsive-component>{{item.users.email}}</td-responsive-component>
                                    <td-responsive-component>
                                    {{item.users.details ? item.users.details.city : 'N/A'}}</td-responsive-component>
                                    <td-responsive-component>
                                        <button type="button" class="bg-red-500 hover:bg-red-700 rounded-lg border-2 border-white hover:border-black text-white py-1 px-2">
                                            Eliminar
                                        </button>
                                    </td-responsive-component>

                                </tr>
                            </template>
                        </table-responsive-component>
                        
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
    import TableResponsiveComponent from '@/Components/TableResponsive'
    import ThResponsiveComponent from '@/Components/THResponsive'
    import TdResponsiveComponent from '@/Components/TDResponsive'

    export default {
        components: {
            AdminLayout,
            JetNavLink,
            JetButton,
            TableResponsiveComponent,
            ThResponsiveComponent,
            TdResponsiveComponent
        },
        props: {
            clients: {
                type: [Object, Array],
                required: true
            }

        },
        data() {
            return {
                titles: ['#','Nombre','Correo','Ciudad'],
            }
        }
    }
</script>
