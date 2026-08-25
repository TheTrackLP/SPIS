<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="font-display mb-0" style="font-size: 1.5rem">
                Legislative Records
            </h1>
            <div class="text-muted" style="font-size: 0.82rem">
                Resolutions, ordinances, and other legislative documents.
            </div>
        </div>
        <button class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i> New Record
        </button>
    </div>
    <div class="card p-1 mb-3">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label for="">SEARCH TITLE/NO.</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="e.g Ordinance No. 15"
                    />
                </div>
                <div class="col-6 col-md-2">
                    <label for="">SP Term</label>
                    <select name="" class="form-select">
                        <option value="">All Terms</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label for="">Type</label>
                    <select name="" class="form-select">
                        <option value="">All Types</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label for="">Status</label>
                    <select name="" class="form-select">
                        <option value="">All Statuses</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-6 col-md-3 d-flex gap-2">
                    <button
                        class="btn btn-sm btn-primary flex-fill"
                        id="btnApplyFilter"
                    >
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                    <button
                        class="btn btn-sm btn-outline-secondary"
                        id="btnClearFilter"
                    >
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div class="table-response">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>SP Term</th>
                    <th>Type</th>
                    <th>No.</th>
                    <th>Session Date</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Author/s</th>
                    <th>Co-Author/s</th>
                    <th>Sector</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</template>
