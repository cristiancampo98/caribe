<template>
    <admin-layout :status="status">
         <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listado de productos
            </h2>
        </template>
        <div class="py-12">
           <jet-nav-link :href="route('product.create')">
                <jet-button type="button">
                    Crear producto
                </jet-button>
            </jet-nav-link>
           
            <div v-if="options.length" class="mt-8">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-3">
                        <label for="lenght">Paginar: </label>
                        <v-select
                        id="lenght"
                        class="w-20 bg-white"
                        v-model="lenght"
                        :options="pages"
                        @input="getPaginate"
                        :clearable="false"></v-select>
                    </div>
                </div>
                 <table-responsive-component>
                    <template #title>
                        <tr>
                            <th-responsive-component 
                            v-for="(title, key) in titles"
                            :key="key">{{title}}</th-responsive-component>
                        </tr>
                    </template>
                    <template #content>
                        <tr v-for="(item, key) in options" :key="key">
                            <td-responsive-component>
                                {{item.id}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.name}}
                            </td-responsive-component>
                             <td-responsive-component>
                                {{item.cubic_meters}} m3 /  {{item.ton}} ton
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.description}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.reference}}
                            </td-responsive-component>
                             <td-responsive-component>
                                <span :class="getClassStatus(item.status)">{{item.status ? 'Activo' : 'Inactivo'}}</span>
                            </td-responsive-component>
                            <td-responsive-component>
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <span  class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center  text-gray-900 hover:text-blue-400 focus:outline-none transition ease-in-out duration-150">
                                                <div class="bg-white border border-transparent hover:border-black shadow-sm p-2 rounded-lg">
                                                    <img src="/img/menu.svg">
                                                </div>
                                            </button>
                                        </span>
                                    </template>
                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Opciones
                                        </div>

                                        <jet-dropdown-link v-for="(option,key) in actions"
                                        :key="key"
                                        :href="route(option.route, {id: item.id})" :as="option.as" method="option.method">
                                            {{option.name}}
                                        </jet-dropdown-link>
                                        <button type="button"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="updateStatus(item)">
                                            {{item.status ? 'Inactivar' : 'Activar'}}
                                        </button>
                                    </template>
                                </jet-dropdown>
                            </td-responsive-component>
                        </tr>
                    </template>
                </table-responsive-component>
                <paginate-component 
                :package="package"
                @updatingData="updateData"></paginate-component>
            </div>
            <div v-else>No hay datos</div>
        </div>
    </admin-layout>
</template>
<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetButton from '@/Jetstream/Button'
    import TableResponsiveComponent from '@/Components/TableResponsive'
    import ThResponsiveComponent from '@/Components/THResponsive'
    import TdResponsiveComponent from '@/Components/TDResponsive'
    import PaginateComponent from '@/Components/Paginate'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import vSelect from "vue-select"
    import 'vue-select/dist/vue-select.css'

    export default {
        components: {
            AdminLayout,
            JetNavLink,
            JetButton,
            TableResponsiveComponent,
            ThResponsiveComponent,
            TdResponsiveComponent,
            PaginateComponent,
            JetDropdown,
            JetDropdownLink,
            vSelect

        },
        created() {
            this.getPaginate();
        },
        data () {
            return {
                status: {},
                loading: false,
                lenght: 5,
                page: this.lenght,
                pages:[
                    5,10,20
                ],
                titles: ['#','Nombre','Equivalencia','Descripción','Referencia','Estado','Opciones'],
                options: [],
                package: [],
                actions: [
                    {name: 'Editar', route:'product.edit'},
                    {name: 'Ver', route:'product.show'},
                ],
            }
        },
        methods: {
            getPaginate(){
                var url = '/getPaginateAllProducts/products',
                    param = '?lenght='+this.lenght,
                    total_url = url + param;

                this.startLoading();

                axios.get(total_url)
                .then(res => {
                    this.options = res.data.data;
                    this.package = res.data
                })
                .finally( () => this.endLoading());

            },
            updateData(data){
                this.options = data.data;
                this.package = data;
            },
            updateStatus(item){
                this.startLoading();

                axios.put(`updateStatus/${item.id}/product`)
                .then( res => {
                    item.status = res.data.status;
                    this.status = {
                        type : res.data.type,
                        text : res.data.text,
                    }
                })
                .finally( () => {
                    this.endLoading();
                });
            },
            getClassStatus(status){
                return status ? 'text-white bg-green-500 p-1 rounded-md'
                    : 'text-white bg-red-500 p-1 rounded-md';

            },
            startLoading(){
                
                this.loading = this.$vs.loading({
                    type: 'circles'
                });
                this.loading.text = "Procesando...";

            },
            endLoading(){
                this.loading.close();
            }
        }

    }
</script>
