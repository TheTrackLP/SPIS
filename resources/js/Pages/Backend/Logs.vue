<script setup>
import { Head } from "@inertiajs/vue3";
import {
    formatDate,
    formatDateTime,
    formatTime,
    strHeadline,
} from "@/resuables";
import { nextTick, ref } from "vue";
import { Modal } from "bootstrap";

const modalRef = ref(null);
let modalInstanceView = null;
const opemViewModal = () => {
    nextTick(() => {
        modalInstanceView = new Modal(modalRef.value);
        modalInstanceView.show();
    });
};

const getSubject = ref("");
const getUserChanged = ref("");
const getDateTime = ref("");
const getModule = ref("");
const getEvent = ref("");
const getFieldName = ref("");
const getOldValue = ref("");
const getNewValue = ref("");
const getAction = ref("");
const getCreatValue = ref(null);

const fetchActivityLog = (log) => {
    opemViewModal();
    getSubject.value = log.subject_label;
    getUserChanged.value = log.username;
    getDateTime.value = log.created_at;
    getModule.value = log.module;
    getEvent.value = log.event_type;
    getFieldName.value = log.field_name;
    getOldValue.value = log.old_value;
    getNewValue.value = log.new_value;
    getAction.value = log.action;
    getCreatValue.value = JSON.parse(log.create_value);
};

const props = defineProps({
    logs: Array,
});
</script>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>
<style>
.diff-old {
    background: #fdecea;
    color: #b02a37;
    text-decoration: line-through;
    padding: 1px 6px;
    border-radius: 4px;
}
.diff-new {
    background: #e8f5e9;
    color: #1e7b34;
    padding: 1px 6px;
    border-radius: 4px;
}

.table-responsive {
    max-height: 710px;
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
    <Head title="Activity Logs" />
    <div class="sp-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="font-display mb-0" style="font-size: 2rem">
                    Activity Logs
                </h1>
                <small class="text-muted">
                    Audit trail of changes made to records and settings
                </small>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date &amp; Time</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Module</th>
                        <th>Subject</th>
                        <th>Change</th>
                        <th class="text-end">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(log, index) in logs" :key="index">
                        <td class="text-nowrap">
                            <div>{{ formatDate(log.created_at) }}</div>
                            <small class="text-muted">{{
                                formatTime(log.created_at)
                            }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="small fw-semibold">{{
                                    log.username
                                }}</span>
                            </div>
                        </td>
                        <td>
                            {{ strHeadline(log.event_type) }}
                        </td>
                        <td>{{ strHeadline(log.module) }}</td>
                        <td>{{ log.subject_label }}</td>
                        <td class="small" v-if="log.action === 'updated'">
                            <span class="diff-old">{{ log.old_value }}</span>
                            <i class="fa-solid fa-arrow-right"></i>
                            <span class="diff-new">{{ log.new_value }}</span>
                        </td>
                        <td v-else-if="log.action === 'created'">
                            <h6>
                                Click button to view full records created
                                <i class="fa-solid fa-arrow-right"></i>
                            </h6>
                        </td>
                        <td class="text-end">
                            <button
                                class="btn btn-outline-primary btn-sm"
                                @click="fetchActivityLog(log)"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- View Full Detail of Activity Log -->
    <div class="modal fade" ref="modalRef" tabindex="-1">
        <div
            class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-4">Activity Details</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="detail-label">Subject</div>
                            <div class="detail-value fs-5">
                                {{ getSubject }}
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="detail-label">Changed by</div>
                            <div class="detail-value">{{ getUserChanged }}</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="detail-label">Date &amp; time</div>
                            <div class="detail-value">
                                {{ formatDateTime(getDateTime) }}
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="detail-label">Module</div>
                            <div class="detail-value">
                                {{ strHeadline(getModule) }}
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="detail-label">Event</div>
                            <div class="detail-value">
                                {{ strHeadline(getEvent) }}
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="updatesLogs" v-if="getAction === 'updated'">
                        <h6 class="fs-5 fw-semibold mb-3">
                            What changed: {{ strHeadline(getFieldName) }}
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="change-card before">
                                    <div class="card-title">Before</div>
                                    <span>{{ getOldValue }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="change-card after">
                                    <div class="card-title">After</div>
                                    <span>{{ getNewValue }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="createRLogs"
                        v-else-if="getAction === 'created'"
                    >
                        <div class="created-banner mb-3">
                            <span class="sign plus">+</span>New record created
                            with the details below
                        </div>
                        <table class="table table-bordered table-hover">
                            <tbody>
                                <tr
                                    v-for="(value, key) in getCreatValue"
                                    :key="key"
                                >
                                    <td>
                                        <strong>{{ strHeadline(key) }}</strong>
                                    </td>
                                    <td>{{ value }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        class="btn btn-secondary px-4"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
