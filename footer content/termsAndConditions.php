<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terms and Conditions</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background-color: #f2eeea;
      color: black;
    }

    header {
      background: #2c2621;
      color: #a29489;
      padding: 20px 0;
      text-align: center;
    }

    main {
      padding: 20px;
    }

    section {
      background: #f2eeea;
      margin: 20px auto;
      padding: 20px;
      border-radius: 5px;
      max-width: 800px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    h2 {
      color: black;
    }

    h1 {
      color: White;
    }

    h2 {
      margin-top: 20px;
    }

    footer {
      text-align: center;
      padding: 10px 0;
      background: #2c2621;
      color: #a29489;
      position: relative;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>



<body>
  <header>
    <h1>Terms and Conditions</h1>
  </header>

  <main>
    <section>
      <p>Welcome to Viva la Vida. By accessing or using our Website, you agree to comply with and be bound by the following terms and conditions. If you do not agree with any part of these terms, please do not use our Website.</p>

      <h2>1. Acceptance of Terms:</h2>
      <p>By accessing this Website, you confirm that you are at least 8 years old and that you have the legal capacity to enter into these Terms. If you are accessing the Website on behalf of a company, you represent that you have the authority to bind that company to these Terms.</p>

      <h2>2. Changes to Terms:</h2>
      <p>We reserve the right to modify these Terms at any time. Any changes will be effective immediately upon posting on the Website. Your continued use of the Website after changes constitutes your acceptance of the new Terms.</p>

      <h2>3. Use of the Website:</h2>
      <p>You agree to use the Website for lawful purposes only. You may not use the Website in a way that violates any applicable laws or regulations, or that infringes the rights of others.</p>

      <h2>4. Intellectual Property:</h2>
      <p>All content on the Website, including text, graphics, logos, images, and software, is the property of Viva la Vida or its licensors and is protected by copyright, trademark, and other intellectual property laws. You may not reproduce, distribute, or create derivative works without our prior written permission.</p>

      <h2>5. User Accounts:</h2>
      <p>If you create an account on our Website, you are responsible for maintaining the confidentiality of your account information and for all activities that occur under your account. You agree to notify us immediately of any unauthorized use of your account.</p>

      <h2>6. Disclaimers:</h2>
      <p>The content on our Website is provided for general informational purposes only. We make no representations or warranties regarding the accuracy, reliability, or completeness of the information. Your use of the Website is at your own risk.</p>

      <h2>7. Limitation of Liability:</h2>
      <p>To the fullest extent permitted by law, Viva la Vida shall not be liable for any indirect, incidental, special, or consequential damages arising out of or in connection with your use of the Website.</p>

      <h2>8. Indemnification:</h2>
      <p>You agree to indemnify and hold harmless Viva la Vida, its affiliates, and their respective officers, directors, employees, and agents from any claims, losses, liabilities, damages, costs, or expenses arising out of your use of the Website or violation of these Terms.</p>

      <h2>9. Governing Law:</h2>
      <p>These Terms shall be governed by and construed in accordance with the laws of The Supreme Court, without regard to its conflict of law principles.</p>

      <h2>10. Contact Information:</h2>
      <p>For any questions regarding these Terms, please contact us at <a href="mailto:Viva.la.Vida@gmail.com">Viva.la.Vida@gmail.com</a>.</p>
    </section>
  </main>

  <footer>
    <p>&copy; 2024 Viva la Vida. All rights reserved.</p>
  </footer>
  <script>
    window.addEventListener('scroll', function() {
      const scrollPosition = window.scrollY;
      const maxScroll = document.body.scrollHeight - window.innerHeight;

      // Calculate the percentage of scrolling
      const scrollPercent = Math.min(scrollPosition / maxScroll, 1); // Ensure it does not exceed 1

      // Define colors
      const color1 = '#f2eeea';
      const color2 = '#a29489';

      // Interpolate between color1 and color2
      const backgroundColor = interpolateColor(color1, color2, scrollPercent);

      // Set the background color
      document.body.style.backgroundColor = backgroundColor;
    });

    // Function to interpolate between two hex colors
    function interpolateColor(color1, color2, ratio) {
      const r1 = parseInt(color1.slice(1, 3), 16);
      const g1 = parseInt(color1.slice(3, 5), 16);
      const b1 = parseInt(color1.slice(5, 7), 16);

      const r2 = parseInt(color2.slice(1, 3), 16);
      const g2 = parseInt(color2.slice(3, 5), 16);
      const b2 = parseInt(color2.slice(5, 7), 16);

      const r = Math.round(r1 + (r2 - r1) * ratio);
      const g = Math.round(g1 + (g2 - g1) * ratio);
      const b = Math.round(b1 + (b2 - b1) * ratio);

      return `rgb(${r}, ${g}, ${b})`;
    }
  </script>
</body>

</html>