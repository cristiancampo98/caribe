<template>
	<div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
		<dt class="text-sm font-medium text-gray-500">
			{{title}}
		</dt>
		<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
			<ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
				<li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm"
				v-for="(item, key) in files" :key="key">
					<div class="w-0 flex-1 flex items-center">
						<!-- Heroicon name: solid/paper-clip -->
						<svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
						</svg>
						<span class="ml-2 flex-1 w-0 truncate">
							{{item.filename}}
							<button class="bg-blue-500 text-white py-1 px-2 ml-2 rounded-lg">Consecutivo # {{item.model_id}}</button>
						</span>

					</div>
					<div class="ml-4 flex-shrink-0">
						<a :href="`/storage/${item.path}`" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">
							Abrir
						</a>
					</div>
				</li>
			</ul>
		</dd>
	</div>
</template>
<script>
	export default{
		props: ['files','title']
	}
</script>