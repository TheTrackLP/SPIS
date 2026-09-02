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
    mainname: "",
});

const openClassModal = () => {
    classFormMode.value = "create";
    classForm.reset();
    openModal();
};

const editModal = ref(null);
const openEditModal = () => {
    nextTick(() => {
        modalInstance = new Modal(editModal.value);
        modalInstance.show();
    });
};

const getMainName = ref("");
const subClassFormMode = ref("create");

const subClassForm = useForm({
    class_id: "",
    subname: "",
    desc: "",
});

const openSubClassModal = (name, id) => {
    subClassFormMode.value = "create";
    openEditModal();
    getMainName.value = name;
    subClassForm.class_id = id;
};

const fetchClass = (value) => {
    classFormMode.value = "edit";
    classForm.id = value.id;
    classForm.mainname = value.mainname;
    openModal();
};

const fetchSubClass = (sub, mainname) => {
    openEditModal();
    subClassFormMode.value = "edit";
    subClassForm.subname = sub.subname;
    subClassForm.desc = sub.desc;
    subClassForm.id = sub.id;
    subClassForm.class_id = sub.class_id;
    getMainName.value = mainname;
};

const closeModal = () => {
    modalInstance?.hide();
    classForm.reset();
    subClassForm.reset();
};

const submitClassForm = () => {
    if (classFormMode.value === "create") {
        classFormMode.value = "create";
        classForm.post(route("class.add"), {
            onSuccess: () => {
                classForm.reset();
                closeModal();
            },
        });
    } else {
        classForm.post(route("class.edit", classForm.id), {
            onSuccess: () => {
                classForm.reset();
                closeModal();
            },
        });
    }
};

const submitSubClassForm = () => {
    if (subClassFormMode.value === "create") {
        subClassFormMode.value = "create";
        subClassForm.post(route("subclass.add"), {
            onSuccess: () => {
                subClassForm.reset;
                closeModal();
                getMainName.value = "";
            },
        });
    } else {
        subClassForm.post(route("subclass.edit", subClassForm.id), {
            onSuccess: () => {
                subClassForm.reset;
                closeModal();
                getMainName.value = "";
            },
        });
    }
};

const openId = ref(null);

function toggle(id) {
    openId.value = openId.value === id ? null : id;
}

const props = defineProps({
    classification: Array,
    subClassification: Array,
    subCount: Array,
});
</script>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>
<style>
.page-header {
    border-bottom: 1px solid #e5e1d8;
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.accordion-item {
    border: 1px solid #e5e1d8;
    border-radius: 10px !important;
    overflow: hidden;
    margin-bottom: 0.75rem;
}
.accordion-item:last-child {
    margin-bottom: 0;
}

.accordion-button {
    background-color: #0f2744;
    color: #fff;
    font-weight: 600;
    padding: 0.9rem 1.25rem;
}
.accordion-button:not(.collapsed) {
    background-color: #0f2744;
    color: #fff;
    box-shadow: none;
}
.accordion-button:focus {
    box-shadow: none;
}
.accordion-button .sub-count {
    font-size: 0.8rem;
    font-weight: 400;
    opacity: 0.8;
    margin-left: 0.5rem;
}

.class-actions {
    display: flex;
    gap: 0.5rem;
    margin-right: 10px;
}
.class-actions button {
    border: none;
    background: rgba(255, 255, 255, 0.12);
    color: #fff;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    font-size: 0.75rem;
}
.class-actions button:hover {
    background: rgba(255, 255, 255, 0.25);
}
.class-actions .btn-delete:hover {
    background: #c0392b;
}
.class-actions .btn-add:hover {
    background: #0d6efd;
}
.class-actions .btn-edit:hover {
    background: #ffc107;
}

.accordion-body {
    padding: 0;
}

.subclass-list {
    list-style: none;
    margin: 0;
    padding: 0;
}
.subclass-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.65rem 1.25rem;
    border-bottom: 1px solid #f0eee7;
}
.subclass-list li:last-child {
    border-bottom: none;
}
.subclass-list li:hover {
    background-color: #faf9f6;
}

