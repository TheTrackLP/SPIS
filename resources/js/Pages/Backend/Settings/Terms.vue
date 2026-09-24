<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import { Modal } from "bootstrap";
import { formatDate } from "@/resuables";

const modalRef = ref(null);
let modalInstance = null;

const openModal = () => {
    nextTick(() => {
        modalInstance = new Modal(modalRef.value);
        modalInstance.show();
    });
};

const TermModalForm = () => {
    openModal();
    termFormMode.value = "create";
    termForm.reset();
};

const termFormMode = ref("create");
const termForm = useForm({
    sptermno: "",
    termfrom: "",
    termto: "",
});

const fetchPeriod = (term) => {
    termFormMode.value = "edit";
    openModal();
    termForm.sptermno = term.sptermno;
    termForm.termfrom = term.termfrom;
    termForm.termto = term.termto;
};

const submitTermForm = () => {
    if ((termFormMode.value = "create")) {
        termFormMode.value = "create";
        termForm.post(route("term.store"), {
            onSuccess: () => {
                termForm.reset();
            },
        });
    } else {
        termFormMode.value = "edit";
        termForm.post(route("term.store"), {
            onSuccess: () => {
                termForm.reset();
            },
        });
    }
};

const props = defineProps({
    terms: Array,
});
</script>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="SP Terms" />
    <div class="sp-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="font-display mb-0" style="font-size: 2rem">
                    SP Terms
                </h1>
                <small class="text-muted"> Manage Sp Terms periods </small>
            </div>
            <button class="btn btn-primary px-3" @click="TermModalForm">
                <i class="fa-solid fa-plus me-1"></i>Add SP Term
            </button>
        </div>
        <div class="row g-3">
            <div
                class="col-12 col-sm-6 col-lg-4"
                v-for="(term, index) in terms"
                :key="index"
            >
                <div class="card sp-card h-100">
                    <div
                        class="card-header d-flex justify-content-between align-items-center"
                        style="
                            background: var(--navy);
                            color: #fff;
                            border-radius: 0.65rem 0.65rem 0 0;
                        "
                    >
                        <span class="fw-bold">{{ term.sptermno }}</span>
                    </div>
                    <div class="card-body">
                        <div class="text-muted small text-uppercase mb-1">
                            Term Period
                        </div>
                        <div class="fw-semibold">
                            {{ formatDate(term.termfrom) }} &ndash;
                            {{ formatDate(term.termto) }}
                        </div>
                    </div>
                    <div
                        class="card-footer bg-white border-top-0 d-flex justify-content-end gap-2"
                    >
                        <button
                            type="button"
                            class="btn btn-sm btn-warning"
                            @click="fetchPeriod(term)"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center text-muted py-5 d-none" id="emptyState">
            <i class="bi bi-folder2-open fs-1 d-block mb-2"></i>
            No SP Terms yet. Click "Add SP Term" to create one.
        </div>
    </div>
    <div
        class="modal fade"
        ref="modalRef"
        tabindex="-1"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form @submit.prevent="submitTermForm">
                    <div
                        class="modal-header"
                        style="background: var(--navy); color: #fff"
                    >
                        <h5>SP Period Form</h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">SP Term No.</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">SP-</span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="e.g. 01"
                                    v-model="termForm.sptermno"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <label class="text-center">INCLUSIVE DATES</label>
                            <div class="col-6 mb-3">
                                <label>From</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="termForm.termfrom"
                                />
                            </div>
                            <div class="col-6 mb-3">
                                <label>To</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="termForm.termto"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="submit"
                            class="btn btn-success px-4 float-end"
                        >
                            {{ termFormMode === "create" ? "Add" : "Update" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
