<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h2 {
            margin-top: 0;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .link-image {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }
        .sidenav {
            height: 100%;
            width: 200px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #FAF0DC;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidenav a {
            padding: 16px 8px 16px 16px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
            background-color: #964B00;
        }

        .main {
            margin-left: 200px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="sidenav">
        <a href="home.php">🏠 Home</a>
        <a href="records/index.php">📖 Book Records</a>
        <a href="issuelist/index.php" class="image-link"><img src="../img/group.png" class="link-image"> Members</a>
        <a href="../penalty/index.php">💵 Penalty List</a>
        <a href="../login/index.php">🖥️ Admin Panel</a>
        <a href="../login/logout.php">🏃 Log Out</a>
        <a href="contact.php">📬 Contact Us</a>
    </div>
    <div class="main">
    <h2>Contact Us</h2>
    <a href="#">Stockwell Street Library</a>

    <h3>Contact Stockwell Street Library</h3>
    <p>For general library enquiries email the Library team.</p>
    <p>Telephone number: 020 8331 7788 (only operates between 11am and 7pm Monday to Sunday)</p>

    <h4>Address:</h4>
    <p>Stockwell Street Library<br>
    10 Stockwell Street<br>
    Greenwich<br>
    London SE10 9BD</p>

    <h4>Head of Library Services:</h4>
    <p>David Pugliett</p>

    <h4>Subject areas covered:</h4>
    <p>Computing & Mathematical Sciences, Law, Maritime Studies, Post Compulsory Education & Training, Humanities, Business, Sociology</p>

    <h4>Opening hours:</h4>
    <p>Our libraries are open for browsing, study, borrowing and returns. <a href="#">View our opening hours</a></p>
    <p>Please be safe when you visit us.</p>

    <h4>Public transport:</h4>
    <p>Nearest train station: Greenwich. Nearest DLR station: Cutty Sark. Numerous Bus services. No parking on campus, other parking very limited in area.</p>

    <h4>Special needs access:</h4>
    <p>Other facilities include:</p>
    <ul>
        <li>2 lifts giving access to all floors of the Library;</li>
        <li>Toilets for disabled students on each floor;</li>
        <li>A refuge area on each floor, particularly for those with mobility problems or who are partially sighted.</li>
    </ul>

    <img src="../img/Stockwell_Street_Library.png" alt="Stockwell Street Library">
    </div>
</body>
</html>