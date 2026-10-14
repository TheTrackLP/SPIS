<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";
import { formatDate } from "@/resuables";

const props = defineProps({
    authors: Array,
    mainClass: Array,
    subClass: Array,
    sectors: Array,
    terms: Array,
    mainAuthRecCount: Array,
    CoAuthRecCount: Array,
    sponsorRecCounts: Array,
    coSponsorRecCounts: Array,
    types: Array,
});

const filterRecordsForm = useForm({
    sptermid: "",
    type_id: "",
    sessionfrom: "",
    sessionto: "",
    status: "",
    authorid: [],
    coauthorid: [],
    sponsorid: [],
    cosponsorid: [],
    mainclassid: [],
    subclassid: [],
    sectorid: [],
});

const clearFilters = () => {
    filterRecordsForm.reset();
    selectedAuthorID.value = "";
    selectedCoAuthorID.value = "";
    selectedSectorID.value = "";
    selectedSubClassID.value = "";
    selectedMainClassID.value = "";
    selectedSponsorAuthorID.value = "";
    selectedCoSponsorAuthorID.value = "";
};

const selectedAuthorID = ref([]);

const selectedAuthors = computed(() => {
    return props.authors.filter((author) =>
        selectedAuthorID.value.includes(author.id),
    );
});
watch(selectedAuthors, (newAuthors) => {
    filterRecordsForm.authorid = newAuthors
        .map((author) => author.id)
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
        filterRecordsForm.coauthorid = newCoAuthors
            .map((coauthor) => coauthor.id)
            .join("/");
    } else {
        filterRecordsForm.coauthorid = null;
    }
});

const selectedSponsorAuthorID = ref([]);

const selectedSponsorAuthors = computed(() => {
    return props.authors.filter((sponsor) =>
        selectedSponsorAuthorID.value.includes(sponsor.id),
    );
});
watch(selectedSponsorAuthors, (newSponsorAuthors) => {
    if (newSponsorAuthors.length > 0) {
        filterRecordsForm.sponsorid = newSponsorAuthors
            .map((sponsor) => sponsor.id)
            .join("/");
    } else {
        filterRecordsForm.sponsorid = null;
    }
});

const selectedCoSponsorAuthorID = ref([]);

const selectedCoSponsorAuthors = computed(() => {
    return props.authors.filter((cosponsorauthor) =>
        selectedCoSponsorAuthorID.value.includes(cosponsorauthor.id),
    );
});
watch(selectedCoSponsorAuthors, (newCoSponsorAuthors) => {
    if (newCoSponsorAuthors.length > 0) {
        filterRecordsForm.cosponsorid = newCoSponsorAuthors
            .map((cosponsorauthor) => cosponsorauthor.id)
            .join("/");
    } else {
        filterRecordsForm.cosponsorid = null;
    }
});

const selectedMainClassID = ref([]);

const selectedMainClass = computed(() => {
    return props.mainClass.filter((main) =>
        selectedMainClassID.value.includes(main.id),
    );
});

watch(selectedMainClass, (mainClas) => {
    filterRecordsForm.mainclassid = mainClas.map((main) => main.id).join("/");
});

const selectedSubClassID = ref([]);

const selectedSubClass = computed(() => {
    return props.subClass.filter((sub) =>
        selectedSubClassID.value.includes(sub.id),
    );
});

watch(selectedSubClass, (subClas) => {
    filterRecordsForm.subclassid = subClas.map((sub) => sub.id).join("/");
});

const selectedSectorID = ref([]);

const selectedSector = computed(() => {
    return props.sectors.filter((sec) =>
        selectedSectorID.value.includes(sec.id),
    );
});

watch(selectedSector, (newSector) => {
    filterRecordsForm.sectorid = newSector.map((sec) => sec.id).join("/");
});

const submitFilterRecords = async () => {
    filterRecordsForm.get(route("filter.dash"));
};

const collapseFilters = ref(false);

const filterByTerms = ref("");

