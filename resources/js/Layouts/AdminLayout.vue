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
	props: {
		status: {
            type: Object,
            default: function() {
                return {
                    type: null,
                    text: null
                }
            }
        }
	},
	mounted(){
        console.log(this.$page.props)
		if (this.status.type && this.status.text) {
			this.getNotification();	
		}
		
	},
	data() {
        return {
            
        }
    },
    watch: {
        status: function(){
            this.getNotification(); 
        }
    },
    methods: {
    	getNotification(){
      		if (this.status.type == 'success') {
    			this.openNotification(
    				'top-right',
    				'success',
    				'<i class="bx bx-select-multiple" ></i>',
    				'Hecho',
    				this.status.text)
    		}
    		if (this.status.type == 'error') {
    			this.openNotification(
    				'top-right',
    				'danger',
    				'<i class="bx bxs-bug" ></i>',
    				'Error',
    				this.status.text)
    		}
    		if (this.status.type == 'warning') {
    			this.openNotification(
    				'top-right',
    				'warn',
    				'<i class="bx bx-error" ></i>',
    				'Precaución',
    				this.status.text)
    		}
    		if (this.status.type == 'info') {
    			this.openNotification(
    				'top-right',
    				'primary',
    				'<i class="bx bx-bell" ></i>',
    				'Aviso',
    				this.status.text)
    		}
      		
      	},
        openNotification(position = null, color, icon,title,text) {
          	const noti = this.$vs.notification({
          		progress: 'auto',
          		sticky: true,
	            icon,
	            color,
	            position,
	            title,
	            text
	        })
      	}
    }
}
</script>