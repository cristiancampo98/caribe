export default {
	install(Vue, options) {

		Vue.mixin({
			mounted() {
				this.getStatusFlash();
			},
			props: {
				flash: {
					type: Object
				}
			},
			data() {
				return {
					status: {},
					loader: false,
				}
			},
			methods: {
				setStatusFlash(type, text){
					this.status = {
						type: type,
						text: text
					}
					this.getNotification();
				},
				getStatusFlash(){
		            for (var val in this.flash){

		                if (this.flash[val]) {
		                    
		                    this.status = {
		                        type: val,
		                        text: this.flash[val]
		                    }
		                }
		            }
		            this.getNotification();
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
		      	},
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
		      	startLoading(){
		            this.loader = this.$vs.loading({
		                type: 'circles'
		            });
		            this.loader.text = "Procesando...";
		        },
		        endLoading(){
		            this.loader.close();
		        },
			}
		});
	}
}