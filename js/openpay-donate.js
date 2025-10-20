jQuery(document).ready(function($){
    // Variables globales del modal
    var $modal = $('#nr-openpay-modal');
    var currentProject = '';

    // Abrir modal al hacer clic en botón de donar
    $(document).on('click', '.nr-donate-btn-open', function(e){
        e.preventDefault();
        currentProject = $(this).data('project');
        $('#nr-modal-project').text(currentProject);
        $('#nr-donate-email').val('');
        $('#nr-donate-amount').val('');
        $('#nr-donate-message').removeClass('error success').text('');
        $modal.addClass('nr-openpay-modal-active');
    });

    // Cerrar modal
    $(document).on('click', '.nr-openpay-modal-close', function(){
        closeModal();
    });

    // Cerrar modal al hacer clic fuera del contenido
    $(document).on('click', '.nr-openpay-modal', function(e){
        if($(e.target).hasClass('nr-openpay-modal')){
            closeModal();
        }
    });

    // Cerrar modal con tecla Escape
    $(document).on('keydown', function(e){
        if(e.key === 'Escape'){
            closeModal();
        }
    });

    // Validar inputs en tiempo real
    $('#nr-donate-email').on('blur', function(){
        $(this).val($.trim($(this).val()));
    });

    $('#nr-donate-amount').on('input', function(){
        var val = $(this).val();
        if(val && isNaN(parseFloat(val))){
            $(this).val('');
        }
    });

    // Manejar envío del formulario
    $(document).on('click','#nr-donate-now',function(e){
        e.preventDefault();
        
        var $btn = $(this);
        var project = currentProject;
        var amount = parseFloat($('#nr-donate-amount').val());
        var email = $('#nr-donate-email').val().trim();
        var $msg = $('#nr-donate-message');
        
        // Limpiar mensaje anterior
        $msg.removeClass('error success').text('');
        
        // Validaciones
        if(!email){
            showMessage($msg, 'Por favor ingresa tu correo electrónico.', 'error');
            return;
        }
        
        if(!isValidEmail(email)){
            showMessage($msg, 'Por favor ingresa un correo válido.', 'error');
            return;
        }
        
        if(!amount || amount < 1){
            showMessage($msg, 'El monto debe ser mayor a $0.99 MXN.', 'error');
            return;
        }
        
        // Mostrar estado de carga
        $btn.addClass('loading').prop('disabled', true).text('Procesando...');
        
        // Enviar solicitud AJAX
        $.ajax({
            url: nrOpenpayDonate.ajax_url,
            type: 'POST',
            data: {
                action: 'nr_openpay_donate',
                nonce: nrOpenpayDonate.nonce,
                project: project,
                amount: amount,
                email: email
            },
            success: function(res){
                if(res.success && res.data && res.data.session_url){
                    // Redirigir al checkout de Openpay
                    window.location.href = res.data.session_url;
                } else {
                    var errorMsg = res.data && res.data.message 
                        ? res.data.message 
                        : 'Error al crear la sesión de pago. Por favor intenta de nuevo.';
                    showMessage($msg, errorMsg, 'error');
                    resetButton($btn);
                }
            },
            error: function(){
                showMessage($msg, 'Error de comunicación con el servidor. Por favor intenta de nuevo.', 'error');
                resetButton($btn);
            },
            timeout: 10000
        });
    });
    
    // Funciones auxiliares
    function isValidEmail(email){
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function showMessage($elem, message, type){
        $elem.removeClass('error success').addClass(type).text(message).fadeIn();
    }
    
    function resetButton($btn){
        $btn.removeClass('loading').prop('disabled', false).text('Continuar con Openpay');
    }

    function closeModal(){
        $modal.removeClass('nr-openpay-modal-active');
    }
});