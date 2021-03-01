export const loadingMixin = {
	data() {
		return {
			loading: false,
		}
	},
	methods: {
		startLoading(){    
			console.log('hello mixin')
            this.loading = this.$vs.loading({
                type: 'circles'
            });
            this.loading.text = "Procesando...";
        },
        endLoading(){
            this.loading.close();
        },
	}
}