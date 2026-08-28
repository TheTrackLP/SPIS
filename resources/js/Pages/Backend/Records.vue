<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { ref, nextTick, computed, watch } from "vue";
import { Modal } from "bootstrap";

const props = defineProps({
    authors: Array,
    sectors: Array,
    class1: Array,
    class2: Array,
    records: Array,
});

const recordFormMode = ref("create");
const recordForm = useForm({
    term: "",
    type: "",
    series_no: "",
    session_date: "",
    title: "",
    status: "",
    authorid: [],
    authorname: [],
    authoracronym: [],
    coauthorid: [],
    coauthorname: [],
    coauthoracronym: [],
    class1id: [],
    class1name: [],
    class2id: [],
    class2name: [],
    sectorid: [],
    sectorname: [],
});

const modalRef = ref(null);
let modalInstance = null;

const openModal = () => {
    nextTick(() => {
        modalInstance = new Modal(modalRef.value);
        modalInstance.show();
    });
};

const opemModalRecordForm = () => {
    openModal();
    recordFormMode.value = "create";
    recordForm.reset();

    selectedAuthorID.value = "";
    selectedClass1ID.value = "";
    selectedClass2ID.value = "";
    selectedSectorID.value = "";
    selectedCoAuthorID.value = "";
};

const closeModal = () => {
    modalInstance?.hide();
    recordForm.reset();
};

const modalRefView = ref(null);
let modalInstanceView = null;

const openViewModal = () => {
    nextTick(() => {
        modalInstanceView = new Modal(modalRefView.value);
        modalInstanceView.show();
    });
};

const getRecordTerm = ref("");
const getRecordTitle = ref("");
const getRecordType = ref("");
const getRecordSeries = ref("");
const getRecordSessionDate = ref("");
const getRecordSector = ref("");
const getRecordAuthors = ref("");
const getRecordCoAuthors = ref("");
const getRecordClass1 = ref("");
const getRecordClass2 = ref("");

const openModaViewRecord = (record) => {
    openViewModal();
    getRecordTitle.value = record.title;
    getRecordTerm.value = record.term;
    getRecordType.value = record.type;
    getRecordSeries.value = record.series_no;
    getRecordSessionDate.value = record.session_date;
    getRecordSector.value = record.sectorname;
    getRecordAuthors.value = record.authorname;
    getRecordCoAuthors.value = record.coauthorname;
    getRecordClass1.value = record.class1name;
    getRecordClass2.value = record.class2name;
};

const submitRecord = () => {
    if (recordFormMode.value === "create") {
        recordForm.post(route("rec.add"), {
            onSuccess: () => {
                recordForm.reset();
                closeModal();
                selectedAuthorID.value = "";
                selectedClass1ID.value = "";
                selectedClass2ID.value = "";
                selectedSectorID.value = "";
                selectedCoAuthorID.value = "";
            },
        });
    }
};

const selectedAuthorID = ref([]);

const selectedAuthors = computed(() => {
    return props.authors.filter((author) =>
        selectedAuthorID.value.includes(author.id),
    );
});
watch(selectedAuthors, (newAuthors) => {
    recordForm.authorid = newAuthors.map((author) => author.id).join("/");
    recordForm.authorname = newAuthors
        .map((author) => author.authorhead)
        .join("/");
    recordForm.authoracronym = newAuthors
        .map((author) => author.authoracronym)
        .join("/");
});

const selectedCoAuthorID = ref([]);

const selectedCoAuthors = computed(() => {
    return props.authors.filter((coauthor) =>
        selectedCoAuthorID.value.includes(coauthor.id),
    );
});
watch(selectedCoAuthors, (newCoAuthors) => {
    if (newCoAuthors.length > 0) {
        recordForm.coauthorid = newCoAuthors
            .map((coauthor) => coauthor.id)
            .join("/");
        recordForm.coauthorname = newCoAuthors
            .map((coauthor) => coauthor.authorhead)
            .join("/");
        recordForm.coauthoracronym = newCoAuthors
            .map((coauthor) => coauthor.authoracronym)
            .join("/");
    } else {
        recordForm.coauthorid = null;
        recordForm.coauthorname = null;
        recordForm.coauthoracronym = null;
    }
});

const selectedClass1ID = ref([]);

const selectedClass1 = computed(() => {
    return props.class1.filter((class1) =>
        selectedClass1ID.value.includes(class1.id),
    );
});

