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
            <div class="d-flex justify-content-between align-items-end mb-3">
                <div>
                    <h1 class="font-display mb-0" style="font-size: 2rem">
                        Dashboard
                    </h1>
                    <div class="text-muted" style="font-size: 0.82rem">
                        Overview of legislative records, current as of today.
                    </div>
                </div>
                <select
                    class="form-select form-select-sm"
                    style="width: auto"
                    id="termFilterDash"
                >
                    <option>SP-12 (Current Term)</option>
                    <option>All Terms</option>
                    <option>SP-11</option>
                    <option>SP-10</option>
                </select>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6 col-lg-3">
                    <div
                        class="sp-card stat-card d-flex align-items-center gap-3"
                    >
                        <div
                            class="stat-icon"
                            style="background: #e7eef9; color: #1d4e89"
                        >
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <div>
                            <div class="stat-value" id="statTotal">0</div>
                            <div class="stat-label">Total Records</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div
                        class="sp-card stat-card d-flex align-items-center gap-3"
                    >
                        <div
                            class="stat-icon"
                            style="background: #fcf1dc; color: #96660c"
                        >
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <div>
                            <div class="stat-value" id="statPending">0</div>
                            <div class="stat-label">Pending</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div
                        class="sp-card stat-card d-flex align-items-center gap-3"
                    >
                        <div
                            class="stat-icon"
                            style="background: #e7f3ea; color: #1e7b34"
                        >
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <div class="stat-value" id="statApproved">0</div>
                            <div class="stat-label">Approved</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div
                        class="sp-card stat-card d-flex align-items-center gap-3"
                    >
                        <div
                            class="stat-icon"
                            style="background: #eef0f2; color: #5a5f66"
                        >
                            <i class="fa-solid fa-box-archive"></i>
                        </div>
                        <div>
                            <div class="stat-value" id="statArchived">0</div>
                            <div class="stat-label">Archived</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="sp-card p-3">
                        <div
                            class="d-flex justify-content-between align-items-center mb-2"
                        >
                            <div class="section-title">
                                Recent Legislative Records
                            </div>
                            <Link
                                :href="route('rec.dash')"
                                class="btn btn-sm btn-outline-secondary"
                                >View All <i class="bi bi-arrow-right"></i
                            ></Link>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-hover mb-0"
                                style="font-size: 0.8rem"
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
                                        class="align-middle"
                                        v-for="(rec, index) in records"
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
                                        <td class="text-center">
                                            {{ formatDate(rec.session_date) }}
                                        </td>
                                        <td class="title-cell">
                                            <div class="t-truncate">
                                                {{ rec.title }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge text-bg-secondary"
                                                >{{ rec.status }}</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sp-card p-3 h-100">
                        <div class="section-title mb-2">Records by Type</div>
                        <canvas id="typeChart" height="220"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>
