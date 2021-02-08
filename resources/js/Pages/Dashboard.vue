<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <img src="/images/Logos-01.png" class="my-12 h-60 sm:h-72 lg:h-96 m-auto" />
                    <div class="visible md:invisible lg:invisible" v-for="item in menu">
                        <div class="center mx-24">
                            <inertia-link 
                            v-if="!item.items.length"
                            :href="route(item.slug)">
                              <vs-button
                              border
                              primary
                              block
                              >{{item.name}}
                              </vs-button>
                            </inertia-link>
                        </div>
                        
                    </div>
                    

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AdminLayout'

    export default {
        components: {
            AppLayout,
        },
        props: {
            menu:{
                type: [Object,Array]
            }
        }
    }
</script>
