<script setup>
const props = defineProps({
    records: Array,
});

import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "2-digit",
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <section id="view-dashboard" class="view active">
            <div class="container-fluid py-4 px-4">
                <div
                    class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2"
                >
                    <div>
                        <h1 class="h3 fw-bold mb-0">Dashboard</h1>
                        <div class="text-muted small">
                            Overview of legislative records, current as of
                            today.
                        </div>
                    </div>
                    <select
                        class="form-select form-select-sm w-auto"
                        id="termFilterDash"
                    >
                        <option>SP-12 (Current Term)</option>
                        <option>All Terms</option>
                        <option>SP-11</option>
                        <option>SP-10</option>
                    </select>
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
                                    <i class="bi bi-journal-bookmark-fill"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold" id="statTotal">
                                        0
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
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold" id="statAuthors">
                                        0
                                    </div>
                                    <div class="text-muted small">Authors</div>
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
                                    class="rounded-circle d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info"
                                    style="width: 44px; height: 44px"
                                >
                                    <i class="bi bi-person-lines-fill"></i>
                                </div>
                                <div>
                                    <div
                                        class="fs-5 fw-bold"
                                        id="statCoAuthors"
                                    >
                                        0
                                    </div>
                                    <div class="text-muted small">
                                        Co-Authors
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
                                    class="rounded-circle d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger"
                                    style="width: 44px; height: 44px"
                                >
                                    <i class="bi bi-tags-fill"></i>
                                </div>
                                <div>
                                    <div
                                        class="fs-5 fw-bold"
                                        id="statClassifications"
                                    >
                                        0
                                    </div>
                                    <div class="text-muted small">
                                        Classifications
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
                                    <i class="bi bi-diagram-3-fill"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold" id="statSectors">
                                        0
                                    </div>
                                    <div class="text-muted small">Sectors</div>
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
                                    class="rounded-circle d-flex align-items-center justify-content-center bg-dark bg-opacity-10 text-dark"
                                    style="width: 44px; height: 44px"
                                >
                                    <i class="bi bi-calendar-range-fill"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold" id="statTerms">
                                        0
                                    </div>
                                    <div class="text-muted small">SP Terms</div>
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
                                    <a
                                        href="#"
                                        class="btn btn-sm btn-outline-secondary"
                                    >
                                        View All
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table
                                        class="table table-hover align-middle mb-0 small"
                                    >
                                        <thead>
                                            <tr class="text-center">
                                                <th>No.</th>
                                                <th>Type</th>
                                                <th>Title</th>
                                                <th>Session Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(value, index) in 50"
                                                :key="index"
                                            >
                                                <td class="text-center">001</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge text-bg-secondary"
                                                        >Resolution</span
                                                    >
                                                </td>
                                                <td>
                                                    <div
                                                        class="text-truncate"
                                                        style="max-width: 260px"
                                                    >
                                                        Resolution appropriating
                                                        funds for the province's
                                                        infrastructure program
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Sep 01, 2026
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge text-bg-warning"
                                                        >Pending</span
                                                    >
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
                                <ul
                                    class="list-group list-group-flush"
                                    id="authorBreakdownList"
                                >
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0"
                                    >
                                        <span>Hon. Juan Dela Cruz</span>
                                        <span
                                            class="badge text-bg-primary rounded-pill"
                                            >18</span
                                        >
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0"
                                    >
                                        <span>Hon. Maria Santos</span>
                                        <span
                                            class="badge text-bg-primary rounded-pill"
                                            >14</span
                                        >
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0"
                                    >
                                        <span>Hon. Pedro Reyes</span>
                                        <span
                                            class="badge text-bg-primary rounded-pill"
                                            >11</span
                                        >
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0"
                                    >
                                        <span>Hon. Ana Villanueva</span>
                                        <span
                                            class="badge text-bg-primary rounded-pill"
                                            >9</span
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
                                    >
                                        <span>Hon. Jose Ramirez</span>
                                        <span
                                            class="badge text-bg-info rounded-pill"
                                            >12</span
                                        >
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0"
                                    >
                                        <span>Hon. Carla Mendoza</span>
                                        <span
                                            class="badge text-bg-info rounded-pill"
                                            >10</span
                                        >
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0"
                                    >
                                        <span>Hon. Ramon Torres</span>
                                        <span
                                            class="badge text-bg-info rounded-pill"
                                            >7</span
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
                                    <ul
                                        class="list-group list-group-flush"
                                        id="coAuthorBreakdownList"
                                    >
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center px-0"
                                        >
                                            <span>Hon. Jose Ramirez</span>
                                            <span
                                                class="badge text-bg-info rounded-pill"
                                                >12</span
                                            >
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center px-0"
                                        >
                                            <span>Hon. Carla Mendoza</span>
                                            <span
                                                class="badge text-bg-info rounded-pill"
                                                >10</span
                                            >
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center px-0"
                                        >
                                            <span>Hon. Ramon Torres</span>
                                            <span
                                                class="badge text-bg-info rounded-pill"
                                                >7</span
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
