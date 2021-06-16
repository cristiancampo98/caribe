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
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import JsonExcel from "vue-json-excel"
import moment from 'moment';
moment.locale('es')

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
        JetDropdownLink,
        JsonExcel
    },
    beforeCreate() {
    	console.log('Hook called from DataTableComponentMixin.js');
    },
 	mounted(){
        this.getPaginate();
    },
    data() {
        return {
            lenght: 5,
            page: this.lenght,
            pages:[
                5,10,20
            ],
            valueParams: {},
            options: [],
            url: null,
            btn_name_excel: "XLS",
		    json_meta: [
		      [
		        {
		          key: "charset",
		          value: "utf-8",
		        },
		      ],
		    ],
		    moment: moment,
        }
    },
    methods: {
        getPaginate(){
            this.startLoading();

            var param = '?lenght='+this.lenght;
            var data = this.paramsStringFormat()

            if (data.length) {
                param += data
            }
            
            var total_url = this.url + param;
            axios.get(total_url)
            .then(res => {
                this.options = res.data.data;
                this.package = res.data
            })
            .finally( () => {
                this.endLoading();
            });
        },
        updateData(data) {
            this.options = data.data;
            this.package = data;
        },
        exportPDF() {
        	this.startLoading();
        	var vm = this
        	const doc = new jsPDF()
        	autoTable(doc, { 
        		html: '#my-table' ,
        		theme: 'grid',
        		columns: vm.columns,
        		margin: {top: 30},
        	})
        	doc.save(vm.document_name)
        	this.endLoading();
        },
        paramsStringFormat() {
            var format = ''
            for(var i in this.valueParams) {
                format += `&${i}=${this.valueParams[i]}`
            }
            return format
        },
        clean() {
            this.valueParams = {}
            this.getPaginate()
        }
    }
	
}