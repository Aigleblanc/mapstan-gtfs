<?php 
    $this->view('structure/header');
    $this->view('structure/nav');
?>
	<div id="container"><!-- START container -->
		<div class="row">
			<div class="col-md-3" id="rapport">
				<div>
					<h4>Déclarer un incident sur une ligne</h4>
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
									<option value="10">-10 min</option>
									<option value="13">-13 min</option>
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
							<textarea id="f_remarque" name="f_remarque" class="form-control" rows="3"></textarea>
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
			</div>			
			<div class="col-md-6 hauteur_map">
				<div id="map"></div>
				<div id="retour_horaire"></div>
				<p>&nbsp;</p>
				<p class="text-center"><button id="btn_realtime" onclick="realtime_toggle()" class="btn btn-default">Activer les bus en temps réel</button></p>
				<p>&nbsp;</p>
				<div class="alert alert-info"><strong>Info : </strong>Ceci est une version beta, des bugs peuvent exister (Voir le <a href="/changelog">changelog</a>)</div>
			</div>
			<div class="col-md-3">
				<div class="ligne_min">
					<p>&nbsp;</p>
					<?php //<div class="alert alert-info"><strong>Attention : Mise à jour des lignes en cours.</strong></div> ?>
					<ul class="nav nav-tabs">
					  <li><a href="#tab_bus" data-toggle="tab">Stan</a></li>
					  <li><a href="#tab_voiture" data-toggle="tab">Autopi</a></li>
					  <li><a href="#tab_velo" data-toggle="tab">VéloStan</a></li>
					  <li><a href="#tab_parking" data-toggle="tab">Parking</a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="tab_bus">
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
						<div class="tab-pane" id="tab_voiture">Voitures à louer</div>
						<div class="tab-pane" id="tab_velo"></div>
						<div class="tab-pane" id="tab_parking"></div>
					</div>
				</div>
			</div>			
		</div>

		<div>
			zone d'alerte, info, news, incidents
		</div>
	</div><!-- END container -->

	<ul>
		<li><a href="https://www.facebook.com/groups/marre.de.stan/">www.facebook.com/groups/marre.de.stan/</a></li>
	</ul>

<?php 
    $this->view('structure/footer');
?>

<script>
	$(document).ready(initialize);
</script>