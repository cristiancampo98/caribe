import AdminLayout from '@/Layouts/AdminLayout'
import DescriptionListComponent from '@/Components/DescriptionList'
import ItemListComponent from '@/Components/ItemList'
import moment from 'moment'
moment.locale('es')

export const ShowViewComponentMixin = {
	components: {
		AdminLayout,
		DescriptionListComponent,
		ItemListComponent
	},
	beforeCreate() {
    	console.log('Hook called from ShowViewComponentMixin.js')
    },
    data() {
    	return {
    		moment: moment
    	}
    }

}