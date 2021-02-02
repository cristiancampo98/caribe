<template>
	<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <div class="mt-8 text-2xl">
            <slot name="title"></slot>
        </div>
        <div class="mt-6 text-gray-500">
           <slot name="description"></slot>
        </div>
        <div class="pt-6">
        	<slot name="content"></slot>
        </div>
    </div>
</template>