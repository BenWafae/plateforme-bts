import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Tableau pour stocker les notifications reçues
window.notificationsRecues = [];

// Fonction pour afficher une notification
function afficherNotification(e) {
    console.log("%c Notification reçue :", "color: green; font-weight: bold;", e);

    // Stocker la notification dans le tableau
    window.notificationsRecues.push(e);
    console.log("Toutes les notifications reçues :", window.notificationsRecues);

    // Utiliser Bootstrap Toast si disponible
    if (typeof bootstrap !== 'undefined') {
        const toastEl = document.createElement('div');
        toastEl.className = 'toast align-items-center text-white bg-primary border-0 position-fixed bottom-0 end-0 m-3';
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');

        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <strong>Nouvelle Notification :</strong> ${e.titre}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        document.body.appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    } else {
        alert("Nouvelle question reçue : " + e.titre);
    }

    // Mettre à jour le compteur de notifications
    const countSpan = document.querySelector("#notification-count");
    if (!countSpan) {
        console.warn(" Element #notification-count non trouvé !");
        return;
    }

    let badge = countSpan.querySelector(".badge");

    if (badge) {
        let currentCount = parseInt(badge.textContent) || 0;
        badge.textContent = currentCount + 1;
        badge.classList.remove('d-none');
    } else {
        badge = document.createElement("span");
        badge.className = "badge bg-danger";
        badge.textContent = "1";
        countSpan.appendChild(badge);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    console.log(" DOM prêt. En attente de notifications...");

    if (typeof window.userId !== 'undefined') {
        console.log(" Echo écoute le canal : professeur." + window.userId);

        window.Echo.private(`professeur.${window.userId}`)
            .listen('.question.creee', (e) => {
                console.log(" Événement '.question.creee' reçu.");
                afficherNotification(e);
            })
            .error((error) => {
                console.error(' Erreur de connexion au canal:', error);
            });

        // Vérification optionnelle de l'abonnement
        setTimeout(() => {
            if (window.checkSubscriptions) {
                window.checkSubscriptions();
            }
        }, 2000);
    } else {
        console.warn(' Aucun userId défini, Echo ne sera pas initialisé.');
    }
});
console.log("App.js chargé! window.userId:", window.userId);
console.log("Echo script chargé !");
