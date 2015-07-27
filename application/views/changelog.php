<?php 
    $this->view('structure/header');
    $this->view('structure/nav');
?>
	<div id="container"><!-- START container -->
		<div class="row">
			<div class="col-md-6">
				<h3>Changelog</h3>

				<div class="alert alert-info">Version de test en cours</div>

				<h4>Bug en cours</h4>

				<ul>
					<li>Modification de l'affichage des bus en temps réél ( optimisation de l'affichage dans l'infobulle )</li>
					<li>(1) Modification en cours pour prendre en compte les lignes supérieur à 00:00 pour les bus temps réél</li>
				</ul>				

				<h4>Version en cours</h4>

				<ul>
					<li>Prise en compte des horaires du Samedi, Dimanche, Semaine pour les bus temps réél (1)</li>
					<li>Signalement de l'api temps réél sur plus de bus ou plus d'horaire dispo</li>
					<li>Optimisation de la taille des retours de l'api realtime ( -10ko's / appel )</li>
					<li>Optimisation du javascript et du nombre d'appel ajax</li>
					<li>Remplacement de Aller/Retour par les vrais directions</li>
					<li>Signalement des directions par leurs noms dans les infobulles</li>
					<li>Mise en place d'une administration pour gérer l'appli ( mais ca reste privé ;) )</li>
					<li>Modification des infobulles</li>
					<li>Bouton de signalement ajouté sur les infobulles des bus</li>
					<li>Envoie des rapports</li>
					<li>Affichage des lignes</li>
					<li>Affichage des arrets</li>
					<li>Affichage des prohchains passages</li>
					<li>Possibilité de rapporter la précense d'un controle en cours</li>
					<li>Modification et ajout des nouvelles lignes</li>
					<li>Importation des horaires de tout le réseau</li>
					<li>Ajout de la fonction de suivie des bus en temps réel, basé sur les horaires théorique</li>
					<li>Modification des pins des bus ( bus au couleur de leur ligne )</li>
				</ul>

				<h4>Evolution à venir</h4>

				<ul>
					<li>Modification du design</li>
					<li>Affichage des horaires des arrets ( en esperant avoir tous ^^ )</li>
					<li>Detection des arrets de bus autour de moi ( géolocalisation )</li>
					<li>Importation des horaires de vacance prochainement</li>
					<li>Modification de l'affichage des bus en temps réél ( optimisation de l'affichage dans l'infobulle )</li>
					<li>Arret au couleur des lignes</li>
					<li>Statistiques</li>
					<li>Page de contact</li>
					<li>Tracking des déplacements des bus avec la Géoc</li>
					<li>Import des données Autopi, VeloStan, Parking</li>
					<li>Création des traces de déplacement des bus</li>
					<li>Système d’alerte par mail dès qu’un incident sera signalé sur les arrêts que vous aurez préalablement décidé de suivre</li>
				</ul>				

			</div>
			<div class="col-md-6">
				
			</div>
		</div>

	</div><!-- END container -->

<?php 
    $this->view('structure/footer');
?>

<script>
	$(document).ready(initialize_stats);
</script>