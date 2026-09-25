<script setup>
import { nextTick, onMounted, ref, watch } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "bootstrap";
import { formatDate } from "@/resuables";
import axios from "axios";

//Modal Form when Adding New Author/s
const modalRef = ref(null);
let modalInstance = null;
const openModal = () => {
    nextTick(() => {
        modalInstance = new Modal(modalRef.value);
        modalInstance.show();
    });
};

//Modal for when viewing History
const modalView = ref(null);
let modalInstanceView = null;
const openModalView = () => {
    nextTick(() => {
        modalInstanceView = new Modal(modalView.value);
        modalInstanceView.show();
    });
};
const authorTermsList = ref([]);
const getFullname = ref("");
const openAuhtorTermModal = (auth) => {
    openModalView();
    authorTermForm.id = auth.id;
    getFullname.value = auth.fullname;
    authorTermForm.reset();
    if (!auth?.id) return;
    fetchAuthorTerms(auth.id);
};

//Modal when Add SP term for Author
const modalTerm = ref(null);
let modalInstanceTerm = null;
const openTermModalForm = () => {
    nextTick(() => {
        modalInstanceTerm = new Modal(modalTerm.value);
        modalInstanceTerm.show();
    });
};
const addAuthorTermForm = (auth) => {
    openTermModalForm();
    authorTermForm.id = auth.id;
    authorTermForm.reset();
    if (!auth?.id) return;
    fetchAuthorTerms(auth.id);
};

const fetchAuthorTerms = (authorId) => {
    axios.get(`/admin/settings/authors/terms/${authorId}`).then((res) => {
        authorTermsList.value = res.data;
    });
};
const openAuthorModal = () => {
    authorFormMode.value = "create";
    authorForm.reset();
    openModal();
};
const closeModal = () => {
    modalInstance?.hide();
    modalInstanceTerm?.hide();
    modalInstanceView?.hide();
    authorForm.reset();
    authorTermForm.reset();
};

const authorTermForm = useForm({
    authortermid: "",
    authortermno: "",
    authorposition: "",
    remarks: "",
});

const addAuthorTerm = () => {
    authorTermForm.post(route("add.term", authorTermForm.id), {
        preserveScroll: true,
        onSuccess: () => {
            authorTermForm.reset();
            closeModal();
        },
    });
};

const currentTerm = ref({});

// onMounted(async () => {
//     for (const author of props.authors) {
//         const res = await axios.get(
//             `admin/settings/authors/current-term/${author.id}`,
//         );
//         currentTerm.value[author.id] = res.data;
//     }
// });

