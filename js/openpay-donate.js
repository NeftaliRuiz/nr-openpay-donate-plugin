jQuery(document).ready(function($){
    // Variables globales del modal
    var $modal = $('#nr-openpay-modal');
    var currentProject = '';

    // Abrir modal al hacer clic en botón de donar
    $(document).on('click', '.nr-donate-btn-open', function(e){
        e.preventDefault();
        currentProject = $(this).data('project');
        $('#nr-modal-project').text(currentProject);
        $('#nr-donate-name').val('');
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
    $('#nr-donate-name').on('blur', function(){
        $(this).val($.trim($(this).val()));
    });

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
        var name = $('#nr-donate-name').val().trim();
        var amount = parseFloat($('#nr-donate-amount').val());
        var email = $('#nr-donate-email').val().trim();
        var $msg = $('#nr-donate-message');
        
        // Limpiar mensaje anterior
        $msg.removeClass('error success').text('');
        
        // Validaciones
        if(!name){
            showMessage($msg, 'Por favor ingresa tu nombre.', 'error');
            return;
        }
        
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
                name: name,
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
                    // Mostrar detalles técnicos si existen
                    try {
                        if (res.data && res.data.debug) {
                            var dbg = res.data.debug;
                            var httpCode = dbg.http_code ? ('HTTP ' + dbg.http_code + ' ') : '';
                            var raw = typeof dbg === 'string' ? dbg : (dbg.response || JSON.stringify(dbg));
                            if (raw && raw.length > 800) raw = raw.substring(0, 800) + '...';
                            var $details = $('<details/>').css({marginTop:'8px'});
                            var $summary = $('<summary/>').text('Detalles técnicos');
                            var $pre = $('<pre/>').css({whiteSpace:'pre-wrap', maxHeight:'220px', overflow:'auto', background:'#f6f7f7', padding:'8px', borderRadius:'4px', border:'1px solid #e0e0e0'}).text(httpCode + (raw || ''));
                            $details.append($summary).append($pre);
                            $msg.append($details);
                        }
                    } catch(e) {}
                    resetButton($btn);
                }
            },
            error: function(xhr){
                var generic = 'Error de comunicación con el servidor. Por favor intenta de nuevo.';
                showMessage($msg, generic, 'error');
                // Intentar extraer mensaje y debug del servidor
                try {
                    var res = xhr.responseJSON || JSON.parse(xhr.responseText);
                    if (res && res.data) {
                        if (res.data.message) {
                            $msg.text(res.data.message).addClass('error');
                        }
                        if (res.data.debug) {
                            var dbg = res.data.debug;
                            var httpCode = dbg.http_code ? ('HTTP ' + dbg.http_code + ' ') : '';
                            var raw = typeof dbg === 'string' ? dbg : (dbg.response || JSON.stringify(dbg));
                            if (raw && raw.length > 800) raw = raw.substring(0, 800) + '...';
                            var $details = $('<details/>').css({marginTop:'8px'});
                            var $summary = $('<summary/>').text('Detalles técnicos');
                            var $pre = $('<pre/>').css({whiteSpace:'pre-wrap', maxHeight:'220px', overflow:'auto', background:'#f6f7f7', padding:'8px', borderRadius:'4px', border:'1px solid #e0e0e0'}).text(httpCode + (raw || ''));
                            $details.append($summary).append($pre);
                            $msg.append($details);
                        }
                    }
                } catch(e) {}
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