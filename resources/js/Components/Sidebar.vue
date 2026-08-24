<template>
    <aside class="sp-sidebar" id="sidebar">
        <div class="brand d-flex align-items-center gap-2">
            <div class="seal">SP</div>
            <div class="name">
                <strong>Sangguniang Panlalawigan</strong>
                Information System
            </div>
        </div>

        <nav class="sp-nav">
            <div class="nav-section-label">Overview</div>
            <a href="#" class="nav-link active" data-view="dashboard"
                ><i class="bi bi-grid-1x2"></i> Dashboard</a
            >

            <div class="nav-section-label">Legislative</div>
            <a href="#" class="nav-link" data-view="records"
                ><i class="bi bi-journal-text"></i> Legislative Records</a
            >

            <div class="nav-section-label">Manage</div>
            <a href="#" class="nav-link" data-view="reports"
                ><i class="bi bi-bar-chart-line"></i> Reports</a
            >
            <a href="#" class="nav-link" data-view="archive"
                ><i class="bi bi-archive"></i> Archive</a
            >
        </nav>

        <div class="sidebar-foot">
            Province of Capiz &middot; v0.1 (UI Preview)
        </div>
    </aside>
</template>
