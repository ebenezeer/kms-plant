<template>
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">

                        <form @submit="saveForm">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" v-model="form.name">
                                    <div class="text-danger" v-if="errors.name">{{errors.name[0]}}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                        v-model="form.email">
                                    <div class="text-danger" v-if="errors.email">{{errors.email[0]}}</div>
                             
                                   </div>

                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>

                                <div class="col-md-6">
                                
                                <select class="form-control" id="role"  v-model="form.role">
                                    <option value="1">Admin</option>
                                    <option value="2">Expert</option>
                                    <option value="3">User</option>
                                </select>
                                 <div class="text-danger" v-if="errors.role">{{errors.role[0]}}</div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password"
                                        v-model="form.password">
                                    <div class="text-danger" v-if="errors.password">{{errors.password[0]}}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm
                                    Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" v-model="form.password_confirmation">
                                    <div class="text-danger" v-if="errors.password">{{errors.password[1]}}</div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Swal from 'sweetalert2/dist/sweetalert2.js'
    export default {
        data() {
            return {

                form: {
                    name: '',
                    email: '',
                    role:'2',
                    password: '',
                    password_confirmation: ''
                },

                foods: [],
                errors: []

            };
        },
        mounted() {

        },
        // created() {
        //     window.axios.get("/dod").then(({ data }) => {
        //         this.units = data;
        //         this.dataTab();
        //     });
        // },

        components: {

        },

        methods: {
            saveForm(event) {
                event.preventDefault();

                axios.post("/admin/adminreg", {
                    //name: this.equipment.name,
                    name: this.form.name,
                    email: this.form.email,
                    role: this.form.role,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation

                })
                    .then(response => {
                        console.log('saved');
                        Swal.fire({
                            title: 'Success!',
                            text: response.data.message,
                            icon: 'success',
                            text: "I will close in 2 seconds.",
                            timer: 2000
                        })
                    })
                    .catch(error => {
                        this.errors = [];

                        this.errors = error.response.data.errors;
                    });
            }

        },
    };
</script>