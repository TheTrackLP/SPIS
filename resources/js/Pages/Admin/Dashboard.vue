<script setup>
import { formatDate } from "@/resuables";
const props = defineProps({
    latestRecords: Array,
    terms: Array,
    mainAuthorCount: Array,
    sectorCount: Array,
    coAuthorCount: Array,
    totalRecords: Object,
    activeAuthors: Object,
});

import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />
    <AdminLayout>
        <section class="view active">
            <div class="container-fluid py-4 px-4">
                <div class="">
                    <div>
                        <h1 class="h3 fw-bold mb-0">Dashboard</h1>
                        <div class="text-muted small">
                            Overview of legislative records, current as of
                            today.
                        </div>
                    </div>
                    <v-select
                        :options="terms"
                        :reduce="(term) => term.id"
                        label="sptermno"
                        placeholder="Select SP Term"
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
                <div class="row g-3 mb-4">
                    <div class="col-6 col-lg-2">
                        <div class="card shadow-sm border-0 h-100">
                            <div
                                class="card-body d-flex align-items-center gap-3"
                            >
                                <div
                                    class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary"
                                    style="width: 44px; height: 44px"
                                >
                                    <i class="fa-solid fa-book"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold" id="statTotal">
                                        {{ totalRecords }}
                                    </div>
                                    <div class="text-muted small">
                                        Total Records
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="card shadow-sm border-0 h-100">
                            <div
                                class="card-body d-flex align-items-center gap-3"
                            >
                                <div
                                    class="rounded-circle d-flex align-items-center justify-content-center"
                                    style="
                                        width: 44px;
                                        height: 44px;
                                        background-color: #f2e9fb;
                                        color: #6f42c1;
                                    "
                                >
                                    <i class="fa-solid fa-users-line"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold">
                                        {{ activeAuthors }}
                                    </div>
                                    <div class="text-muted small">
                                        Active Authors
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="card shadow-sm border-0 h-100">
                            <div
                                class="card-body d-flex align-items-center gap-3"
                            >
                                <div
                                    class="rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success"
                                    style="width: 44px; height: 44px"
                                >
                                    <i class="fa-solid fa-diagram-project"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold">0</div>
                                    <div class="text-muted small">Sectors</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-7">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <div
                                    class="d-flex justify-content-between align-items-center mb-3"
                                >
                                    <div class="fw-semibold">
                                        Recent Legislative Records
                                    </div>
                                    <Link
                                        :href="route('rec.dash')"
                                        class="btn btn-sm btn-outline-secondary"
                                    >
                                        View All
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </Link>
                                </div>
                                <div class="table-responsive">
                                    <table
                                        class="table table-hover align-middle mb-0 small"
                                    >
                                        <thead>
                                            <tr class="text-center">
                                                <th>Res. No.</th>
                                                <th>Type</th>
                                                <th>Title</th>
                                                <th>Session Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="align-middle"
                                                v-for="(
                                                    rec, index
                                                ) in latestRecords"
                                                :key="index"
                                            >
                                                <td class="text-center">
                                                    {{ rec.resono }}
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge text-bg-secondary"
                                                        >{{ rec.type }}</span
                                                    >
                                                </td>
                                                <td>
                                                    <div
                                                        class="text-truncate"
                                                        style="max-width: 260px"
                                                    >
                                                        {{ rec.title }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{
                                                        formatDate(
                                                            rec.session_date,
                                                        )
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <div class="fw-semibold mb-3">
                                    Records by Author
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0"
                                        v-for="(
                                            count, index
                                        ) in mainAuthorCount"
                                        :key="index"
                                    >
                                        <span>{{ count.fullname }}</span>
                                        <span
                                            class="badge text-bg-primary rounded-pill"
                                            >{{ count.count }}</span
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <div class="fw-semibold mb-3">
                                    Records by Co-Author
                                </div>
                                <ul
                                    class="list-group list-group-flush"
                                    id="coAuthorBreakdownList"
                                >
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0"
                                        v-for="(
                                            coAuthor, index
                                        ) in coAuthorCount"
                                        :key="index"
                                    >
                                        <span>{{ coAuthor.fullname }}</span>
                                        <span
                                            class="badge text-bg-info rounded-pill"
                                            >{{ coAuthor.count }}</span
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="fw-semibold mb-3">
                                    Records by Sector
                                </div>
                                <div id="sectorBreakdownList">
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center px-0"
                                            v-for="(
                                                sector, index
                                            ) in sectorCount"
                                            :key="index"
                                        >
                                            <span>{{ sector.name }}</span>
                                            <span
                                                class="badge text-bg-info rounded-pill"
                                                >{{ sector.count }}</span
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>