const authorFormMode = ref("create");
const authorForm = useForm({
    authorfirstname: "",
    authormiddlename: "",
    authorlastname: "",
    authorbirtdate: "",
    authorstatus: "",
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
    terms: Array,
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
                            <th>#</th>
                            <th>Name</th>
                            <th>Birthdate</th>
                            <th>Records</th>
                            <th>Current Term</th>
                            <th>History</th>
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
                            <td class="text-center">{{ index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="font-weight: 500">
                                        {{ auth.fullname }}
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                {{ formatDate(auth.authorbirtdate) }}
                            </td>
                            <td>
                                <p>Authored</p>
                                <p>Co-Authored</p>
                                <p>Sponsor</p>
                                <p>Co-Sponsor</p>
                            </td>
                            <td class="text-center">{{ auth.sptermno }}</td>
                            <td class="text-center">
                                <button
                                    class="btn btn-sm btn-success"
                                    @click="openAuhtorTermModal(auth)"
                                >
                                    <i class="fa-solid fa-eye"></i> History
                                </button>
                            </td>
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
                            <td class="text-center">
                                <div
                                    class="d-flex gap-2 justify-content-center"
                                >
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="addAuthorTermForm(auth)"
                                    >
                                        <i class="fa-solid fa-pen"></i> Add Term
                                    </button>
                                    <button
                                        class="btn btn-sm btn-warning"
                                        @click="fetchAuthorData(auth)"
                                    >
                                        <i class="fa-solid fa-pen"></i> Edit
                                        Author
                                    </button>
                                </div>
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
    <!-- Add/Edit a Author/s Info -->
    <div
        class="modal fade"
        ref="modalRef"
        tabindex="-1"
        data-bs-keyboard="false"
        data-bs-backdrop="static"
    >
        <form @submit.prevent="submitAuhtorForm">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 0.65rem">
                    <div
                        class="modal-header"
                        style="background: var(--navy); color: #fff"
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
                            @click="closeModal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="section-label mb-2">Author Info</div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="lastName" class="form-label"
                                    >Last Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="e.g. Cruz-Am"
                                    v-model="authorForm.authorlastname"
                                />
                            </div>
                            <div class="col-md-4">
                                <label for="firstName" class="form-label"
                                    >First Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="e.g. Aldwin"
                                    v-model="authorForm.authorfirstname"
                                />
                            </div>
                            <div class="col-md-4">
                                <label for="middleName" class="form-label"
                                    >Middle Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="e.g. Amane"
                                    v-model="authorForm.authormiddlename"
                                />
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="birthDate" class="form-label"
                                    >Birth Date</label
                                >
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="authorForm.authorbirtdate"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="authorStatus" class="form-label"
                                    >Status</label
                                >
                                <select
                                    class="form-select"
                                    v-model="authorForm.authorstatus"
                                >
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
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
            </div>
        </form>
    </div>
    <!-- Viewing Modal for SP Service History -->
    <div
        class="modal fade"
        tabindex="-1"
        ref="modalView"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div
                    class="modal-header"
                    style="background: var(--navy); color: #fff"
                >
                    <h4 class="modal-title">
                        {{ getFullname }}
                    </h4>
                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        @click="closeModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h4 class="font-display mb-0">SP History Term</h4>
                        <div class="text-muted">
                            History of Board Members' Terms.
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th rowspan="2">POSITION</th>
                                    <th colspan="2">INCLUSIVE DATES</th>
                                    <th rowspan="2">TERM NO.</th>
                                    <th rowspan="2">SP TERM NO.</th>
                                    <th rowspan="2">REMARKS</th>
                                </tr>
                                <tr>
                                    <th class="text-center">FROM</th>
                                    <th class="text-center">TO</th>
                                </tr>
                            </thead>
                            <tbody v-if="authorTermsList.length > 0">
                                <tr
                                    class="text-center align-middle"
                                    v-for="(authterm, index) in authorTermsList"
                                    :key="index"
                                >
                                    <td>{{ authterm.authorposition }}</td>
                                    <td>{{ formatDate(authterm.termfrom) }}</td>
                                    <td>{{ formatDate(authterm.termto) }}</td>
                                    <td>{{ authterm.authortermno }}</td>
                                    <td>{{ authterm.sptermno }}</td>
                                    <td>{{ authterm.remarks }}</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td
                                        colspan="7"
                                        class="text-center align-middle"
                                    >
                                        <div
                                            class="text-center text-muted py-5"
                                        >
                                            <i
                                                class="bi bi-clock-history fs-2 d-block mb-2"
                                            ></i>
                                            No term history recorded yet.
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        @click="closeModal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal FOrm when adding new Term -->
    <div
        class="modal fade"
        tabindex="-1"
        ref="modalTerm"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
    >
        <div class="modal-dialog modal-dialog-centered">
            <form @submit.prevent="addAuthorTerm">
                <div class="modal-content">
                    <div
                        class="modal-header"
                        style="background: var(--navy); color: #fff"
                    >
                        <h5>Add Author Term</h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            @click="closeModal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" v-model="authorTermForm.id" />
                        <div class="col-md-12 mb-3">
                            <label for="termId" class="form-label">Term</label>
                            <v-select
                                :options="terms"
                                :reduce="(term) => term.id"
                                label="sptermno"
                                placeholder="Select SP Term"
                                v-model="authorTermForm.authortermid"
                            >
                                <template #option="term">
                                    {{ term.sptermno }} |
                                    {{ formatDate(term.termfrom) }}-{{
                                        formatDate(term.termto)
                                    }}
                                </template>
                                <template #selected-option="term">
                                    {{ term.sptermno }} |
                                    {{ formatDate(term.termfrom) }}-{{
                                        formatDate(term.termto)
                                    }}
                                </template></v-select
                            >
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="position" class="form-label"
                                    >Position</label
                                >
                                <select
                                    class="form-select"
                                    v-model="authorTermForm.authorposition"
                                >
                                    <option selected disabled>
                                        Select Position
                                    </option>
                                    <option value="Vice Governor">
                                        Vice Governor
                                    </option>
                                    <option value="SP Member">SP Member</option>
                                    <option value="SP Member (LIGA President)">
                                        SP Member (LIGA President)
                                    </option>
                                    <option value="SP Member SK President">
                                        SP Member (SK President)
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="spTermNo" class="form-label"
                                    >SP Term No.</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="e.g. 4th"
                                    v-model="authorTermForm.authortermno"
                                />
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="remarks" class="form-label"
                                >Remarks</label
                            >
                            <textarea
                                class="form-control"
                                rows="2"
                                placeholder="e.g. Completed 3 consecutive terms"
                                v-model="authorTermForm.remarks"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success px-4">
                            Save Term
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
