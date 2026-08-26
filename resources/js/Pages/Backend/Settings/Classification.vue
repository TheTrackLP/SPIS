<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { computed, nextTick, ref } from "vue";
import { Modal } from "bootstrap";

const modalRef = ref(null);
let modalInstance = null;

const openModal = () => {
    nextTick(() => {
        modalInstance = new Modal(modalRef.value);
        modalInstance.show();
    });
};

const classFormMode = ref("create");
const classForm = useForm({
    name: "",
    class: "",
});

const openClassModal = () => {
    classFormMode.value = "create";
    classForm.reset();
    openModal();
};

const closeModal = () => {
    modalInstance?.hide();
    classForm.reset();
};

const fetchClass = (row) => {
    classFormMode.value = "edit";
    openModal();
    classForm.id = row.id;
    classForm.name = row.name;
    classForm.class = row.class;
};

const classOneSearch = ref("");
const classTwoSearch = ref("");

const filteredOne = computed(() => {
    const classOneQuery = classOneSearch.value.toLowerCase().trim();
    if (!classOneQuery) return props.class1;
    return props.class1.filter((c1) =>
        c1.name.toLowerCase().includes(classOneQuery),
    );
});
const filteredTwo = computed(() => {
    const classTwoQuery = classTwoSearch.value.toLowerCase().trim();
    if (!classTwoQuery) return props.class2;
    return props.class2.filter((c2) =>
        c2.name.toLowerCase().includes(classTwoQuery),
    );
});

const submitClassForm = () => {
    if (classFormMode.value === "create") {
        classForm.post(route("class.add"), {
            onSuccess: () => {
                classForm.reset();
                closeModal();
            },
        });
    } else {
    }
};

const props = defineProps({
    class1: Array,
    class2: Array,
});
</script>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>
<style>
.table-responsive {
    max-height: 650px;
    overflow-y: auto;
}
.table-responsive th {
    position: sticky;
    top: 0;
    z-index: 2;
    background-color: #ffffff;
}
</style>
<template>
    <Head title="Classification" />
    <div class="sp-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="font-display mb-0" style="font-size: 2rem">
                    Classifications
                </h1>
                <div class="text-muted" style="font-size: 0.82rem">
                    Manage Classification 1 (primary) and Classification 2
                    (secondary) values used on legislative records.
                </div>
            </div>
            <button class="btn btn-primary btn-sm px-3" @click="openClassModal">
                <i class="fa-solid fa-plus me-1"></i>Add Classification
            </button>
        </div>
        <div class="row g-3">
            <div class="col-lg-6">
                <div class="sp-card p-3 h-100">
                    <div
                        class="d-flex justify-content-between align-items-center mb-3"
                    >
                        <div class="section-title">
                            Classification 1
                            <span
                                class="text-muted fw-normal"
                                style="font-size: 0.75rem"
                                >(Primary)</span
                            >
                        </div>
                        <div class="d-none d-md-block position-relative">
                            <i
                                class="fa-solid fa-magnifying-glass position-absolute"
                                style="
                                    left: 0.25rem;
                                    top: 0.6rem;
                                    color: var(--ink-muted);
                                    font-size: 0.85rem;
                                "
                            ></i>
                            <input
                                type="text"
                                class="form-control form-control-sm ps-4"
                                style="width: 230px"
                                placeholder="Search Classification 1"
                                v-model="classOneSearch"
                            />
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table table-hover mb-0"
                            style="font-size: 0.85rem"
                        >
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>In Use</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="class1.length > 0">
                                <tr
                                    v-for="(row, index) in filteredOne"
                                    :key="index"
                                >
                                    <td>{{ row.name }}</td>
                                    <td class="text-center">
                                        <span class="badge text-bg-secondary"
                                            >18 records</span
                                        >
                                    </td>
                                    <td class="text-end">
                                        <button
                                            class="btn btn-sm btn-warning border"
                                            @click="fetchClass(row)"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr class="text-center align-middle">
                                    <td colspan="3">
                                        <h6>No data available.</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sp-card p-3 h-100">
                    <div
                        class="d-flex justify-content-between align-items-center mb-3"
                    >
                        <div class="section-title">
                            Classification 2
                            <span
                                class="text-muted fw-normal"
                                style="font-size: 0.75rem"
                                >(Secondary)</span
                            >
                        </div>
                        <div class="d-none d-md-block position-relative">
                            <i
                                class="fa-solid fa-magnifying-glass position-absolute"
                                style="
                                    left: 0.25rem;
                                    top: 0.6rem;
                                    color: var(--ink-muted);
                                    font-size: 0.85rem;
                                "
                            ></i>
                            <input
                                type="text"
                                class="form-control form-control-sm ps-4"
                                style="width: 230px"
                                placeholder="Search Classification 2"
                                v-model="classTwoSearch"
                            />
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table table-hover mb-0"
                            style="font-size: 0.85rem"
                        >
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>In Use</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="class2.length > 0">
                                <tr
                                    class="align-middle"
                                    v-for="(row, index) in filteredTwo"
                                    :key="index"
                                >
                                    <td>{{ row.name }}</td>
                                    <td class="text-center">
                                        <span class="badge text-bg-secondary"
                                            >18 records</span
                                        >
                                    </td>
                                    <td class="text-end">
                                        <button
                                            class="btn btn-sm btn-warning border"
                                            @click="fetchClass(row)"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr class="text-center align-middle">
                                    <td colspan="3">
                                        <h6>No data available.</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="modal fade"
        ref="modalRef"
        tabindex="-1"
        data-bs-keyboard="false"
        data-bs-backdrop="static"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 0.65rem">
                <form @submit.prevent="submitClassForm">
                    <div
                        class="modal-header"
                        style="
                            background: var(--navy);
                            color: #fff;
                            border-radius: 0.65rem 0.65rem 0 0;
                        "
                    >
                        <h5
                            class="modal-title font-display"
                            style="font-size: 1.05rem"
                        >
                            {{ classFormMode === "create" ? "Add" : "Update" }}
                            Classification
                        </h5>
                        <input type="hidden" v-model="classForm.id" />
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label
                                class="form-label"
                                style="font-size: 0.78rem; font-weight: 500"
                                >Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                placeholder="e.g. Infrastructure"
                                required
                                v-model="classForm.name"
                            />
                        </div>
                        <div class="mb-3">
                            <label
                                class="form-label"
                                style="font-size: 0.78rem; font-weight: 500"
                                >Classification 1 or 2?</label
                            >
                            <select
                                v-model="classForm.class"
                                class="form-control"
                                required
                            >
                                <option value="">Select Classification</option>
                                <option value="class1">Classification 1</option>
                                <option value="class2">Classification 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="btn btn-sm btn-success px-3"
                        >
                            {{
                                classForm.processing
                                    ? "Saving..."
                                    : classFormMode === "create"
                                      ? "Add"
                                      : "Update"
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
