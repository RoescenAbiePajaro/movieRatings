<footer>
  <div class="footer-container">
    <p>&copy; 2024 Movie Discussions. Join us for exciting chats!</p>
    <div class="social-links">
      <a href="https://facebook.com" target="_blank" class="social-icon">Facebook</a>
      <a href="https://twitter.com" target="_blank" class="social-icon">Twitter</a>
      <a href="https://instagram.com" target="_blank" class="social-icon">Instagram</a>
    </div>
  </div>
</footer>

<style>
  footer {
    background: none; /* Removes the gray background */
    color: #fff;
    padding: 20px;
    text-align: center;
    position: fixed;
    bottom: 0;
    width: 100%;
    font-family: Arial, sans-serif;
  }

  .footer-container {
    max-width: 1000px;
    margin: 0 auto;
  }

  p {
    font-size: 1rem;
    margin-bottom: 10px;
  }

  .social-links {
    margin-top: 10px;
  }

  .social-icon {
    color: #fff;
    text-decoration: none;
    margin: 0 15px;
    font-size: 1.1rem;
    transition: color 0.3s;
  }

  .social-icon:hover {
    color: #007bff;
  }

  /* Make footer content responsive */
  @media (max-width: 768px) {
    footer {
      padding: 15px;
    }

    .footer-container {
      padding: 0 20px;
    }

    .social-links {
      margin-top: 10px;
    }

    .social-icon {
      margin: 0 10px;
      font-size: 1rem;
    }
  }
</style>
