<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <section id="view-dashboard" class="view active">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <div>
                    <h1 class="font-display mb-0" style="font-size: 1.5rem">
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
                            <i class="bi bi-journals"></i>
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
                            <i class="bi bi-hourglass-split"></i>
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
                            <i class="bi bi-check-circle"></i>
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
                            <i class="bi bi-archive"></i>
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
                            <a
                                href="#"
                                class="btn btn-sm btn-outline-secondary"
                                data-view="records"
                                >View All <i class="bi bi-arrow-right"></i
                            ></a>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-hover mb-0"
                                style="font-size: 0.8rem"
                            >
                                <thead style="color: #10233f">
                                    <tr>
                                        <th>No.</th>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Session Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="recentRecordsBody"></tbody>
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
