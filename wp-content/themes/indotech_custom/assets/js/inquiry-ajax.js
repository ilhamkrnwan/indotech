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

      // Find form inputs dynamically
      const name = ($form.find('[name="full_name"]').val() || $form.find('[name="contact_name"]').val() || '').trim();
      const email = ($form.find('[name="email"]').val() || $form.find('[name="contact_email"]').val() || '').trim();
      const phone = ($form.find('[name="phone"]').val() || $form.find('[name="contact_phone"]').val() || '').trim();
      const message = ($form.find('[name="message"]').val() || $form.find('[name="contact_message"]').val() || '').trim();
      
      const hasEmailField = $form.find('[name="email"]').length > 0 || $form.find('[name="contact_email"]').length > 0;
      const hasPhoneField = $form.find('[name="phone"]').length > 0 || $form.find('[name="contact_phone"]').length > 0;

      // Validate name (always required)
      if (!name) {
        showResponse('Nama lengkap wajib diisi.', false);
        return;
      }

      // Validate email (only if field exists in form)
      if (hasEmailField && !email) {
        showResponse('Alamat email wajib diisi.', false);
        return;
      }

      // Validate phone (only if field exists and is required in form)
      const $phoneField = $form.find('[name="phone"], [name="contact_phone"]');
      if (hasPhoneField && $phoneField.prop('required') && !phone) {
        showResponse('Nomor WhatsApp / Telepon wajib diisi.', false);
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
            
            // Check form type and build WhatsApp redirect
            const $productTitleField = $form.find('[name="product_title"]');
            const $brandTitleField = $form.find('[name="brand_title"]');
            const $subjectField = $form.find('[name="subject"]');
            const $partnerTypeField = $form.find('[name="partner_type"]');
            const waNum = indotechData.whatsapp || '6285600061005';
            
            let redirectText = '';

            if ($productTitleField.length) {
              // Product detail form WhatsApp redirect
              const productTitle = $productTitleField.val();
              const nameText = name || '-';
              const emailText = email || '-';
              
              redirectText = `Halo indotech.id, saya *${nameText}*\n\n`;
              redirectText += `• *Nama*: ${nameText}\n`;
              redirectText += `• *Email*: ${emailText}\n`;
              redirectText += `• *Ingin bertanya tentang*: ${productTitle}\n\n`;
              if (message) {
                redirectText += `*Pesan:*\n"${message}"\n\n`;
              }
              redirectText += `Terima kasih.`;
              
            } else if ($brandTitleField.length) {
              // Brand detail form WhatsApp redirect
              const brandTitle = $brandTitleField.val();
              const nameText = name || '-';
              const emailText = email || '-';
              
              redirectText = `Halo indotech.id, saya *${nameText}*\n\n`;
              redirectText += `• *Nama*: ${nameText}\n`;
              redirectText += `• *Email*: ${emailText}\n`;
              redirectText += `• *Ingin bertanya tentang brand*: ${brandTitle}\n\n`;
              if (message) {
                redirectText += `*Pesan:*\n"${message}"\n\n`;
              }
              redirectText += `Terima kasih.`;

            } else if ($subjectField.length) {
              // Contact page form WhatsApp redirect
              const subjectText = $form.find('[name="subject"] option:selected').text() || 'Pertanyaan Umum';
              const nameText = name || '-';
              const phoneText = phone || '-';
              
              redirectText = `Halo indotech.id, saya *${nameText}*\n\n`;
              redirectText += `Saya ingin bertanya mengenai:\n*${subjectText}*\n\n`;
              redirectText += `Berikut data saya:\n`;
              redirectText += `• *Nama*: ${nameText}\n`;
              redirectText += `• *Nomor WhatsApp*: ${phoneText}\n\n`;
              if (message) {
                redirectText += `*Pesan:*\n"${message}"\n\n`;
              }
              redirectText += `Terima kasih.`;

            } else if ($partnerTypeField.length) {
              // Kemitraan page form WhatsApp redirect
              const partnerType = $form.find('[name="partner_type"] option:selected').text() || '-';
              const companyName = $form.find('[name="company_name"]').val() || '-';
              const partnerCity = $form.find('[name="partner_city"]').val() || '-';
              const nameText = name || '-';
              const emailText = email || '-';
              const phoneText = phone || '-';
              
              redirectText = `Halo indotech.id, saya *${nameText}*\n\n`;
              redirectText += `Saya ingin mendaftar sebagai mitra *${partnerType}*:\n\n`;
              redirectText += `Berikut data pendaftaran saya:\n`;
              redirectText += `• *Nama*: ${nameText}\n`;
              redirectText += `• *Perusahaan / Toko*: ${companyName}\n`;
              redirectText += `• *Email*: ${emailText}\n`;
              redirectText += `• *WhatsApp*: ${phoneText}\n`;
              redirectText += `• *Kota*: ${partnerCity}\n\n`;
              if (message) {
                redirectText += `*Pesan/Bisnis:*\n"${message}"\n\n`;
              }
              redirectText += `Terima kasih.`;
            }

            if (redirectText) {
              const waUrl = 'https://wa.me/' + waNum + '?text=' + encodeURIComponent(redirectText);
              window.open(waUrl, '_blank');
            }

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
