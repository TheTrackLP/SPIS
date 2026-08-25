<template>
    <div>
        <div class="brand d-flex align-items-center gap-2">
            <div class="seal">SP</div>
            <div class="name">
                <strong>Sangguniang Panlalawigan</strong>
                Information System
            </div>
        </div>

        <nav class="sp-nav">
            <div class="nav-section-label">Overview</div>
            <a
                :href="route('admin.dash')"
                class="nav-link"
                data-view="dashboard"
            >
                <i class="fa-solid fa-gauge"></i> Dashboard</a
            >

            <div class="nav-section-label">Legislative</div>
            <a :href="route('rec.dash')" class="nav-link" data-view="records"
                ><i class="fa-solid fa-book"></i> Legislative Records</a
            >

            <div class="nav-section-label">Manage</div>
            <a href="#" class="nav-link" data-view="reports"
                ><i class="fa-solid fa-chart-simple"></i> Reports</a
            >
            <a href="#" class="nav-link" data-view="archive"
                ><i class="fa-solid fa-box-archive"></i> Archive</a
            >
        </nav>

        <div class="sidebar-foot">
            Province of Capiz &middot; v0.1 (UI Preview)
        </div>
    </div>
</template>
