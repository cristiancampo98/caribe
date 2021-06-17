<template>
	<div class="m-3 border border-gray-400">
		<div class="bg-white py-2">
			<img class="w-16 md:w-32 lg:w-48" src="/images/Logos-01.png" alt="Logo empresa">
			<div class="flex  px-2">
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Fecha de remisión</dt>
					<dd class="p-1">{{moment(remission.created_at).format('DD/MM/YYYY')}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Consecutivo de remisión</dt>
					<dd class="p-1">{{remission.id}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Consecutivo de pedido</dt>
					<dd class="p-1">{{remission.order_detail.order.id}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Versión</dt>
					<dd class="p-1">2</dd>
				</div>
			</div>
			<div class="flex  px-2">
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Empresa</dt>
					<dd class="p-1">{{remission.order_detail.order.client.details.name_company}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Cliente</dt>
					<dd class="p-1">{{remission.order_detail.order.client.name}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Correo</dt>
					<dd class="p-1">{{remission.order_detail.order.client.email}}</dd>
				</div>
			</div>
			<div class="flex  px-2">
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Departamento</dt>
					<dd class="p-1">{{remission.order_detail.order.client.details.deparment}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Ciudad</dt>

					<dd class="p-1">{{remission.order_detail.order.client.details.city}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Dirección</dt>
					<dd class="p-1">{{remission.order_detail.order.client.details.street_address}}</dd>

				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Telefono</dt>
					<dd class="p-1">{{remission.order_detail.order.client.details.phones}}</dd>
				</div>
			</div>
			<div class="flex  px-2">
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Producto</dt>
					<dd class="p-1">{{remission.order_detail.product.name}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Cantidad entregada</dt>
					<dd class="p-1">{{remission.delivered | formatNumber}} m3</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Cantidad del producto</dt>
					<dd class="p-1">{{remission.order_detail.quantity | formatNumber m3}}</dd>				
				</div>
			</div>
			<div class="flex  px-2">
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Conductor</dt>
					<dd class="p-1">{{remission.carrier.carrier}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Identificación</dt>
					<dd class="p-1">{{remission.carrier.identification_number}}</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Placa</dt>
					<dd class="p-1 uppercase">{{remission.carrier.vehicle.license_plate}}</dd>
				</div>
			</div>
			<div class="flex" 
			v-if="multimedia.length">
				<div class="flex-1 p-2"
				v-for="(item, key) in multimedia" 
				:key="key">
					<vue-image
	            	:title="item.filename"
	            	:path="item.path"
	            	:description="item.reason"></vue-image>
				</div>
			</div>
			<div class="flex flex-row-reverse mr-4">
				<div>
					<dt>Remitido por</dt>
					<dd>{{remission.creator.name}}</dd>
				</div>				
			</div>
		</div>
		
	</div>
</template>
<script>
import VueImage from '@/Components/VueImage'
import moment from 'moment';
moment.locale('es')
export default {
	components: {
		VueImage
	},
	props: {
		remission: Object
	},
	data() {
		return {
			multimedia : [],
			moment: moment,
		}
	},
	async mounted() {
		await this.getMultimediaFilesByRemission();
		setTimeout(print, 1000)
	},
	methods: {
	    getMultimediaFilesByRemission(){
	    	this.startLoading();
	        axios.get(`/getMultimediaFilesByRemission/${this.remission.id}/remission`)
	        .then( res => {
	            this.multimedia = res.data;
	        })
	        .finally( () => {
	        	this.endLoading();
	        });
	    },
	    print(){
	    	window.print
	    }
	}
}
</script>

