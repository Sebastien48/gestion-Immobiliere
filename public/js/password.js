

// Désactiver l'autre champ quand l'un est rempli
document.getElementById('email').addEventListener('input', function() {
    if (this.value) {
        document.getElementById('phone').disabled = true;
    } else {
        document.getElementById('phone').disabled = false;
    }
});

document.getElementById('phone').addEventListener('input', function() {
    if (this.value) {
        document.getElementById('email').disabled = true;
    } else {
        document.getElementById('email').disabled = false;
    }
});