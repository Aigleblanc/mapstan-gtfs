<?php 
    $this->view('structure/header');
?>
	<div id="menu_navigation" style="">
		<?php
		    $this->view('structure/nav');
		?>
	</div>
	<div id="container"><!-- START container -->
		<div class="row">
			<div class="col-md-12 hauteur_map" style="box-sizing:border-box;">
				<div id="side_toggle">
					<div class="toggle" id="toggle_rapport" title="Rapport Réseau-Stan"><span id="on_toggle_rapport" class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#Modal_rapport_stan"></span></div>
					<div class="toggle" id="toggle_line" 	title="Voir les lignes"><span id="on_toggle_line" class="glyphicon glyphicon-list" data-toggle="modal" data-target="#Modal_lignesStan"></span></div>
					<div class="toggle" id="toggle_tmpreel" title="Bus en temps réel"><span id="on_toggle_tmpreel" class=""><img id="img_toggle_tmpreel" src="/static/img/map/pack/bus-18@2x-play.png" /></span></div>
					<div class="toggle" id="toggle_velo" 	title="Voir les zones VeloStan"><span id="on_toggle_velo" class=""><img id="img_toggle_velo" src="/static/img/map/pack/bicycle-18@2x.png" /></span></div>
					<div class="toggle" id="toggle_autopi"  title="Voir les zones Autopi"><span id="on_toggle_autopi" class=""><img id="img_toggle_autopi" src="/static/img/map/pack/car-18@2x.png" /></span></div>
					<div class="toggle" id="toggle_parking" title="Voir les parkings"><span id="on_toggle_parking" class=""><img id="img_toggle_parking" src="/static/img/map/pack/parking-18@2x.png" /></span></div>
					<div class="toggle" id="toggle_travaux" title="Voir les travaux"><span id="on_toggle_travaux" class=""><img id="img_toggle_travaux" src="/static/img/map/pack/construction_icon.png" /></span></div>
					<div class="toggle" id="toggle_gare" 	title="Voir les gares"><span id="on_toggle_gare" class=""><img id="img_toggle_gare" src="/static/img/map/pack/rail-18@2x.png" /></span></div>
					<div class="toggle" id="toggle_train" 	title="Voir les trains"><span id="on_toggle_train" class=""><img id="img_toggle_train" src="/static/img/map/train/rail-18@2x_play.png" /></span></div>
					<div class="toggle" id="toggle_gps" 	title="Me localiser"><span id="on_toggle_gps" class="glyphicon glyphicon-screenshot" ></span></div>
					<div class="toggle" id="toggle_config"  title="Configuration"><span id="on_toggle_config" class="glyphicon glyphicon-cog" data-toggle="modal" data-target="#myModal"></span></div>
				</div>
				<input type="text" id="find_me" style="position:absolute;z-index:9999" />
				<div class="" id="map"></div>
			</div>	
		</div>
	</div><!-- END container -->

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Configuration</h4>
				</div>
				<div class="modal-body">
				  	<div class="checkbox">
						<label>
							<input id="display_line" type="checkbox" value="display" checked="checked"> Effacer la ligne en cours lorsque j'en affiche une nouvelle.
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input id="gps_center" type="checkbox" value="display" checked="checked"> Centrer automatique sur ma position.
						</label>
					</div>

					<p style="font-size:0.8em;">MapStan est une application Web expérimentale. Elle ne fait l'objet d'aucun lien ni d'aucun support de la part de Réseau-Stan.<br>
					Les informations sont basées sur les données OpenData fournis par le Grand Nancy, ces informations pourraient etre manquantes ou inexactes.<br>
					<br>
						MapStan utilise les données OpenData fournit par le site <a href="http://opendata.grand-nancy.org">opendata.grand-nancy.org</a> sous <a href="http://opendata.grand-nancy.org/conditions-dutilisation/en-resume/">licence Open Database Licence (ODbL)</a>
					</p>
					<div id="suivie_position"></div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="Modal_horaire" tabindex="-1" role="dialog" aria-labelledby="Modal_horaireLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="Modal_horaireLabel">Horaire de passage</h4>
				</div>
				<div class="modal-body" id="modal_horaire_core">
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->	

	<div class="modal fade" id="Modal_lignesStan" tabindex="-1" role="dialog" aria-labelledby="Modal_lignesStanLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="Modal_lignesStanLabel">Ligne Réseau-Stan</h4>
				</div>
				<div class="modal-body" id="">
					<ul id="liste_ligne" class="liste_ligne list-unstyled">
					<?php foreach ($lignes as $ligne): ?>
						<li style="padding-top:3px;">
							<ul class="list-inline">
	  							<li>
									<div class="icone_ligne" style="background-color:#<?=$ligne->route_color;?>">
										<span><?=$ligne->route_short_name; ?></span>
									</div>
								</li>
								<li>
									<div class="icone_ligne_text"><?=$ligne->route_long_name?></div>
								</li>
								<li>
									<span title="<?=$ligne->aller['name']; ?>" class="click_route curspointer glyphicon glyphicon-collapse-up" data-id-route="<?=$ligne->route_id; ?>" data-sens-route="<?=$ligne->aller['value']; ?>"></span> 
									<span title="<?=$ligne->retour['name']; ?>" class="click_route curspointer glyphicon glyphicon-collapse-down" data-id-route="<?=$ligne->route_id; ?>" data-sens-route="<?=$ligne->retour['value']; ?>"></span> 
								</li>										
							</ul>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->		

	<div class="modal fade" id="Modal_rapport_stan" tabindex="-1" role="dialog" aria-labelledby="Modal_rapport_stanLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="Modal_rapport_stanLabel">Rapport Réseau-Stan</h4>
				</div>
				<div class="modal-body" id="">

					<form id="form_rapport" role="form">
						<div class="form-group">
							<label for="f_nom_ligne">Ligne *</label>
							<select name="f_nom_ligne" id="f_nom_ligne" class="form-control">
								<option value="null">Selectionner une ligne</option>
								<?php foreach ($lignes as $ligne): ?>
									<option value="<?=$ligne->route_id; ?>"><?=$ligne->route_short_name; ?> - <?=$ligne->route_long_name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="f_direction">Direction *</label>
							<select name="f_direction" id="f_direction" class="form-control">
								<option value="0"></option>
								<option value="1"></option>
							</select>
						</div>						
						<div class="form-group">
							<label for="f_nom_arret">Arret *</label>
							<select name="f_nom_arret" id="f_nom_arret" class="form-control"></select>
						</div>
						<div class="form-group">
							<label for="f_probleme">Mon rapport concerne *</label>					
							<select name="f_probleme" id="f_probleme" class="form-control">
								<option value="null">Selectionner un type de rapport</option>
								<option value="retard">un bus en retard</option>
								<option value="avance">un bus en avance</option>
								<option value="never">un bus jamais passé</option>
								<option value="pasarret">un bus qui ne s'arrête pas</option>
								<option value="compliment">un compliment pour un chauffeur</option>
								<option value="controleur">la présence de contrôleurs</option>
								<option value="surpop">un bus surpeuplé</option>
								<option value="incident">un incident</option>
								<option value="accident">un accident à l'arret/sur la ligne</option>
								<option value="bugcoord">un arret n'est pas à sa place sur la carte</option>
								<option value="autre">une autre catégorie...</option>
							</select>
						</div>

						<div id="zone_retard" style="display:none">
							<div class="form-group">
								<label for="f_tps_retard">Temps du retard *</label>					
								<select id="f_tps_retard" class="form-control">
									<option value="null">choisir le temps</option>
									<option value="1">+1 min</option>
									<option value="2">+2 min</option>
									<option value="3">+3 min</option>
									<option value="4">+4 min</option>
									<option value="5">+5 min</option>
									<option value="6">+6 min</option>
									<option value="7">+7 min</option>
									<option value="7">+8 min</option>
									<option value="7">+9 min</option>
									<option value="10">+10 min</option>
									<option value="10">+11 min</option>
									<option value="10">+12 min</option>
									<option value="13">+13 min</option>
									<option value="13">+14 min</option>
									<option value="15">+15 min</option>
									<option value="20">+20 min</option>
								</select>
							</div>
						</div>

						<div id="zone_avance" style="display:none">
							<div class="form-group">
								<label for="f_tps_avance">Temps d'avance *</label>					
								<select id="f_tps_avance" class="form-control">
									<option value="null">choisir le temps</option>
									<option value="1">-1 min</option>
									<option value="2">-2 min</option>
									<option value="3">-3 min</option>
									<option value="4">-4 min</option>
									<option value="5">-5 min</option>
									<option value="6">-6 min</option>
									<option value="7">-7 min</option>
									<option value="7">-8 min</option>
									<option value="7">-9 min</option>
									<option value="10">-10 min</option>
									<option value="10">-11 min</option>
									<option value="10">-12 min</option>
									<option value="13">-13 min</option>
									<option value="13">-14 min</option>
									<option value="15">-15 min</option>
									<option value="20">-20 min</option>
								</select>
							</div>
						</div>						

						<div class="form-group">
							<label for="f_heure">Heure de passage normal : </label>
							<div class="row">
								<div class="col-xs-4">	
									<select id="f_heure" name="f_heure" class="form-control">
										<option value="h">Heure</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="00">00</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>						
									</select>
								</div>
								<div class="col-xs-4">
									<select id="f_min" name="f_min" class="form-control">
										<option value="min">Minutes</option>	
										<?php for ($minutes = 00 ; $minutes <= 59 ; $minutes++):
											$min = sprintf("%02d", $minutes);
										?>
										<option value="<?=$min ?>"><?=$min;?></option>
									<?php endfor; ?>							
									</select>	
								</div>
							</div>					
						</div>

						<div class="form-group">
							<label for="f_num_bus">Numero de bus</label>
							<input type="text" class="form-control" name="f_num_bus" id="f_num_bus" placeholder="Numero de bus">
						</div>
						<div class="form-group">
							<label for="f_email">Email</label>
							<input type="email" class="form-control" name="f_email" id="f_email" placeholder="Entrer votre email">
						</div>
						<div class="form-group">
							<label for="f_remarque">Remarque</label>
							<textarea id="f_remarque" name="f_remarque" class="form-control" rows="2"></textarea>
						</div>
						<div class="form-group">
							<label for="f_remarque">Date de l'évènement</label>
							<input type="text" class="form-control" name="f_date" id="f_date" placeholder="jj-mm-yyyy hh:mm:ss" value="<?=date('d-m-Y H:i:s');?>">
						</div>

						<div id="" style="font-size:0.8em;padding-bottom:5px;" class="">* champs obligatoire <br> Votre email ne sera ni exploité ni vendu, il servira pour vous avertir lors de la publication des stats.</div>
						<div id="retour_rapport" style="display:none;" class="alert"></div>
						<button type="submit" class="btn btn-default">Envoyer</button>
					</form>

				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->		

<?php 
    $this->view('structure/footer');
?>

<script>
	$(document).ready(initialize);
	function resize()
	{
		$("#zone_left, #zone_right, #map").css( "height", $( window ).height());
	}
	$(function() {
		resize();
		$('.tooltips').tooltip();
	});
	$(window).on("debouncedresize", function( event ) {
	    resize();
	});
</script>