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
                                                    <a
                                                        href="javascript:;"
                                                        class="m-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#addNew"
                                                        :data-bs-editMode="1"
                                                        :data-bs-editUser="
                                                            user.id
                                                        "
                                                    >
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

                    <div class="card-footer">
                        <LaravelVuePagination
                            :data="users"
                            :show-disabled="true"
                            @pagination-change-page="loadUsers"
                        />
                    </div>
                </div>
            </div>
        </div>
        <UserModal />
    </div>
</template>

<script>
import UserModal from "./UserModal.vue";

export default {
    data() {
        return {
            users: {},
        };
    },
    components: {
        UserModal,
    },
    methods: {
        loadUsers(page = 1, search = "") {
            let url = "api/users?page=" + page;
            if ((search = this.$parent.$parent.search))
                url += "&search=" + search;
            axios.get(url).then(({ data }) => (this.users = data));
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
                    axios
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
        this.emitter.on("sendSearch", () => {
            this.loadUsers();
        });
    },
    unmounted() {
        this.emitter.all.clear();
    },
};
</script>
