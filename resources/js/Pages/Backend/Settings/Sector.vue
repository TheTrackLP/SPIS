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
const sectorFormMode = ref("create");
const sectorForm = useForm({
    name: "",
    desc: "",
});

const openSectorFormModal = () => {
    openModal();
    sectorFormMode.value = "create";
    sectorForm.reset();
    sectorDesc.value = false;
};

const closeModal = () => {
    modalInstance?.hide();
    classForm.reset();
};

const sectorDesc = ref(false);

const fetchSector = (sector) => {
    sectorFormMode.value = "edit";
    openModal();
    sectorForm.id = sector.id;
    sectorForm.name = sector.name;
    sectorForm.desc = sector.desc;
    sectorDesc.value = true;
};

const submitSectorForm = () => {
    if (sectorFormMode.value === "create") {
        sectorForm.post(route("sector.add"), {
            onSuccess: () => {
                closeModal();
                sectorForm.reset();
            },
        });
    } else {
        sectorForm.post(route("sector.edit", sectorForm.id), {
            onSuccess: () => {
                closeModal();
                sectorForm.reset();
            },
        });
    }
};

const props = defineProps({
    sectors: Array,
});
</script>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="Sector" />
    <div class="sp-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="font-display mb-0" style="font-size: 1.5rem">
                    Sectors
                </h1>
                <div class="text-muted" style="font-size: 0.82rem">
                    Manage sector classifications used to categorize legislative
                    records.
                </div>
            </div>
            <button
                class="btn btn-primary px-3 btn-sm"
                @click="openSectorFormModal"
            >
                <i class="fa-solid fa-plus me-1"></i>Add Sector
            </button>
        </div>

        <div class="sp-card p-0">
            <div class="table-responsive">
                <table
                    class="table table-hover mb-0"
                    style="font-size: 0.85rem"
                >
                    <thead>
                        <tr>
                            <th style="width: 40px">#</th>
                            <th>Name</th>
                            <th class="text-center">In Use</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="align-middle"
                            v-for="(sector, index) in sectors"
                            :key="index"
                        >
                            <td class="text-muted">{{ index + 1 }}</td>
                            <td style="font-weight: 500">{{ sector.name }}</td>
                            <td class="text-center">
                                <span class="chip">14 records</span>
                            </td>
                            <td class="text-end">
                                <button
                                    class="btn btn-sm btn-warning border"
                                    @click="fetchSector(sector)"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </button>
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
                        style="font-size: 1.05rem"
                    >
                        {{ sectorFormMode === "create" ? "Add" : "Update" }}
                        Sector
                    </h5>
                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <form @submit.prevent="submitSectorForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label
                                class="form-label"
                                style="font-size: 0.78rem; font-weight: 500"
                                >Sector Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                placeholder="e.g. Institutional"
                                required
                                v-model="sectorForm.name"
                            />
                            <input type="hidden" v-model="sectorForm.id" />
                        </div>
                        <div v-if="sectorDesc" class="mb-3">
                            <label
                                class="form-label"
                                style="font-size: 0.78rem; font-weight: 500"
                                >Sector Description</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Description"
                                required
                                v-model="sectorForm.desc"
                            />
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
                            class="btn btn-sm btn-success px-4"
                        >
                            {{ sectorFormMode === "create" ? "Add" : "Update" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
