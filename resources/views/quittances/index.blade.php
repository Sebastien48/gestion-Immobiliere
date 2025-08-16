@extends('layout')

@section('title', 'Gestion des Quittances')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-file-invoice text-indigo-600 mr-2"></i> Gestion des Quittances
    </h2>
    <div class="flex gap-2">
        <button onclick="openModal('generateReceiptModal')" 
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Générer une quittance
        </button>
    </div>
</div>

<!-- Filtres -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Filtre par locataire -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Locataire</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous les locataires</option>
                <option value="1">Jean Marc (B1-05)</option>
                <option value="2">Marie Ange (B2-12)</option>
                <option value="3">Thomas Shelby (A-03)</option>
            </select>
        </div>
        
        <!-- Filtre par mois -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous les mois</option>
                <option value="2023-07">Juillet 2023</option>
                <option value="2023-06">Juin 2023</option>
                <option value="2023-05">Mai 2023</option>
            </select>
        </div>
        
        <!-- Filtre par statut -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous</option>
                <option value="rent">Loyer</option>
                <option value="deposit">Caution</option>
                <option value="charge">Charges</option>
            </select>
        </div>
        
        <!-- Recherche -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" placeholder="Code, locataire..." 
                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
        </div>
    </div>
</div>

<!-- Liste des quittances -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Code
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Numéro
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Locataire
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Période
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Montant
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date génération
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Quittance 1 -->
                <tr>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-indigo-600">QUI-2023-001</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="font-mono">2023-07-001</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                JM
                            </div>
                            <div class="ml-4">
                                <div class="font-medium">Jean Marc</div>
                                <div class="text-sm text-gray-500">B1-05</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Juillet 2023</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium">750 000 FCFA</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">05/07/2023</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="downloadReceipt('QUI-2023-001')" class="text-blue-600 hover:text-blue-900" title="Télécharger">
                                <i class="fas fa-download"></i>
                                <span class="sm:hidden">Télécharger</span>
                            </button>
                            <button onclick="sendReceiptByEmail('QUI-2023-001')" class="text-green-600 hover:text-green-900" title="Envoyer par email">
                                <i class="fas fa-envelope"></i>
                                <span class="sm:hidden">Envoyer</span>
                            </button>
                            <button onclick="viewReceiptDetails('QUI-2023-001')" class="text-indigo-600 hover:text-indigo-900" title="Détails">
                                <i class="fas fa-eye"></i>
                                <span class="sm:hidden">Voir</span>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Quittance 2 -->
                <tr>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-indigo-600">QUI-2023-002</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="font-mono">2023-07-002</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                                MA
                            </div>
                            <div class="ml-4">
                                <div class="font-medium">Marie Ange</div>
                                <div class="text-sm text-gray-500">B2-12</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Juillet 2023</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium">650 000 FCFA</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">10/07/2023</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="downloadReceipt('QUI-2023-002')" class="text-blue-600 hover:text-blue-900" title="Télécharger">
                                <i class="fas fa-download"></i>
                                <span class="sm:hidden">Télécharger</span>
                            </button>
                            <button onclick="sendReceiptByEmail('QUI-2023-002')" class="text-green-600 hover:text-green-900" title="Envoyer par email">
                                <i class="fas fa-envelope"></i>
                                <span class="sm:hidden">Envoyer</span>
                            </button>
                            <button onclick="viewReceiptDetails('QUI-2023-002')" class="text-indigo-600 hover:text-indigo-900" title="Détails">
                                <i class="fas fa-eye"></i>
                                <span class="sm:hidden">Voir</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-gray-50 px-4 sm:px-6 py-3 flex items-center justify-between border-t border-gray-200">
        <div class="text-sm text-gray-500">
            Affichage de <span class="font-medium">1</span> à <span class="font-medium">2</span> sur <span class="font-medium">2</span> quittances
        </div>
        <nav class="flex space-x-2">
            <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white cursor-not-allowed" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-chevron-right"></i>
            </button>
        </nav>
    </div>
</div>

<!-- Modal Génération de quittance -->
<div id="generateReceiptModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 sm:mx-6 overflow-y-auto" style="max-height: 90vh;">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-file-invoice text-indigo-500 mr-2"></i> Générer une quittance
            </h3>
            <button onclick="closeModal('generateReceiptModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="generateReceiptForm" class="p-4 sm:p-6">
            <!-- Sélection du paiement -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Paiement*</label>
                <select id="paymentSelect" name="payment_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Sélectionnez un paiement</option>
                    <option value="1">PAY-2307-001 - Jean Marc (Juillet 2023 - 750 000 FCFA)</option>
                    <option value="2">PAY-2307-002 - Marie Ange (Juillet 2023 - 650 000 FCFA)</option>
                    <option value="3">PAY-2306-001 - Thomas Shelby (Juin 2023 - 550 000 FCFA)</option>
                </select>
            </div>
            
            <!-- Numéro de quittance -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de quittance*</label>
                <input type="text" name="receipt_number" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md"
                       placeholder="2023-07-001">
            </div>
            
            <!-- Date de génération -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de génération*</label>
                <input type="date" name="generation_date" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md"
                       value="{{ date('Y-m-d') }}">
            </div>
            
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                <button type="button" onclick="closeModal('generateReceiptModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center justify-center">
                    <i class="fas fa-file-pdf mr-2"></i> Générer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Détails de la quittance -->
