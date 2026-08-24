<template>
    <header class="sp-topbar">
        <button class="btn-icon d-lg-none" id="btnSidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="crumb">
            Legislative Information System /
            <strong id="crumbCurrent">Dashboard</strong>
        </div>

        <div class="ms-auto d-flex align-items-center gap-2">
            <div class="d-none d-md-block position-relative">
                <i
                    class="bi bi-search position-absolute"
                    style="
                        left: 0.65rem;
                        top: 0.55rem;
                        color: var(--ink-muted);
                        font-size: 0.85rem;
                    "
                ></i>
                <input
                    type="text"
                    class="form-control form-control-sm ps-4"
                    style="width: 230px"
                    placeholder="Search records, authors..."
                />
            </div>
            <button class="btn-icon position-relative">
                <i class="bi bi-bell"></i>
                <span
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                    style="background: var(--amber); font-size: 0.5rem"
                    >3</span
                >
            </button>
            <div class="dropdown">
                <button
                    class="btn d-flex align-items-center gap-2 border-0"
                    data-bs-toggle="dropdown"
                >
                    <div
                        style="
                            width: 32px;
                            height: 32px;
                            border-radius: 50%;
                            background: var(--navy);
                            color: #fff;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 0.75rem;
                            font-weight: 600;
                        "
                    >
                        EC
                    </div>
                    <div
                        class="text-start d-none d-md-block"
                        style="line-height: 1.1"
                    >
                        <div style="font-size: 0.8rem; font-weight: 600">
                            Echo Cruz
                        </div>
                        <div
                            style="font-size: 0.68rem; color: var(--ink-muted)"
                        >
                            SP Records Officer
                        </div>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#"
                            ><i class="bi bi-person me-2"></i>Profile</a
                        >
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"
                            ><i class="bi bi-gear me-2"></i>Settings</a
                        >
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item" href="#"
                            ><i class="bi bi-box-arrow-right me-2"></i>Sign
                            out</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </header>
</template>
