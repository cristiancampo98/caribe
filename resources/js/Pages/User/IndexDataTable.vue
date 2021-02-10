<template>
	<data-table
    url="getPaginateAllUsers/users"
    :per-page="perPage"
    :columns="columns">
</data-table>
</template>
<script>
	export default {
    name: 'app',
    data() {
        return {
            perPage: ['2', '3', '4'],
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    filterable: true,
                },
                {
                    label: 'Name',
                    name: 'name',
                    filterable: true,
                },
                {
                    label: 'Email',
                    name: 'email',
                    filterable: true,
                },
                {
                    label: '',
                    name: 'View',
                    filterable: false,
                },
            ]
        }
    },
}
</script>