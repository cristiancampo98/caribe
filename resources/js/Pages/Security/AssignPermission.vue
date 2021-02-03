<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Assignar permisos
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                	
                    <div class="mx-8 my-8">
                    	<p>Seleccione los permisos que asignará a <strong>{{role.name}}</strong> :</p>
                    	<form @submit.prevent="submit">
                    		<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-20 mt-8">
                        		<div class="center con-checkbox capitalize" 
	                        	v-for="(item, index) in permissions"
	                        	:key="index">
	                        		<vs-checkbox 
	                        		:val="{id: item.id, name: item.name}"
	                        		v-model="form.permissions"
	                        		>
	                        			{{item.name}}    
								    </vs-checkbox>
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
        	form: this.$inertia.form({
		        role_id: this.role.id,
		        permissions: []
		    }),
		    reset: false
        }
    },
    methods: {
    	submit(){
    		 this.$inertia.post('/permissionRole', this.form)
    	},
    	setPermissionsToFormPermissions(isReset = false){
    		this.form.permissions = this.role.permissions.map( function (item) {
    			var data = {};
    			data.id = item.id;
    			data.name = item.name;
    			return data
    		});
    		this.reset = isReset
    	}

    }
}
</script>
