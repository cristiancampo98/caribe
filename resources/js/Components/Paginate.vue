<template>
	<!-- This example requires Tailwind CSS v2.0+ -->
	<div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
		<div v-if="package.data" class="flex-1 flex justify-between sm:hidden">
			<a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
				Anterior
			</a>
			<a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
				Siguiente
			</a>
		</div>
		<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
			<div v-if="package.data">
				<p class="text-sm text-gray-700">
					Mostrando
					<span class="font-medium">{{package.from}}</span>
					hasta
					<span class="font-medium">{{package.to}}</span>
					de
					<span class="font-medium">{{package.total}}</span>
					resultados
				</p>
			</div>
			<div v-else>
				<p class="text-sm text-gray-700">No hay registros.</p>
			</div>
			<div>
				<nav v-if="package.data" class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">
					<button v-if="package.current_page != 1" @click="prevPageUrl" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
						<span class="sr-only">Anterior</span>
						<!-- Heroicon name: solid/chevron-left -->
						<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
						</svg>
					</button>
					<button
					v-for="i in package.last_page"
					:key="i"
					@click="getPage(i)"
					:class="classes(i)">
						{{i}}
					</button>
					

					<button v-if="package.current_page != package.last_page" @click="nextPageUrl" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
						<span class="sr-only">Siguiente</span>
						<!-- Heroicon name: solid/chevron-right -->
						<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
						</svg>
					</button>
				</nav>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			package: {
				type: [Array, Object]
			}
		},
		data() {
			return {
				active: false,
				loading: null,
			}
		},
		computed: {
			
		},
		methods: {
			getPage(page){
				var url = this.package.path;
				var params = '?lenght='+this.package.per_page+'&page='+page;
				var total_url = url + params;
				axios.get(total_url)
				.then(res => {
					this.startLoading();
					this.$emit('updatingData', res.data)
				})
				.finally( () => {
					this.endLoading();
				});
			},
			prevPageUrl() {
				axios.get(this.package.prev_page_url+'&lenght='+this.package.per_page)
				.then(res => {
					this.startLoading();
					this.$emit('updatingData', res.data)
				})
				.finally( () => {
					this.endLoading();
				});
			},
			nextPageUrl() {
				axios.get(this.package.next_page_url+'&lenght='+this.package.per_page)
				.then(res => {
					this.startLoading();
					this.$emit('updatingData', res.data)
				})
				.finally( () => {
					this.endLoading();
				});
			},
			classes(page){
				return page == this.package.current_page
				? 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50'
				: 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'
			},
			startLoading(){
				
				this.loading = this.$vs.loading({
            		type: 'circles'
            	});
            	this.loading.text = "Procesando...";

			},
			endLoading(){
				this.loading.close();
			}
		}
	}
</script>