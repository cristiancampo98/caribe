<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Asignar permisos
            </h2>
        </template>
        <div class="py-12">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white p-4">
                <p>Seleccione los permisos que asignará a <strong>{{role.name}}</strong> :</p>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-20 mt-8">
                        
                        <div v-for="(item, index) in permissions">
                            <vs-checkbox 
                            class="capitalize hover:underline hover:text-green-500" 
                            v-model="seen"  
                            :val="index"
                            >
                                <template #icon>
                                    <i  class='bx bx-collection' ></i>
                                </template>
                                Permisos para {{index}}
                            </vs-checkbox>
                            <div class="ml-4" v-for="group in seen" v-if="group == index">
                                <vs-checkbox
                                success
                                class="capitalize"
                                v-for="(perm, key) in item" 
                                :key="key"
                                :val="{id: perm.id, name: perm.name}"
                                v-model="form.permissions"
                                >
                                    {{perm.name}}
                                </vs-checkbox>
                            </div>
                        </div>
                    </div>
                     <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <jet-action-message :on="reset" class="mr-3">
                            Restablecido.
                        </jet-action-message>

                        <button type="button" class="mx-2 inline-flex items-center px-4 py-2 bg-transparent border border-red-600 rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-red-600 hover:text-white active:bg-red-600 focus:outline-none focus:border-white transition ease-in-out duration-150" @click="setPermissionsToFormPermissions(true)">
                            Restablecer
                        </button>

                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Guardar
                        </jet-button>
                    </div>
                </form>
            </div>
        </div>
    </admin-layout>
</template>

<script>

import AdminLayout from '@/Layouts/AdminLayout'
import JetButton from '@/Jetstream/Button'
import JetActionMessage from '@/Jetstream/ActionMessage'


export default {
    components: {
        AdminLayout,
        JetButton,
        JetActionMessage,
    },
    props: {
        permissions: {
            Object
        },
        role: {
            Object
        }
    },
    mounted(){
        this.setPermissionsToFormPermissions()
        
    },
    data () {
        return {
            breadcrumb: {
                current_page: 'Listar roles', 
                others_pages: {
                    'Listar roles': 'role.index',
                    'Asignar permiso': '#'
                }
            },
            form: this.$inertia.form({
                role_id: this.role.id,
                permissions: []
            }),
            reset: false,
            seen: []
        }
    },
    methods: {
        submit(){
             this.$inertia.post('/permissionRole', this.form)
        },
        setPermissionsToFormPermissions(isReset = false){
            this.seen = [];
            this.form.permissions = [];

            this.role.permissions.map( (item) => {

                const found = this.seen.find(value => value == item.controller)

                if (!found) {
                    this.seen.push(item.controller)    
                }

                const data = {
                    id : item.id,
                    name : item.name
                }
                
                this.form.permissions.push(data)
            });

            this.reset = isReset
        },

    }
}
</script>
