  // Variables
  
        let currentUserPage = 1;
        
        // Chargement des utilisateurs validés
        async function loadValidatedUsers(page = 1) {
            const tableBody = document.getElementById('validatedUsersTable');
            const filter = document.getElementById('filterValidated').value;
            const start = document.getElementById('validatedStart');
            const prevBtn = document.getElementById('prevValidated');
            const nextBtn = document.getElementById('nextValidated');
            const end = document.getElementById('validatedEnd');
            const agencesTotal = document.getElementById('agencesTotal');
            const agencessemaine= document.getElementById('weeklyRegistrations');
            const agencesmois = document.getElementById('monthlyRegistrations');
            
            // Afficher le skeleton pendant le chargement
            tableBody.innerHTML = `
                <tr id="skeletonRow">
                    <td colspan="6" class="px-6 py-4 text-center">
                        <div class="flex flex-col items-center space-y-3">
                            <div class="skeleton skeleton-text w-3/4"></div>
                            <div class="skeleton skeleton-text w-1/2"></div>
                            <div class="skeleton skeleton-text w-2/3"></div>
                        </div>
                    </td>
                </tr>
            `;

            try {
                const response = await fetch(`/admin/users/validated?page=${page}&filter=${filter}`);
                const data = await response.json();

                if (!data.success) throw new Error(data.message || 'Erreur de chargement');

                // Remplissage du tableau
                tableBody.innerHTML = '';
                data.users.forEach(user => {
                    
                        
                    const row = `
                        <tr>
                            <td class="px-6 py-4">${user.code}</td>
                            <td class="px-6 py-4">${user.nom} ${user.prenom}</td>
                            <td class="px-6 py-4">${user.email}</td>
                            <td class="px-6 py-4">
                                
                            </td>
                            <td class="px-6 py-4">${user.agence ? user.agence.nomAgence : '-'}</td>
                            <td class="px-6 py-4">
                                <button class="text-blue-600 hover:underline" onclick="editUser(${user.id})">Modifier</button>
                                <button class="text-red-600 hover:underline ml-2" onclick="deleteUser(${user.id})">Supprimer</button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });

                // Mise à jour de la pagination
           /*   document.getElementById('validatedStart').textContent = data.from;
                document.getElementById('validatedEnd').textContent = data.to;
                document.getElementById('validatedTotal').textContent = data.total;
                document.getElementById('agencesTotal').textContent = data.total;
              */
                // Boutons de pagination
                prevBtn.disabled = data.current_page <= 1;
                nextBtn.disabled = data.current_page >= data.last_page;
                agencesTotal.textContent=data.total;
                document.getElementById('validatedTotal').textContent = data.total;
                
                prevBtn.classList.toggle('cursor-not-allowed', prevBtn.disabled);
                nextBtn.classList.toggle('cursor-not-allowed', nextBtn.disabled);
                agencessemaine.textContent = data.userssemaine;
                agencesmois.textContent = data.usersmois;
                
                currentUserPage = data.current_page;

            } catch (error) {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-4 text-red-600">${error.message}</td></tr>`;
            }
        }

        // Édition d'utilisateur
        function editUser(userId) {
            fetch(`/admin/users/${userId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const user = data.user;
                        document.getElementById('code').value = user.code;
                        document.getElementById('nom').value = user.nom;
                        document.getElementById('prenom').value = user.prenom;
                        document.getElementById('agence').value = user.agence || '';
                        document.getElementById('telephone').value = user.telephone;
                        document.getElementById('role').value = user.role;
                        document.getElementById('email').value = user.email;
                        
                        // Modifier le formulaire pour l'édition
                        const form = document.getElementById('userForm');
                        form.action = `/admin/users/${userId}`;
                        form.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-sync mr-2"></i> Mettre à jour';
                        
                        showUserForm();
                    } else {
                        alert('Erreur lors du chargement des données utilisateur');
                    }
                });
        }

        // Suppression d'utilisateur
        function deleteUser(userId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadValidatedUsers();
                    }
                });
            }
        }

        // Initialisation des utilisateurs
        document.addEventListener('DOMContentLoaded', () => {
            // Événements de pagination
            document.getElementById('prevValidated').addEventListener('click', () => {
                if (currentUserPage > 1) loadValidatedUsers(currentUserPage - 1);
            });

            document.getElementById('nextValidated').addEventListener('click', () => {
                loadValidatedUsers(currentUserPage + 1);
            });

            // Filtre utilisateurs
            document.getElementById('filterValidated').addEventListener('change', () => {
                loadValidatedUsers();
            });

            // Charger initialement
            loadValidatedUsers();
        });