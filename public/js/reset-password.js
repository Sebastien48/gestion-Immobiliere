function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById('eye-icon-' + (inputId === 'password' ? 'password' : 'confirmation'));
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414L8.464 8.464m5.657 5.657l1.415 1.414M14.828 14.828l1.414 1.414m-2.122-2.122a3 3 0 00-4.243-4.243m0 0L8.464 8.464m0 0L7.05 7.05m1.414 1.414L7.05 7.05"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l22 22"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
        
        // Vérification de la force du mot de passe
        function checkPasswordStrength(password) {
            let strength = 0;
            let text = '';
            let color = '';
            let width = '0%';
            
            if (password.length >= 8) strength += 1;
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            switch (strength) {
                case 0:
                case 1:
                    text = 'Très faible';
                    color = '#ef4444';
                    width = '20%';
                    break;
                case 2:
                    text = 'Faible';
                    color = '#f97316';
                    width = '40%';
                    break;
                case 3:
                    text = 'Moyenne';
                    color = '#eab308';
                    width = '60%';
                    break;
                case 4:
                    text = 'Forte';
                    color = '#22c55e';
                    width = '80%';
                    break;
                case 5:
                    text = 'Très forte';
                    color = '#16a34a';
                    width = '100%';
                    break;
            }
            
            return { text, color, width };
        }
        
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthDiv = document.getElementById('password-strength');
            const strengthText = document.getElementById('strength-text');
            const strengthBar = document.getElementById('strength-bar');
            
            if (password.length > 0) {
                strengthDiv.style.display = 'block';
                const strength = checkPasswordStrength(password);
                strengthText.textContent = strength.text;
                strengthText.style.color = strength.color;
                strengthBar.style.width = strength.width;
                strengthBar.style.backgroundColor = strength.color;
            } else {
                strengthDiv.style.display = 'none';
            }
        });
        
        // Validation en temps réel
        document.getElementById('password_confirmation').addEventListener('input', function(e) {
            const password = document.getElementById('password').value;
            const confirmation = e.target.value;
            
            if (confirmation.length > 0) {
                if (password === confirmation) {
                    e.target.style.borderColor = '#22c55e';
                } else {
                    e.target.style.borderColor = '#ef4444';
                }
            } else {
                e.target.style.borderColor = '#d1d5db';
            }
        });