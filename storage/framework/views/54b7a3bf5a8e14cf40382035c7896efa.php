
                    <style>
                        /* ==========================================
                           LIGHT MODE (Default)
                           ========================================== */
                        .fi-sidebar, 
                        aside.fi-sidebar {
                            background-color: #ffffff !important;
                            border-right: 1px solid #e5e7eb !important;
                        }

                        /* ==========================================
                           DARK MODE FIXES
                           ========================================== */
                        /* Menimpa root HTML & elemen sidebar utama */
                        .dark .fi-sidebar,
                        html.dark .fi-sidebar,
                        aside.fi-sidebar.dark,
                        .dark aside.fi-sidebar {
                            background-color: #0b1220 !important;
                            border-right: 1px solid #1f2937 !important;
                            --gray-50: #0b1220; /* Menambal warna background grup navigasi internal */
                        }

                        /* Menimpa container navigasi internal di dalam sidebar */
                        .dark .fi-sidebar nav,
                        html.dark aside.fi-sidebar nav {
                            background-color: #0b1220 !important;
                        }

                        /* Warna teks tombol menu saat Dark Mode */
                        .dark .fi-sidebar-item-button {
                            color: #e5e7eb !important;
                        }

                        /* Warna hover tombol menu saat Dark Mode */
                        .dark .fi-sidebar-item-button:hover {
                            background-color: rgba(249, 115, 22, 0.12) !important;
                        }

                        .fi-wi-stats-overview-stat,
                        .fi-section {
                            border-radius: 16px !important;
                            border: 1px solid #eef2f7 !important;
                            background: #ffffff !important;
                            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.07) !important;
                        }

                        .fi-wi-stats-overview-stat {
                            overflow: hidden;
                            transition: transform 180ms ease, box-shadow 180ms ease;
                        }

                        .fi-wi-stats-overview-stat:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.11) !important;
                        }

                        .fi-wi-stats-overview-stat-label {
                            color: #6b7280 !important;
                            font-size: 0.78rem !important;
                            font-weight: 600 !important;
                        }

                        .fi-wi-stats-overview-stat-value {
                            color: #111827 !important;
                            font-weight: 800 !important;
                        }

                        .fi-ta-header-cell {
                            background: #f8fafc !important;
                            color: #334155 !important;
                        }

                        .fi-ta-table {
                            background: #ffffff !important;
                        }

                        .fi-ta-row {
                            border-bottom: 1px solid #eef2f7 !important;
                        }

                        .fi-ta-cell,
                        .fi-ta-text {
                            color: #111827 !important;
                        }

                        .fi-ta-row:hover {
                            background: #fff7ed !important;
                        }

/* ── Reset badge global (jangan beri warna di sini) ── */
.fi-badge {
    border-radius: 999px !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    padding: 2px 10px !important;
}

/* ── Badge per warna (gunakan nilai asli DB) ── */
.fi-badge[data-color="success"] {
    background: rgba(22, 163, 74, 0.12) !important;
    border-color: rgba(22, 163, 74, 0.30) !important;
    color: #15803D !important;
}
.fi-badge[data-color="danger"] {
    background: rgba(239, 68, 68, 0.12) !important;
    border-color: rgba(239, 68, 68, 0.30) !important;
    color: #B91C1C !important;
}
.fi-badge[data-color="warning"] {
    background: rgba(245, 158, 11, 0.12) !important;
    border-color: rgba(245, 158, 11, 0.30) !important;
    color: #B45309 !important;
}
.fi-badge[data-color="info"] {
    background: rgba(59, 130, 246, 0.12) !important;
    border-color: rgba(59, 130, 246, 0.30) !important;
    color: #1D4ED8 !important;
}
.fi-badge[data-color="gray"],
.fi-badge[data-color="secondary"] {
    background: rgba(107, 114, 128, 0.10) !important;
    border-color: rgba(107, 114, 128, 0.25) !important;
    color: #374151 !important;
}

