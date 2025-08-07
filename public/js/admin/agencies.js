 let currentAgencyPage = 1;
        
        // Chargement des agences
        

// Chargement des agences
async function loadAgencies(page = 1) {
    const tableBody = document.getElementById('agencesTable');
    const agencesTotal = document.getElementById('agencesTotaux');
    const agencesTotalCount = document.getElementById('agencesTotalCount');
    const prevBtn = document.getElementById('prevAgences');
    const nextBtn = document.getElementById('nextAgences');

    // Afficher le skeleton pendant le chargement
    tableBody.innerHTML = `
        <tr id="skeletonRowAgencies">
            <td colspan="7" class="text-center px-6 py-4">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-3/4 h-4 bg-gray-200 rounded animate-pulse"></div>
                    <div class="w-1/2 h-4 bg-gray-200 rounded animate-pulse"></div>
                    <div class="w-2/3 h-4 bg-gray-200 rounded animate-pulse"></div>
                </div>
            </td>
        </tr>
    `;

    try {
        const response = await fetch(`/admin/agences/list?page=${page}`);
        const data = await response.json();

        if (!data.success) throw new Error(data.message || 'Erreur de chargement');

        // Remplissage du tableau
        tableBody.innerHTML = '';
        if (data.agences.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-gray-500">Aucune agence trouvée.</td></tr>`;
        } else {
            data.agences.forEach(agence => {
                const row = `
                    <tr>
                        <td class="px-6 py-4">${agence.numero}</td>
                        <td class="px-6 py-4">${agence.nomAgence}</td>
                        <td class="px-6 py-4">${agence.emailAgence}</td>
                        <td class="px-6 py-4">${agence.adresse}</td>
                        <td class="px-6 py-4">${agence.telephoneAgence}</td>
                        <td class="px-6 py-4">${agence.fondateur}</td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:underline" onclick="viewAgency(${agence.id})">Voir</button>
                            <button class="text-red-600 hover:underline ml-2" onclick="deleteAgency(${agence.id})">Supprimer</button>
                            <button class="text-yellow-600 hover:underline ml-2" onclick="editAgency(${agence.id})">Modifier</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        // Mise à jour des statistiques
        agencesTotal.textContent = data.total;
        agencesTotalCount.textContent = data.total;

        // Pagination (désactive les boutons si besoin)
        prevBtn.disabled = page <= 1;
        nextBtn.disabled = data.end >= data.total;

        prevBtn.classList.toggle('cursor-not-allowed', prevBtn.disabled);
        nextBtn.classList.toggle('cursor-not-allowed', nextBtn.disabled);

        currentAgencyPage = page;

    } catch (error) {
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-red-600">${error.message}</td></tr>`;
    }
}

        /*
        async function loadAgencies(page = 1) {
            
            const tableBody = document.getElementById('agencesTable');
            const agencesTotal = document.getElementById('agencesTotal');
           const agencesTotalCount = document.getElementById('agencesTotalCount');
            const prevBtn = document.getElementById('prevAgences');
            const nextBtn = document.getElementById('nextAgences');
            
            // Afficher le skeleton pendant le chargement
            tableBody.innerHTML = `
                <tr id="skeletonRowAgencies">
                    <td colspan="7" class="text-center px-6 py-4">
                        <div class="flex flex-col items-center space-y-3">
                            <div class="w-3/4 h-4 bg-gray-200 rounded animate-pulse"></div>
                            <div class="w-1/2 h-4 bg-gray-200 rounded animate-pulse"></div>
                            <div class="w-2/3 h-4 bg-gray-200 rounded animate-pulse"></div>
                        </div>
                    </td>
                </tr>
            `;

            try {
                const response = await fetch(`/admin/agences/list?page=${page}`);
                const data = await response.json();

                if (!data.success) throw new Error(data.message || 'Erreur de chargement');

                // Remplissage du tableau
                tableBody.innerHTML = '';
                data.agences.forEach(agence => {
                    const row = `
                        <tr>
                            <td class="px-6 py-4">${agence.numero}</td>
                            <td class="px-6 py-4">${agence.nomAgence}</td>
                            <td class="px-6 py-4">${agence.emailAgence}</td>
                            <td class="px-6 py-4">${agence.adresse}</td>
                            <td class="px-6 py-4">${agence.telephoneAgence}</td>
                            <td class="px-6 py-4">${agence.fondateur}</td>
                            <td class="px-6 py-4">
                                <button class="text-blue-600 hover:underline" onclick="viewAgency(${agence.id})">Voir</button>
                                <button class="text-red-600 hover:underline ml-2" onclick="deleteAgency(${agence.id})">Supprimer</button>
                                <button class="text-yellow-600 hover:underline ml-2" onclick="editAgency(${agence.id})">Modifier</button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });

                // Mise à jour des statistiques
                   
                   
                   document.getElementById('validatedStart').textContent = data.from;
                   document.getElementById('validatedEnd').textContent = data.to;
                   document.getElementById('validatedTotal').textContent = data.total;
                   document.getElementById('agencesTotal').textContent = data.total;
                
                
                // Boutons de pagination
                prevBtn.disabled = data.current_page <= 1;
                nextBtn.disabled = data.current_page >= data.last_page;
                
              
                
                currentAgencyPage = data.current_page;

            } catch (error) {
                tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-red-600">${error.message}</td></tr>`;
            }
        }
        */

        // Visualisation agence
        function viewAgency(agencyId) {
            fetch(`/admin/agences/${agencyId}`)
                .then(response => response.json())
                .then(agence => {
                    alert(`Détails de l'agence:\nNom: ${agence.nomAgence}\nEmail: ${agence.emailAgence}`);
                });
        }

        // Édition agence
        function editAgency(agencyId) {
            fetch(`/admin/agences/${agencyId}/edit`)
            .method('GET')
                .then(response => response.json())
                .then(agence => {
                    document.getElementById('numero').value = agence.numero;
                    document.getElementById('nomAgence').value = agence.nomAgence;
                    document.getElementById('fondateur').value = agence.fondateur;
                    document.getElementById('emailAgence').value = agence.emailAgence;
                    document.getElementById('adresse').value = agence.adresse;
                    document.getElementById('telephoneAgence').value = agence.telephoneAgence;
                    
                    // Modifier le formulaire pour l'édition
                    // ouvrir le formulaire d'edition
                    showAgenceForm();
                    const form = document.getElementById('agenceForm');
                    form.action = `/admin/agences/${agencyId}`;
                    form.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-sync mr-2"></i> Mettre à jour';
                    
                    
                });
        }

        // Suppression agence
        function deleteAgency(agencyId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette agence ?')) {
                fetch(`/admin/agences/${agencyId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadAgencies();
                    }
                });
            }
        }

        // Initialisation des agences
        document.addEventListener('DOMContentLoaded', () => {
            // Événements de pagination
            document.getElementById('prevAgences').addEventListener('click', () => {
                if (currentAgencyPage > 1) loadAgencies(currentAgencyPage - 1);
            });

            document.getElementById('nextAgences').addEventListener('click', () => {
                loadAgencies(currentAgencyPage + 1);
            });

            // Charger initialement
            loadAgencies();
        });

        // =============================================
        // Gestion des formulaires
        // =============================================
        
        // Gestion du formulaire utilisateur
        document.getElementById('userForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const messageDiv = document.getElementById('formMessage');
            const token = document.querySelector('meta[name="csrf-token"]').content;

            // Validation des mots de passe
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ Les mots de passe ne correspondent pas</div>`;
                return;
            }

            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';

                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    messageDiv.innerHTML = `<div class="bg-green-100 text-green-800 p-3 rounded">✅ ${data.message}</div>`;
                    form.reset();
                    hideUserForm();
                    loadValidatedUsers();
                } else {
                    messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ ${data.message || 'Erreur lors de la création'}</div>`;
                }
            } catch (error) {
                messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ Erreur réseau: ${error.message}</div>`;
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Enregistrer';
            }
        });

        // Gestion du formulaire agence
        document.getElementById('agenceForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const messageDiv = document.getElementById('formMessage');
            const token = document.querySelector('meta[name="csrf-token"]').content;

            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';

                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    messageDiv.innerHTML = `<div class="bg-green-100 text-green-800 p-3 rounded">✅ ${data.message}</div>`;
                    form.reset();
                    hideAgenceForm();
                    loadAgencies();
                } else {
                    messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ ${data.message || 'Erreur lors de la création'}</div>`;
                }
            } catch (error) {
                messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ Erreur réseau: ${error.message}</div>`;
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Enregistrer l\'agence';
            }
        });