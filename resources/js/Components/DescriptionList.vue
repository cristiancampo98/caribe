<template>
	<!-- This example requires Tailwind CSS v2.0+ -->
	<div class="bg-white shadow overflow-hidden sm:rounded-lg">
		<div class="px-4 py-5 sm:px-6">
			<h3 class="text-lg leading-6 font-medium text-gray-900">
				<slot name="title"></slot>
			</h3>
			<p class="mt-1 max-w-2xl text-sm text-gray-500">
				<slot name="subtitle"></slot>
			</p>
		</div>
		<div class="border-t border-gray-200">
			<dl>
				<slot></slot>
			</dl>
		</div>
	</div>
</template>