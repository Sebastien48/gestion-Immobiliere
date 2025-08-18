// Fonction pour mettre à jour les graphiques avec les données réelles
function updateCharts() {
    fetch('/admin/stats')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Données reçues:', data); // Pour debug

            // Met à jour le graphique des inscriptions
            if (inscriptionsChart && data.months && data.inscriptions) {
                inscriptionsChart.data.labels = data.months;
                inscriptionsChart.data.datasets[0].data = data.inscriptions;
                inscriptionsChart.update();
            }

            // Met à jour le graphique des rôles
            if (rolesChart && data.roles) {
                rolesChart.data.labels = Object.keys(data.roles);
                rolesChart.data.datasets[0].data = Object.values(data.roles);
                rolesChart.update();
            }

            // Met à jour le graphique de performances avec les données réelles
            if (performanceChart && data.performance) {
                performanceChart.data.datasets[0].data = [
                    data.performance.batiments || 0,
                    data.performance.appartements || 0,
                    data.performance.locataires || 0,
                    data.performance.locations || 0
                ];
                performanceChart.update();
            }

            // Met à jour les statistiques dans les cartes
            updateStatCards(data);
        })
        .catch(error => {
            console.error('Erreur lors du chargement des statistiques:', error);
            // Afficher un message d'erreur à l'utilisateur
            showErrorMessage('Erreur lors du chargement des statistiques');
        });
}

// Fonction pour mettre à jour les cartes de statistiques
function updateStatCards(data) {
    // Total bâtiments
    if (data.batiments_total !== undefined) {
        const batimentsElement = document.getElementById('batimentsTotal');
        if (batimentsElement) {
            batimentsElement.textContent = data.batiments_total;
        }
    }

    // Total appartements (si vous avez cette donnée)
    if (data.appartements_total !== undefined) {
        const appartementsElement = document.getElementById('appartementsTotal');
        if (appartementsElement) {
            appartementsElement.textContent = data.appartements_total;
        }
    }

    // Total locataires (si vous avez cette donnée)
    if (data.locataires_total !== undefined) {
        const locatairesElement = document.getElementById('locatairesTotal');
        if (locatairesElement) {
            locatairesElement.textContent = data.locataires_total;
        }
    }
}

// Fonction pour afficher un message d'erreur
function showErrorMessage(message) {
    const messageDiv = document.getElementById('formMessage');
    if (messageDiv) {
        messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded mb-4">⚠️ ${message}</div>`;
        // Masquer le message après 5 secondes
        setTimeout(() => {
            messageDiv.innerHTML = '';
        }, 5000);
    }
}

// Fonction pour initialiser les graphiques avec des données par défaut
function initChartsWithDefaults() {
    // Données par défaut pour éviter les erreurs
    const defaultData = {
        months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        inscriptions: [0, 0, 0, 0, 0, 0, 0],
        roles: { 'utilisateur': 0, 'administrateur': 0 },
        performance: {
            batiments: 0,
            appartements: 0,
            locataires: 0,
            locations: 0
        }
    };

    // Initialiser les graphiques avec les données par défaut
    if (inscriptionsChart) {
        inscriptionsChart.data.labels = defaultData.months;
        inscriptionsChart.data.datasets[0].data = defaultData.inscriptions;
        inscriptionsChart.update();
    }

    if (rolesChart) {
        rolesChart.data.labels = Object.keys(defaultData.roles);
        rolesChart.data.datasets[0].data = Object.values(defaultData.roles);
        rolesChart.update();
    }

    if (performanceChart) {
        performanceChart.data.datasets[0].data = [
            defaultData.performance.batiments,
            defaultData.performance.appartements,
            defaultData.performance.locataires,
            defaultData.performance.locations
        ];
        performanceChart.update();
    }
}

// Fonction pour rafraîchir les statistiques périodiquement
function startStatsRefresh() {
    // Mettre à jour les statistiques toutes les 5 minutes
    setInterval(updateCharts, 5 * 60 * 1000);
}

// Export des fonctions pour utilisation globale
if (typeof window !== 'undefined') {
    window.updateCharts = updateCharts;
    window.updateStatCards = updateStatCards;
    window.initChartsWithDefaults = initChartsWithDefaults;
    window.startStatsRefresh = startStatsRefresh;
}