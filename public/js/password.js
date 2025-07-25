        function switchTab(tab) {
            const emailForm = document.getElementById('email-form');
            const phoneForm = document.getElementById('phone-form');
            const emailTab = document.getElementById('email-tab');
            const phoneTab = document.getElementById('phone-tab');
            
            if (tab === 'email') {
                emailForm.style.display = 'block';
                phoneForm.style.display = 'none';
                emailTab.classList.add('active');
                phoneTab.classList.remove('active');
                
                // Mettre à jour le champ requis
                document.getElementById('email').required = true;
                document.getElementById('phone').required = false;
            } else {
                emailForm.style.display = 'none';
                phoneForm.style.display = 'block';
                emailTab.classList.remove('active');
                phoneTab.classList.add('active');
                
                // Mettre à jour le champ requis
                document.getElementById('email').required = false;
                document.getElementById('phone').required = true;
            }
        }
        
        // Gestion du formulaire
        document.getElementById('forgot-password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submit-btn');
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            
            // Simulation d'envoi
            submitBtn.textContent = 'Envoi en cours...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                // Simuler une réponse réussie
                successMessage.style.display = 'block';
                errorMessage.style.display = 'none';
                
                submitBtn.textContent = 'Envoyer le lien de réinitialisation';
                submitBtn.disabled = false;
                
                // Masquer le message après 5 secondes
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000);
            }, 2000);
        });