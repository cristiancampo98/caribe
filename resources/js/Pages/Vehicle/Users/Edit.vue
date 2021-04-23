<template>
	<admin-layout>
		<template #header>
			Clientes asignados a vehículos
		</template>
		<div class="py-12">
			<table-responsive-component>
			  	<template #title>
                    <tr>
                        <th-responsive-component 
                        v-for="(title, key) in titles"
                        :key="key">{{title}}</th-responsive-component>
                    </tr>
                </template>
                <template #content>
                    <tr v-for="(item, key) in data" :key="key">
                    	<td-responsive-component>
                    		<p>Cliente: {{item.client.name}}</p>
                    		<cite>Empresa: {{item.client.details.name_company}}</cite>
                    	</td-responsive-component>
                    	<td-responsive-component class="uppercase">{{item.vehicle.license_plate}}</td-responsive-component>
                    	<td-responsive-component class="uppercase">{{item.vehicle.brand}}</td-responsive-component>
                    	<td-responsive-component>
                    		<jet-input type="text" class="mt-1 block w-full" v-model="item.carrier" required/>
                    	</td-responsive-component>
                    	<td-responsive-component>
                    		<button type="button" @click="updateVehicleUser(item)" class="border-2 border-green-500 hover:bg-green-500 hover:text-white p-1 rounded-md">Actualizar</button>
                    	</td-responsive-component>
                    </tr>
                </template>
			</table-responsive-component>
			
		</div>
	</admin-layout>
	
</template>
<script>
	import AdminLayout from '@/Layouts/AdminLayout'
	import TableResponsiveComponent from '@/Components/TableResponsive'
	import ThResponsiveComponent from '@/Components/THResponsive'
	import TdResponsiveComponent from '@/Components/TDResponsive'
	import JetInput from '@/Jetstream/Input'
	import vSelect from "vue-select"
	import 'vue-select/dist/vue-select.css'

	export default {
		components: {
			AdminLayout,
			TableResponsiveComponent,
			ThResponsiveComponent,
			TdResponsiveComponent,
			JetInput,
			vSelect,
		},
		props: {
			data: {
				type: Object,
				required: true
			},
			clients: {
				type: Object,
				required: true
			},
		},
		data() {
			return {
				titles: ['Cliente/Empresa','Vehiculo','Marca','Conductor','Opciones']
			}
		},
		methods: {
			updateVehicleUser(item) {
				this.startLoading();
				const data = {
					id: item.id,
					user_id: item.user_id,
					vehicle_id: item.vehicle_id,
					carrier: item.carrier
				}
				axios.put(`/vehicle-user/${data.id}`, data)
				.then( res => {
					this.setStatusFlash(res.data.type, res.data.text)
				})
				.finally( () => this.endLoading())
			}
		}
	}
</script>