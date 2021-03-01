import AdminLayout from '@/Layouts/AdminLayout'
import JetNavLink from '@/Jetstream/NavLink'
import JetButton from '@/Jetstream/Button'
import TableResponsiveComponent from '@/Components/TableResponsive'
import ThResponsiveComponent from '@/Components/THResponsive'
import TdResponsiveComponent from '@/Components/TDResponsive'
import vSelect from "vue-select"
import 'vue-select/dist/vue-select.css'
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'
import PaginateComponent from '@/Components/Paginate'


export const DataTableComponentMixin = {

	components: {
     	AdminLayout,
        JetNavLink,
        JetButton,
        TableResponsiveComponent,
        ThResponsiveComponent,
        TdResponsiveComponent,
        vSelect,
        PaginateComponent,
        JetDropdown,
        JetDropdownLink
    },
    beforeCreate() {
    	console.log('Hook called from DataTableComponentMixin.js');
    },
 	mounted(){
        this.getPaginate();
        console.log(this.options)
    },
    data() {
        return {
            lenght: 5,
            page: this.lenght,
            pages:[
                5,10,20
            ],
            options: []
        }
    },
    methods: {

        getPaginate(){
            this.startLoading();
            var url = '/getClientsPaginate/client';
            var param = '?lenght='+this.lenght;
            var total_url = url + param;
            axios.get(total_url)
            .then(res => {
                this.options = res.data.data;
                this.package = res.data
                console.log(this.options)
            })
            .finally( () => {
                this.endLoading();
            });

        },
        updateData(data){
            this.options = data.data;
            this.package = data;
        },
    }
	
}