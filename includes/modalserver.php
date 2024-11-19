

<div id="modal-server-status" class="modal-server-status">
    <div class="modal-content" id="modal-loading">
        <img src="<?php echo $basePath; ?>/assets/images/loading.gif" alt="Cargando...">
        <p>Conectando al servidor...</p>
    </div>
    <div class="modal-content" id="modal-error" style="display: none;">
        <img src="<?php echo $basePath; ?>/assets/images/error.png" alt="Error de red">
        <p>Problemas de conexión. Verifica tu red.</p>
    </div>
</div>

<script>
    let isModalActive = false; 

    function checkServer() {
        $.ajax({
            // URL dinámica hacia check_server.php
            url: "<?php echo $basePath; ?>/includes/check_server.php",
            method: "GET",
            timeout: 5000,
            beforeSend: function() {
                const modal = document.getElementById('modal-server-status');
                const loading = document.getElementById('modal-loading');
                const error = document.getElementById('modal-error');

                isModalActive = true;
                disablePageElements(true);

                if (!modal.classList.contains('show') || error.style.display === 'block') {
                    modal.classList.add('show');
                    loading.style.display = 'block';
                    error.style.display = 'none';
                }
            },
            success: function(response) {
                const modal = document.getElementById('modal-server-status');
                if (modal.classList.contains('show')) {
                    modal.classList.remove('show');
                }
                isModalActive = false; 
                disablePageElements(false);
            },
            error: function() {
                const loading = document.getElementById('modal-loading');
                const error = document.getElementById('modal-error');
                if (loading.style.display === 'block') {
                    loading.style.display = 'none';
                    error.style.display = 'block';
                }
                isModalActive = false;
                disablePageElements(false);
            }
        });
    }

    function disablePageElements(disable) {
        const elements = document.querySelectorAll('a, button, input, select, textarea');
        elements.forEach(element => {
            element.disabled = disable;
            if (disable) {
                element.classList.add('disabled');
            } else {
                element.classList.remove('disabled');
            }
        });
    }

    window.addEventListener('keydown', function(event) {
        if (isModalActive && (event.key === 'F5' || (event.ctrlKey && event.key === 'r'))) {
            event.preventDefault(); 
        }
    });

    window.addEventListener('contextmenu', function(event) {
        if (isModalActive) {
            event.preventDefault(); 
        }
    });

    window.addEventListener('beforeunload', function(event) {
        if (isModalActive) {
            event.preventDefault();
            event.returnValue = '';
        }
    });

    setInterval(checkServer, 10000);
</script>
