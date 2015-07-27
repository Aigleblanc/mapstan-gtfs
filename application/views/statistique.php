<?php 
    $this->view('structure/header');
    $this->view('structure/nav');
?>
	<script src="/assets/js/heatmap/heatmap.js"></script>
	<script src="/assets/js/heatmap/heatmap-gmaps.js"></script>

	<script src="http://code.highcharts.com/highcharts.js"></script>

	<div id="container"><!-- START container -->
		<div class="row">
			<div class="col-md-6">
				<h3>Statistique</h3>

				<h4>Statisitique global</h4>

				<ul>
					<li><a href="#">Voir tous les passages en retard signalés</a> <span class="badge"><?=$nb_retard?></span></li>
					<li><a href="#">Voir toutes les passages en avance signalés</a> <span class="badge"><?=$nb_avance?></span></li>
					<li><a href="#">Voir tous les incidents</a> <span class="badge"><?=$nb_incident?></span></li>
					<li><a href="#">Voir les arrets mal placé sur la carte</a> <span class="badge"><?=$nb_bugcoord?></span></li>
					<li><a href="#">Voir les accidents</a> <span class="badge"><?=$nb_accident?></span></li>
					<li><a href="#">Voir les compliments pour un chauffeur</a> <span class="badge"><?=$nb_compliment?></span></li>
					<li><a href="#">Voir tous les bus jamais passés</a> <span class="badge"><?=$nb_never?></span></li>
					<li><a href="#">Voir tous les bus surpeuplés</a> <span class="badge"><?=$nb_surpop?></span></li>
					<li><a href="#">Voir tous les bus qui ne s'arrête pas</a> <span class="badge"><?=$nb_pasarret?></span></li>
					<li><a href="#">Voir toutes les zones controlées</a> <span class="badge"><?=$nb_controleur?></span></li>
					<li><a href="#">voir les signalements hors classement</a> <span class="badge"><?=$nb_autre?></span></li>
				</ul>

		<?php /*<a href="http://www.reseau-stan.com/horaires/arret/?rub_code=28&lign_id=88&laDate=11/2/2014&sens=1&pa_id=1180">test</a>*/ ?>


				<ul>
					<li>Nombre total de rapport <span class="badge"><?=$nb_total?></span></li>
					<li>Nombre de rapport en attente de validation <span class="badge"><?=$nb_validation?></span></li>
				</ul>

				<h4>Graphiques</h4>

				<div id="stats_global" style="width:100%; height:400px;"></div>

				<div id="stats_lignes" style="width:100%; height:400px;"></div>

				<div id="stats_lignes_scolaire" style="width:100%; height:400px;"></div>
				
				<div id="stats_lignes_mini" style="width:100%; height:400px;"></div>

				<script>
					$(function () {
					    $('#stats_global').highcharts({
					        chart: {
					            plotBackgroundColor: null,
					            plotBorderWidth: null,
					            plotShadow: false
					        },
					        title: {
					            text: 'Répartition des signalements sur le Réseau-Stan'
					        },
					        tooltip: {
					    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					        },
					        plotOptions: {
					            pie: {
					                allowPointSelect: true,
					                cursor: 'pointer',
					                dataLabels: {
					                    enabled: true,
					                    color: '#000000',
					                    connectorColor: '#000000',
					                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
					                }
					            }
					        },
					        series: [{
					            type: 'pie',
					            name: 'Signalements',
					            data: [
					                ['Passages en retard',  				<?=$nb_retard?>],
					                ['Passages en avance',  				<?=$nb_avance?>],
					                ['Bus jamais passés',   				<?=$nb_never?>],
					                ['Bus surpeuplés',  					<?=$nb_surpop?>],
					                ['Bus qui ne s\'arrête pas',  			<?=$nb_pasarret?>],
					                ['Incidents', 							<?=$nb_incident?>],
					                ['Zones controlées',  					<?=$nb_controleur?>],
					                ['Autres',  							<?=$nb_autre?>],
					                ['les arrets mal placé sur la carte', 	<?=$nb_bugcoord?>],
					                ['les accidents',  						<?=$nb_accident?>],
					                ['les compliments pour un chauffeur',  	<?=$nb_compliment?>]
					            ]
					        }]
					    });
			
				        $('#stats_lignes').highcharts({
				            chart: {
				                type: 'area'
				            },
				            title: {
				                text: 'Retards et arrets en fonctions des lignes courantes'
				            },
				            subtitle: {
				                text: 'Source: Données MapStan'
				            },
				            xAxis: {
				                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'],
				                tickmarkPlacement: 'on',
				                title: {
				                    enabled: false
				                }
				            },
				            yAxis: {
				                title: {
				                    text: 'Nombre d\'évenements'
				                },
				                labels: {
				                    formatter: function() {
				                        return this.value;
				                    }
				                }
				            },
				            tooltip: {
				                shared: true,
				                valueSuffix: '  nombre'
				            },
				            plotOptions: {
				                area: {
				                    stacking: 'normal',
				                    lineColor: '#666666',
				                    lineWidth: 1,
				                    marker: {
				                        lineWidth: 1,
				                        lineColor: '#666666'
				                    }
				                }
				            },
				            series: [{
				                name: 'Bus en retards',
				                data: [<?=$ligne_retard?>]
				            }, {
				                name: 'Bus en avances',
				                data: [<?=$ligne_avance?>]
				            }, {
				                name: 'Bus ne passe pas',
				                data: [<?=$ligne_never?>]
				            }]
				        });

				        $('#stats_lignes_scolaire').highcharts({
				            chart: {
				                type: 'area'
				            },
				            title: {
				                text: 'Retards et arrets en fonctions des lignes scolaires'
				            },
				            subtitle: {
				                text: 'Source: Données MapStan'
				            },
				            xAxis: {
				                categories: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'M', 'N', 'S'],
				                tickmarkPlacement: 'on',
				                title: {
				                    enabled: false
				                }
				            },
				            yAxis: {
				                title: {
				                    text: 'Nombre d\'évenements'
				                },
				                labels: {
				                    formatter: function() {
				                        return this.value;
				                    }
				                }
				            },
				            tooltip: {
				                shared: true,
				                valueSuffix: '  nombre'
				            },
				            plotOptions: {
				                area: {
				                    stacking: 'normal',
				                    lineColor: '#666666',
				                    lineWidth: 1,
				                    marker: {
				                        lineWidth: 1,
				                        lineColor: '#666666'
				                    }
				                }
				            },
				            series: [{
				                name: 'Bus en retards',
				                data: [<?=$ligne_s_retard?>]
				            }, {
				                name: 'Bus en avances',
				                data: [<?=$ligne_s_avance?>]
				            }, {
				                name: 'Bus ne passe pas',
				                data: [<?=$ligne_s_never?>]
				            }]
				        });

				        $('#stats_lignes_mini').highcharts({
				            chart: {
				                type: 'area'
				            },
				            title: {
				                text: 'Retards et arrets en fonctions des lignes Mobi et Ptit Stan'
				            },
				            subtitle: {
				                text: 'Source: Données MapStan'
				            },
				            xAxis: {
				                categories: ['MsE', 'MsO', 'psL', 'psN', 'psP'],
				                tickmarkPlacement: 'on',
				                title: {
				                    enabled: false
				                }
				            },
				            yAxis: {
				                title: {
				                    text: 'Nombre d\'évenements'
				                },
				                labels: {
				                    formatter: function() {
				                        return this.value;
				                    }
				                }
				            },
				            tooltip: {
				                shared: true,
				                valueSuffix: '  nombre'
				            },
				            plotOptions: {
				                area: {
				                    stacking: 'normal',
				                    lineColor: '#666666',
				                    lineWidth: 1,
				                    marker: {
				                        lineWidth: 1,
				                        lineColor: '#666666'
				                    }
				                }
				            },
				            series: [{
				                name: 'Bus en retards',
				                data: [<?=$ligne_p_retard?>]
				            }, {
				                name: 'Bus en avances',
				                data: [<?=$ligne_p_avance?>]
				            }, {
				                name: 'Bus ne passe pas',
				                data: [<?=$ligne_p_never?>]
				            }]
				        });
				    });
				</script>

			</div>
			<div class="col-md-6">
				<div id="map_stats"></div>
			</div>
		</div>

	</div><!-- END container -->

<?php 
    $this->view('structure/footer');
?>

<script>
	$(document).ready(initialize_stats);
</script>