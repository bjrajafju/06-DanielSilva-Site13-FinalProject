<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Backoffice - DaniShopper</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --dark-bg: #1a1c23;
            --sidebar-bg: #24262d;
            --card-bg: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            width: 100%;
        }

        /* Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
            transition: all 0.3s;
            z-index: 1000;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        #sidebar .sidebar-header h3 {
            color: #fff;
            font-weight: 700;
            margin: 0;
            font-size: 1.2rem;
            letter-spacing: 1px;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li a {
            padding: 12px 25px;
            display: block;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: 0.3s;
            font-weight: 500;
            font-size: 0.9rem;
        }

        #sidebar ul li a:hover,
        #sidebar ul li.active>a {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--primary-color);
        }

        #sidebar ul li a i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .sidebar-heading {
            padding: 10px 25px;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 15px;
        }

        /* Content */
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .topbar {
            background: #fff;
            padding: 15px 30px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
            margin-bottom: 30px;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 15px 20px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .table thead th {
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: var(--secondary-color);
            border-top: none;
        }

        .img-preview {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">