/* ── Stat cards ── */
.fi-wi-stats-overview-stat {
    border-radius: 14px !important;
    border: 0.5px solid #eef2f7 !important;
    background: #ffffff !important;
    box-shadow: none !important;
    transition: box-shadow 150ms ease !important;
}
.fi-wi-stats-overview-stat:hover {
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08) !important;
}
.fi-wi-stats-overview-stat-label {
    font-size: 12px !important;
    font-weight: 600 !important;
    color: #6b7280 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.04em !important;
}
.fi-wi-stats-overview-stat-value {
    font-size: 22px !important;
    font-weight: 700 !important;
    color: #111827 !important;
}


                        .favorite-menus-title {
                            color: #111827;
                        }

                        .favorite-menus-subtitle,
                        .favorite-menu-count {
                            color: #6b7280;
                        }

                        .favorite-menu-item {
                            background: #ffffff;
                            border: 1px solid #f1f5f9;
                        }

                        .favorite-menu-image {
                            border: 1px solid #e5e7eb;
                        }

                        .favorite-menu-name {
                            color: #111827;
                        }

                        .favorite-menu-revenue {
                            color: #16a34a;
                        }

                        .favorite-menu-empty {
                            border: 1px dashed #e5e7eb;
                            color: #6b7280;
                        }

                        .dark .fi-wi-stats-overview-stat,
                        .dark .fi-section {
                            background: #111827 !important;
                            border-color: #1f2937 !important;
                            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.22) !important;
                        }

                        .dark .fi-wi-stats-overview-stat-label,
                        .dark .fi-wi-stats-overview-stat-description {
                            color: #94a3b8 !important;
                        }

                        .dark .fi-wi-stats-overview-stat-value {
                            color: #f8fafc !important;
                        }

                        .dark .fi-wi-stats-overview-stat svg {
                            color: #fdba74 !important;
                        }

                        .dark .fi-ta-table,
                        .dark .fi-ta-content,
                        .dark .fi-ta-ctn,
                        .dark .fi-ta-header,
                        .dark .fi-ta-table thead,
                        .dark .fi-ta-table thead tr {
                            background: #111827 !important;
                            color: #e5e7eb !important;
                        }

                        .dark .fi-ta-header-cell,
                        .dark .fi-ta-header-cell button,
                        .dark .fi-ta-header-cell span,
                        .dark .fi-ta-header-cell-label,
                        .dark .fi-ta-header-cell-label span {
                            background: #0f172a !important;
                            color: #cbd5e1 !important;
                            border-bottom-color: #243244 !important;
                        }

                        .dark .fi-ta-header-cell svg {
                            color: #94a3b8 !important;
                        }

                        .dark .fi-ta-row {
                            background: #111827 !important;
                            border-bottom-color: #243244 !important;
                        }

                        .fi-ta-row:hover {
                            background: rgba(230, 83, 60, 0.07) !important;
                        }

                        /* =========================================================
                           THEME ORANYE + MALAM: page/module wrapper
                           ========================================================= */
                        .fi-main {
                            background: #f9f9f9 !important;
                        }

                        .dark .fi-main {
                            background: #0b1220 !important;
                        }

                        /* Hero/header area (judul halaman) */
                        .fi-page-header {
                            background: linear-gradient(180deg, rgba(11,18,32,0.95), rgba(11,18,32,0.85)) !important;
                            border-bottom: 1px solid rgba(243, 232, 225, 0.10) !important;
                        }

                        .fi-page-title,
                        .fi-page-heading,
                        .fi-page-header h1,
                        .fi-page-header h2 {
                            color: #ffffff !important;
                            font-weight: 900 !important;
                        }

                        .fi-primary {
                            background: #E65100 !important;
                        }

                        .fi-button-primary,
                        .fi-button--primary,
                        .fi-ta-ctn .fi-button,
                        button.fi-button--primary {
                            background: #E65100 !important;
                            border-color: #E65100 !important;
                            color: #ffffff !important;
                        }

                        .fi-button-primary:hover,
                        .fi-button--primary:hover,
                        button.fi-button--primary:hover {
                            background: #D35400 !important;
                            border-color: #D35400 !important;
                        }

                        /* Cards/section */
                        .fi-section {
                            background: #ffffff !important;
                        }

                        .fi-wi-stats-overview-stat {
                            background: #F9F9F9 !important;
                            border-color: #eef2f7 !important;
                        }

                        .fi-wi-stats-overview-stat:hover {
                            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.10) !important;
                        }

                        /* Charts canvas padding/border */
                        .fi-card,
                        .fi-section {
                            border-radius: 18px !important;
                        }

                        /* Table */
                        .fi-ta-table {
                            border: 1px solid #eef2f7 !important;
                            border-radius: 16px !important;
                            overflow: hidden;
                        }

                      

                        /* Order cards: pending/transaksi */
                        .fi-table-panel {
                            background: #ffffff !important;
                            border-radius: 18px !important;
                            border: 1px solid #eef2f7 !important;
                        }

                        .dark .fi-ta-cell,
                        .dark .fi-ta-text,
                        .dark .fi-ta-text-item,
                        .dark .fi-ta-cell .fi-icon-btn {
                            color: #e5e7eb !important;
                        }


                        .dark .fi-ta-cell .fi-icon-btn:hover {
                            background: rgba(249, 115, 22, 0.14) !important;
                            color: #fdba74 !important;
                        }

                        .dark .favorite-menus-title,
                        .dark .favorite-menu-name {
                            color: #f8fafc;
                        }

                        .dark .favorite-menus-subtitle,
                        .dark .favorite-menu-count {
                            color: #94a3b8;
                        }

                        .dark .favorite-menu-item {
                            background: #0f172a;
                            border-color: #243244;
                        }

                        .dark .favorite-menu-image {
                            border-color: #334155;
                        }

                        .dark .favorite-menu-revenue {
                            color: #4ade80;
                        }

                        .dark .favorite-menu-empty {
                            border-color: #334155;
                            color: #94a3b8;
                        }
                    </style>
                <?php /**PATH C:\xampp1\htdocs\sistem-angkringan\storage\framework\views/4f06d06395fb0ac2ccf753ae5a0e1698.blade.php ENDPATH**/ ?>