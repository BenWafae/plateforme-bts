import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Tableau pour stocker les notifications reçues
window.notificationsRecues = [];

// Fonction pour afficher une notification de nouvelle question
function afficherNotificationQuestion(e) {
    console.log("%c Notification Question reçue :", "color: green; font-weight: bold;", e);
    
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
                    <strong>Nouvelle question :</strong> ${e.titre}
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
    mettreAJourCompteurNotifications();
}

// Fonction pour afficher une notification de nouvelle réponse
function afficherNotificationReponse(e) {
    console.log("%c Notification Réponse reçue :", "color: green; font-weight: bold;", e);
    
    // Stocker la notification dans le tableau
    window.notificationsRecues.push(e);
    console.log("Toutes les notifications reçues :", window.notificationsRecues);
    
    // Utiliser Bootstrap Toast si disponible
    if (typeof bootstrap !== 'undefined') {
        const toastEl = document.createElement('div');
        toastEl.className = 'toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3';
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');
        
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <strong>Nouvelle réponse :</strong> ${e.contenu}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        document.body.appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    } else {
        alert("Nouvelle réponse reçue : " + e.contenu);
    }
    
    // Mettre à jour le compteur de notifications
    mettreAJourCompteurNotifications();
}

// Fonction pour mettre à jour le compteur de notifications
function mettreAJourCompteurNotifications() {
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
        
        const canalProf = window.Echo.private(`professeur.${window.userId}`);
        
        // Écoute pour l'événement question.creee
        canalProf.listen('.question.creee', (e) => {
            console.log(" Événement '.question.creee' reçu.");
            afficherNotificationQuestion(e);
        });
        
        // Écoute pour l'événement reponse.creee (sans point au début)
        canalProf.listen('.reponse.creee', (e) => {
            console.log(" Événement 'reponse.creee' reçu.");
            afficherNotificationReponse(e);
        });
        
        // En cas d'erreur de connexion au canal
        canalProf.error((error) => {
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

// Ajout d'une fonction pour afficher les abonnements actifs (utile pour le débogage)
window.checkSubscriptions = function() {
    if (window.Echo && window.Echo.connector && window.Echo.connector.channels) {
        console.log("Canaux actifs:", Object.keys(window.Echo.connector.channels));
        
        // Vérifier spécifiquement le canal du professeur
        if (window.userId) {
            const canalName = `private-professeur.${window.userId}`;
            console.log(`Canal '${canalName}' abonné:`, !!window.Echo.connector.channels[canalName]);
        }
    } else {
        console.warn("Impossible de vérifier les abonnements Echo");
    }
};
console.log("App.js chargé! window.userId:", window.userId);
console.log("Echo script chargé !");
