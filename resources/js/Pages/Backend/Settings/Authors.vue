<script setup>
import { nextTick, ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "bootstrap";

const modalRef = ref(null);
let modalInstance = null;

const openModal = () => {
    nextTick(() => {
        modalInstance = new Modal(modalRef.value);
        modalInstance.show();
    });
};

const openAuthorModal = () => {
    authorFormMode.value = "create";
    authorForm.reset();
    openModal();
};
const closeModal = () => {
    modalInstance?.hide();
    authorForm.reset();
};

const authorFormMode = ref("create");
const authorForm = useForm({
    authorhead: "",
    authordesc: "",
    authoroffice: "",
    authoracronym: "",
    authorposition: "",
    authorterm: "",
});

const fetchAuthorData = (auth) => {
    authorFormMode.value = "edit";
    authorForm.id = auth.id;
    authorForm.authorhead = auth.authorhead;
    authorForm.authordesc = auth.authordesc;
    authorForm.authoroffice = auth.authoroffice;
    authorForm.authoracronym = auth.authoracronym;
    authorForm.authorposition = auth.authorposition;
    authorForm.authorterm = auth.authorterm;
    openModal();
};

const submitAuhtorForm = () => {
    if (authorFormMode.value === "create") {
        authorForm.post(route("author.add"), {
            onSuccess: () => {
                authorForm.reset();
                closeModal();
            },
        });
    } else {
        authorForm.post(route("author.edit", authorForm.id), {
            onSuccess: () => {
                authorForm.reset();
                closeModal();
            },
        });
    }
};

const props = defineProps({
    authors: Array,
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
    max-height: 720px;
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
    <Head title="Authors" />
    <div class="sp-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="font-display mb-0" style="font-size: 2rem">
                    Authors
                </h1>
                <div class="text-muted" style="font-size: 0.82rem">
                    Board members authoring legislative records.
                </div>
            </div>
            <button class="btn btn-primary btn-sm" @click="openAuthorModal">
                <i class="fa-solid fa-plus me-1"></i>Add Author
            </button>
        </div>

        <div class="sp-card p-0">
            <div class="table-responsive">
                <table
                    class="table table-hover mb-0"
                    style="font-size: 0.85rem"
                >
                    <thead>
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Office</th>
                            <th>Position</th>
                            <th>SP Term</th>
                            <th>Records</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="authors.length > 0">
                        <tr
                            class="align-middle"
                            v-for="(auth, index) in authors"
                            :key="index"
                        >
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="font-weight: 500">
                                        {{ auth.authorhead }}
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                {{ auth.authoroffice }}
                            </td>
                            <td class="text-center">
                                {{ auth.authorposition }}
                            </td>
                            <td class="text-center">{{ auth.authorterm }}</td>
                            <td class="text-center">Records Later</td>
                            <td class="text-center">
                                <span
                                    class="badge rounded-pill text-bg-success"
                                    v-if="auth.authorstatus === 1"
                                    >Active</span
                                >
                                <span
                                    class="badge rounded-pill text-bg-danger"
                                    v-else
                                    >Inactive</span
                                >
                            </td>
                            <td class="text-center p-1 g-2">
                                <button
                                    class="btn btn-sm btn-warning"
                                    @click="fetchAuthorData(auth)"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash"></i>
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
        data-bs-keyboard="false"
        data-bs-backdrop="static"
    >
        <div class="modal-dialog modal-dialog-centered">
            <form @submit.prevent="submitAuhtorForm">
                <div class="modal-content" style="border-radius: 0.65rem">
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
                            style="font-size: 1.1rem"
                        >
                            Add Author
                        </h5>
                        <input type="hidden" v-model="authorForm.id" />
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
                                >Full Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                placeholder="e.g. Hon. Juan Dela Cruz"
                                v-model="authorForm.authorhead"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label
                                class="form-label"
                                style="font-size: 0.78rem; font-weight: 500"
                                >Office Description</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                placeholder="e.g. BM Juan Dela Cruz"
                                v-model="authorForm.authordesc"
                                required
                            />
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label
                                    class="form-label"
                                    style="font-size: 0.78rem; font-weight: 500"
                                    >Office Name
                                </label>
                                <select
                                    v-model="authorForm.authoroffice"
                                    class="form-select"
                                >
                                    <option value="">Select Office</option>
                                    <option
                                        v-for="n in 14"
                                        :key="n"
                                        :value="`SP-${String(n).padStart(2, '0')}`"
                                    >
                                        SP Member Office
                                        {{ String(n).padStart(2, "0") }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label
                                    class="form-label"
                                    style="font-size: 0.78rem; font-weight: 500"
                                    >Office Acronym
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="e.g. SP01- BM Dela Cruz"
                                    v-model="authorForm.authoracronym"
                                    required
                                />
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label
                                    class="form-label"
                                    style="font-size: 0.78rem; font-weight: 500"
                                    >Position</label
                                >
                                <select
                                    class="form-select"
                                    v-model="authorForm.authorposition"
                                >
                                    <option value="">Select Position</option>
                                    <option value="Board Member">
                                        Board Member
                                    </option>
                                    <option value="IP LIGA Fed. Pres.">
                                        IP Federation President
                                    </option>
                                    <option value="LIGA Fed. Pres.">
                                        LIGA Federation President
                                    </option>
                                    <option value="SK LIGA Fed. Pres.">
                                        SK Federation President
                                    </option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label
                                    class="form-label"
                                    style="font-size: 0.78rem; font-weight: 500"
                                    >SP Term</label
                                >
                                <select
                                    class="form-select"
                                    v-model="authorForm.authorterm"
                                >
                                    <option value="">Select SP-Term</option>
                                    <option
                                        v-for="n in 25"
                                        :key="n"
                                        :value="`SP-${String(n).padStart(2, '0')}`"
                                    >
                                        SP-{{ String(n).padStart(2, "0") }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-check me-1"></i>
                            {{
                                authorForm.processing
                                    ? "Saving..."
                                    : authorFormMode === "create"
                                      ? "Add Auhtor"
                                      : "Save Author"
                            }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
