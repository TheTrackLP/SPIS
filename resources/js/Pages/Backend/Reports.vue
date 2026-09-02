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
                <i class="bi bi-printer me-1"></i>Print
            </button>
            <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
            </button>
            <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-file-earmark-excel me-1"></i>Export Excel
            </button>
        </div>
    </div>
    <div class="sp-card p-3 mb-3 filter-toolbar">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">SP Term</label>
                <select class="form-select form-select-sm">
                    <option>All Terms</option>
                    <option>SP-12</option>
                    <option>SP-11</option>
                    <option>SP-10</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Type</label>
                <select class="form-select form-select-sm">
                    <option>All Types</option>
                    <option>Resolution</option>
                    <option>Ordinance</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date Range</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="mm/dd/yyyy – mm/dd/yyyy"
                />
            </div>
            <div class="col-md-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="mm/dd/yyyy – mm/dd/yyyy"
                />
            </div>
            <div class="col-md-2">
                <button class="btn btn-success btn-sm w-100">
                    <i class="bi bi-search me-1"></i>Generate Report
                </button>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">Records by Author</div>
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th class="text-center">Records</th>
                            <th style="width: 35%">Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hon. Juan Dela Cruz</td>
                            <td class="text-center">42</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 85%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hon. Maria Santos</td>
                            <td class="text-center">37</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 74%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hon. Jose Garcia</td>
                            <td class="text-center">28</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 56%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hon. Ana Reyes</td>
                            <td class="text-center">19</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 38%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hon. Pedro Cruz</td>
                            <td class="text-center">14</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 28%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">Records by Co-Author</div>
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Co-Author</th>
                            <th class="text-center">Records</th>
                            <th style="width: 35%">Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hon. Mark Santos</td>
                            <td class="text-center">21</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 80%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hon. Ana Reyes</td>
                            <td class="text-center">18</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 69%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hon. Jose Garcia</td>
                            <td class="text-center">15</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 58%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hon. Pedro Cruz</td>
                            <td class="text-center">11</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 42%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hon. Juan Dela Cruz</td>
                            <td class="text-center">7</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 27%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">
                    Records by Classification 1
                </div>
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Classification</th>
                            <th class="text-center">Records</th>
                            <th style="width: 35%">Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Finance</td>
                            <td class="text-center">18</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 75%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Education</td>
                            <td class="text-center">14</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 58%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Agriculture</td>
                            <td class="text-center">11</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 46%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Health</td>
                            <td class="text-center">7</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 29%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Strategic</td>
                            <td class="text-center">9</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 37%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="sp-card p-3 h-100">
                <div class="section-title mb-3">
                    Records by Classification 2
                </div>
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Classification</th>
                            <th class="text-center">Records</th>
                            <th style="width: 35%">Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>LGU-Capiz</td>
                            <td class="text-center">22</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 88%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Budget</td>
                            <td class="text-center">15</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 60%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Tourism</td>
                            <td class="text-center">9</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 36%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Roads</td>
                            <td class="text-center">6</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 24%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Social Services</td>
                            <td class="text-center">4</td>
                            <td>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill"
                                        style="width: 16%"
                                    ></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
