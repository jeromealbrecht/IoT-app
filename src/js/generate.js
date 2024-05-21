$(document).ready(function() {
// public\getters\get_module_status.php

    // Récupération des statuts des modules
    function getModuleStatus() {
        $.ajax({
            url: 'get_module_status.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let hasErrorModule = false;
                $.each(response, function(index, module) {
                    let $moduleElement = $('[data-module-id="' + module.id + '"]');
                    let $statusElement = $moduleElement.find('.module-status');

                    if (module.status === 'error') {
                        $moduleElement.find('.card').addClass('border-danger');
                        $statusElement.html('Status: ❌');
                        hasErrorModule = true;
                    } else {
                        $moduleElement.find('.card').removeClass('border-danger');
                        $statusElement.html('Status: ✅');
                    }
                });
                // si un ou plusieurs modules sont en panne, 
                // on affiche une notification d'erreur
                if (hasErrorModule) {
                    showError();
                } else {
                    showNotification();
                }
            },
            error: function() {
                console.log('Une erreur s\'est produite lors de la récupération des statuts des modules.');
            }
        });
    }

    // Affichage de la notification
    function showNotification() {
        $('#notification').addClass('show');
        $('#notification i').removeClass('fa-exclamation-triangle').addClass('fa-check');
        $('#notification span').text('État des modules ok');
        setTimeout(function() {
            $('#notification').removeClass('show');
        }, 3000);
    }

    // Affichage de la notification d'erreur
    function showError() {
        $('#notification').addClass('show');
        $('#notification i').removeClass('fa-check').addClass('fa-exclamation-triangle');
        $('#notification span').text('Un ou plusieurs modules sont en panne !');
    }

    // Appel initial pour récupérer les statuts des modules au chargement de la page
    getModuleStatus();

    // Appel initial pour générer les données des modules au chargement de la page
    generateModuleData();

    // Rafraîchissement automatique toutes les 5 secondes
    setInterval(getModuleStatus, 5000);
    setInterval(generateModuleData, 5000);
});

// generer les données des modules
function generateModuleData() {
    $.ajax({
        url: 'generate_module_data.php',
        type: 'GET',
        success: function(response) {
            console.log(response);
        },
        error: function() {
            console.log('Une erreur s\'est produite lors de la génération des données des modules.');
        }
    });
}

function confirmDelete(moduleId) {
    Swal.fire({
        title: 'Confirmation',
        text: 'Êtes-vous sûr de vouloir supprimer ce module ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'delete_module.php?id=' + moduleId;
        }
    });
}

const hamburgerMenu = document.querySelector('.hamburger-menu');
const navLinks = document.querySelector('.nav-links');
const links = document.querySelectorAll('.nav-links li');

// Ajoutez la classe .nav-hidden au chargement de la page
navLinks.classList.add('nav-hidden');

hamburgerMenu.addEventListener('click', () => {
  navLinks.classList.toggle('nav-hidden');
  
  links.forEach((link, index) => {
    if (link.style.animation) {
      link.style.animation = '';
    } else {
      link.style.animation = `linkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
    }
  });
  
  hamburgerMenu.classList.toggle('toggle');
});