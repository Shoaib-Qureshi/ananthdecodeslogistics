<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Admin Dashboard</title>
    <style>
        .main_section {
            padding-top: 32px;
        }

        .dashboard-shell {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 28px;
            padding: 28px;
            box-shadow: 0 22px 48px rgba(15, 23, 42, 0.06);
        }

        .dashboard-heading {
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.12);
        }

        .dashboard-heading h1 {
            font-size: clamp(1.9rem, 2.6vw, 2.5rem);
            letter-spacing: -0.05em;
            color: #0f172a;
        }

        .dashboard-heading p {
            max-width: 620px;
            color: #64748b;
            font-size: 0.94rem;
        }

        .dashboard-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.18);
            color: #0f172a;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 18px;
        }

        .dash-card {
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.04);
        }

        .metric-card {
            grid-column: span 4;
            min-height: 178px;
        }

        .metric-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            color: #0f172a;
            font-size: 1.15rem;
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .metric-label {
            margin-top: 18px;
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .metric-value-row {
            margin-top: 8px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 10px;
        }

        .metric-value {
            font-size: clamp(2.1rem, 3vw, 3rem);
            line-height: 1;
            letter-spacing: -0.06em;
            color: #0f172a;
            font-weight: 700;
        }

        .metric-meta {
            margin-top: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: #64748b;
            font-size: 0.9rem;
        }

        .metric-trend {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .metric-trend.positive {
            background: #f8fafc;
            color: #0f172a;
        }

        .metric-trend.neutral {
            background: #f8fafc;
            color: #0f172a;
        }

        .metric-trend.warning {
            background: #f8fafc;
            color: #0f172a;
        }

        .panel-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .panel-top h3 {
            font-size: 1.35rem;
            letter-spacing: -0.04em;
            color: #0f172a;
        }

        .panel-top p {
            margin-top: 6px;
            color: #64748b;
            font-size: 0.9rem;
        }

        .workflow-card {
            grid-column: span 8;
        }

        .workflow-list {
            display: grid;
            gap: 14px;
        }

        .workflow-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 18px;
            border-radius: 20px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .workflow-index {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            color: #0f172a;
            font-weight: 700;
            flex-shrink: 0;
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .workflow-item strong {
            display: block;
            margin-bottom: 6px;
            color: #0f172a;
            font-size: 1rem;
        }

        .workflow-item p {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .workflow-item a {
            color: #0f172a;
            font-size: 0.88rem;
            font-weight: 700;
        }

        .quick-actions {
            grid-column: span 4;
        }

        .action-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .action-card {
            display: grid;
            grid-template-columns: 44px minmax(0, 1fr);
            align-items: start;
            gap: 14px;
            padding: 16px;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.14);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease, background-color 0.18s ease;
            cursor: pointer;
        }

        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            border-color: rgba(15, 23, 42, 0.12);
            background: #fff;
        }

        .action-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            color: #0f172a;
            font-size: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.16);
            flex-shrink: 0;
        }

        .action-copy {
            min-width: 0;
        }

        .action-card strong {
            display: block;
            margin-bottom: 4px;
            color: #0f172a;
            font-size: 0.95rem;
        }

        .action-card span {
            display: block;
            color: #64748b;
            font-size: 0.84rem;
            line-height: 1.55;
        }

        @media (max-width: 1399px) {
            .metric-card {
                grid-column: span 6;
            }

            .workflow-card,
            .quick-actions {
                grid-column: span 12;
            }
        }

        @media (max-width: 1199px) {
            .workflow-card,
            .quick-actions,
            .metric-card {
                grid-column: span 12;
            }
        }

        @media (max-width: 991px) {
            .main_section {
                padding-top: 14px;
            }

            .dashboard-shell {
                padding: 16px;
                border-radius: 22px;
            }

            .metric-card,
            .workflow-card,
            .quick-actions {
                grid-column: span 12;
            }
        }

        @media (max-width: 767px) {
            .dash-card {
                padding: 18px;
                border-radius: 22px;
            }

            .action-grid {
                grid-template-columns: 1fr;
            }

            .panel-top {
                flex-direction: column;
                align-items: flex-start;
            }

            .action-card {
                grid-template-columns: 40px minmax(0, 1fr);
                gap: 12px;
            }

            .action-icon {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>

<body>
    @include('admin.adminHeader')

    <section class="main_section">
        <div class="container-fluid">
            <div class="dashboard-shell">
                <div class="dashboard-heading">
                    <div>
                        <span class="dashboard-chip"><i class="fas fa-th-large"></i> Overview</span>
                        <h1 class="mt-3">Admin Dashboard</h1>
                        <p class="mt-2">A minimal control room for publishing, contributor review, and core site updates.</p>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <section class="dash-card metric-card">
                        <span class="metric-icon"><i class="fas fa-users"></i></span>
                        <div class="metric-label">Authors</div>
                        <div class="metric-value-row">
                            <div class="metric-value">{{ $userCount }}</div>
                        </div>
                        <div class="metric-meta">
                            <span>Current author records</span>
                            <span class="metric-trend positive"><i class="fas fa-arrow-up"></i> Managed</span>
                        </div>
                    </section>

                    <section class="dash-card metric-card">
                        <span class="metric-icon"><i class="fas fa-newspaper"></i></span>
                        <div class="metric-label">Live Blogs</div>
                        <div class="metric-value-row">
                            <div class="metric-value">{{ $blogCount }}</div>
                        </div>
                        <div class="metric-meta">
                            <span>Published articles</span>
                            <span class="metric-trend neutral"><i class="fas fa-check"></i> Live</span>
                        </div>
                    </section>

                    <section class="dash-card metric-card">
                        <span class="metric-icon"><i class="fas fa-layer-group"></i></span>
                        <div class="metric-label">Quick Actions</div>
                        <div class="metric-value-row">
                            <div class="metric-value">08</div>
                        </div>
                        <div class="metric-meta">
                            <span>Frequently used admin shortcuts</span>
                            <span class="metric-trend warning"><i class="fas fa-bolt"></i> Ready</span>
                        </div>
                    </section>

                    <section class="dash-card workflow-card">
                        <div class="panel-top">
                            <div>
                                <h3>Review Flow</h3>
                                <p>Keep the moderation and publishing loop clean and predictable.</p>
                            </div>
                        </div>

                        <div class="workflow-list">
                            <div class="workflow-item">
                                <span class="workflow-index">01</span>
                                <div>
                                    <strong>Check contributor queue</strong>
                                    <p>Review submitted contributor posts and move high-quality articles forward.</p>
                                    <a href="/admin/contributor-posts">Open contributor posts</a>
                                </div>
                            </div>
                            <div class="workflow-item">
                                <span class="workflow-index">02</span>
                                <div>
                                    <strong>Update live editorial content</strong>
                                    <p>Refine published blogs, remove weak articles, and keep category pages fresh.</p>
                                    <a href="/admin/live-blogs/">Manage live blogs</a>
                                </div>
                            </div>
                            <div class="workflow-item">
                                <span class="workflow-index">03</span>
                                <div>
                                    <strong>Maintain site sections</strong>
                                    <p>Refresh homepage, about page, members, milestones, and support content from one area.</p>
                                    <a href="/admin/edit-home-page/">Edit pages</a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="dash-card quick-actions">
                        <div class="panel-top">
                            <div>
                                <h3>Quick Actions</h3>
                                <p>Minimal shortcuts for the tasks the team will open most often.</p>
                            </div>
                        </div>

                        <div class="action-grid">
                            <a class="action-card" href="/admin/create-blog/">
                                <span class="action-icon"><i class="fas fa-pen"></i></span>
                                <span class="action-copy">
                                    <strong>Create Blog</strong>
                                    <span>Write and publish a new editorial article.</span>
                                </span>
                            </a>
                            <a class="action-card" href="/admin/users-list/">
                                <span class="action-icon"><i class="fas fa-users"></i></span>
                                <span class="action-copy">
                                    <strong>Authors List</strong>
                                    <span>Review author accounts and manage user records.</span>
                                </span>
                            </a>
                            <a class="action-card" href="/admin/registrations">
                                <span class="action-icon"><i class="fas fa-user-plus"></i></span>
                                <span class="action-copy">
                                    <strong>Registrations</strong>
                                    <span>Approve or reject contributor access requests.</span>
                                </span>
                            </a>
                            <a class="action-card" href="/admin/messages/">
                                <span class="action-icon"><i class="fas fa-envelope-open"></i></span>
                                <span class="action-copy">
                                    <strong>Inbox</strong>
                                    <span>Review contact form messages and incoming admin queries.</span>
                                </span>
                            </a>
                            <a class="action-card" href="/admin/book-reviews/">
                                <span class="action-icon"><i class="fas fa-book"></i></span>
                                <span class="action-copy">
                                    <strong>Book Reviews</strong>
                                    <span>Manage review entries and publishing details.</span>
                                </span>
                            </a>
                            <a class="action-card" href="/admin/live-insights/">
                                <span class="action-icon"><i class="fas fa-chart-bar"></i></span>
                                <span class="action-copy">
                                    <strong>Insights</strong>
                                    <span>Update live board insights and editorial intelligence pieces.</span>
                                </span>
                            </a>
                            <a class="action-card" href="/admin/manage-milestones/">
                                <span class="action-icon"><i class="fas fa-flag"></i></span>
                                <span class="action-copy">
                                    <strong>Milestones</strong>
                                    <span>Keep company highlights and timeline entries current.</span>
                                </span>
                            </a>
                            <a class="action-card" href="/admin/edit-about-page/">
                                <span class="action-icon"><i class="fas fa-info-circle"></i></span>
                                <span class="action-copy">
                                    <strong>About Page</strong>
                                    <span>Refine the main brand story and company profile content.</span>
                                </span>
                            </a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

    @include('admin.adminFooter')
</body>

</html>
