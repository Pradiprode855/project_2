<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - EV Tech News</title>

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4630320743197588"
    crossorigin="anonymous"></script>
  <style>
    h2 {
      margin-bottom: 20px;
      color: #2c3e50;
      border-bottom: 2px solid #3498db;
      padding-bottom: 10px;
    }

    input,
    textarea,
    button {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 4px;
      border: 1px solid #414446;
      font-size: 16px;
      box-sizing: border-box;
    }

    input:focus,
    textarea:focus {
      border-color: #3498db;
      outline: none;
      box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
    }

    button {
      background: #3294d6;
      color: #36373b;
      border: none;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s;
    }

    button:hover {
      background: #2980b9;
    }

    .notification {
      display: none;
      margin: 15px 0;
      padding: 12px;
      border-radius: 4px;
      text-align: center;
      font-weight: bold;
    }

    .success {
      background: #e4ebf0;
      color: #2c6aa1;
      border: 1px solid #a8d3ff;
    }

    .error {
      background: #ffeaea;
      color: #c23b3b;
      border: 1px solid #ffc5c5;
    }

    /* Highlight Email Box */
    .highlight-email {
      font-size: 18px;
      font-weight: bold;
      color: #2c6aa1;
      background: #eaf4ff;
      padding: 12px;
      border-radius: 6px;
      text-align: center;
      margin: 20px auto;
      max-width: 700px;
    }

    .highlight-email a {
      color: #d63384;
      text-decoration: none;
      font-weight: bold;
    }

    /* Stylish Image Card */
    .image-card {
      position: relative;
      width: 400px;
      height: 250px;
      overflow: hidden;
      border-radius: 20px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .image-card {
      position: relative;
      width: 665px;
      height: 650px;
      overflow: hidden;
      border-radius: 20px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .image-card:hover .overlay {
      bottom: 0;
    }

    .overlay h2 {
      margin: 0;
      font-size: 20px;
    }

    .overlay p {
      font-size: 14px;
      margin-top: 5px;
    }

    .image-container {
      display: flex;
      height: auto;
      width: auto;
      justify-content: center;
      /* center horizontally */
      align-items: center;
      /* center vertically (if parent has height) */
      margin: 20px auto;
    }
  </style>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-7GW3TR4VM6"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-7GW3TR4VM6');
  </script>
</head>

<body>

 

  <div id="header-placeholder"></div>
 <!-- Highlighted Email Notice -->
  <div class="highlight-email">
    📧 For all inquiries, please email us directly at 
    <a href="mailto:info@evtech.news">info@evtech.news</a>
    <br>
    (All updates will be received only on this email.)
  </div>
  <div class="image-container">
    <div class="image-card">
      <img src="/contact-us1.jpg" alt="Contact Us">
      <div class="overlay">
        <h2>Contact Us</h2>
        <p>We’d love to hear from you!</p>
      </div>
    </div>
  </div>

  <div class="container">
    <h2>Contact Us</h2>
    <div id="notification" class="notification"></div>
    <form id="contactForm" method="post" action="<?= base_url('evcontacts/contact') ?>">
      <input type="text" name="name" placeholder="Your Name" required />
      <input type="email" name="email" placeholder="Your Email" required />
      <input type="text" name="subject" placeholder="Subject" required />
      <textarea name="message1" placeholder="Your Message" required></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>

  <!-- <div class="container">
    <h2>Admin Panel - Submissions</h2>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody id="submissionsList"></tbody>
    </table>
  </div> -->

  <script>
    // // Handle form submission
    // document.getElementById('contactForm').addEventListener('submit', function (e) {
    //   e.preventDefault();
    //   const formData = new FormData(this);

    //   fetch('savecontacts.php', {
    //     method: 'POST',
    //     body: formData
    //   })
    //     .then(res => res.json())
    //     .then(data => {
    //       const notification = document.getElementById('notification');
    //       if (data.status === "success") {
    //         notification.className = 'notification success';
    //         notification.textContent = data.message;
    //         document.getElementById('contactForm').reset();
    //         loadSubmissions(); // Refresh table after new submission
    //       } else {
    //         notification.className = 'notification error';
    //         notification.textContent = data.message;
    //       }
    //       notification.style.display = 'block';
    //       setTimeout(() => notification.style.display = 'none', 5000);
    //     })
    //     .catch(err => {
    //       console.error(err);
    //       const notification = document.getElementById('notification');
    //       notification.className = 'notification error';
    //       notification.textContent = "Something went wrong!";
    //       notification.style.display = 'block';
    //     });
    // });

    // // Load submissions into Admin Panel
    // function loadSubmissions() {
    //   fetch('getcontacts.php')
    //     .then(res => res.json())
    //     .then(submissions => {
    //       const submissionsList = document.getElementById('submissionsList');
    //       submissionsList.innerHTML = '';

    //       if (submissions.length === 0) {
    //         submissionsList.innerHTML = '<tr><td colspan="5" style="text-align: center;">No submissions yet</td></tr>';
    //         return;
    //       }

    //       submissions.forEach(sub => {
    //         const row = document.createElement('tr');
    //         row.innerHTML = `
    //           <td>${sub.name}</td>
    //           <td>${sub.email}</td>
    //           <td>${sub.subject}</td>
    //           <td>${sub.message}</td>
    //           <td>${new Date(sub.created_at).toLocaleString()}</td>
    //         `;
    //         submissionsList.appendChild(row);
    //       });
    //     })
    //     .catch(err => console.error("Error loading submissions:", err));
    // }

    // // Load submissions on page load
    // window.onload = loadSubmissions;
  </script>
  <footer>
    <div id="footer-placeholder"></div>
    <script src="include.js"></script>
  </footer>

</body>

</html>