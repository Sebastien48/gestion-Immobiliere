// Variables globales Three.js
        let scene, camera, renderer, buildings = [];
        let mouse = { x: 0, y: 0 };

        // Initialisation de Three.js
        function initThreeJS() {
            const canvas = document.getElementById('three-canvas');
            
            // Scene
            scene = new THREE.Scene();
            scene.fog = new THREE.Fog(0x667eea, 10, 100);

            // Camera
            camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.set(0, 8, 20);
            camera.lookAt(0, 0, 0);

            // Renderer
            renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setClearColor(0x667eea, 1);
            renderer.shadowMap.enabled = true;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;

            // Éclairage
            const ambientLight = new THREE.AmbientLight(0x404040, 0.4);
            scene.add(ambientLight);

            const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
            directionalLight.position.set(10, 10, 5);
            directionalLight.castShadow = true;
            directionalLight.shadow.mapSize.width = 2048;
            directionalLight.shadow.mapSize.height = 2048;
            scene.add(directionalLight);

            // Lumière point colorée
            const pointLight = new THREE.PointLight(0x764ba2, 0.6, 50);
            pointLight.position.set(-10, 8, 10);
            scene.add(pointLight);

            // Création des bâtiments
            createBuildings();

            // Sol
            const groundGeometry = new THREE.PlaneGeometry(100, 100);
            const groundMaterial = new THREE.MeshLambertMaterial({ 
                color: 0x2a2a2a,
                transparent: true,
                opacity: 0.3
            });
            const ground = new THREE.Mesh(groundGeometry, groundMaterial);
            ground.rotation.x = -Math.PI / 2;
            ground.position.y = -0.5;
            ground.receiveShadow = true;
            scene.add(ground);

            // Gestion de la souris
            document.addEventListener('mousemove', onMouseMove);
            window.addEventListener('resize', onWindowResize);

            // Cacher l'écran de chargement
            document.getElementById('loading').style.display = 'none';

            // Démarrer l'animation
            animate();
        }

        // Création des bâtiments
        function createBuildings() {
            const buildingCount = 15;
            const colors = [0x3b82f6, 0x1d4ed8, 0x764ba2, 0x667eea, 0x4f46e5];

            for (let i = 0; i < buildingCount; i++) {
                const width = Math.random() * 2 + 1;
                const height = Math.random() * 8 + 2;
                const depth = Math.random() * 2 + 1;

                const geometry = new THREE.BoxGeometry(width, height, depth);
                const material = new THREE.MeshLambertMaterial({ 
                    color: colors[Math.floor(Math.random() * colors.length)],
                    transparent: true,
                    opacity: 0.8
                });

                const building = new THREE.Mesh(geometry, material);
                
                // Position aléatoire
                const radius = Math.random() * 20 + 10;
                const angle = (i / buildingCount) * Math.PI * 2 + Math.random() * 0.5;
                
                building.position.x = Math.cos(angle) * radius;
                building.position.z = Math.sin(angle) * radius;
                building.position.y = height / 2;

                building.castShadow = true;
                building.receiveShadow = true;

                // Propriétés pour l'animation
                building.userData = {
                    originalY: building.position.y,
                    phase: Math.random() * Math.PI * 2,
                    speed: 0.005 + Math.random() * 0.01
                };

                buildings.push(building);
                scene.add(building);
            }
        }

        // Gestion du mouvement de la souris
        function onMouseMove(event) {
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
        }

        // Redimensionnement de la fenêtre
        function onWindowResize() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        }

        // Animation
        function animate() {
            requestAnimationFrame(animate);

            // Animation de la caméra basée sur la souris
            camera.position.x += (mouse.x * 5 - camera.position.x) * 0.05;
            camera.position.y += (8 + mouse.y * 3 - camera.position.y) * 0.05;
            camera.lookAt(0, 2, 0);

            // Animation des bâtiments
            buildings.forEach((building, index) => {
                building.userData.phase += building.userData.speed;
                building.position.y = building.userData.originalY + Math.sin(building.userData.phase) * 0.3;
                building.rotation.y += 0.002;
            });

            renderer.render(scene, camera);
        }

        // Fonction pour basculer la visibilité du mot de passe
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L12 12m6.121-3.879L21 21"></path>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }

        // Gestion de la soumission du formulaire
        function handleLogin(event) {
            event.preventDefault();
            
            const button = event.target.querySelector('button[type="submit"]');
            const originalContent = button.innerHTML;
            
            // Animation de chargement
            button.innerHTML = `
                <div class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Connexion en cours...
                </div>
            `;
            button.disabled = true;
            
            // Simulation de la connexion
            setTimeout(() => {
                // Animation de succès
                button.innerHTML = `
                    <div class="flex items-center justify-center">
                        <i class="fas fa-check mr-2"></i>
                        Connecté !
                    </div>
                `;
                button.classList.add('bg-green-600');
                
                // Redirection après un court délai
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 1000);
            }, 2000);
        }

        // Animation d'entrée de la page
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser Three.js
            initThreeJS();
            
            const card = document.querySelector('.glass-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 500);
        });