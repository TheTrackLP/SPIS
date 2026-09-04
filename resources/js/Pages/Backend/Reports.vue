<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    authors: Array,
    mainClass: Array,
    subClass: Array,
    sectors: Array,
    mainAuthRecCount: Array,
    CoAuthRecCount: Array,
});

const collapseFilters = ref(false);
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
            <button class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-print me-1"></i>Print
            </button>
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
                <form id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">SP Term</label>
                            <select class="form-select">
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
                        <div class="col-md-4">
                            <label class="form-label"
                                >Main Classification</label
                            >
                            <v-select
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
                                :options="subClass"
                                :reduce="(sub) => sub.id"
                                label="subname"
                                placeholder="Select Sub Classification"
                                multiple
                            ></v-select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Author</label>
                            <v-select
                                :options="authors"
                                :reduce="(auth) => auth.id"
                                label="authorhead"
                                placeholder="Select Author/s"
                                multiple
                            ></v-select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Co-Author</label>
                            <v-select
                                :options="authors"
                                :reduce="(auth) => auth.id"
                                label="authorhead"
                                placeholder="Select Co Author/s"
                                multiple
                            ></v-select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Type</label>
                            <select class="form-select">
                                <option value="">All Types</option>
                                <option value="A-ORD">A-ORB</option>
                                <option value="ORD">ORD</option>
                                <option value="RES">RES</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sector</label>
                            <v-select
                                :options="sectors"
                                :reduce="(sector) => sector.id"
                                label="name"
                                placeholder="Select Sectors"
                                multiple
                            ></v-select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select">
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
                        <div class="col-md-4">
                            <label class="form-label">Date From</label>
                            <input type="date" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date To</label>
                            <input type="date" class="form-control" />
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-rotate-left me-1"></i>Reset
                        </button>
                        <Link
                            type="button"
                            class="btn btn-primary"
                            :href="route('filter.dash')"
                        >
                            <i class="fa-solid fa-magnifying-glass me-1"></i
                            >Apply Filters
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">Records by Author</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Author</th>
                                <th>Records</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(count, index) in mainAuthRecCount"
                                :key="index"
                            >
                                <td>{{ count.authorhead }}</td>
                                <td>{{ count.count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">Records by Co-Author</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Author</th>
                                <th>Records</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(count, index) in CoAuthRecCount"
                                :key="index"
                            >
                                <td>{{ count.coauthorhead }}</td>
                                <td>{{ count.count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">
                    Records by Classification 1
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Classification</th>
                                <th>Records</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Finance</td>
                                <td>18</td>
                            </tr>
                            <tr>
                                <td>Education</td>
                                <td>14</td>
                            </tr>
                            <tr>
                                <td>Agriculture</td>
                                <td>11</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">
                    Records by Classification 2
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Sub Classification</th>
                                <th>Records</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Budget Allocation</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>Scholarship</td>
                                <td>8</td>
                            </tr>
                            <tr>
                                <td>Land Use</td>
                                <td>6</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->
    </div>
</template>
