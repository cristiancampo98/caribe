<template>
	<div class="grid grid-flow-row lg:grid-flow-col gap-4 auto-rows-min lg:auto-cols-max">
		<div >
            <jet-label for="user_id" value="Cliente" />
            <v-select 
            class="lg:w-72 md:64 min-w-full lg:min-w-max"
	        label="name" 
	        :filterable="false" 
	        :options="clients"
	        :reduce= "clients => clients.id"
	        @search="onSearch"
	        v-model="user_id"
	        @input="loadOrders">
			    <template slot="no-options">
			      Escribe el nombre de un cliente
			    </template>
			    <template slot="option" slot-scope="option">
			      <div class="d-center">
			        <p> Nombre: {{ option.name }}</p>
			        <cite>Empresa: {{ option.name_company }}</cite>
			        </div>
			    </template>
			    <template slot="selected-option" slot-scope="option">
			      <div class="selected d-center">
			      	 <p>{{ option.name }}</p>
			      	 <cite>Empresa: {{ option.name_company }}</cite>
			      </div>
			    </template>
			</v-select>
            <jet-input-error :message="error_client" class="mt-2" />
        </div>
        <div v-if="orders.length">
            <jet-label for="order_id" value="Pedidos" />
            <v-select 
	        label="id" 
	        class="lg:w-72 md:64 min-w-full lg:min-w-max"
	        :options="orders" 
	        v-model="order_id"
	        :reduce= "orders => orders.id"
	        @input="showDetailOrder">
			    <template slot="option" slot-scope="option">
			      <div class="d-center">
			        <p> Pedido #: {{ option.id }}</p>
			        <cite>Cliente: {{ user_name }}</cite>
			        </div>
			    </template>
			    <template slot="selected-option" slot-scope="option">
			      <div class="selected d-center">
			      	 <p>Pedido #: {{ option.id }}</p>
			      </div>
			    </template>
			</v-select>
            <jet-input-error :message="error_client" class="mt-2" />
        </div>
	</div>
</template>
<script>
	import JetLabel from '@/Jetstream/Label'
	import JetInputError from '@/Jetstream/InputError'
	import vSelect from "vue-select"
	import 'vue-select/dist/vue-select.css'
	export default {
		components: {
	        JetLabel,
	        JetInputError,
	        vSelect
	    },
	    async mounted() {	
	    	await this.loadClientSave();
	    },
	    data() {
	    	return {
	    		clients: [],
	    		orders: [],
	    		details: [],
	    		order_id: null,
	    		user_id: null,
	    		user_name: null,
	    		error_client: null,
	    	}
	    },
	    props: {
	    	client: {
	    		type: Object,
	    		required: false
	    	},
	    	default_order_id: {
	    		type: Number,
	    		required: false
	    	},
	    },
	    watch: {
	    	details() {
	    		this.$emit("getDetailsOrder", this.details);
	    	},
	    	order_id() {
	    		if (this.order_id) {
	    			this.$emit("getValueOrderId", this.order_id);	
	    		} else {
	    			this.details = [];
	    		}
	    	},
	    	user_id() {
	    		if (!this.user_id) {
	    			this.order_id = [];
	    		}
	    	}
	    },
	    methods: {
	    	onSearch(search, loading) {
	    		if(search.length >= 3) {
	    			loading(true);
	    			this.search(loading, search, this);
	    		}
	    	},
	    	search: _.debounce((loading, search, vm) => {
	    		axios.get(
	    			`/getClientWithOrders/client?q=${search}`
	    			).then(res => {
	    				vm.clients = res.data.clients;
	    				vm.setStatusFlash(res.data.type, res.data.text);
	    				loading(false);
	    			});
	    	}, 350),
	    	loadOrders(value){
	    		if (value) {
	    			this.startLoading();
			    	this.clients.map( item => {
			    		if (item.id == value) {
			    			
			    			this.user_name = item.name;
			    		}
			    	})
			    	axios.get(
			    		`/getOrdersByUserId/order?id=${value}`
			    	).then( res => {
			    		this.orders = res.data.orders;
			    		this.setStatusFlash(res.data.type, res.data.text);
			    	})
			    	.finally( () => this.endLoading());
	    		} else {
	    			this.user_id = null;
	    			this.order_id = null;
	    			this.orders = [];
	    		}
		    },
		    showDetailOrder(value){
		    	if (value) {
		    		this.startLoading();
			    	axios.get(
			    		`/getOrderDetailsByOrderId/orderDetail?id=${value}`
			    	).then( res => {
			    		this.details = res.data.details;
			    		this.setStatusFlash(res.data.type, res.data.text);
			    	})
			    	.finally( () => this.endLoading());
		    	} else {
		    		this.details = [];
		    	}
		    },
		    loadClientSave() {
		    	if (this.client) {	
		    		this.user_id = this.client.user_id
		    		this.order_id = this.default_order_id
		    		axios.get(
	    				`/getClientWithOrders/client?q=${this.client.name}`
	    			).then(res => {
	    				this.clients = res.data.clients;
	    				if (this.user_id) {
	    					axios.get(
					    		`/getOrdersByUserId/order?id=${this.user_id}`
					    	).then( res => {
					    		this.orders = res.data.orders;
					    		axios.get(
						    		`/getOrderDetailsByOrderId/orderDetail?id=${this.order_id}`
						    	).then( res => {
						    		this.details = res.data.details;
						    	})
					    	})
	    				}
	    			});
		    	}
		    },

	    }
	}
</script>