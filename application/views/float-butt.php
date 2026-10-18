
    <div class="floating-buttons">
        <a href="https://wa.me/918891618698" class="float-btn flw whatsapp" target="_blank">
            <i class="fab fa-whatsapp"></i>
            <span>Whatsapp Us</span>
        </a>

        <a href="tel:+918891618698" class="float-btn flc call">
            <i class="fas fa-phone-alt"></i>
            <span>Call Us Now</span>
        </a>

        <a href="<?php echo base_url(); ?>contact" class="float-btn fld demo">
            <i class="fas fa-play"></i>
            <span>Quick Demo</span>
        </a>
    </div>


    <script>
                
        $(document).ready(function () {
            $('#newsletter-form').on('submit', function (e) {
                e.preventDefault();

                var $form = $(this);
                var email = $.trim($('#subscriber_email').val());
                var $button = $form.find('.newsletter-submit');

                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showMessage('Please enter a valid email address.', 'error');
                    return;
                }

                $button.prop('disabled', true).text('Subscribing...');

                $.ajax({
                    type: 'POST',
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: 'json',

                    success: function (response) {
                        if (response.status === 'success') {
                            showMessage(
                                response.message || 'Successfully subscribed!',
                                'success'
                            );
                            $form[0].reset();
                        } else {
                            showMessage(
                                response.message || 'Subscription failed. Please try again.',
                                'error'
                            );
                        }
                    },

                    error: function (xhr) {
                        console.error('Newsletter error:', xhr.responseText);
                        showMessage(
                            'Unable to subscribe right now. Please try again later.',
                            'error'
                        );
                    },

                    complete: function () {
                        $button.prop('disabled', false).text('Subscribe ↗');
                    }
                });
            });

            function showMessage(message, type) {
                var $message = $('#newsletter-message');

                if (!$message.length) {
                    $message = $('<p>', {
                        id: 'newsletter-message',
                        'aria-live': 'polite'
                    });
                    $('#newsletter-form').append($message);
                }

                $message
                    .removeClass('success error')
                    .addClass(type)
                    .text(message);
            }
        });

    </script>