.action-btns button {
    border: none;
    background: none;
    color: #6c757d;
    padding: 0.2rem 0.4rem;
}
.action-btns button:hover {
    color: #ffc107;
}
.action-btns .btn-delete:hover {
    color: #c0392b;
}

.empty-state {
    padding: 1.25rem;
    color: #9a978d;
    font-size: 0.9rem;
    text-align: center;
}
</style>
<template>
    <Head title="Classification" />
    <div class="sp-content py-4">
        <div
            class="d-flex justify-content-between align-items-center flex-wrap mb-3"
        >
            <div>
                <h1 class="font-display mb-0" style="font-size: 2rem">
                    Classifications
                </h1>
                <small class="text-muted"
                    >Manage Class and Sub-Class categories used in legislative
                    records</small
                >
            </div>
            <button class="btn btn-primary btn-sm px-4" @click="openClassModal">
                <i class="fa-solid fa-plus me-1"></i> Add Class
            </button>
        </div>
        <div
            class="accordion"
            id="classAccordion"
            v-for="value in classification"
            :key="value.id"
        >
            <div class="accordion-item">
                <h2 class="accordion-header d-flex align-items-center">
                    <button
                        class="accordion-button"
                        type="button"
                        :class="{ collapsed: openId !== value.id }"
                        @click="toggle(value.id)"
                    >
                        <div class="class-actions">
                            <button
                                class="btn-add"
                                title="Add Class"
                                @click="
                                    openSubClassModal(value.mainname, value.id)
                                "
                            >
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button
                                class="btn-edit"
                                title="Edit"
                                @click="fetchClass(value)"
                            >
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <!-- <button class="btn-delete" title="Delete Class">
                                <i class="fa-solid fa-trash"></i>
                            </button> -->
                        </div>
                        {{ value.mainname }}
                        <span
                            class="sub-count"
                            v-for="count in subCount.filter(
                                (count) => count.class_id === value.id,
                            )"
                        >
                            ({{ count.count }} sub-classes)</span
                        >
                    </button>
                </h2>
                <div
                    :id="'collapseClass' + value.id"
                    class="accordion-collapse collapse"
                    :class="{ show: openId === value.id }"
                >
                    <div class="accordion-body">
                        <ul class="subclass-list">
                            <li
                                v-for="(sub, index) in subClassification.filter(
                                    (i) => i.class_id === value.id,
                                )"
                                :key="index"
                            >
                                <span
                                    >{{ sub.subname }}
                                    <span v-if="sub.desc">
                                        | {{ sub.desc }}</span
                                    ></span
                                >
                                <div class="action-btns">
                                    <button
                                        class="btn-edit"
                                        title="Edit"
                                        @click="
                                            fetchSubClass(sub, value.mainname)
                                        "
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <!-- <button class="btn-delete" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button> -->
                                </div>
                            </li>
                        </ul>
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
        <div class="modal-dialog">
            <form @submit.prevent="submitClassForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ classFormMode === "create" ? "Add" : "Update" }}
                            Classification
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" v-model="classForm.id" />
                            <label class="form-label"
                                >Classification Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                placeholder="e.g. Resolution"
                                v-model="classForm.mainname"
                            />
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
                            Save Class
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div
        class="modal fade"
        ref="editModal"
        tabindex="-1"
        data-bs-keyboard="false"
        data-bs-backdrop="static"
    >
        <div class="modal-dialog">
            <form @submit.prevent="submitSubClassForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Sub-Class</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input
                                type="hidden"
                                v-model="subClassForm.class_id"
                            />
                            <input type="hidden" v-model="subClassForm.id" />
                            <label class="form-label">Parent Class</label>
                            <input
                                type="text"
                                class="form-control"
                                disabled
                                v-model="getMainName"
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub-Class Name</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="e.g. PBO"
                                v-model="subClassForm.subname"
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label"
                                >Sub-Class Description</label
                            >
                            <textarea
                                class="form-control"
                                placeholder="e.g. Provincial Budget Office"
                                rows="3"
                                v-model="subClassForm.desc"
                            ></textarea>
                            <small
                                >Can leave Blank if no need Description</small
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            @click="closeModal"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-dark">
                            Save Sub-Class
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
