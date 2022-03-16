<template>
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$route.name}}</div>

                    <div class="card-body">
                        <h1>biatvdgfdgfdgfdgdfgdfgdfgdfgfdg</h1>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        data() {
            return {

                errors: [],

            };
        },
        mounted() {

        },

        components: {

        },

        methods: {
            getbudget() {
                axios.get("/office/budget").then(({ data }) => {
                    this.budgets = data;
                    this.dataTabbudget();
                });
            },

        },
    };
</script>