const filterMainAuthCountsByTerms = computed(() => {
    const termQuery = filterByTerms.value;
    return props.mainAuthRecCount.filter((term) => {
        const matchTerm = !termQuery || term.sptermid === termQuery;
        return matchTerm;
    });
});
const filterCoAuthCountsByTerms = computed(() => {
    const termQuery = filterByTerms.value;
    return props.CoAuthRecCount.filter((term) => {
        const matchTerm = !termQuery || term.sptermid === termQuery;
        return matchTerm;
    });
});

const filterSponsorsCountByTerms = computed(() => {
    const termQuery = filterByTerms.value;
    return props.sponsorRecCounts.filter((term) => {
        const matchTerm = !termQuery || term.sptermid === termQuery;
        return matchTerm;
    });
});

const filterCoSponsorsCountByTerms = computed(() => {
    const termQuery = filterByTerms.value;
    return props.coSponsorRecCounts.filter((term) => {
        const matchTerm = !termQuery || term.sptermid === termQuery;
        return matchTerm;
    });
});
</script>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="Reports" />
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="font-display mb-0" style="font-size: 1.5rem">Reports</h1>
            <div class="text-muted" style="font-size: 0.82rem">
                Legislative record summaries by author, co-author, and
                classification.
            </div>
        </div>
        <div class="d-flex gap-2">
            <v-select
                :options="terms"
                style="min-width: 300px"
                :reduce="(term) => term.id"
                label="sptermno"
                placeholder="Select SP Term"
                v-model="filterByTerms"
            >
                <template #option="term">
                    {{ term.sptermno }} | {{ formatDate(term.termfrom) }}-{{
                        formatDate(term.termto)
                    }}
                </template>
                <template #selected-option="term">
                    {{ term.sptermno }} | {{ formatDate(term.termfrom) }}-{{
                        formatDate(term.termto)
                    }}
                </template></v-select
            >
            <!-- <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
            </button>
            <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-file-earmark-excel me-1"></i>Export Excel
            </button> -->
        </div>
    </div>
    <div class="card shadow-sm mb-4">
        <div
            class="card-header bg-white d-flex justify-content-between align-items-center"
        >
            <h6 class="mb-0 fw-semibold">
                <i class="fa-solid fa-filter me-2"></i>Filter Records
            </h6>
            <button
                class="btn btn-sm btn-outline-secondary"
                type="button"
                @click="collapseFilters = !collapseFilters"
            >
                <i class="fa-solid fa-chevron-down"></i>
            </button>
        </div>

        <div class="collapse" :class="{ show: collapseFilters }">
            <div class="card-body">
                <form @submit.prevent="submitFilterRecords" target="_blank">
                    <div class="row g-3">
                        <!-- Row 1 -->
                        <div class="col-md-4">
                            <label class="form-label">SP Term</label>
                            <v-select
                                :options="terms"
                                :reduce="(term) => term.id"
                                label="sptermno"
                                placeholder="Select SP Term"
                                v-model="filterRecordsForm.sptermid"
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
                                </template>
                            </v-select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"
                                >Main Classification</label
                            >
                            <v-select
                                v-model="selectedMainClassID"
                                :options="mainClass"
                                :reduce="(main) => main.id"
                                label="mainname"
                                placeholder="Select Main Classification"
                                multiple
                            ></v-select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sub Classification</label>
                            <v-select
                                v-model="selectedSubClassID"
                                :options="subClass"
                                :reduce="(sub) => sub.id"
                                label="subname"
                                placeholder="Select Sub Classification"
                                multiple
                            ></v-select>
                        </div>

                        <!-- Row 2: Authors & Sponsors -->
                        <div class="col-md-3">
                            <label class="form-label">Author/s</label>
                            <v-select
                                v-model="selectedAuthorID"
                                :options="authors"
                                :reduce="(auth) => auth.id"
                                label="fullname"
                                placeholder="Select Author/s"
                                multiple
                            ></v-select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Co-Author/s</label>
                            <v-select
                                v-model="selectedCoAuthorID"
                                :options="authors"
                                :reduce="(auth) => auth.id"
                                label="fullname"
                                placeholder="Select Co-Author/s"
                                multiple
                            ></v-select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sponsor/s</label>
                            <v-select
                                v-model="selectedSponsorAuthorID"
                                :options="authors"
                                :reduce="(auth) => auth.id"
                                label="fullname"
                                placeholder="Select Sponsor/s"
                                multiple
                            ></v-select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Co-Sponsor/s</label>
                            <v-select
                                v-model="selectedCoSponsorAuthorID"
                                :options="authors"
                                :reduce="(auth) => auth.id"
                                label="fullname"
                                placeholder="Select Co-Sponsor/s"
                                multiple
                            ></v-select>
                        </div>

                        <!-- Row 3 -->
                        <div class="col-md-4">
                            <label class="form-label">Type</label>
                            <v-select
                                :options="types"
                                :reduce="(type) => type.id"
                                label="type_name"
                                placeholder="Select Type"
                                v-model="filterRecordsForm.type_id"
                            ></v-select>
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
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select
                                class="form-select"
                                v-model="filterRecordsForm.status"
                            >
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

                        <!-- Row 4 -->
                        <div class="col-md-6">
                            <label class="form-label">Date From</label>
                            <input
                                type="date"
                                class="form-control"
                                v-model="filterRecordsForm.sessionfrom"
                            />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date To</label>
                            <input
                                type="date"
                                class="form-control"
                                v-model="filterRecordsForm.sessionto"
                            />
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            @click="clearFilters"
                        >
                            <i class="fa-solid fa-rotate-left me-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass me-1"></i
                            >Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">Records by Author/s</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Author</th>
                                <th>Records</th>
                                <th>SP Term</th>
                            </tr>
                        </thead>
                        <tbody v-if="filterMainAuthCountsByTerms.length > 0">
                            <tr
                                v-for="(
                                    count, index
                                ) in filterMainAuthCountsByTerms"
                                :key="index"
                            >
                                <td>{{ count.fullname }}</td>
                                <td>{{ count.count }}</td>
                                <td>{{ count.spterm }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td
                                    colspan="7"
                                    class="text-center align-middle"
                                >
                                    <h6>No Data as of Yet</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">Records by Co-Author/s</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Author</th>
                                <th>Records</th>
                                <th>SP Term</th>
                            </tr>
                        </thead>
                        <tbody v-if="filterCoAuthCountsByTerms.length > 0">
                            <tr
                                v-for="(
                                    count, index
                                ) in filterCoAuthCountsByTerms"
                                :key="index"
                            >
                                <td>{{ count.fullname }}</td>
                                <td>{{ count.count }}</td>
                                <td>{{ count.spterm }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td
                                    colspan="7"
                                    class="text-center align-middle"
                                >
                                    <h6>No Data as of Yet</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">Records by Sponsor/s</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Author</th>
                                <th>Records</th>
                                <th>SP Term</th>
                            </tr>
                        </thead>
                        <tbody v-if="filterSponsorsCountByTerms.length > 0">
                            <tr
                                v-for="(
                                    count, index
                                ) in filterSponsorsCountByTerms"
                                :key="index"
                            >
                                <td>{{ count.fullname }}</td>
                                <td>{{ count.count }}</td>
                                <td>{{ count.spterm }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td
                                    colspan="7"
                                    class="text-center align-middle"
                                >
                                    <h6>No Data as of Yet</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">Records by Co-Sponsor/s</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Author</th>
                                <th>Records</th>
                                <th>SP Term</th>
                            </tr>
                        </thead>
                        <tbody v-if="filterCoSponsorsCountByTerms.length > 0">
                            <tr
                                v-for="(
                                    count, index
                                ) in filterCoSponsorsCountByTerms"
                                :key="index"
                            >
                                <td>{{ count.fullname }}</td>
                                <td>{{ count.count }}</td>
                                <td>{{ count.spterm }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td
                                    colspan="7"
                                    class="text-center align-middle"
                                >
                                    <h6>No Data as of Yet</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
