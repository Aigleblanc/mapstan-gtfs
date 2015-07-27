<?php 
    $this->view('structure/header');
    $this->view('structure/nav');
?>
	<div id="container"><!-- START container -->
		<div class="row">
			<div class="col-md-6">
				<h3>Rapport <?=$rapport->id;?></h3>

				<p><?=rapport($rapport->type_probleme);?></p>
				<p>Ligne : <?=$rapport->nom_ligne;?></p>
				<p>Arret : <?=$rapport->nom_arret;?></p>
				<p>Direction : <?=$rapport->nom_sens;?> (<?=($rapport->sens == 1)? 'Aller' : 'Retour';?>)</p>

				<?php if(!empty($rapport->num_bus)): ?>
					<p>Bus numero <?=$rapport->num_bus;?></p>
				<?php endif; ?> 

				<?php if($rapport->type_probleme == "retard"): ?>
					<p>Temps de retard : <?=$rapport->tps_retard;?> min</p>
					<p>Horaire de passage : <?=$rapport->passage_heure;?>:<?=$rapport->passage_minute;?></p>
				<?php elseif($rapport->type_probleme == "avance"): ?>
					<p>Temps d'avance : <?=$rapport->tps_avance;?></p>
					<p>Horaire de passage : <?=$rapport->passage_heure;?>h <?=$rapport->passage_minute;?></p>
				<?php endif; ?> 

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