
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

                        .fi-badge {
                            border-radius: 999px !important;
                            font-weight: 700 !important;
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

                        .dark .fi-ta-row:hover {
                            background: rgba(249, 115, 22, 0.10) !important;
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

                        /* ==========================================
                           PERBAIKAN LAYOUT & UKURAN NAVIGASI
                           ========================================== */
                        @media (min-width: 1024px) {
                            /* 1. Menentukan Lebar Ideal Kontainer Sidebar */
                            .fi-sidebar,
                            aside.fi-sidebar {
                                width: 16rem !important;
                                min-width: 16rem !important;
                            }

                            /* 2. Mengatur Konten Utama Menyesuaikan Lebar Sidebar */
                            html:not(.fi-sidebar-close) .fi-main {
                                padding-inline-start: 16rem !important;
                            }

                            /* 3. Penyesuaian Tombol Menu (Icon & Teks Berjejer Rapi) */
                            .fi-sidebar-item-button {
                                display: flex !important;
                                align-items: center !important;
                                justify-content: flex-start !important;
                                gap: 0.75rem !important; /* Jarak horizontal antara icon dan teks */
                                padding-top: 0.625rem !important; /* Ketebalan padding atas (Bisa diganti 0.75rem jika ingin lebih renggang) */
                                padding-bottom: 0.625rem !important; /* Ketebalan padding bawah */
                                padding-left: 0.75rem !important;
                                padding-right: 0.75rem !important;
                            }

                            /* 4. Memastikan Icon Navigasi Proporsional */
                            .fi-sidebar-item-button .fi-sidebar-item-icon,
                            .fi-sidebar-item-button svg {
                                width: 1.25rem !important;
                                height: 1.25rem !important;
                                flex-shrink: 0 !important;
                            }

                            /* 5. Mengembalikan Teks Menu Navigasi Agar Terlihat Jelas */
                            .fi-sidebar-item-button .fi-sidebar-item-label,
                            .fi-sidebar-item-label {
                                display: block !important;
                                font-size: 0.875rem !important; /* Ukuran teks menu navigasi */
                                white-space: nowrap !important;
                            }
                        }
                    </style>
                