<div id="receiptDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 sm:mx-6">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-file-invoice text-indigo-500 mr-2"></i> Détails de la quittance
            </h3>
            <button onclick="closeModal('receiptDetailsModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4 sm:p-6">
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Code quittance</p>
                    <p class="font-mono font-medium text-indigo-600" id="detailReceiptCode">QUI-2023-001</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500">Numéro</p>
                    <p class="font-medium" id="detailReceiptNumber">2023-07-001</p>
                </div>
                
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-3">
                        JM
                    </div>
                    <div>
                        <p class="font-medium" id="detailReceiptTenant">Jean Marc</p>
                        <p class="text-sm text-gray-500" id="detailReceiptApartment">B1-05</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Période</p>
                        <p class="font-medium" id="detailReceiptPeriod">Juillet 2023</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Montant</p>
                        <p class="font-medium" id="detailReceiptAmount">750 000 FCFA</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Date paiement</p>
                        <p class="font-medium" id="detailReceiptPaymentDate">05/07/2023</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date génération</p>
                        <p class="font-medium" id="detailReceiptGenerationDate">05/07/2023</p>
                    </div>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500">Code paiement</p>
                    <p class="font-mono" id="detailReceiptPaymentCode">PAY-2307-001</p>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button onclick="closeModal('receiptDetailsModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Envoi par email -->
<div id="sendReceiptModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 sm:mx-6">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-envelope text-green-500 mr-2"></i> Envoyer la quittance
            </h3>
            <button onclick="closeModal('sendReceiptModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="sendReceiptForm" class="p-4 sm:p-6">
            <div class="mb-4">
                <p class="text-gray-600 mb-2">Quittance à envoyer:</p>
                <p class="font-medium" id="receiptToSend">QUI-2023-001 - Jean Marc (Juillet 2023)</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email du destinataire*</label>
                <input type="email" name="recipient_email" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md"
                       placeholder="email@exemple.com">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Sujet*</label>
                <input type="text" name="email_subject" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md"
                       value="Quittance de loyer - Juillet 2023">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Message*</label>
                <textarea name="email_message" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md">Veuillez trouver ci-joint votre quittance de loyer pour le mois de Juillet 2023.</textarea>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                <button type="button" onclick="closeModal('sendReceiptModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i> Envoyer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Données simulées
    const receiptsData = {
        "QUI-2023-001": {
            number: "2023-07-001",
            tenant: "Jean Marc",
            apartment: "B1-05",
            period: "Juillet 2023",
            amount: "750 000 FCFA",
            paymentDate: "05/07/2023",
            generationDate: "05/07/2023",
            paymentCode: "PAY-2307-001",
            tenantEmail: "jean.marc@exemple.com"
        },
        "QUI-2023-002": {
            number: "2023-07-002",
            tenant: "Marie Ange",
            apartment: "B2-12",
            period: "Juillet 2023",
            amount: "650 000 FCFA",
            paymentDate: "10/07/2023",
            generationDate: "10/07/2023",
            paymentCode: "PAY-2307-002",
            tenantEmail: "marie.ange@exemple.com"
        }
    };

    // Gestion des modals
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Générer une quittance
    document.getElementById('generateReceiptForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        // Simuler la génération du PDF
        const receiptCode = 'QUI-' + new Date().getFullYear() + '-' + Math.floor(100 + Math.random() * 900);
        
        console.log('Quittance générée:', {
            code: receiptCode,
            ...data
        });
        
        closeModal('generateReceiptModal');
        
        // Afficher un message temporaire
        const alert = document.createElement('div');
        alert.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded';
        alert.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Quittance générée avec succès!';
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    });

    // Télécharger une quittance
    function downloadReceipt(receiptCode) {
        // Simuler le téléchargement
        console.log('Téléchargement de la quittance:', receiptCode);
        alert('Téléchargement de la quittance ' + receiptCode + ' (simulation)');
    }

    // Envoyer une quittance par email
    function sendReceiptByEmail(receiptCode) {
        const receipt = receiptsData[receiptCode];
        document.getElementById('receiptToSend').textContent = receiptCode + ' - ' + receipt.tenant + ' (' + receipt.period + ')';
        document.querySelector('#sendReceiptForm input[name="recipient_email"]').value = receipt.tenantEmail;
        document.querySelector('#sendReceiptForm input[name="email_subject"]').value = 'Quittance de loyer - ' + receipt.period;
        openModal('sendReceiptModal');
    }

    // Voir les détails d'une quittance
    function viewReceiptDetails(receiptCode) {
        const receipt = receiptsData[receiptCode];
        
        document.getElementById('detailReceiptCode').textContent = receiptCode;
        document.getElementById('detailReceiptNumber').textContent = receipt.number;
        document.getElementById('detailReceiptTenant').textContent = receipt.tenant;
        document.getElementById('detailReceiptApartment').textContent = receipt.apartment;
        document.getElementById('detailReceiptPeriod').textContent = receipt.period;
        document.getElementById('detailReceiptAmount').textContent = receipt.amount;
        document.getElementById('detailReceiptPaymentDate').textContent = receipt.paymentDate;
        document.getElementById('detailReceiptGenerationDate').textContent = receipt.generationDate;
        document.getElementById('detailReceiptPaymentCode').textContent = receipt.paymentCode;
        
        openModal('receiptDetailsModal');
    }

    // Gestion de l'envoi par email
    document.getElementById('sendReceiptForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        console.log('Envoi email:', data);
        
        closeModal('sendReceiptModal');
        
        // Afficher un message temporaire
        const alert = document.createElement('div');
        alert.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded';
        alert.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Email envoyé avec succès!';
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    });

    // Fermer les modals en cliquant à l'extérieur
    document.addEventListener('click', function(event) {
        if (event.target === document.getElementById('generateReceiptModal') || 
            event.target === document.getElementById('receiptDetailsModal') ||
            event.target === document.getElementById('sendReceiptModal')) {
            closeModal(event.target.id);
        }
    });
</script>
@endsection