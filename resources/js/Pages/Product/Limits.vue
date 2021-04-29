<template>
	<admin-layout>
		<template #header>
			Límites de producción de productos
		</template>
		<div class="py-12">
			<ul v-if="error" class="bg-red-500 text-white">
				<li>El valor de la cantidad del limite de la producción del producto debe ser menor  1000</li>
			</ul>
			<table-responsive-component>
			  	<template #title>
                    <tr>
                        <th-responsive-component 
                        v-for="(title, key) in titles"
                        :key="key">{{title}}</th-responsive-component>
                    </tr>
                </template>
                <template #content>
                    <tr v-for="(item, key) in products" :key="key">
                    	<td-responsive-component class="uppercase">{{item.name}}</td-responsive-component>
                    	<td-responsive-component>
                    		<jet-input type="number" class="mt-1 block w-full" v-model.number="item.limit_day" min="1" max="999.9" required/>
                    	</td-responsive-component>
                    	<td-responsive-component>
                    		<button type="button" @click="updateLimits(item)" class="border-2 border-green-500 hover:bg-green-500 hover:text-white p-1 rounded-md">Actualizar</button>
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
			products: {
				type: Array,
				required: true
			},
		},
		data() {
			return {
				titles: ['Producto','Límite producción','Opciones'],
				error: false
			}
		},
		methods: {
			updateLimits(item) {
				this.startLoading();
				console.log(item)
				const data = {
					id: item.id,
					limit_day: item.limit_day,
					
				}
				axios.put(`/updateLimits/${data.id}`, data)
				.then( res => {
					this.setStatusFlash(res.data.type, res.data.text)
					this.error = false
				})
				.catch( (err) => {
					this.error = true
				})
				.finally( () => {
					this.endLoading();
				})
			}
		}
	}
</script>