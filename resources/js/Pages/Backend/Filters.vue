<style>
body {
    background: #f1f1f1;
}

.print-toolbar {
    position: sticky;
    top: 0;
    z-index: 10;
    background: #fff;
    border-bottom: 1px solid #ddd;
    padding: 12px 20px;
}

.print-sheet {
    background: #fff;
    max-width: 1700px;
    margin: 24px auto;
    padding: 30px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.report-header {
    background: #0a1a4f;
    color: #fff;
    text-align: center;
    padding: 10px;
    font-weight: bold;
}

.report-header {
    background: #16227a;
    font-size: 0.95rem;
    padding: 6px;
}

table.report-table {
    font-size: 0.85rem;
    border-collapse: collapse;
    width: 100%;
}

table.report-table th {
    background: #1e9c6b;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #ccc;
    padding: 6px;
}

table.report-table th.status-header {
    background: #0a1a4f;
}

table.report-table td {
    border: 1px solid #ddd;
    padding: 6px 8px;
    vertical-align: top;
}

table.report-table td.text-center {
    text-align: center;
    white-space: nowrap;
}

.badge-type {
    background: #cfe2ff;
    color: #084298;
    font-weight: 600;
}

.link-col a {
    text-decoration: underline;
}
@media print {
    .no-print {
        display: none !important;
    }

    body {
        background: #fff;
    }

    .print-sheet {
        box-shadow: none;
        margin: 0;
        padding: 0;
        max-width: 100%;
    }

    table.report-table {
        font-size: 10px;
    }

    table.report-table th {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    @page {
        size: landscape;
        margin: 10mm;
    }
}
</style>
<template>
    <div
        class="print-toolbar no-print d-flex justify-content-between align-items-center"
    >
        <div>
            <h6 class="mb-0 fw-semibold">
                <i class="fa-solid fa-print me-2"></i>Print Preview
            </h6>
            <small class="text-muted"
                >Review before printing or exporting to PDF</small
            >
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" onclick="window.close()">
                <i class="fa-solid fa-xmark me-1"></i>Close
            </button>
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fa-solid fa-print me-1"></i>Print
            </button>
        </div>
    </div>
    <div class="print-sheet">
        <div class="report-header">
            <div>12TH SANGGUNIANG PANLALAWIGAN INFORMATION SYSTEM</div>
        </div>
        <div class="table-responsive">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>SP TERM</th>
                        <th>TYPE</th>
                        <th>NO.</th>
                        <th>LINK</th>
                        <th>SESSION<br />DATE</th>
                        <th style="min-width: 320px">TITLE</th>
                        <th class="status-header">STATUS</th>
                        <th>AUTHOR/S</th>
                        <th>CO-AUTHOR/S</th>
                        <th>SECTOR</th>
                        <th>CLASS</th>
                    </tr>
                </thead>
                <tbody id="reportBody">
                    <!-- Row example (repeat per record) -->
                    <tr>
                        <td class="text-center">SP-11</td>
                        <td class="text-center">
                            <span class="badge-type badge">A-ORD</span>
                        </td>
                        <td class="text-center fw-semibold">089</td>
                        <td class="text-center link-col">
                            <a href="#">1-2024</a>
                        </td>
                        <td class="text-center">15-Jan-24</td>
                        <td>
                            APPROVING THE SUPPLEMENTAL APPROPRIATION of funds in
                            the PROVINCIAL BUDGET OFFICE and the PROVINCIAL
                            GOVERNOR'S OFFICE in the total amount of TWO HUNDRED
                            TWENTY-SEVEN MILLION NINE HUNDRED SEVENTY-EIGHT
                            THOUSAND (P227,978,234.00) TWO HUNDRED THIRTY-FOUR
                            PESOS
                        </td>
                        <td class="text-center"></td>
                        <td>BESA, JB</td>
                        <td></td>
                        <td>INSTITUTIONAL, INFRASTRUCTURE</td>
                        <td>Budgeting, Dept-Cap, Civil Service</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-3 small text-muted no-print">
            Showing filtered results based on your applied filters. This page is
            formatted for printing/export.
        </div>
    </div>
</template>