watch(selectedClass1, (newClass1) => {
    recordForm.class1id = newClass1.map((class1) => class1.id).join("/");
    recordForm.class1name = newClass1.map((class1) => class1.name).join("/");
});

const selectedClass2ID = ref([]);

const selectedClass2 = computed(() => {
    return props.class2.filter((class2) =>
        selectedClass2ID.value.includes(class2.id),
    );
});

watch(selectedClass2, (newClass2) => {
    recordForm.class2id = newClass2.map((class2) => class2.id).join("/");
    recordForm.class2name = newClass2.map((class2) => class2.name).join("/");
});

const selectedSectorID = ref([]);

const selectedSector = computed(() => {
    return props.sectors.filter((sec) =>
        selectedSectorID.value.includes(sec.id),
    );
});

watch(selectedSector, (newSector) => {
    recordForm.sectorid = newSector.map((sec) => sec.id).join("/");
    recordForm.sectorname = newSector.map((sec) => sec.name).join("/");
});
function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "2-digit",
    });
}
const filterText = ref("");
const filterTerm = ref("");
const filterType = ref("");
const filterStatus = ref("");

const filteredRecords = computed(() => {
    const textQuery = filterText.value.toLowerCase().trim();
    const termQuery = filterTerm.value;
    const typeQuery = filterType.value;
    const statusQuery = filterStatus.value;

    return props.records.filter((rec) => {
        const matchesText =
            !textQuery || rec.title.toLowerCase().includes(textQuery);
        const matchesTerm = !termQuery || rec.term === termQuery;
        const matchesType = !typeQuery || rec.type === typeQuery;
        const matchesStatus = !statusQuery || rec.status === statusQuery;

        return matchesText && matchesTerm && matchesType && matchesStatus;
    });
});

