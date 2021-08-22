<template>
	<div class="m-3 border border-gray-400">
		<div class="bg-white py-2">
			<div class="grid grid-cols-5 gap-4">
				<div>
					<img class="w-16 md:w-32 lg:w-48" src="/images/Logos-01.png" alt="Logo empresa">
				</div>
				<div class="col-span-3 text-center">
					<p class="">La negociación a que este documento se refiere se entenderá completa con la presentación para el cobro de la factura debidamente aceptada y la constancia de recibo de la mercancía o los servicos específicados.</p>
					<h4 class="font-bold">"SE DEBE PRESENTAR ANTES DE 3 MESES DESPUES DE SU EXPEDICIÓN"</h4>
				</div>
			</div>
			

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
					<dt class="bg-gray-300 p-1">Lugar de cargue</dt>
					<dd class="p-1">
						{{remission.order_detail.order.place_loading}}
					</dd>
				</div>
				<div class="flex-1 border border-gray-400">
					<dt class="bg-gray-300 p-1">Destino</dt>
					<dd class="p-1">
						{{remission.order_detail.order.department}} - {{remission.order_detail.order.city}}.
						Dirección: {{remission.order_detail.order.shipping_address}}
						</dd>
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
					<dd class="p-1">{{remission.order_detail.quantity | formatNumber}} m3</dd>				
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
					<dt class="font-bold">Remitido por</dt>
					<dd class="-mt-3 text-xl underline">{{remission.creator.name}}</dd>
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

