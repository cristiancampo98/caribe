<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Menú
            </h2>
        </template>
        <div class="py-12">
            <jet-nav-link :href="route('menu.create')">
        		<jet-button type="button">
        			Crear menú
        		</jet-button>
        	</jet-nav-link>
            <div class="mt-8">
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
                                {{item.slug}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.description}}
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
                                    </template>
                                </jet-dropdown>
                            </td-responsive-component>
                        </tr>
                    </template>
                </table-responsive-component>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import { DataTableComponentMixin} from '@/Mixins/DataTableComponentMixin'
    export default {
        mixins: [DataTableComponentMixin],
        created() {
            this.url = '/getPaginateAllMenus/menu';
        },
        data() {
            return {
                titles: ['#','Name','Slug','Descripción','Opciones'],
                actions: [
                    {name: 'Editar', route:'menu.edit', method: 'get' , as: ""},
                    {name: 'Mostrar', route:'menu.show', method: 'get' , as: ""},
                    {name: 'Eliminar', route:'menu.destroy', method: 'delete' , as: "button"},
                ]
            }
        },
    }
</script>
