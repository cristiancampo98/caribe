<template>
	<div>
        <!-- navbar -->
		<partial-navbar/>

		<div class="flex h-screen">
            <!-- sidebar -->
            <partial-sidebar/>
			<!-- end sidebar -->

			<div class="w-full">
				<header class="bg-white shadow" v-if="$slots.header">
	                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
	                    <slot name="header"></slot>
	                </div>
	            </header>
				<main>
	                <slot></slot>
	            </main>
			</div>
		</div>
	</div>
</template>
<script>
import PartialNavbar from '@/Partials/Navbar'
import PartialSidebar from '@/Partials/Sidebar'
import 'boxicons/css/boxicons.min.css'

export default {
	components: {
        PartialNavbar,
        PartialSidebar
	},
}
</script>