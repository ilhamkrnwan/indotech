/**
 * Indotech Custom Theme — Inquiry AJAX Handler
 */
(function ($) {
  'use strict';

  $(document).ready(function () {
    const $form = $('#indotech-inquiry-form');
    if (!$form.length) return;

    $form.on('submit', function (e) {
      e.preventDefault();

      const $submitBtn = $form.find('button[type="submit"]');
      const $responseContainer = $('#indotech-inquiry-response');

      // Simple client-side validation
      const name = $form.find('[name="full_name"]').val().trim();
      const email = $form.find('[name="email"]').val().trim();
      const phone = $form.find('[name="phone"]').val().trim();

      if (!name || !email || !phone) {
        showResponse('Semua kolom wajib diisi.', false);
        return;
      }

      // Check Honeypot field (should be empty)
      const honeypot = $form.find('[name="website_url"]').val();
      if (honeypot) {
        showResponse('Spam detected.', false);
        return;
      }

      // Prepare request data
      const formData = $form.serializeArray();
      formData.push({ name: 'action', value: 'indotech_submit_inquiry' });
      formData.push({ name: 'nonce', value: indotechData.nonce });

      // Visual feedback
      $submitBtn.prop('disabled', true).text('Mengirim...');
      $responseContainer.removeClass('success error').hide();

      $.ajax({
        url: indotechData.ajaxUrl,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (res) {
          if (res.success) {
            showResponse(res.data.message || 'Pertanyaan Anda berhasil dikirim!', true);
            $form[0].reset();
          } else {
            showResponse(res.data.message || 'Terjadi kesalahan. Silakan coba lagi.', false);
            $submitBtn.prop('disabled', false).text('Kirim Penawaran');
          }
        },
        error: function () {
          showResponse('Koneksi gagal. Silakan periksa koneksi internet Anda.', false);
          $submitBtn.prop('disabled', false).text('Kirim Penawaran');
        }
      });

      function showResponse(message, isSuccess) {
        $responseContainer
          .removeClass('success error')
          .addClass(isSuccess ? 'success' : 'error')
          .text(message)
          .fadeIn();
      }
    });
  });

})(jQuery);
