<template>
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
                            <has-error :form="form" field="name"></has-error>
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
                            <has-error :form="form" field="email"></has-error>
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
                            <has-error :form="form" field="type"></has-error>
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
                                    'is-invalid': form.errors.has('password'),
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
                    this.form.reset();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
    },
};
</script>
