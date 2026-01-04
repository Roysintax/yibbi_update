<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YIBBI</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Menggunakan CSS dari folder assets utama -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --danger-gradient: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            --sidebar-bg: linear-gradient(180deg, #1e1e2f 0%, #27293d 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            display: flex;
            flex-wrap: nowrap;
            min-height: 100vh;
            overflow-x: hidden; /* Prevent horizontal scroll */
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .main-content {
            flex-grow: 1;
            padding: 2.5rem;
            width: 100%; /* Ensure full width */
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
        }
        
        /* Card Enhancements */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-hover-shadow);
        }
        
        .card-header {
            font-weight: 600;
            font-size: 1rem;
            border: none;
            padding: 1.25rem 1.5rem;
            border-radius: 20px 20px 0 0 !important;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-footer {
            padding: 1rem 1.5rem;
            border: none;
        }
        
        /* Gradient Headers */
        .bg-primary { background: var(--primary-gradient) !important; }
        .bg-success { background: var(--success-gradient) !important; }
        .bg-info { background: var(--info-gradient) !important; }
        .bg-warning { background: var(--warning-gradient) !important; }
        .bg-danger { background: var(--danger-gradient) !important; }
        .bg-dark { background: var(--dark-gradient) !important; }
        .bg-secondary { background: linear-gradient(135deg, #868f96 0%, #596164 100%) !important; }
        
        /* Button Enhancements */
        .btn {
            border-radius: 12px;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary { background: var(--primary-gradient); }
        .btn-success { background: var(--success-gradient); }
        .btn-info { background: var(--info-gradient); }
        .btn-warning { background: var(--warning-gradient); }
        .btn-danger { background: var(--danger-gradient); }
        .btn-dark { background: var(--dark-gradient); }
        
        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }
        
        .alert-info {
            background: linear-gradient(135deg, #e0f4ff 0%, #d5ebff 100%);
            color: #0066cc;
        }
        
        /* Page Header */
        .page-header-wrapper {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }
        
        .page-header-wrapper h1 {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin: 0;
        }
        
        /* Stats Numbers */
        .card-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .card-text {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        /* Icon Styling */
        .card-header i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        /* Scrollbar Styling */
        .main-content::-webkit-scrollbar {
            width: 10px;
        }
        
        .main-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .main-content::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }
        
        .main-content::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        /* Badge Styling */
        .badge {
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            font-weight: 500;
        }

        /* Mobile Responsiveness */
        @media (max-width: 991.98px) {
            body {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow-x: hidden;
                overflow-y: auto; /* Enable vertical scroll on mobile */
            }
            
            .main-content {
                width: 100%;
                height: auto;
                overflow-y: visible; /* Let content expand naturally */
                padding: 1.5rem;
                flex-grow: 1;
            }

            .sidebar-wrapper {
                width: 100% !important;
                min-height: auto !important;
                height: auto;
            }
        }
    </style>
</head>
<body>
