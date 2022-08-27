<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h3 class="card-header">
                        Users Component
                        <div class="card-tools">
                            <button
                                class="btn btn-success"
                                data-bs-toggle="modal"
                                data-bs-target="#addNew"
                            >
                                Add New
                                <i class="fas fa-user-plus fa-fw"></i>
                            </button>
                        </div>
                    </h3>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body table-responsive p-0">
                                    <table
                                        class="table table-hover text-nowrap"
                                    >
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="user in users.data"
                                                :key="user.id"
                                            >
                                                <td>{{ user.id }}</td>
                                                <td>{{ user.name }}</td>
                                                <td>{{ user.email }}</td>
                                                <td v-UpLetter="user.type"></td>
                                                <td
                                                    v-date="user.created_at"
                                                ></td>
                                                <td>
                                                    <a href="#" class="m-1">
                                                        <i
                                                            class="fa fa-edit blue"
                                                        ></i>
                                                    </a>

                                                    <a
                                                        href="#"
                                                        class="m-1"
                                                        @click="
                                                            deleteUser(user)
                                                        "
                                                    >
                                                        <i
                                                            class="fa fa-trash red"
                                                        ></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div
            class="modal fade"
            id="addNew"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addNewLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewLabel">Add New</h5>
                        <h5 class="modal-title" id="addNewLabel">
                            Update User's Info
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    placeholder="Name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('name'),
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="name"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <input
                                    v-model="form.email"
                                    type="email"
                                    name="email"
                                    placeholder="Email Address"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('email'),
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="email"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <textarea
                                    v-model="form.bio"
                                    name="bio"
                                    id="bio"
                                    placeholder="Short bio for user (Optional)"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('bio'),
                                    }"
                                ></textarea>
                                <has-error :form="form" field="bio"></has-error>
                            </div>

                            <div class="form-group">
                                <select
                                    name="type"
                                    v-model="form.type"
                                    id="type"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('type'),
                                    }"
                                >
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Standard User</option>
                                    <option value="author">Author</option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="type"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <input
                                    v-model="form.password"
                                    type="password"
                                    name="password"
                                    placeholder="Password"
                                    id="password"
                                    class="form-control"
                                    :class="{
                                        'is-invalid':
                                            form.errors.has('password'),
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="password"
                                ></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            >
                                Close
                            </button>
                            <button
                                v-show="editmode"
                                type="submit"
                                class="btn btn-success"
                            >
                                Update
                            </button>
                            <button
                                v-show="!editmode"
                                type="submit"
                                class="btn btn-primary"
                            >
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                id: "",
                name: "",
                email: "",
                password: "",
                type: "",
                bio: "",
                photo: "",
            }),
            users: {},
            editmode: false,
        };
    },
    methods: {
        createUser() {
            this.$Progress.start();
            this.form
                .post("api/users")
                .then(() => {
                    console.log("Done!");
                    this.$Progress.finish();
                    document
                        .querySelector(
                            '.modal-footer button[data-bs-dismiss="modal"]'
                        )
                        .click();
                    this.$swal(
                        "Good job!",
                        "User Created Successfully!",
                        "success"
                    );
                    this.emitter.emit("loadUsers");
                    this.form = new Form({});
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        loadUsers() {
            axios.get("api/users").then(({ data }) => (this.users = data));
        },
        deleteUser(user) {
            this.$swal({
                title: `Are you sure to delete ?\n"${user.name}"`,
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                // Send request to the server
                if (result.value) {
                    this.form
                        .delete("api/users/" + user.id)
                        .then(() => {
                            this.$swal(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            this.emitter.emit("loadUsers");
                        })
                        .catch(() => {
                            this.$swal(
                                "Failed!",
                                "There was something wronge.",
                                "warning"
                            );
                        });
                }
            });
        },
    },
    mounted() {
        this.loadUsers();
        this.emitter.on("loadUsers", () => {
            this.loadUsers();
        });
    },
    unmounted() {
        this.emitter.all.clear();
    },
};
</script>
