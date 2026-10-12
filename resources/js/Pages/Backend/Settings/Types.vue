<script setup>
import { ref } from "vue";
import { useForm, Head } from "@inertiajs/vue3";

const typeFormMode = ref("create");

const typeForm = useForm({
    type_name: "",
    type_desc: "",
});

const clearForms = () => {
    typeForm.reset();
    typeFormMode.value = "create";
};

const fetchType = (type) => {
    typeFormMode.value = "edit";
    typeForm.id = type.id;
    typeForm.type_name = type.type_name;
    typeForm.type_desc = type.type_desc;
};

const submitTypeForm = () => {
    if (typeFormMode.value === "create") {
        typeFormMode.value = "create";
        typeForm.post(route("types.store"), {
            onSuccess: () => {
                typeForm.reset();
            },
        });
    } else {
        typeFormMode.value = "edit";
        typeForm.post(route("types.update", typeForm.id), {
            onSuccess: () => {
                typeForm.reset();
            },
        });
    }
};

const props = defineProps({
    types: Array,
});
</script>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>
<template>
    <Head title="Types" />
    <div class="sp-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="font-display mb-0" style="font-size: 2rem">Types</h1>
                <small class="text-muted">
                    Manage types classifications used to categorize legislative
                    records.
                </small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="sp-card p-0">
                    <form @submit.prevent="submitTypeForm">
                        <div class="card">
                            <div
                                class="card-header"
                                style="background: var(--navy); color: #fff"
                            >
                                Type Form
                            </div>
                            <input type="hidden" v-model="typeForm.id" />
                            <div class="card-body">
                                <div class="mb-3">
                                    <label
                                        class="form-label"
                                        style="
                                            font-size: 0.78rem;
                                            font-weight: 500;
                                        "
                                        >Type Name</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="e.g. ORD"
                                        required
                                        v-model="typeForm.type_name"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="form-label"
                                        style="
                                            font-size: 0.78rem;
                                            font-weight: 500;
                                        "
                                        >Type Description</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="e.g. Ordinance"
                                        required
                                        v-model="typeForm.type_desc"
                                    />
                                </div>
                            </div>
                            <div class="card-footer">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-secondary px-4"
                                    @click="clearForms"
                                >
                                    Clear
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-success px-4 float-end"
                                >
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="sp-card p-0">
                    <div class="table-responsive">
                        <table
                            class="table table-hover mb-0"
                            style="font-size: 0.85rem"
                        >
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Desc</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle text-center">
                                <tr v-for="(type, index) in types" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ type.type_name }}</td>
                                    <td>{{ type.type_desc }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-warning"
                                            @click="fetchType(type)"
                                        >
                                            <i
                                                class="fa-solid fa-pen-to-square"
                                            ></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
