<template>
    <div class="sp-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="font-display mb-0" style="font-size: 1.5rem">
                    Sectors
                </h1>
                <div class="text-muted" style="font-size: 0.82rem">
                    Manage sector classifications used to categorize legislative
                    records.
                </div>
            </div>
            <button
                class="btn btn-amber btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#addSectorModal"
            >
                <i class="fa-solid fa-plus me-1"></i>Add Sector
            </button>
        </div>

        <div class="sp-card p-0">
            <div class="table-responsive">
                <table
                    class="table table-hover mb-0"
                    style="font-size: 0.85rem"
                >
                    <thead>
                        <tr>
                            <th style="width: 40px">#</th>
                            <th>Name</th>
                            <th class="text-center">In Use</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-muted">1</td>
                            <td style="font-weight: 500">Institutional</td>
                            <td class="text-center">
                                <span class="chip">14 records</span>
                            </td>
                            <td class="text-end">
                                <button
                                    class="btn btn-sm btn-light border"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addSectorModal"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-light border">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">2</td>
                            <td style="font-weight: 500">Economic</td>
                            <td class="text-center">
                                <span class="chip">9 records</span>
                            </td>
                            <td class="text-end">
                                <button
                                    class="btn btn-sm btn-light border"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addSectorModal"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-light border">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">3</td>
                            <td style="font-weight: 500">Social</td>
                            <td class="text-center">
                                <span class="chip">21 records</span>
                            </td>
                            <td class="text-end">
                                <button
                                    class="btn btn-sm btn-light border"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addSectorModal"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-light border">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">4</td>
                            <td style="font-weight: 500">Environmental</td>
                            <td class="text-center">
                                <span class="chip">6 records</span>
                            </td>
                            <td class="text-end">
                                <button
                                    class="btn btn-sm btn-light border"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addSectorModal"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-light border">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">5</td>
                            <td style="font-weight: 500">Infrastructure</td>
                            <td class="text-center">
                                <span class="chip">17 records</span>
                            </td>
                            <td class="text-end">
                                <button
                                    class="btn btn-sm btn-light border"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addSectorModal"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-light border">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">6</td>
                            <td style="font-weight: 500">Governance</td>
                            <td class="text-center">
                                <span class="chip">3 records</span>
                            </td>
                            <td class="text-end">
                                <button
                                    class="btn btn-sm btn-light border"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addSectorModal"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-light border">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add / Edit Sector Modal -->
    <div class="modal fade" id="addSectorModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
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
                        style="font-size: 1.05rem"
                    >
                        Add Sector
                    </h5>
                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <form>
                    <div class="modal-body">
                        <label
                            class="form-label"
                            style="font-size: 0.78rem; font-weight: 500"
                            >Sector Name</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            placeholder="e.g. Institutional"
                            required
                        />
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-sm btn-amber">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
