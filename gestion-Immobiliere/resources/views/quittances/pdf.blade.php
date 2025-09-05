<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    
    <title>Quittance - {{ $quittance->id_quittance }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        .title { font-size: 20px; font-weight:bold; text-align:center; margin: 20px 0;}
        .section { margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="title">Quittance de loyer</div>
    <div class="section">
        <strong>N° : </strong> {{ $quittance->id_quittance }}<br>
        <strong>Date : </strong> {{ $quittance->date_creation }}
    </div>
    <div class="section">
        <strong>Bâtiment :</strong> {{ $quittance->paiement->batiment->nom ?? 'N/A'}}<br>
        <strong>Appartement :</strong> {{ $quittance->paiement->code_appartement ?? 'N/A'}}
    </div>
    <div class="section">
        <strong>Locataire :</strong>
        {{ $quittance->paiement->locataire->nom ?? 'N/A' }}
        {{ $quittance->paiement->locataire->prenom ?? '' }}
        <br>
        <strong>Période :</strong> {{ $quittance->paiement->mois ?? 'N/A' }}<br>
        <strong>Montant payé :</strong> {{ number_format($quittance->paiement->montant ?? 0, 0, ',', ' ') }} FCFA
    </div>
</body>
</html>