<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <work-space-component>
                        <template #title>
                            Productos
                        </template>
                        <template #description>
                            <jet-button type="button" @click.native.prevent="isActiveSection(true)">
                               Crear productos
                            </jet-button>
                            <jet-button type="button" @click.native.prevent="isActiveSection(false)">
                               Listar productos
                            </jet-button>
                        </template>
                        <template #content>
                           <table-component v-if="!active"/>
                        </template>
                    </work-space-component>
                </div>
                <jet-section-border />
                <div v-if="active">
                    <create-product :units="units"/>
                    <jet-section-border />
                </div>
                  
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import TableComponent from '@/Components/Table'
    import WorkSpaceComponent from '@/Components/WorkSpace'
    import JetButton from '@/Jetstream/Button'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import CreateProduct from '@/Pages/Product/Create'
    


    export default {
        components: {
            AppLayout,
            TableComponent,
            WorkSpaceComponent,
            JetButton,
            JetSectionBorder,
            CreateProduct
        },
        props: {
            units : Array,
        },
        data(){
            return {
                active: false,
            }
        },
        methods: {
            isActiveSection(param){
                this.active = param
            },
        }
    }
</script>
