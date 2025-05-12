<body>
  <?php
  include_once('../templates/header.php');
  ?>
  <h1>Formulario de Pago</h1>

  <form id="paymentForm" class="w-100 m-3 input-group d-flex justify-content-center flex-wrap gap-1" method="post">
    <div class="w-100 mb-3">
      <label class="fw-bolder fs-5 w-100">Importe:</label>
      <input class="w-25" type="number" step="0.01" name="amount" required value="100.50">


      <!-- <label class="fw-bolder fs-5 w-100">Estado:</label>
      <input class="w-25" type="text" name="status" value="incomplete" required> -->


      <label class="fw-bolder fs-5 w-100">Cuenta emisora:</label>
      <input class="w-25" type="text" name="debtor_account" value="ES0987654321098765432109" required>


      <label class="fw-bolder fs-5 w-100">Cuenta receptora:</label>
      <input class="w-25" type="text" name="creditor_account" value="ES1234567890123456789012" required>
    </div>



    <button class="fw-bolder fs-5 w-50" type=" submit">Enviar pago</button>
  </form>

  <section id="results"></section>

  <script>
    $("#paymentForm").on("submit", function(e) {
      e.preventDefault();

      $.ajax({
        url: "send_notification.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
          $("#results").html(response).hide().fadeIn();
        },
        error: function(xhr) {
          $("#results").html("<p style='color:red;'>Error al enviar el pago.</p>").fadeIn();
        }
      });
    });
  </script>

  <?php
  include_once('../templates/footer.php');
  ?>
</body>

</html>