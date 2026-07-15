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
      
      let message = ($form.find('[name="message"]').val() || $form.find('[name="contact_message"]').val() || '').trim();
      const address = ($form.find('[name="address"]').val() || '').trim();
      const productSize = $form.find('[name="product_size"]:checked').val() || '';
      const productAroma = $form.find('[name="product_aroma"]:checked').val() || '';
      
      if (address) {
        message = '';
        if (productSize) message += `Ukuran: ${productSize}\n`;
        if (productAroma) message += `Aroma: ${productAroma}\n`;
        message += `Alamat: ${address}`;
      }
      
      const formType = $form.attr('data-form-type') || '';
      const isKemitraan = formType === 'kemitraan';
      const isBrand = $form.find('[name="brand_title"]').length > 0;
      const isBypass = isKemitraan || isBrand;

      // If Kemitraan or Brand and name is empty, bypass validation and AJAX database submit, directly open WhatsApp
      if (isBypass && !name) {
        const formWaNum = $form.find('[name="whatsapp_number"]').val();
        const waNum = formWaNum ? formWaNum.replace(/[^0-9]/g, '') : (indotechData.whatsapp || '6285600061005');
        
        let defaultText = "Halo indotech.id, saya tertarik untuk mendaftar sebagai mitra. Mohon informasi lebih lanjut.";
        if (isBrand) {
          const brandTitle = $form.find('[name="brand_title"]').val() || '';
          defaultText = `Halo indotech.id, saya tertarik untuk bermitra/maklon dengan brand ${brandTitle}. Mohon informasi lebih lanjut.`;
        }
        
        const waUrl = 'https://wa.me/' + waNum + '?text=' + encodeURIComponent(defaultText);
        window.open(waUrl, '_blank');
        $form[0].reset();
        return;
      }

      const hasEmailField = $form.find('[name="email"]').length > 0 || $form.find('[name="contact_email"]').length > 0;
      const hasPhoneField = $form.find('[name="phone"]').length > 0 || $form.find('[name="contact_phone"]').length > 0;

      // Validate name (always required except for Kemitraan and Brand)
      if (!isBypass && !name) {
        showResponse('Nama lengkap wajib diisi.', false);
        return;
      }

      // Validate email (only if field exists in form and not Kemitraan/Brand)
      if (!isBypass && hasEmailField && !email) {
        showResponse('Alamat email wajib diisi.', false);
        return;
      }

      // Validate phone (only if field exists, is required, and not Kemitraan/Brand)
      const $phoneField = $form.find('[name="phone"], [name="contact_phone"]');
      if (!isBypass && hasPhoneField && $phoneField.prop('required') && !phone) {
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
            const formWaNum = $form.find('[name="whatsapp_number"]').val();
            const waNum = formWaNum ? formWaNum.replace(/[^0-9]/g, '') : (indotechData.whatsapp || '6285600061005');
            
            let redirectText = '';

            if ($productTitleField.length) {
              // Product detail form WhatsApp redirect
              const productTitle = $productTitleField.val();
              const nameText = name || '-';
              
              redirectText = `Halo indotech.id, saya *${nameText}*\n\n`;
              redirectText += `Saya tertarik untuk memesan/tanya mengenai produk berikut:\n\n`;
              redirectText += `• *Produk*: ${productTitle}\n`;
              if (productSize) redirectText += `• *Ukuran*: ${productSize}\n`;
              if (productAroma) redirectText += `• *Aroma*: ${productAroma}\n`;
              if (address) redirectText += `• *Alamat Kirim*: ${address}\n`;
              redirectText += `\nMohon informasi ketersediaan stok dan ongkos kirimnya. Terima kasih.`;
              
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

            } else if ($partnerTypeField.length || formType === 'kemitraan') {
              // Kemitraan page form WhatsApp redirect
              const partnerType = $form.find('[name="partner_type"] option:selected').val() ? $form.find('[name="partner_type"] option:selected').text() : '';
              const partnerCity = $form.find('[name="partner_city"]').val() || '';
              const nameText = name || '';
              const emailText = email || '';
              
              redirectText = `Halo indotech.id, saya ingin bertanya/mendaftar kemitraan:\n\n`;
              if (nameText) redirectText += `• *Nama*: ${nameText}\n`;
              if (emailText) redirectText += `• *Email*: ${emailText}\n`;
              if (partnerCity) redirectText += `• *Kota/Kabupaten*: ${partnerCity}\n`;
              if (partnerType) redirectText += `• *Tipe Mitra*: ${partnerType}\n`;
              if (message) {
                redirectText += `\n*Pesan/Bisnis:*\n"${message}"\n`;
              }
              redirectText += `\nTerima kasih.`;
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