const clearFilters = () => {
    filterText.value = "";
    filterTerm.value = "";
    filterType.value = "";
    filterStatus.value = "";
};
</script>
<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>
<template>
    <Head title="Records" />
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="font-display mb-0" style="font-size: 2rem">
                Legislative Records
            </h1>
            <div class="text-muted" style="font-size: 0.82rem">
                Resolutions, ordinances, and other legislative documents.
            </div>
        </div>
        <button class="btn btn-primary btn-sm" @click="opemModalRecordForm">
            <i class="fa-solid fa-plus"></i> New Record
        </button>
    </div>
    <div class="card p-1 mb-3">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label for="">SEARCH TITLE/NO.</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="e.g Ordinance No. 15"
                        v-model="filterText"
                    />
                </div>
                <div class="col-6 col-md-2">
                    <label for="">SP Term</label>
                    <select v-model="filterTerm" class="form-select">
                        <option value="">All Terms</option>
                        <option
                            v-for="n in 25"
                            :key="n"
                            :value="`SP-${String(n).padStart(2, '0')}`"
                        >
                            SP-{{ String(n).padStart(2, "0") }}
                        </option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label for="">Type</label>
                    <select v-model="filterType" class="form-select">
                        <option value="">All Types</option>
                        <option value="A-ORD">A-ORB</option>
                        <option value="ORD">ORD</option>
                        <option value="RES">RES</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label for="">Status</label>
                    <select v-model="filterStatus" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="AMENDATORY">AMENDATORY</option>
                        <option value="AMENDED">AMENDED</option>
                        <option value="RECALLATORY">RECALLATORY</option>
                        <option value="RECALLED">RECALLED</option>
                        <option value="REITERATED">REITERATED</option>
                        <option value="REITERATORY">REITERATORY</option>
                        <option value="REPEALING">REPEALING</option>
                        <option value="SUSPENDED">SUSPENDED</option>
                        <option value="SUSPENSIVE">SUSPENSIVE</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 d-flex gap-2">
                    <button
                        class="btn btn-sm btn-outline-secondary flex-fill"
                        @click="clearFilters"
                    >
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div class="table-responsive">
        <table
            class="table table-hover mb-0 align-middle"
            style="font-size: 0.85rem"
        >
            <thead>
                <tr>
                    <th>SP Term</th>
                    <th>Type</th>
                    <th>No.</th>
                    <th>Session Date</th>
                    <th style="min-width: 280px">Title</th>
                    <th>Status</th>
                    <th>Author/s</th>
                    <th>Co-Author/s</th>
                    <th>Sector</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(record, index) in filteredRecords"
                    :key="index"
                    @click="openModaViewRecord(record)"
                >
                    <td>{{ record.term }}</td>
                    <td>
                        <span class="badge text-bg-secondary">{{
                            record.type
                        }}</span>
                    </td>
                    <td>{{ record.series_no }}</td>
                    <td>{{ formatDate(record.session_date) }}</td>
                    <td class="title-cell">
                        <div class="t-truncate">{{ record.title }}</div>
                    </td>
                    <td>
                        <span class="badge text-bg-secondary">{{
                            record.status
                        }}</span>
                    </td>
                    <td style="font-size: 0.8rem">{{ record.authorname }}</td>
                    <td style="font-size: 0.8rem">
                        {{ record.coauthorname || "No co-authors" }}
                    </td>
                    <td>
                        <span class="chip">{{ record.sectorname }}</span>
                    </td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button
                                class="btn btn-sm btn-light border"
                                data-bs-toggle="dropdown"
                            >
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#"
                                        ><i class="fa-solid fa-eye me-2"></i
                                        >View</a
                                    >
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        ><i class="fa-solid fa-pen me-2"></i
                                        >Edit</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item text-danger"
                                        href="#"
                                        ><i class="fa-solid fa-trash me-2"></i
                                        >Delete</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal fade" ref="modalRefView" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 0.65rem">
                <div
                    class="modal-header"
                    style="
                        background: var(--navy);
                        color: #fff;
                        border-radius: 0.65rem 0.65rem 0 0;
                    "
                >
                    <div>
                        <span class="badge text-bg-secondary">{{
                            getRecordType
                        }}</span>
                        <span
                            class="ms-2"
                            style="font-size: 0.8rem; color: #c6cedc"
                            >No. <span>{{ getRecordSeries }}</span> &middot;
                            <span>{{ getRecordTerm }}</span></span
                        >
                    </div>
                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <h5 class="font-display" style="line-height: 1.4">
                        {{ getRecordTitle }}
                    </h5>

                    <div class="detail-divider"></div>
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="detail-label">SP Term</div>
                            <div class="detail-value">{{ getRecordTerm }}</div>
                        </div>
                        <div class="col-4">
                            <div class="detail-label">Type</div>
                            <div class="detail-value">{{ getRecordType }}</div>
                        </div>
                        <div class="col-4">
                            <div class="detail-label">Session Date</div>
                            <div class="detail-value">
                                {{ formatDate(getRecordSessionDate) }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="detail-label">Status</div>
                            <div class="detail-value"></div>
                        </div>
                        <div class="col-4">
                            <div class="detail-label">Sector</div>
                            <div class="detail-value">
                                {{ getRecordSector }}
                            </div>
                        </div>
                    </div>

                    <div class="detail-divider"></div>
                    <div class="detail-label mb-1">Author/s</div>
                    <div>
                        <span class="chip mb-2">{{ getRecordAuthors }}</span>
                    </div>

                    <label class="detail-label mb-1">Co-Author/s</label>
                    <span class="chip" v-if="getRecordCoAuthors">
                        {{ getRecordCoAuthors }}
                    </span>
                    <div v-else>
                        <span class="chip">No Co-Author/s</span>
                    </div>

                    <div class="detail-divider"></div>
                    <div class="detail-label mb-1">Classification</div>
                    <div class="row">
                        <div class="col-6">
                            <div
                                style="
                                    font-size: 0.72rem;
                                    color: var(--ink-muted);
                                "
                            >
                                Class 1
                            </div>
                            <span class="chip">{{ getRecordClass1 }}</span>
                        </div>
                        <div class="col-6">
                            <div
                                style="
                                    font-size: 0.72rem;
                                    color: var(--ink-muted);
                                "
                            >
                                Class 2
                            </div>
                            <span class="chip">{{ getRecordClass2 }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-printer me-1"></i>Print
                    </button>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-download me-1"></i>Download
                    </button>
                    <button class="btn btn-sm btn-amber">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div
        class="modal fade"
        ref="modalRef"
        tabindex="-1"
        data-bs-keydrop="false"
        data-bs-backdrop="static"
    >
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <form @submit.prevent="submitRecord">
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
                            style="font-size: 1.15rem"
                        >
                            New Legislative Record
                        </h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="section-heading">Basic Information</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">SP Term</label>
                                <select
                                    class="form-select"
                                    required
                                    v-model="recordForm.term"
                                >
                                    <option value="" disabled selected>
                                        Select term
                                    </option>
                                    <option
                                        v-for="n in 25"
                                        :key="n"
                                        :value="`SP-${String(n).padStart(2, '0')}`"
                                    >
                                        SP-{{ String(n).padStart(2, "0") }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Type</label>
                                <select
                                    class="form-select"
                                    required
                                    v-model="recordForm.type"
                                >
                                    <option value="" disabled selected>
                                        Select type
                                    </option>
                                    <option value="A-ORD">A-ORD</option>
                                    <option value="ORD">ORD</option>
                                    <option value="RES">RES</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">No.</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="e.g. 691"
                                    required
                                    v-model="recordForm.series_no"
                                />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Session Date</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    required
                                    v-model="recordForm.session_date"
                                />
                            </div>
                        </div>
                        <div class="section-heading">Legislative Title</div>
                        <div class="mb-4">
                            <label class="form-label">Full Title</label>
                            <textarea
                                class="form-control"
                                rows="5"
                                placeholder="Enter the complete legislative title..."
                                required
                                v-model="recordForm.title"
                            ></textarea>
                        </div>
                        <div class="section-heading">Classification</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"
                                    >Class 1
                                    <span class="text-muted fw-normal"
                                        >(can select multiple)</span
                                    ></label
                                >
                                <v-select
                                    v-model="selectedClass1ID"
                                    :options="class1"
                                    :reduce="(row1) => row1.id"
                                    label="name"
                                    placeholder="Select Classification 1"
                                    multiple
                                ></v-select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"
                                    >Class 2
                                    <span class="text-muted fw-normal"
                                        >(can select multiple)</span
                                    ></label
                                >
                                <v-select
                                    v-model="selectedClass2ID"
                                    :options="class2"
                                    :reduce="(row2) => row2.id"
                                    label="name"
                                    placeholder="Select Classification 2"
                                    multiple
                                ></v-select>
                            </div>
                        </div>
                        <div class="section-heading">Author/s</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Author 1</label>
                                <v-select
                                    v-model="selectedAuthorID"
                                    :options="authors"
                                    :reduce="(author) => author.id"
                                    label="authorhead"
                                    placeholder="Select Author"
                                    multiple
                                ></v-select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"
                                    >Co-Author
                                    <span class="text-muted fw-normal"
                                        >(optional)</span
                                    ></label
                                >
                                <v-select
                                    v-model="selectedCoAuthorID"
                                    :options="authors"
                                    :reduce="(author) => author.id"
                                    label="authorhead"
                                    placeholder="Select Author"
                                    multiple
                                ></v-select>
                            </div>
                        </div>
                        <div class="section-heading">Status</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label"
                                    >Workflow Status</label
                                >
                                <select
                                    class="form-select"
                                    v-model="recordForm.status"
                                >
                                    <option value="" disabled selected>
                                        Select status
                                    </option>
                                    <option value="AMENDATORY">
                                        AMENDATORY
                                    </option>
                                    <option value="AMENDED">AMENDED</option>
                                    <option value="RECALLATORY">
                                        RECALLATORY
                                    </option>
                                    <option value="RECALLED">RECALLED</option>
                                    <option value="REITERATED">
                                        REITERATED
                                    </option>
                                    <option value="REITERATORY">
                                        REITERATORY
                                    </option>
                                    <option value="REPEALING">REPEALING</option>
                                    <option value="SUSPENDED">SUSPENDED</option>
                                    <option value="SUSPENSIVE">
                                        SUSPENSIVE
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    >Legislative Action
                                    <span class="text-muted fw-normal"
                                        >(optional)</span
                                    ></label
                                >
                                <select class="form-select">
                                    <option value="" selected>None</option>
                                    <option>Amendatory</option>
                                    <option>Amended</option>
                                    <option>Recallatory</option>
                                    <option>Recalled</option>
                                    <option>Reiterated</option>
                                    <option>Reiteratory</option>
                                    <option>Repealing</option>
                                    <option>Suspended</option>
                                    <option>Suspensive</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sector</label>
                                <v-select
                                    v-model="selectedSectorID"
                                    :options="sectors"
                                    :reduce="(sector) => sector.id"
                                    label="name"
                                    placeholder="Select Sectors"
                                    multiple
                                ></v-select>
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
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-lg me-1"></i>Save Record
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
