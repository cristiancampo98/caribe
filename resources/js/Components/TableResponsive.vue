<template>
	<div class="flex flex-col">
		<div class="my-2 overflow-x-auto md:overflow-visible md:overflow-visible lg:overflow-visible sm:-mx-6 lg:-mx-8">
			<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
				<div class="shadow overflow-visible border-b border-gray-200 sm:rounded-lg rounded-md">
					<table class="min-w-full divide-y divide-gray-200" id="my-table">
						<thead class="bg-gray-50">
							<slot name="title"></slot>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							<slot name="content"></slot>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</template>