<template>
	<div class="w-64 p-6 hidden md:block border-r border-gray-200">
		<img class="w-16 md:w-32 lg:w-48" src="images/Logos-01.png" alt="...">
		<h6 class="font-bold mb-4">Menu</h6>
		<ul class="mb-8">
			<div v-for="(item, index) in menu" 
			:key="index"
			class="hover:bg-white px-1 py-0.5 rounded-md" 
			>
				<li class="flex   text-gray-900" v-if="item.items.length">
					
					<jet-dropdown align="center" width="48">
	                    <template #trigger>
	                    	<span  class="inline-flex rounded-md">
	                            <button type="button" class="inline-flex items-center  text-gray-900 hover:text-blue-400 focus:outline-none transition ease-in-out duration-150">
	                            	<div class="bg-white shadow-sm mr-3 p-2 rounded-lg">
										<img src="img/home.svg">
									</div>
	                                {{ item.name }}

	                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
	                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
	                                </svg>
	                            </button>
	                        </span>
	                    </template>

	                    <template #content>
	                        <!-- Account Management -->
	                        <div class="block px-4 py-2 text-xs text-gray-400">
	                            Manage Account
	                        </div>

	                        <jet-dropdown-link v-for="(value, key) in item.items"
	                        :key="key"
	                        :href="route(value.route)">
	                            {{value.name}}
	                        </jet-dropdown-link>

	                    </template>
	                </jet-dropdown>
				</li>
				<inertia-link v-else :href="route(item.slug)">
					<li class="flex  text-gray-900 hover:text-blue-400">
						<div class="bg-white shadow-sm mr-3 p-2 rounded-lg">
							<img src="img/home.svg">
						</div>
						<span class="self-center">{{item.name}}</span>
					</li>
				</inertia-link>
			</div>
		</ul>
	</div>
</template>
<script>
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'

export default {
	components: {
		JetDropdown,
		JetDropdownLink
	},
	data () {
		return {
			isLoading : false,
			menu : []
		}
	},
	created() {
		this.getAccessMenu();
	},
	methods: {
		getAccessMenu(){
			axios.get('/security/getAccessMenu')
    		.then(res => {
				this.menu = res.data;
			})
			.finally( () => { this.isLoading = false })
		},
	}
}
</script>