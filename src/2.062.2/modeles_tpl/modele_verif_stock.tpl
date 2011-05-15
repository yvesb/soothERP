<h2>{TITLE:}</h2>
<h3>Nous avons relevés <span style="color:red">{NBARTICLES:}</span> article(s) {LIBMESSAGE:} </h3>
<BR/>
<table border='1'>
	<tr>
		<td>Reférence de l'article</td>
		<td>Libellé de l'article</td>
		<td>Stock de l'article</td>
		<td>Sorties en cours</td>
		<td>Minimum renseigné</td>
	</tr>
{BLOCK:articles}
	<tr>
		<td>{DATA:articles.ref_article}</td>
		<td>{DATA:articles.lib_article}</td>
		<td>{DATA:articles.qteStock}</td>
		<td>{DATA:articles.qteSorties}</td>
		<td>{DATA:articles.qteMini}</td>
	</tr>
{BLOCKEND:articles}