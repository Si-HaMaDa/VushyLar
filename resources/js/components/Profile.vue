<style>
.widget-user-header {
    background-position: center center;
    background-size: cover;
    height: 250px !important;
}
.widget-user .card-footer {
    padding: 0;
}
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div
                        class="widget-user-header text-white"
                        style="background-image: url('./img/user-cover.jpg')"
                    >
                        <h3 class="widget-user-username">
                            {{ this.form.name }}
                        </h3>
                        <h5 class="widget-user-desc">{{ this.form.type }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img
                            class="img-circle"
                            :src="userImage"
                            alt="User Avatar"
                        />
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">3,200</h5>
                                    <span class="description-text">SALES</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">13,000</h5>
                                    <span class="description-text"
                                        >FOLLOWERS</span
                                    >
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text"
                                        >PRODUCTS</span
                                    >
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <!-- <li class="nav-item">
                                <a
                                    class="nav-link"
                                    href="#activity"
                                    data-toggle="tab"
                                    >Activity</a
                                >
                            </li> -->
                            <li class="nav-item">
                                <a
                                    class="nav-link active show"
                                    href="#settings"
                                    data-toggle="tab"
                                    >Settings</a
                                >
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane" id="activity">
                                <h3 class="text-center">
                                    Display User Activity
                                </h3>
                            </div>
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label
                                            for="inputName"
                                            class="col-sm-2 control-label"
                                            >Name</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="form.name"
                                                class="form-control"
                                                id="inputName"
                                                placeholder="Name"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has('name'),
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="name"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="inputEmail"
                                            class="col-sm-2 control-label"
                                            >Email</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type="email"
                                                v-model="form.email"
                                                class="form-control"
                                                id="inputEmail"
                                                placeholder="Email"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'email'
                                                        ),
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="email"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="inputExperience"
                                            class="col-sm-2 control-label"
                                            >Experience</label
                                        >

                                        <div class="col-sm-12">
                                            <textarea
                                                v-model="form.bio"
                                                class="form-control"
                                                id="inputExperience"
                                                placeholder="Experience"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has('bio'),
                                                }"
                                            ></textarea>
                                            <has-error
                                                :form="form"
                                                field="bio"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="photo"
                                            class="col-sm-2 control-label"
                                            >Profile Photo</label
                                        >
                                        <div class="col-sm-12">
                                            <input
                                                type="file"
                                                @change="updateProfile"
                                                name="image"
                                                class="form-input"
                                            />
                                            <has-error
                                                :form="form"
                                                field="image"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="password"
                                            class="col-sm-12 control-label"
                                            >Password (leave empty if not
                                            changing)</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type="password"
                                                v-model="form.password"
                                                class="form-control"
                                                id="password"
                                                placeholder="Password"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'password'
                                                        ),
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="password"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button
                                                @click.prevent="updateUser"
                                                type="submit"
                                                class="btn btn-success"
                                            >
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- end tabs -->
        </div>
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
                image: "",
            }),
        };
    },
    mounted() {},
    methods: {
        updateProfile(e) {
            let file = e.target.files[0];
            let reader = new FileReader();

            let limit = 1024 * 1024 * 2;
            if (file["size"] > limit) {
                this.$swal(
                    "Oops...",
                    "You are uploading a large file",
                    "error"
                );
                return false;
            }

            reader.onloadend = (file) => (this.form.image = reader.result);

            reader.readAsDataURL(file);
        },
        updateUser() {
            this.$Progress.start();
            this.form
                .patch("api/user/profile")
                .then(() => {
                    this.$Progress.finish();
                    this.$swal(
                        "Good job!",
                        "User Updated Successfully!",
                        "success"
                    );
                })
                .catch(() => {
                    this.$swal(
                        "Failed!",
                        "There was something wronge.",
                        "warning"
                    );
                    this.$Progress.fail();
                });
        },
    },
    computed: {
        userImage() {
            if (this.form.image.includes("base64")) return this.form.image;
            return "storage/profile/" + this.form.image;
        },
    },
    created() {
        axios
            .get("api/user/profile")
            .then(({ data }) => this.form.fill(data.user));
    },
};
</script>
