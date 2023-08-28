<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="formattedRows" :filter="filter" :per-page="perPage"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>
<script>
export default {
    data() {
        return {
            columns: [
                {
                    label: 'name',
                    field: 'name'
                },
                {
                    label: 'hire_date',
                    field: 'hire_date'
                },
                {
                    label: 'phone_number',
                    field: 'phone_number'
                },
                {
                    label: 'email',
                    field: 'email'
                },
                {
                    label: 'salary',
                    field: 'salary'
                },
                {
                    label: 'position_id',
                    field: 'position_id',
                },

            ],
            rows: [],
            page: 1,
            filter:  '',
            perPage: 12,
            positionNames: {}
        }
    },
    async created() {
        await this.loadPositionNames();
        this.showEmployees();
    },
    computed: {
        formattedRows() {
            return this.rows.map(row => {
                return {
                    ...row,
                    position_id: this.getPositionName(row.position_id)
                };
            });
        }
    },
    methods: {
        showEmployees: function () {
            axios.get('/employees').then(res => {
                this.rows = res.data;
            });
        },
        async loadPositionNames() {
            try {
                const response = await axios.get('/positions');
                const positions = response.data;
                this.positionNames = positions.reduce((acc, position) => {
                    acc[position.id] = position.name;
                    return acc;
                }, {});
            } catch (error) {
                console.error('Error loading position names:', error);
            }
        },
        getPositionName(positionId) {
            return this.positionNames[positionId] || 'Unknown Position';
        }
    },
}
</script>
