<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { nextTick, ref, computed } from "vue";
import { Modal } from "bootstrap";

const modalRef = ref(null);
let modalInstanceForm = null;
const modalUserForm = () => {
    nextTick(() => {
        modalInstanceForm = new Modal(modalRef.value);
        modalInstanceForm.show();
    });
};

const closeModal = () => {
    modalInstanceForm?.hide();
};

const userFormMode = ref("craete");
const userForm = useForm({
    username: "",
    name: "",
    email: "",
    authorid: "",
    password: "",
    confirmPass: "",
    role: "",
    status: "",
});

const submitUserForm = () => {
    if (userFormMode.value === "create") {
        userFormMode.value = "create";
        userForm.post(route("users.store"), {
            onSuccess: () => {
                userForm.reset();
                closeModal();
            },
        });
    } else {
        userFormMode.value = "edit";
        userForm.post(route("users.update", userForm.id), {
            onSuccess: () => {
                userForm.reset();
                closeModal();
            },
        });
    }
};

const openModalUserForm = () => {
    modalUserForm();
    userFormMode.value = "create";
    userForm.reset();
};

const showStatus = ref(false);

const fetctUserDate = (user) => {
    userFormMode.value = "edit";
    showStatus.value = true;
    modalUserForm();

    userForm.id = user.id;
    userForm.username = user.username;
    userForm.name = user.name;
    userForm.email = user.email;
    userForm.authorid = user.authorid;
    userForm.role = user.role;
    userForm.status = user.status;
};

const checkBoxShow = ref(false);

const props = defineProps({
    authors: Array,
    users: Array,
});
</script>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>
<template>
    <Head title="Users" />
    <div class="sp-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="font-display mb-0" style="font-size: 2rem">Users</h1>
                <small class="text-muted">
                    Manage users Usernames and Passwords
                </small>
            </div>
            <button
                class="btn btn-primary px-3 btn-sm"
                @click="openModalUserForm"
            >
                <i class="fa-solid fa-plus me-1"></i>Add User
            </button>
        </div>
        <div class="sp-card p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 40px">#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody v-if="users.length > 0">
                        <tr
                            v-for="(user, index) in users"
                            :key="index"
                            class="align-middle"
                        >
                            <td class="text-muted">{{ index + 1 }}</td>
                            <td>
                                <span v-if="user.name">
                                    {{ user.name }}
                                </span>
                                <span v-else-if="user.authorid">
                                    {{ user.fullname }}
                                </span>
                            </td>
                            <td class="text-center">{{ user.username }}</td>
                            <td class="text-center">{{ user.email }}</td>
                            <td class="text-center">
                                {{ user.role }}
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge text-bg-secondary"
                                    v-if="user.status === 0"
                                    >Inactive</span
                                >
                                <span
                                    class="badge text-bg-success"
                                    v-else-if="user.status === 1"
                                    >Active</span
                                >
                            </td>
                            <td class="text-center">
                                <button
                                    class="btn btn-sm btn-warning"
                                    @click="fetctUserDate(user)"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="7" class="text-center align-middle">
                                <h6>No Data as of Yet</h6>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        ref="modalRef"
        tabindex="-1"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog">
            <form @submit.prevent="submitUserForm">
                <div class="modal-content">
                    <div
                        class="modal-header"
                        style="background: var(--navy); color: #fff"
                    >
                        <h5
                            class="modal-title font-display"
                            style="font-size: 1.05rem"
                        >
                            User Form
                        </h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            @click="closeModal"
                        ></button>
                    </div>
                    <input type="hidden" v-model="userForm.id" />
                    <div class="modal-body">
                        <div class="form-group mb-3" v-if="checkBoxShow">
                            <label for="">Author</label>
                            <v-select
                                :options="authors"
                                :reduce="(auth) => auth.id"
                                label="fullname"
                                placeholder="Select Author"
                                v-model="userForm.authorid"
                            ></v-select>
                        </div>
                        <div class="form-group mb-3" v-else>
                            <label for="">Name</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="e.g. Juan Dela Cruz"
                                v-model="userForm.name"
                            />
                        </div>
                        <div class="form-check mb-3">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                v-model="checkBoxShow"
                                id="checkDefault"
                            />
                            <label class="form-check-label" for="checkDefault">
                                Check if Author
                            </label>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Username</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="e.g. JuanDelaCruz223"
                                v-model="userForm.username"
                            />
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                placeholder="e.g. juandelacruz@example.com"
                                v-model="userForm.email"
                            />
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Role</label>
                                    <select
                                        class="form-control"
                                        v-model="userForm.role"
                                    >
                                        <option value="" selected>
                                            Select Role
                                        </option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                                <div class="col-md-6" v-if="showStatus">
                                    <label for="">Status</label>
                                    <select
                                        class="form-control"
                                        v-model="userForm.status"
                                    >
                                        <option value="" selected>
                                            Select Status
                                        </option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group mb-3">
                                <label for="">Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    v-model="userForm.password"
                                />
                            </div>
                            <div class="col-6 form-group mb-3">
                                <label for="">Confirm Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    v-model="userForm.confirmPass"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success px-4">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
