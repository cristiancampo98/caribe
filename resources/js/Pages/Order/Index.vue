<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pedidos
            </h2>
        </template>
        <div class="py-12">
           <jet-nav-link :href="route('order.create')" class="m-8">
                <jet-button type="button">
                    Crear pedido
                </jet-button>
            </jet-nav-link>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-3">
                    <label for="lenght">Paginar: </label>
                    <v-select
                    id="lenght"
                    class="w-20 bg-white"
                    v-model="lenght"
                    :options="pages"
                    @input="getPaginateOrders"
                    :clearable="false"></v-select>
                </div>
            </div>
            
                
            <table-responsive-component v-if="loading">
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
                            {{item.client.name}}
                        </td-responsive-component>
                        <td-responsive-component>
                            {{item.status}}
                        </td-responsive-component>
                        <td-responsive-component>
                            {{item.note}}
                        </td-responsive-component>
                        <td-responsive-component>
                            {{item.creator.name}}
                        </td-responsive-component>
                        <td-responsive-component>
                            {{item.created_at}}
                        </td-responsive-component>
                    </tr>
                </template>
            </table-responsive-component>
            <paginate-component 
            :package="package"
            @updatingData="updateData"></paginate-component>
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
            vSelect
            
        },
        data () {
            return {
                loading: false,
                lenght: 5,
                page: this.lenght,
                pages:[
                    5,10,20
                ],
                titles: ['#','Cliente','Estado','Nota','Creador','Creado','Opciones'],
                options: [],
                package: []
            }
        },
        mounted(){
            this.getPaginateOrders();
        },
        methods: {
            getPaginateOrders(){
                var url = '/getAllOrders/order';
                var param = '?lenght='+this.lenght;
                var total_url = url + param;
                axios.get(total_url)
                .then(res => {
                    this.options = res.data.data;
                    this.package = res.data
                })
                .finally( () => this.loading = true);

            },
            updateData(data){
                this.options = data.data;
                this.package = data;
            }
        }
    }
</script>
