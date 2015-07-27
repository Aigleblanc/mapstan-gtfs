<html>
<head>
	<title></title>

</head>
<body>
	Liste des lignes : 
	<?php foreach ($lignes as $ligne) : ?>
		<div class="liste_ligne" style="color:#<?=$ligne->route_color;?>"><a href="/ligne/<?=$ligne->route_short_name; ?>"><div class="icone_ligne" style="background-color:#<?=$ligne->route_color;?>"><?=$ligne->route_short_name; ?></div></a> <?=$ligne->route_long_name?></div>
	<?php endforeach; ?>
</body>
</html>