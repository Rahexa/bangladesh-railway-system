<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Group No Name 1</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #1a202c;
            color: #e2e8f0;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            overflow-x: hidden;
        }
        header {
            background: linear-gradient(135deg, #2d3748, #4a5568);
            color: #00ffcc;
            text-align: center;
            padding: 2.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
        }
        header h1 {
            margin: 0;
            font-size: 2.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: fadeIn 1s ease-in-out;
        }
        .container {
            max-width: 1100px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }
        .section {
            margin-bottom: 2.5rem;
        }
        .section h2 {
            color: #00ffcc;
            font-size: 2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid rgba(0, 255, 204, 0.3);
            padding-bottom: 0.5rem;
            text-transform: uppercase;
        }
        .overview, .contact-info {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 255, 204, 0.1);
        }
        .overview p, .contact-info p {
            margin: 0.6rem 0;
            color: #a0aec0;
        }
        .contact-info a {
            color: #00ffcc;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .contact-info a:hover {
            color: #ff6b6b;
        }
        .members {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* First row: 3 members */
            grid-template-rows: auto auto; /* Two rows */
            gap: 1.5rem;
            padding: 1rem;
        }
        .member-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(5px);
            padding: 1.2rem;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 255, 204, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }
        .member-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 255, 204, 0.2);
        }
        .member-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid #00ffcc;
            transition: transform 0.3s ease;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .member-card:hover img {
            transform: scale(1.05);
        }
        .member-card h3 {
            margin: 0 0 0.5rem;
            color: #00ffcc;
            font-size: 1.3rem;
            text-transform: uppercase;
        }
        .member-card p {
            margin: 0.4rem 0;
            color: #a0aec0;
            font-size: 0.95rem;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @media (max-width: 768px) {
            header h1 {
                font-size: 2.2rem;
            }
            .section h2 {
                font-size: 1.6rem;
            }
            .members {
                grid-template-columns: 1fr 1fr; /* Two columns on mobile */
                grid-template-rows: auto auto; /* Maintain two rows */
            }
            .member-card img {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>About Us - </h1>
    </header>
    <div class="container">
        <div class="section overview">
            <h2>Our Mission</h2>
            <p>We are Group A, a dynamic team of five passionate developers working on the Bangladesh Railway System project. Our mission is to revolutionize railway travel in Bangladesh by creating a seamless, technology-driven platform that simplifies ticket booking, enhances route tracking, and improves passenger management. We aim to provide a user-friendly experience with real-time updates, secure transactions, and reliable services, ensuring that every journey is smooth and enjoyable. This project was initiated as part of our academic endeavor to address real-world transportation challenges, with a focus on scalability, accessibility, and innovation.</p>
        </div>

        <div class="section">
            <h2>Our Team</h2>
            <div class="members">
                <div class="member-card">
                    <img src="https://via.placeholder.com/120" alt="Raihan Sikder">
                    <h3>Raihan Sikder</h3>
                    <p>ID: 222210005101128</p>
                    <p>Role: Team Lead</p>
                </div>
                <div class="member-card">
                    <img src="https://via.placeholder.com/120" alt="Hamed Hasan">
                    <h3>Hamed Hasan</h3>
                    <p>ID: 222210005101099</p>
                    <p>Role: Frontend Developer</p>
                </div>
                <div class="member-card">
                    <img src="https://via.placeholder.com/120" alt="Soumen Biswas">
                    <h3>Soumen Biswas</h3>
                    <p>ID: 222210005101110</p>
                    <p>Role: Database Manager</p>
                </div>
                <div class="member-card">
                    <img src="https://via.placeholder.com/120" alt="Sbuj Gupta">
                    <h3>Sbuj Gupta</h3>
                    <p>ID: 22221000510100</p>
                    <p>Role: Tester</p>
                </div>
            </div>
        </div>

        <div class="section contact-info">
            <h2>Contact Us</h2>
            <p>Email: <a href="mailto:groupnoname1@example.com">groupnoname1@example.com</a></p>
            <p>Project Repository: <a href="https://github.com/groupnoname1/railway-system" target="_blank">GitHub</a></p>
            <p>Social Media: Follow us on <a href="https://twitter.com/groupnoname1" target="_blank">Twitter</a> and <a href="https://linkedin.com/company/groupnoname1" target="_blank">LinkedIn</a> for updates.</p>
            <p>Project Timeline: Initiated in March 2025, with the first phase completed by May 2025. Future updates include mobile app integration and AI-based route optimization.</p>
            <p>Support: For inquiries, reach out via email. We aim to respond within 24-48 hours. For urgent issues, mention "URGENT" in the subject line.</p>
        </div>
    </div>
</body>
</html>